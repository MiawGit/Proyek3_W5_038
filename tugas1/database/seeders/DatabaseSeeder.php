<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'budi',
            'password' => 'budi123',
            'nama_lengkap' => 'Budi Santoso',
        ]);

        User::create([
            'username' => 'siti',
            'password' => 'siti123',
            'nama_lengkap' => 'Siti Aminah',
        ]);
    }
}