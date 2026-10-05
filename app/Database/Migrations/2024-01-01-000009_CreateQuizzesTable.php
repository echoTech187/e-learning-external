<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        // Quizzes
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'lesson_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'duration'      => ['type' => 'INT', 'constraint' => 11, 'default' => 30], // minutes
            'passing_score' => ['type' => 'INT', 'constraint' => 11, 'default' => 70],
            'max_attempts'  => ['type' => 'INT', 'constraint' => 11, 'default' => 3],
            'shuffle'       => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_active'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quizzes');

        // Questions
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'quiz_id' => ['type' => 'CHAR', 'constraint' => 36],
            'question'    => ['type' => 'TEXT'],
            'type'        => ['type' => 'ENUM', 'constraint' => ['multiple_choice', 'true_false', 'essay'], 'default' => 'multiple_choice'],
            'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'points'      => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'explanation' => ['type' => 'TEXT', 'null' => true],
            'order'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('questions');

        // Question options
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'question_id' => ['type' => 'CHAR', 'constraint' => 36],
            'option_text' => ['type' => 'TEXT'],
            'is_correct'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'order'       => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_id', 'questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('question_options');

        // Quiz attempts
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'quiz_id' => ['type' => 'CHAR', 'constraint' => 36],
            'score'       => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => '0.00'],
            'total_points'=> ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'earned_points'=> ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'is_passed'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'started_at'  => ['type' => 'DATETIME', 'null' => true],
            'finished_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_attempts');

        // Quiz answers
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'attempt_id' => ['type' => 'CHAR', 'constraint' => 36],
            'question_id' => ['type' => 'CHAR', 'constraint' => 36],
            'answer'      => ['type' => 'TEXT', 'null' => true],
            'is_correct'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('attempt_id', 'quiz_attempts', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_answers');
    }

    public function down()
    {
        $this->forge->dropTable('quiz_answers');
        $this->forge->dropTable('quiz_attempts');
        $this->forge->dropTable('question_options');
        $this->forge->dropTable('questions');
        $this->forge->dropTable('quizzes');
    }
}
