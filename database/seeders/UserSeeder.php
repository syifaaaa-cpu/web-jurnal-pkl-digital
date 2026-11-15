<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed initial users across the 4 application roles.
     */
    public function run(): void
    {
        // 1. Akun Admin Utama (Permintaan Pengguna untuk Login & Kelola Persetujuan Akun)
        User::updateOrCreate(
            ['email' => 'm.dzikryfikry@gmail.com'],
            [
                'name' => 'M. Dzikry Fikry',
                'password' => Hash::make('Dzikry12345#'),
                'role' => 'admin',
                'status' => 'approved',
                'nip' => '199001012022031001',
                'phone' => '087744445006',
            ]
        );

        // 2. Akun Administrator Sistem (Default Backup)
        User::updateOrCreate(
            ['email' => 'admin@jurnal.com'],
            [
                'name' => 'Administrator Pokja Hubin',
                'password' => Hash::make('Admin12345#'),
                'role' => 'admin',
                'status' => 'approved',
                'phone' => '02187907233',
            ]
        );

        // 3. Akun Guru Pembimbing Sekolah
        $pembimbing = User::updateOrCreate(
            ['email' => 'pembimbing@jurnal.com'],
            [
                'name' => 'Drs. H. Ahmad Sudrajat, M.Pd.',
                'password' => Hash::make('Guru12345#'),
                'role' => 'pembimbing',
                'status' => 'approved',
                'nip' => '197805122005011003',
                'phone' => '081234567890',
            ]
        );

        // 4. Akun Mentor Industri DUDI
        $mentor = User::updateOrCreate(
            ['email' => 'mentor@jurnal.com'],
            [
                'name' => 'Ir. Hendra Kurniawan',
                'password' => Hash::make('Mentor12345#'),
                'role' => 'mentor',
                'status' => 'approved',
                'tempat_dudi' => 'PT. Ciptadra Softindo (Depok)',
                'dudi_lat' => -6.402484,
                'dudi_lng' => 106.794241,
                'phone' => '085678901234',
            ]
        );

        // 5. Akun Siswa Magang (Dengan NISN 10 Digit & Jurusan PPLG)
        User::updateOrCreate(
            ['email' => 'siswa@jurnal.com'],
            [
                'name' => 'Fajar Pratama',
                'password' => Hash::make('Siswa12345#'),
                'role' => 'siswa',
                'status' => 'approved',
                'nis' => '23241001',
                'nisn' => '0081234567',
                'departemen' => 'PPLG',
                'phone' => '089876543210',
                'tempat_dudi' => 'PT. Ciptadra Softindo (Depok)',
                'dudi_lat' => -6.402484,
                'dudi_lng' => 106.794241,
                'mentor_id' => $mentor->id,
            ]
        );
    }
}
