<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Pertama',
            'email' => 'admin1@sejenak.com',
            'username' => 'admin1',
            'nomor_hp' => '081234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin Kedua',
            'email' => 'admin2@sejenak.com',
            'username' => 'admin2',
            'nomor_hp' => '081234567891',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Admin Ketiga',
            'email' => 'admin3@sejenak.com',
            'username' => 'admin3',
            'nomor_hp' => '081234567892',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
