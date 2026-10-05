<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name'       => 'Super Admin',
                'email'      => 'admin@elearning.id',
                'password'   => password_hash('Admin@123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Budi Santoso',
                'email'      => 'instruktur@elearning.id',
                'password'   => password_hash('Instruktur@123', PASSWORD_DEFAULT),
                'role'       => 'instructor',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Siti Rahma',
                'email'      => 'siswa@elearning.id',
                'password'   => password_hash('Siswa@123', PASSWORD_DEFAULT),
                'role'       => 'student',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Ahmad Yani',
                'email'      => 'orangtua@elearning.id',
                'password'   => password_hash('OrangTua@123', PASSWORD_DEFAULT),
                'role'       => 'parent',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($users);

        // Insert profiles for each user
        $profiles = [];
        $ids = $this->db->table('users')->select('id, role')->get()->getResultArray();
        $parentId = null;
        $studentId = null;
        foreach ($ids as $user) {
            if ($user['role'] === 'parent') $parentId = $user['id'];
            if ($user['role'] === 'student') $studentId = $user['id'];
        }

        foreach ($ids as $user) {
            $profiles[] = [
                'user_id'    => $user['id'],
                'parent_id'  => ($user['role'] === 'student') ? $parentId : null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->db->table('user_profiles')->insertBatch($profiles);

        echo "✅ Users seeded!\n";
        echo "   - admin@elearning.id / Admin@123\n";
        echo "   - instruktur@elearning.id / Instruktur@123\n";
        echo "   - siswa@elearning.id / Siswa@123\n";
        echo "   - orangtua@elearning.id / OrangTua@123\n";
    }
}
