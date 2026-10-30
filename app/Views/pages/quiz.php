<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= csrf_meta() ?>
    <link rel="icon" type="image/x-icon" href="<?= base_url('Override.png'); ?>" sizes="32x32">
    <link rel="stylesheet" href="<?= base_url('css/output.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/global.css') ?>">
    <link rel="stylesheet" href="<?= base_url('css/pages/quiz.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=JetBrains+Mono:wght@300;400;700&display=swap" rel="stylesheet">
    <title>System Override | Override Quiz</title>
</head>

<body class="text-white" data-audio="<?= base_url('./audio/override-sfx-adsion-protocol.mp3') ?>">

    <div class="cyber-grid"></div>

    <?= $this->include('partials/navbar') ?>

    <?= $this->include('partials/cyber-preloader') ?>

    <main class="quiz-page">

        <header class="quiz-hero">
            <h1>Override <span>Quiz</span></h1>
            <p>
                <?= esc($perRound) ?> questions &middot; <?= esc($cfg->secondsPerQuestion) ?>s each &middot;
                highest score wins, fastest time breaks the tie
            </p>
        </header>

        <div class="quiz-layout">

            <!-- ===================== GAME PANEL ===================== -->
            <section class="quiz-panel" aria-label="Quiz">

                <!-- START -->
                <div id="screen-start" class="quiz-screen">
                    <p class="quiz-label">// Identify</p>
                    <h2 class="quiz-title">Enter your callsign</h2>

                    <form id="start-form" class="quiz-form" autocomplete="off" novalidate>
                        <label for="player-name" class="quiz-label">Callsign</label>
                        <input id="player-name" name="player_name" type="text" class="quiz-input"
                            minlength="<?= esc($cfg->nameMin) ?>" maxlength="<?= esc($cfg->nameMax) ?>"
                            placeholder="User-X" required>
                        <p id="start-error" class="quiz-error" role="alert" hidden></p>

                        <button id="start-btn" type="submit" class="quiz-btn" <?= $perRound < 1 ? 'disabled' : '' ?>>
                            Initiate_Round
                        </button>

                        <?php if ($perRound < 1) : ?>
                            <p class="quiz-error">No questions have been loaded yet. Check back soon.</p>
                        <?php endif; ?>
                    </form>

                    <p class="quiz-hint">
                        Answer with the mouse, or press <kbd>1</kbd>&ndash;<kbd>4</kbd> / <kbd>A</kbd>&ndash;<kbd>D</kbd>.
                        A wrong or late answer costs the full <?= esc($cfg->secondsPerQuestion) ?> seconds.
                    </p>
                </div>

                <!-- PLAY -->
                <div id="screen-play" class="quiz-screen" hidden>
                    <div class="quiz-meta">
                        <span id="q-number" class="quiz-label">1 / <?= esc($perRound) ?></span>
                        <span class="quiz-label">Score <strong id="score">0</strong></span>
                    </div>

                    <div class="quiz-progress" aria-hidden="true"><div id="progress-bar"></div></div>

                    <div class="quiz-timer" aria-hidden="true">
                        <div id="timer-bar"></div>
                        <span id="timer-text">--</span>
                    </div>

                    <h2 id="q-text" class="quiz-question" aria-live="polite"></h2>

                    <div id="choices" class="quiz-choices">
                        <?php foreach (['A', 'B', 'C', 'D'] as $i => $letter) : ?>
                            <button type="button" class="quiz-choice" data-choice="<?= $i + 1 ?>">
                                <span class="quiz-choice-key"><?= $letter ?></span>
                                <span class="quiz-choice-text"></span>
                            </button>
                        <?php endforeach; ?>
                    </div>

                    <p id="feedback" class="quiz-feedback" aria-live="assertive"></p>
                </div>

                <!-- RESULT -->
                <div id="screen-result" class="quiz-screen" hidden>
                    <p class="quiz-label">// Round complete</p>
                    <h2 class="quiz-title" id="result-name"></h2>

                    <div class="quiz-stats">
                        <div><span class="quiz-label">Score</span><strong id="result-score">0 / 0</strong></div>
                        <div><span class="quiz-label">Total time</span><strong id="result-time">0.00s</strong></div>
                        <div><span class="quiz-label">Rank</span><strong id="result-rank">#-</strong></div>
                    </div>

                    <button id="again-btn" type="button" class="quiz-btn">Play_Again</button>
                </div>

            </section>

            <!-- ===================== LEADERBOARD ===================== -->
            <aside class="quiz-panel" aria-label="Leaderboard">
                <p class="quiz-label">// Leaderboard</p>
                <h2 class="quiz-title">Fastest operators</h2>

                <table class="quiz-board">
                    <thead>
                        <tr><th>#</th><th>Callsign</th><th>Score</th><th>Time</th></tr>
                    </thead>
                    <tbody id="board-body">
                        <?php if (empty($leaderboard)) : ?>
                            <tr class="quiz-board-empty"><td colspan="4">No finished rounds yet. Be the first.</td></tr>
                        <?php else : ?>
                            <?php foreach ($leaderboard as $row) : ?>
                                <tr>
                                    <td><?= esc($row['rank']) ?></td>
                                    <td><?= esc($row['player_name']) ?></td>
                                    <td><?= esc($row['score']) ?>/<?= esc($row['total_questions']) ?></td>
                                    <td><?= number_format(((int) $row['total_time_ms']) / 1000, 2) ?>s</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </aside>

        </div>
    </main>

    <?= $this->include('partials/footer') ?>

    <script>
        window.QUIZ = <?= json_encode([
                            'startUrl'       => site_url('quiz/start'),
                            'nextUrl'        => site_url('quiz/next'),
                            'answerUrl'      => site_url('quiz/answer'),
                            'leaderboardUrl' => site_url('quiz/leaderboard'),
                            'feedbackMs'     => $cfg->feedbackMs,
                        ], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
    </script>
    <script src="<?= base_url('js/partials/loading.js') ?>"></script>
    <script src="<?= base_url('js/main/quiz.js') ?>"></script>
    <script src="<?= base_url('js/partials/audio-manager.js') ?>"></script>
</body>

</html>
