<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGamePatches extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'patch_id'          => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'patch_path'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'patch_title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'patch_description' => ['type' => 'TEXT'],
            'patch_version'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'patch_type'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'patch_release'     => ['type' => 'DATE'],
        ]);
        $this->forge->addKey('patch_id', true);
        // IF NOT EXISTS: databases created from the old README SQL keep working.
        $this->forge->createTable('game_patches', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('game_patches', true);
    }
}
