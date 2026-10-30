<?php

namespace Tests\Feature;

use App\Database\Seeds\QuizSeeder;
use CodeIgniter\Config\Factories;
use CodeIgniter\Security\Exceptions\SecurityException;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\Mock\MockCache;
use Config\Quiz;
use Config\Services;

/**
 * The quiz is graded and timed on the server. These tests pin down the rules
 * that make the leaderboard meaningful.
 *
 * @internal
 */
final class QuizTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    protected $namespace = 'App';
    protected $refresh   = true;

    private string $csrf = '';

    protected function setUp(): void
    {
        parent::setUp();

        // Fresh in-memory cache so the start-rate throttle never leaks between tests.
        Services::injectMock('cache', new MockCache());
        Services::resetSingle('throttler');

        $this->seed(QuizSeeder::class);
        $this->csrf = service('security')->getHash();
    }

    protected function tearDown(): void
    {
        Factories::reset('config');
        parent::tearDown();
    }

    // ------------------------------------------------------------ helpers

    private function submit(string $path, array $data = []): \CodeIgniter\Test\TestResponse
    {
        return $this->withHeaders(['X-CSRF-TOKEN' => $this->csrf])->post($path, $data);
    }

    /** @return array<string,mixed> */
    private function json(\CodeIgniter\Test\TestResponse $result): array
    {
        return json_decode($result->getJSON(), true) ?? [];
    }

    /** @return array{token:string,total:int,question:array} */
    private function startRound(string $name = 'Neo One'): array
    {
        $result = $this->submit('quiz/start', ['player_name' => $name]);
        $result->assertOK();

        return $this->json($result);
    }

    /** What the database says is right for a question the browser was shown. */
    private function correctChoiceFor(string $questionText): int
    {
        $row = $this->db->table('quiz_questions')->where('question', $questionText)->get()->getRowArray();

        return (int) $row['correct_choice'];
    }

    private function wrongChoiceFor(string $questionText): int
    {
        return $this->correctChoiceFor($questionText) === 1 ? 2 : 1;
    }

    private function insertFinished(string $name, int $score, int $timeMs, int $total = 10): void
    {
        $this->db->table('quiz_attempts')->insert([
            'token' => bin2hex(random_bytes(16)), 'player_name' => $name,
            'question_ids' => '[]', 'total_questions' => $total, 'current_index' => $total,
            'score' => $score, 'total_time_ms' => $timeMs, 'finished' => 1,
        ]);
    }

    // ------------------------------------------------------- page + start

    public function testPageRendersWithTokenAndEmptyBoard(): void
    {
        $result = $this->get('quiz');

        $result->assertOK();
        $result->assertSee('No finished rounds yet');
        $this->assertStringContainsString('name="X-CSRF-TOKEN"', $result->getBody());
    }

    public function testStartRejectsBadCallsigns(): void
    {
        foreach (['', 'ab', str_repeat('x', 21), '<script>alert(1)</script>', '   ', '-dash'] as $bad) {
            $this->submit('quiz/start', ['player_name' => $bad])->assertStatus(422);
        }
    }

    public function testStartDefaultsToTenQuestionsWithFourChoices(): void
    {
        $round = $this->startRound();

        $this->assertSame(10, $round['total']);
        $this->assertSame(1, $round['question']['number']);
        $this->assertCount(4, $round['question']['choices']);
        $this->assertSame(32, strlen($round['token']));
    }

    public function testQuestionCountIsConfigurable(): void
    {
        $cfg                    = new Quiz();
        $cfg->questionsPerRound = 5;
        Factories::injectMock('config', 'Quiz', $cfg);

        $this->assertSame(5, $this->startRound()['total']);
    }

    public function testRoundIsCappedByThePoolSize(): void
    {
        $this->db->table('quiz_questions')->where('id >', 3)->update(['is_active' => 0]);

        $this->assertSame(3, $this->startRound()['total']);
    }

    public function testStartFailsCleanlyWhenThereAreNoQuestions(): void
    {
        $this->db->table('quiz_questions')->update(['is_active' => 0]);

        $this->submit('quiz/start', ['player_name' => 'Neo One'])->assertStatus(503);
    }

    public function testAnswersAreNeverSentWithAQuestion(): void
    {
        $body = $this->submit('quiz/start', ['player_name' => 'Neo One'])->getJSON();

        $this->assertStringNotContainsStringIgnoringCase('correct', $body);
        $this->assertStringNotContainsString('correct_choice', $body);
    }

    // ------------------------------------------------------------ grading

    public function testPerfectRoundFinishesWithScoreAndRankOne(): void
    {
        $round    = $this->startRound('Speedy');
        $question = $round['question'];
        $last     = null;

        for ($i = 1; $i <= $round['total']; $i++) {
            $this->assertSame($i, $question['number']);

            $answer = $this->json($this->submit('quiz/answer', [
                'token'  => $round['token'],
                'choice' => $this->correctChoiceFor($question['text']),
            ]));

            $this->assertTrue($answer['correct']);
            $last = $answer;

            if (! $answer['finished']) {
                $question = $this->json($this->submit('quiz/next', ['token' => $round['token']]))['question'];
            }
        }

        $this->assertTrue($last['finished']);
        $this->assertSame(10, $last['result']['score']);
        $this->assertSame(10, $last['result']['total']);
        $this->assertSame(1, $last['result']['rank']);
        // even instant answers are floored at minAnswerMs, so a "0 ms" run is impossible
        $this->assertGreaterThanOrEqual(10 * (new Quiz())->minAnswerMs, $last['result']['totalTimeMs']);
    }

    public function testWrongAnswerScoresNothingAndRevealsTheRightOne(): void
    {
        $round  = $this->startRound();
        $text   = $round['question']['text'];
        $answer = $this->json($this->submit('quiz/answer', [
            'token' => $round['token'], 'choice' => $this->wrongChoiceFor($text),
        ]));

        $this->assertFalse($answer['correct']);
        $this->assertSame(0, $answer['score']);
        $this->assertSame($this->correctChoiceFor($text), $answer['correctChoice']);
    }

    public function testWrongAnswerIsChargedTheFullTimeLimit(): void
    {
        $round = $this->startRound();
        $limit = (new Quiz())->secondsPerQuestion * 1000;

        $answer = $this->json($this->submit('quiz/answer', [
            'token' => $round['token'], 'choice' => $this->wrongChoiceFor($round['question']['text']),
        ]));

        $this->assertSame($limit, $answer['chargedMs']);
    }

    public function testCorrectButLateAnswerCountsAsWrong(): void
    {
        $round = $this->startRound();

        // pretend the question was handed out a minute ago
        $this->db->table('quiz_attempts')->where('token', $round['token'])
            ->update(['question_served_at_ms' => (int) round(microtime(true) * 1000) - 60000]);

        $answer = $this->json($this->submit('quiz/answer', [
            'token' => $round['token'], 'choice' => $this->correctChoiceFor($round['question']['text']),
        ]));

        $this->assertTrue($answer['timedOut']);
        $this->assertFalse($answer['correct']);
        $this->assertSame(0, $answer['score']);
    }

    public function testNoAnswerFromTheBrowserTimerIsATimeout(): void
    {
        $round  = $this->startRound();
        $answer = $this->json($this->submit('quiz/answer', ['token' => $round['token'], 'choice' => 0]));

        $this->assertFalse($answer['correct']);
    }

    public function testOutOfRangeChoiceIsWrong(): void
    {
        $round = $this->startRound();

        foreach ([5, -1, 99] as $i => $bad) {
            if ($i > 0) {
                $this->submit('quiz/next', ['token' => $round['token']]);
            }
            $answer = $this->json($this->submit('quiz/answer', ['token' => $round['token'], 'choice' => $bad]));
            $this->assertFalse($answer['correct']);
        }
    }

    public function testAQuestionCanOnlyBeAnsweredOnce(): void
    {
        $round = $this->startRound();
        $right = $this->correctChoiceFor($round['question']['text']);

        $first = $this->submit('quiz/answer', ['token' => $round['token'], 'choice' => $right]);
        $first->assertOK();

        // same question again, before /next: refused, score must not move
        $this->submit('quiz/answer', ['token' => $round['token'], 'choice' => $right])->assertStatus(409);

        $attempt = $this->db->table('quiz_attempts')->where('token', $round['token'])->get()->getRowArray();
        $this->assertSame(1, (int) $attempt['score']);
    }

    public function testNextDoesNotRestartTheTimer(): void
    {
        $round = $this->startRound();
        $old   = (int) round(microtime(true) * 1000) - 5000;

        $this->db->table('quiz_attempts')->where('token', $round['token'])->update(['question_served_at_ms' => $old]);
        $this->submit('quiz/next', ['token' => $round['token']])->assertOK();

        $attempt = $this->db->table('quiz_attempts')->where('token', $round['token'])->get()->getRowArray();
        $this->assertSame($old, (int) $attempt['question_served_at_ms']);
    }

    public function testUnknownOrMalformedTokensAreRejected(): void
    {
        $this->submit('quiz/answer', ['token' => str_repeat('a', 32), 'choice' => 1])->assertStatus(404);
        $this->submit('quiz/answer', ['token' => "' OR 1=1 --", 'choice' => 1])->assertStatus(404);
        $this->submit('quiz/next', ['token' => ''])->assertStatus(404);
    }

    public function testFinishedRoundCannotBeReplayed(): void
    {
        $cfg                    = new Quiz();
        $cfg->questionsPerRound = 1;
        Factories::injectMock('config', 'Quiz', $cfg);

        $round = $this->startRound();
        $this->submit('quiz/answer', ['token' => $round['token'], 'choice' => 1])->assertOK();

        $this->submit('quiz/answer', ['token' => $round['token'], 'choice' => 1])->assertStatus(409);
        $this->submit('quiz/next', ['token' => $round['token']])->assertStatus(409);
    }

    // -------------------------------------------------------- leaderboard

    public function testLeaderboardRanksByScoreThenFastestTime(): void
    {
        $this->insertFinished('Slow10', 10, 50000);
        $this->insertFinished('Fast10', 10, 40000);
        $this->insertFinished('Quick9', 9, 10000);   // fast, but lower score still loses

        $entries = $this->json($this->get('quiz/leaderboard'))['entries'];

        $this->assertSame(['Fast10', 'Slow10', 'Quick9'], array_column($entries, 'name'));
        $this->assertSame([1, 2, 3], array_column($entries, 'rank'));
        $this->assertSame(40000, $entries[0]['timeMs']);
    }

    public function testExactTiesShareARank(): void
    {
        $this->insertFinished('First', 8, 30000);
        $this->insertFinished('Twin', 8, 30000);
        $this->insertFinished('Third', 7, 1000);

        $entries = $this->json($this->get('quiz/leaderboard'))['entries'];

        $this->assertSame([1, 1, 3], array_column($entries, 'rank'));
    }

    public function testUnfinishedRoundsAreNotOnTheBoard(): void
    {
        $this->startRound('Midway');

        $this->assertSame([], $this->json($this->get('quiz/leaderboard'))['entries']);
    }

    public function testBoardIsLimitedToTheConfiguredSize(): void
    {
        for ($i = 1; $i <= 15; $i++) {
            $this->insertFinished("Player {$i}", 5, $i * 1000);
        }

        $entries = $this->json($this->get('quiz/leaderboard'))['entries'];

        $this->assertCount((new Quiz())->leaderboardSize, $entries);
    }

    public function testCallsignsAreEscapedOnThePage(): void
    {
        // never reachable through validation, but the page must be safe even if the DB is dirty
        $this->insertFinished('<b>x</b>', 10, 1000);

        $body = $this->get('quiz')->getBody();

        $this->assertStringNotContainsString('<b>x</b>', $body);
        $this->assertStringContainsString('&lt;b&gt;x&lt;/b&gt;', $body);
    }

    // ----------------------------------------------------------- hardening

    public function testStartRequiresACsrfToken(): void
    {
        $this->expectException(SecurityException::class);

        // framework post(): no X-CSRF-TOKEN header, so the csrf filter must refuse it
        $this->post('quiz/start', ['player_name' => 'Neo One']);
    }

    public function testStartIsRateLimitedPerIp(): void
    {
        $limit = (new Quiz())->startsPerMinute;

        for ($i = 0; $i < $limit; $i++) {
            $this->submit('quiz/start', ['player_name' => 'Neo One'])->assertOK();
        }

        $this->submit('quiz/start', ['player_name' => 'Neo One'])->assertStatus(429);
    }
}