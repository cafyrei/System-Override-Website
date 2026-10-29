<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserFeedback extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'feedback_id'   => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'username'      => ['type' => 'VARCHAR', 'constraint' => 50],
            // Allowed values (suggestion, bug_report) are enforced by validation in
            // Pages\Feedback; a plain VARCHAR keeps this portable across DB drivers.
            'feedback_type' => ['type' => 'VARCHAR', 'constraint' => 20],
            'comment'       => ['type' => 'TEXT'],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'status'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'unread'],
            'created_at'    => ['type' => 'DATETIME', 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('feedback_id', true);
        $this->forge->createTable('user_feedback', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('user_feedback', true);
    }
}
