<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@jurnal.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Siswa PKL',
            'email' => 'siswa@jurnal.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        User::create([
            'name' => 'Mentor Perusahaan',
            'email' => 'mentor@jurnal.com',
            'password' => Hash::make('password123'),
            'role' => 'mentor',
        ]);

        User::create([
            'name' => 'Guru Pembimbing',
            'email' => 'pembimbing@jurnal.com',
            'password' => Hash::make('password123'),
            'role' => 'pembimbing',
        ]);
    }
}
