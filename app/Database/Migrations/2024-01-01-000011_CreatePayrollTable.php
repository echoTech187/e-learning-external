<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePayrollTable extends Migration
{
    public function up()
    {
        // Mentor earnings per order
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'instructor_id' => ['type' => 'CHAR', 'constraint' => 36],
            'order_id' => ['type' => 'CHAR', 'constraint' => 36],
            'course_id' => ['type' => 'CHAR', 'constraint' => 36],
            'gross_amount'  => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'platform_fee'  => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => '0.00'],
            'net_amount'    => ['type' => 'DECIMAL', 'constraint' => '12,2'],
            'period'        => ['type' => 'VARCHAR', 'constraint' => 7, 'null' => true], // e.g. 2024-01
            'status'        => ['type' => 'ENUM', 'constraint' => ['pending', 'processed', 'paid'], 'default' => 'pending'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('instructor_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('mentor_earnings');

        // Payroll periods
        $this->forge->addField([
            'id' => ['type' => 'CHAR', 'constraint' => 36],
            'period'       => ['type' => 'VARCHAR', 'constraint' => 7], // e.g. 2024-01
            'start_date'   => ['type' => 'DATE'],
            'end_date'     => ['type' => 'DATE'],
            'status'       => ['type' => 'ENUM', 'constraint' => ['draft', 'processed', 'paid'], 'default' => 'draft'],
            'total_amount' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00'],
            'notes'        => ['type' => 'TEXT', 'null' => true],
            'processed_at' => ['type' => 'DATETIME', 'null' => true],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payroll_periods');
    }

    public function down()
    {
        $this->forge->dropTable('payroll_periods');
        $this->forge->dropTable('mentor_earnings');
    }
}
