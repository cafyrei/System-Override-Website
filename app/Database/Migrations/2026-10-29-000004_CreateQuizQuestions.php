<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateQuizQuestions extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'question'       => ['type' => 'TEXT'],
            'choice_1'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'choice_2'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'choice_3'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'choice_4'       => ['type' => 'VARCHAR', 'constraint' => 255],
            // Which of choice_1..choice_4 is right (1-4). Never sent to the browser before answering.
            'correct_choice' => ['type' => 'TINYINT', 'constraint' => 1, 'unsigned' => true],
            // 0 hides a question from rounds without deleting it.
            'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'     => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('quiz_questions', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('quiz_questions', true);
    }
}