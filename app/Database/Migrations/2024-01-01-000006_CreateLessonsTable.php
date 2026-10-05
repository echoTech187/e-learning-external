<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLessonsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'section_id' => ['type' => 'CHAR', 'constraint' => 36],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'type'        => ['type' => 'ENUM', 'constraint' => ['video', 'youtube', 'pdf', 'article', 'quiz', 'live'], 'default' => 'video'],
            'content'     => ['type' => 'TEXT', 'null' => true], // URL/path/content
            'description' => ['type' => 'TEXT', 'null' => true],
            'duration'    => ['type' => 'INT', 'constraint' => 11, 'default' => 0], // minutes
            'is_free'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_published'=> ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'order'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('section_id', 'course_sections', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lessons');
    }

    public function down()
    {
        $this->forge->dropTable('lessons');
    }
}
