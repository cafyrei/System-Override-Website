<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * SAMPLE questions so the quiz works on a fresh install. Generic gaming and
 * tech trivia: replace them with questions about your own game.
 *
 *   php spark db:seed QuizSeeder
 *
 * Does nothing if the table already has questions, so it is safe to re-run.
 */
class QuizSeeder extends Seeder
{
    public function run(): void
    {
        $table = $this->db->table('quiz_questions');

        if ($table->countAllResults() > 0) {
            return;
        }

        // [question, choice 1, choice 2, choice 3, choice 4, correct choice (1-4)]
        $questions = [
            ['What does "NPC" stand for in games?', 'Non-Player Character', 'New Player Content', 'Networked Play Console', 'Next Patch Cycle', 1],
            ['What does "HUD" stand for in a game interface?', 'High-Use Display', 'Heads-Up Display', 'Hardware Upgrade Deck', 'Hidden User Data', 2],
            ['What does "RPG" stand for?', 'Rapid Play Group', 'Real-time Pixel Graphics', 'Role-Playing Game', 'Remote Player Gateway', 3],
            ['What does "GPU" stand for?', 'General Purpose Unit', 'Game Power Utility', 'Graphics Processing Unit', 'Graphics Pixel Updater', 3],
            ['What does "CPU" stand for?', 'Central Processing Unit', 'Core Power Unit', 'Control Panel Utility', 'Computer Primary Update', 1],
            ['What does "RAM" stand for?', 'Rapid Access Module', 'Random Access Memory', 'Read-Only Archive Memory', 'Remote Application Manager', 2],
            ['Which language is used to style web pages?', 'SQL', 'Python', 'CSS', 'Bash', 3],
            ['What number system do computers use at the lowest level?', 'Decimal', 'Binary', 'Roman', 'Duodecimal', 2],
            ['Which of these is a PHP framework?', 'Django', 'Rails', 'Express', 'CodeIgniter', 4],
            ['What is the default port for HTTPS?', '21', '80', '443', '8080', 3],
            ['What does "HTTP" stand for?', 'HyperText Transfer Protocol', 'High Transfer Text Process', 'Hosted Terminal Transfer Page', 'HyperText Terminal Protocol', 1],
            ['What does "FPS" measure on a PC while gaming?', 'Frames per second', 'Files per session', 'Fragments per shot', 'Firewall packets per second', 1],
        ];

        $rows = [];

        foreach ($questions as [$q, $c1, $c2, $c3, $c4, $correct]) {
            $rows[] = [
                'question'       => $q,
                'choice_1'       => $c1,
                'choice_2'       => $c2,
                'choice_3'       => $c3,
                'choice_4'       => $c4,
                'correct_choice' => $correct,
                'is_active'      => 1,
            ];
        }

        $table->insertBatch($rows);
    }
}
