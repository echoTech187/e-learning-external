<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'order_code'     => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'user_id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'amount'         => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'discount'       => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'total'          => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'status'         => ['type' => 'ENUM', 'constraint' => ['pending', 'paid', 'failed', 'cancelled', 'refunded'], 'default' => 'pending'],
            'payment_method' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'payment_proof'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'payment_date'   => ['type' => 'DATETIME', 'null' => true],
            'notes'          => ['type' => 'TEXT', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('course_id', 'courses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
