<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        
        \App\Models\User::create([
            'name' => 'Guru Budi',
            'email' => 'guru@sekolah.com',
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        \App\Models\User::create([
            'name' => 'Siswa Ani',
            'email' => 'siswa@sekolah.com',
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);
    }
}
