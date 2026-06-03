<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Studio',
            'email' => 'admin@sejenak.com',
            'username' => 'admin_studio',
            'nomor_hp' => '081234567899',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        $this->call([
            AdminSeeder::class,
            ServicePackageSeeder::class,
            FaqSeeder::class,
            GallerySeeder::class,
        ]);
    }
}
