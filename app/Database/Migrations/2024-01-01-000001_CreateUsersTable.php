<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'       => ['type' => 'ENUM', 'constraint' => ['admin', 'instructor', 'student', 'parent'], 'default' => 'student'],
            'photo'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'phone'      => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'remember_token' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
