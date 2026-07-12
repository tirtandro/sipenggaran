<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sman2wates.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Guru BK - Siti Nurhaliza',
            'email' => 'gurubk@sman2wates.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_bk',
        ]);

        User::create([
            'name' => 'Guru Piket - Budi Santoso',
            'email' => 'gurupiket@sman2wates.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_piket',
        ]);

        User::create([
            'name' => 'Wali Kelas X A - Dewi Lestari',
            'email' => 'walikelas@sman2wates.sch.id',
            'password' => Hash::make('password'),
            'role' => 'wali_kelas',
            'kelas_id' => 16,
        ]);
    }
}
