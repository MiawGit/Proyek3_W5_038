<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Akun demo dibuat lewat seeder (tepercaya), bukan dari form registrasi publik (BR-01, BR-03)
        $users = [
            [
                'name' => 'Staff Toko',
                'email' => 'staff@tokoonline.test',
                'role' => 'staff',
            ],
            [
                'name' => 'Admin Toko',
                'email' => 'admin@tokoonline.test',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'password' => Hash::make('password123'),
                ]
            );
        }
    }
}
