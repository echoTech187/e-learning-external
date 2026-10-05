<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Pemrograman', 'slug' => 'pemrograman', 'icon' => 'fas fa-code', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Desain Grafis', 'slug' => 'desain-grafis', 'icon' => 'fas fa-paint-brush', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Bisnis & Kewirausahaan', 'slug' => 'bisnis-kewirausahaan', 'icon' => 'fas fa-briefcase', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pemasaran Digital', 'slug' => 'pemasaran-digital', 'icon' => 'fas fa-bullhorn', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Pengembangan Diri', 'slug' => 'pengembangan-diri', 'icon' => 'fas fa-brain', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Bahasa', 'slug' => 'bahasa', 'icon' => 'fas fa-language', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Keuangan & Akuntansi', 'slug' => 'keuangan-akuntansi', 'icon' => 'fas fa-chart-line', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
            ['name' => 'Data Science & AI', 'slug' => 'data-science-ai', 'icon' => 'fas fa-robot', 'is_active' => 1, 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('categories')->insertBatch($categories);
        echo "✅ Categories seeded!\n";
    }
}
