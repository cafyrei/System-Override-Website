<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateQuizAttempts extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            // Random secret the browser holds for the duration of one round.
            'token'                 => ['type' => 'VARCHAR', 'constraint' => 32],
            'player_name'           => ['type' => 'VARCHAR', 'constraint' => 20],
            // JSON list of the question ids picked for this round, in order.
            'question_ids'          => ['type' => 'TEXT'],
            'total_questions'       => ['type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => true],
            'current_index'         => ['type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => true, 'default' => 0],
            'score'                 => ['type' => 'SMALLINT', 'constraint' => 5, 'unsigned' => true, 'default' => 0],
            // Sum of time charged per question. A wrong or late answer is charged the full limit.
            'total_time_ms'         => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'default' => 0],
            // Server clock (unix ms) when the current question was handed out. NULL = none active.
            'question_served_at_ms' => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'null' => true],
            'finished'              => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at'            => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('token');
        $this->forge->addKey(['finished', 'score', 'total_time_ms']); // leaderboard ordering
        $this->forge->createTable('quiz_attempts', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('quiz_attempts', true);
    }
}