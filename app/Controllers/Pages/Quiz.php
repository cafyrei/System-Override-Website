<?php

namespace App\Controllers\Pages;

use App\Controllers\BaseController;
use App\Models\Pages\QuizAttemptModel;
use App\Models\Pages\QuizQuestionModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Timed multiple-choice quiz with a leaderboard.
 *
 * Integrity rules (the browser is never trusted):
 *  - The correct answer is never sent with a question; it is revealed only
 *    after that question has been answered.
 *  - The server owns the clock: time is measured from when it handed the
 *    question out to when the answer arrives. The browser timer is cosmetic.
 *  - A wrong or late answer is charged the FULL time limit, so guessing fast
 *    can't beat actually knowing the answer.
 *  - A question can be answered once (guarded by an atomic UPDATE).
 *
 * Ranking: highest score first, then lowest total time.
 */
class Quiz extends BaseController
{
    public function index(): string
    {
        $cfg  = config('Quiz');
        $pool = (new QuizQuestionModel())->where('is_active', 1)->countAllResults();

        return view('pages/quiz', [
            'cfg'         => $cfg,
            'perRound'    => min($cfg->questionsPerRound, $pool),
            'leaderboard' => (new QuizAttemptModel())->leaderboard($cfg->leaderboardSize),
        ]);
    }

    /** POST quiz/start: create a round and hand out question 1. */
    public function start(): ResponseInterface
    {
        $cfg = config('Quiz');

        if (service('throttler')->check('quiz-start-' . md5($this->request->getIPAddress()), $cfg->startsPerMinute, MINUTE) === false) {
            return $this->error('Too many rounds started. Wait a minute and try again.', 429);
        }

        $rules = [
            'player_name' => [
                'rules'  => sprintf('required|regex_match[/^[A-Za-z0-9][A-Za-z0-9 _\-]{%d,%d}$/]', $cfg->nameMin - 1, $cfg->nameMax - 1),
                'errors' => [
                    'required'    => 'Enter a callsign to play.',
                    'regex_match' => sprintf('Callsign must be %d-%d characters: letters, numbers, spaces, _ or -.', $cfg->nameMin, $cfg->nameMax),
                ],
            ],
        ];

        if (! $this->validate($rules)) {
            return $this->error(implode(' ', $this->validator->getErrors()), 422);
        }

        // Pick this round's questions. Shuffling ids in PHP (not ORDER BY RAND())
        // keeps it portable across databases; fine for pools up to a few thousand.
        $ids = array_map('intval', (new QuizQuestionModel())->where('is_active', 1)->findColumn('id') ?? []);

        if ($ids === []) {
            return $this->error('No questions are available yet. Check back soon.', 503);
        }

        shuffle($ids);
        $ids = array_slice($ids, 0, max(1, $cfg->questionsPerRound));

        $token = bin2hex(random_bytes(16));

        (new QuizAttemptModel())->insert([
            'token'                 => $token,
            'player_name'           => trim((string) $this->request->getPost('player_name')),
            'question_ids'          => json_encode($ids),
            'total_questions'       => count($ids),
            'current_index'         => 0,
            'score'                 => 0,
            'total_time_ms'         => 0,
            'question_served_at_ms' => $this->nowMs(), // the clock for question 1 starts now
            'finished'              => 0,
        ]);

        return $this->response->setJSON([
            'success'  => true,
            'token'    => $token,
            'total'    => count($ids),
            'seconds'  => $cfg->secondsPerQuestion,
            'question' => $this->presentQuestion($ids[0], 1),
        ]);
    }

    /**
     * POST quiz/next: hand out the current question and start its clock.
     * Idempotent: asking again never restarts the timer.
     */
    public function next(): ResponseInterface
    {
        $attempt = $this->loadAttempt();

        if ($attempt === null) {
            return $this->error('Round not found.', 404);
        }

        if ((int) $attempt['finished'] === 1) {
            return $this->error('This round is already finished.', 409);
        }

        if ($attempt['question_served_at_ms'] === null) {
            db_connect()->table('quiz_attempts')
                ->where('id', $attempt['id'])
                ->where('question_served_at_ms IS NULL', null, false)
                ->update(['question_served_at_ms' => $this->nowMs()]);
        }

        $ids   = json_decode($attempt['question_ids'], true);
        $index = (int) $attempt['current_index'];

        return $this->response->setJSON([
            'success'  => true,
            'question' => $this->presentQuestion((int) $ids[$index], $index + 1),
        ]);
    }

