<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCourseSectionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'=> ['type' => 'TEXT', 'null' => true],
            'order'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('course_sections');
    }

    public function down()
    {
        $this->forge->dropTable('course_sections');
    }
}
