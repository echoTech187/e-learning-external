<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserProfilesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'parent_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true], // for student -> parent link
            'bio'         => ['type' => 'TEXT', 'null' => true],
            'address'     => ['type' => 'TEXT', 'null' => true],
            'birth_date'  => ['type' => 'DATE', 'null' => true],
            'gender'      => ['type' => 'ENUM', 'constraint' => ['male', 'female', 'other'], 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('user_profiles');
    }
}
