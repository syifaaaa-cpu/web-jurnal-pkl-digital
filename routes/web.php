<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Utama (Homepage)
Route::get('/', function () {
    return view('welcome-mockup');
});

// 2. Halaman Form Login
Route::get('/login', function () {
    return view('login-mockup');
})->name('login');

// 3. Proses Login Backend (POST dari form login)
Route::post('/login', [AuthController::class, 'login']);

// 4. Proses Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 5. Rute yang Membutuhkan Autentikasi (Wajib Login)
Route::middleware(['auth'])->group(function () {

    // Route untuk Manajemen Akun Admin
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Dashboard Siswa
    Route::get('/dashboard/siswa', [LogbookController::class, 'index']);

    // Rute untuk Tambah & Simpan Logbook Siswa
    Route::get('/dashboard/siswa/logbook/create', [LogbookController::class, 'create']);
    Route::post('/dashboard/siswa/logbook', [LogbookController::class, 'store']);

    Route::post('/dashboard/siswa/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::put('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Route untuk Halaman Dashboard Admin & Plotting Kelompok
    Route::get('/dashboard/Admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/dashboard/admin/plotting', [AdminController::class, 'storePlotting'])->name('admin.plotting.store');

    // Route untuk Dashboard Mentor DUDI & Validasi Jurnal
    Route::get('/dashboard/mentor-dudi', [MentorController::class, 'index'])->name('dashboard.mentor');
    Route::post('/dashboard/mentor/logbook/{id}', [MentorController::class, 'updateLogbookStatus'])->name('mentor.logbook.update');

    // Route Export Laporan & Sertifikat
    Route::get('/admin/export-laporan', [AdminController::class, 'exportLaporan'])->name('admin.export.laporan');
    Route::get('/admin/export-sertifikat', [AdminController::class, 'exportSertifikat'])->name('admin.export.sertifikat');

    // Route Timeline & Pengaturan Sistem Admin
    Route::post('/admin/timeline/update', [AdminController::class, 'updateTimeline'])->name('admin.timeline.update');
    Route::post('/admin/settings/update', [AdminController::class, 'updateTimeline'])->name('admin.settings.update');
    Route::post('/admin/settings/umum', [AdminController::class, 'updateSettingUmum'])->name('admin.settings.umum');
    Route::post('/admin/settings/sekolah', [AdminController::class, 'updateSettingSekolah'])->name('admin.settings.sekolah');
    Route::post('/admin/settings/keamanan', [AdminController::class, 'updateSettingKeamanan'])->name('admin.settings.keamanan');
    Route::post('/admin/settings/notifikasi', [AdminController::class, 'updateSettingNotifikasi'])->name('admin.settings.notifikasi');

    // Dashboard Pembimbing Sekolah (Opsional)
    Route::get('/dashboard/pembimbing', function () {
        return view('dashboards.pembimbing');
    });

    Route::post('/dashboard/mentor/nilai', [MentorController::class, 'storeNilai'])->name('mentor.store.nilai');

    Route::middleware(['auth'])->group(function () {
    // Route untuk dashboard guru pembimbing
    Route::get('/dashboard/pembimbing', [PembimbingController::class, 'index'])->name('dashboard.pembimbing');

    // Route untuk menyimpan nilai laporan pembimbing
    Route::post('/dashboard/pembimbing/nilai/{id}', [PembimbingController::class, 'updateNilaiLaporan'])->name('pembimbing.update.laporan');
});
Route::middleware(['auth'])->group(function () {
    // Route untuk mengunduh sertifikat / arsip PDF
    Route::get('/export/sertifikat', [AdminController::class, 'exportSertifikat'])->name('export.sertifikat');
});
Route::get('/dashboard/pembimbing/logbook/export/{id}', [PembimbingController::class, 'exportLogbook'])->name('pembimbing.export.logbook');

Route::middleware(['auth'])->group(function () {
    // Route download rekap keseluruhan nilai siswa
    Route::get('/dashboard/pembimbing/export-excel', [PembimbingController::class, 'exportExcel'])->name('pembimbing.export.excel');
});
Route::middleware(['auth'])->group(function () {
    // Route untuk menyimpan pembaruan profil guru pembimbing
    Route::post('/dashboard/pembimbing/profile/update', [PembimbingController::class, 'updateProfile'])->name('pembimbing.update.profile');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'index'])->name('dashboard.siswa');
    Route::put('/dashboard/siswa/profile/update', [SiswaController::class, 'updateProfile'])->name('siswa.profile.update');
    Route::put('/dashboard/siswa/password/update', [SiswaController::class, 'updatePassword'])->name('siswa.password.update');
});
});
