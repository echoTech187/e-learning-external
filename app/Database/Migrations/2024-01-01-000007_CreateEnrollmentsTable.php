<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEnrollmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'order_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'progress'     => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => '0.00'],
            'enrolled_at'  => ['type' => 'DATETIME', 'null' => true],
            'completed_at' => ['type' => 'DATETIME', 'null' => true],
            'expires_at'   => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('enrollments');

        // Lesson progress
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'lesson_id' => ['type' => 'CHAR', 'constraint' => 36],
            'is_completed' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'watch_time'   => ['type' => 'INT', 'constraint' => 11, 'default' => 0], // seconds
            'completed_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('lesson_id', 'lessons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('lesson_progress');
    }

    public function down()
    {
        $this->forge->dropTable('lesson_progress');
        $this->forge->dropTable('enrollments');
    }
}
