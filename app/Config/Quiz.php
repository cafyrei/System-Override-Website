<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Quiz settings. Every value can be overridden from .env, e.g.
 *
 *   quiz.questionsPerRound = 15
 *   quiz.secondsPerQuestion = 20
 *
 * If you change questionsPerRound on a live site, old and new scores are not
 * comparable (9/10 vs 9/15). Clear `quiz_attempts` when you change it.
 */
class Quiz extends BaseConfig
{
    /** Questions in one round. Capped at the number of active questions in the pool. */
    public int $questionsPerRound = 10;

    /** Time allowed per question. */
    public int $secondsPerQuestion = 15;

    /** Rows shown on the leaderboard. */
    public int $leaderboardSize = 10;

    /** Rounds one IP may start per minute. */
    public int $startsPerMinute = 10;

    /** Answers faster than this are recorded as this (no human reads + clicks in 0 ms). */
    public int $minAnswerMs = 250;

    /** Slack added to the time limit to cover network latency before an answer counts as late. */
    public int $graceMs = 1500;

    /** How long the browser pauses on the right/wrong feedback before the next question. */
    public int $feedbackMs = 1400;

    public int $nameMin = 3;

    public int $nameMax = 20;
}