    /** POST quiz/answer: grade the active question. choice 1-4, or 0 when the browser's timer ran out. */
    public function answer(): ResponseInterface
    {
        $cfg     = config('Quiz');
        $attempt = $this->loadAttempt();

        if ($attempt === null) {
            return $this->error('Round not found.', 404);
        }

        if ((int) $attempt['finished'] === 1 || $attempt['question_served_at_ms'] === null) {
            return $this->error('There is no active question.', 409);
        }

        $index    = (int) $attempt['current_index'];
        $ids      = json_decode($attempt['question_ids'], true);
        $question = (new QuizQuestionModel())->find((int) $ids[$index]);
        $correct  = (int) ($question['correct_choice'] ?? 0);

        $choice  = (int) $this->request->getPost('choice');
        $limitMs = $cfg->secondsPerQuestion * 1000;
        $elapsed = max($this->nowMs() - (int) $attempt['question_served_at_ms'], $cfg->minAnswerMs);
        $late    = $elapsed > $limitMs + $cfg->graceMs;
        $isRight = ! $late && $choice >= 1 && $choice <= 4 && $choice === $correct;
        $charged = $isRight ? min($elapsed, $limitMs) : $limitMs;

        $nextIndex  = $index + 1;
        $isFinished = $nextIndex >= (int) $attempt['total_questions'];

        // Atomic: only succeeds if this exact question is still the active one,
        // so a double-submit or a racing request can't be counted twice.
        $db = db_connect();
        $db->table('quiz_attempts')
            ->where('id', $attempt['id'])
            ->where('current_index', $index)
            ->where('finished', 0)
            ->where('question_served_at_ms IS NOT NULL', null, false)
            ->set('score', 'score + ' . ($isRight ? 1 : 0), false)
            ->set('total_time_ms', 'total_time_ms + ' . $charged, false)
            ->set([
                'current_index'         => $nextIndex,
                'question_served_at_ms' => null,
                'finished'              => $isFinished ? 1 : 0,
            ])
            ->update();

        if ($db->affectedRows() !== 1) {
            return $this->error('That question was already answered.', 409);
        }

        $fresh = (new QuizAttemptModel())->find($attempt['id']);

        $payload = [
            'success'       => true,
            'correct'       => $isRight,
            'timedOut'      => $late,
            'correctChoice' => $correct,
            'elapsedMs'     => min($elapsed, $limitMs),
            'chargedMs'     => $charged,
            'score'         => (int) $fresh['score'],
            'finished'      => $isFinished,
        ];

        if ($isFinished) {
            $payload['result'] = [
                'name'        => $fresh['player_name'],
                'score'       => (int) $fresh['score'],
                'total'       => (int) $fresh['total_questions'],
                'totalTimeMs' => (int) $fresh['total_time_ms'],
                'rank'        => $this->rankOf($fresh),
            ];
        }

        return $this->response->setJSON($payload);
    }

    /** GET quiz/leaderboard */
    public function leaderboard(): ResponseInterface
    {
        $rows = (new QuizAttemptModel())->leaderboard(config('Quiz')->leaderboardSize);

        return $this->response->setJSON([
            'success' => true,
            'entries' => array_map(static fn (array $r): array => [
                'rank'   => (int) $r['rank'],
                'name'   => $r['player_name'],
                'score'  => (int) $r['score'],
                'total'  => (int) $r['total_questions'],
                'timeMs' => (int) $r['total_time_ms'],
            ], $rows),
        ]);
    }

    // ------------------------------------------------------------------

    /** Question as the browser may see it: text and choices only, never the answer. */
    private function presentQuestion(int $id, int $number): array
    {
        $q = (new QuizQuestionModel())->find($id);

        return [
            'number'  => $number,
            'text'    => $q['question'] ?? '(This question is no longer available.)',
            'choices' => [$q['choice_1'] ?? '', $q['choice_2'] ?? '', $q['choice_3'] ?? '', $q['choice_4'] ?? ''],
        ];
    }

    private function loadAttempt(): ?array
    {
        $token = (string) $this->request->getPost('token');

        if (preg_match('/^[a-f0-9]{32}$/', $token) !== 1) {
            return null;
        }

        return (new QuizAttemptModel())->where('token', $token)->first();
    }

    /** 1 + the number of finished rounds that beat this one. */
    private function rankOf(array $attempt): int
    {
        $better = db_connect()->table('quiz_attempts')
            ->where('finished', 1)
            ->groupStart()
                ->where('score >', (int) $attempt['score'])
                ->orGroupStart()
                    ->where('score', (int) $attempt['score'])
                    ->where('total_time_ms <', (int) $attempt['total_time_ms'])
                ->groupEnd()
            ->groupEnd()
            ->countAllResults();

        return $better + 1;
    }

    private function nowMs(): int
    {
        return (int) round(microtime(true) * 1000);
    }

    private function error(string $message, int $status): ResponseInterface
    {
        return $this->response
            ->setStatusCode($status)
            ->setJSON(['success' => false, 'message' => $message]);
    }
}