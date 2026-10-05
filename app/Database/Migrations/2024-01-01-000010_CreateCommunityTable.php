<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommunityTable extends Migration
{
    public function up()
    {
        // Certificates
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'certificate_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'issued_at'          => ['type' => 'DATETIME', 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('certificates');

        // Discussions / Comments
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'lesson_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'parent_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'message'    => ['type' => 'TEXT'],
            'is_pinned'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'likes'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('discussions');

        // Notifications
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 200],
            'message'    => ['type' => 'TEXT'],
            'type'       => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'info'],
            'link'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'is_read'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('notifications');

        // Live classes
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'instructor_id' => ['type' => 'CHAR', 'constraint' => 36],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'platform'      => ['type' => 'ENUM', 'constraint' => ['zoom', 'gmeet', 'other'], 'default' => 'zoom'],
            'meeting_link'  => ['type' => 'VARCHAR', 'constraint' => 500],
            'meeting_id'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'passcode'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'scheduled_at'  => ['type' => 'DATETIME'],
            'duration'      => ['type' => 'INT', 'constraint' => 11, 'default' => 60],
            'status'        => ['type' => 'ENUM', 'constraint' => ['upcoming', 'ongoing', 'ended', 'cancelled'], 'default' => 'upcoming'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('instructor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('live_classes');

        // Reviews/Ratings
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'rating'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 5],
            'review'     => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('course_reviews');
    }

    public function down()
    {
        $this->forge->dropTable('course_reviews');
        $this->forge->dropTable('live_classes');
        $this->forge->dropTable('notifications');
        $this->forge->dropTable('discussions');
        $this->forge->dropTable('certificates');
    }
}
