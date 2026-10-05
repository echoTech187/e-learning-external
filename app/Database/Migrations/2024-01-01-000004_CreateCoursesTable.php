<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCoursesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'instructor_id' => ['type' => 'CHAR', 'constraint' => 36],
            'category_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'slug'          => ['type' => 'VARCHAR', 'constraint' => 280, 'unique' => true],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'thumbnail'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'trailer_video' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'price'         => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'discount_price'=> ['type' => 'DECIMAL', 'constraint' => '12,2', 'null' => true],
            'level'         => ['type' => 'ENUM', 'constraint' => ['beginner', 'intermediate', 'advanced', 'all'], 'default' => 'all'],
            'language'      => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Indonesia'],
            'status'        => ['type' => 'ENUM', 'constraint' => ['draft', 'published', 'archived'], 'default' => 'draft'],
            'is_featured'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'total_students'=> ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_lessons' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'total_duration'=> ['type' => 'INT', 'constraint' => 11, 'default' => 0], // in minutes
            'rating'        => ['type' => 'DECIMAL', 'constraint' => '3,2', 'default' => '0.00'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('instructor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('courses');
    }

    public function down()
    {
        $this->forge->dropTable('courses');
    }
}
