<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'parent_id' => ['type' => 'CHAR', 'constraint' => 36, 'null' => true],
            'name'       => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'       => ['type' => 'VARCHAR', 'constraint' => 120, 'unique' => true],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'description'=> ['type' => 'TEXT', 'null' => true],
            'is_active'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}
