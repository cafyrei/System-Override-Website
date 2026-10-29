<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGallery extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'gallery_id'          => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'image_path'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'gallery_title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'gallery_description' => ['type' => 'TEXT'],
        ]);
        $this->forge->addKey('gallery_id', true);
        $this->forge->createTable('gallery', true);
    }

    public function down(): void
    {
        $this->forge->dropTable('gallery', true);
    }
}
