<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil UserSeeder agar data 4 role (admin, siswa, mentor, pembimbing) ikut dimasukkan ke database
        $this->call([
            UserSeeder::class,
        ]);
    }
}
