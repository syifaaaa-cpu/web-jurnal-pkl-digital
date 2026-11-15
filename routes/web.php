<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\PembimbingController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Jurnal PKL Digital SMKN 1 Depok
|--------------------------------------------------------------------------
*/

// --- 0. BATASAN PARAMETER GLOBAL (Pencegahan SQL Injection pada URL) ---
Route::pattern('id', '[0-9]+');

// --- 1. RUTE PUBLIK (TIDAK PERLU LOGIN) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:3,1');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- 2. RUTE TERPROTEKSI (WAJIB LOGIN) DENGAN RBAC ---

// A. Role: ADMIN PUSAT (Pokja Hubin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Manajemen Pengguna & Persetujuan Akun Baru
    Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    Route::post('/admin/users/{id}/approve', [AdminController::class, 'approveUser'])->name('admin.users.approve');
    Route::post('/admin/users/{id}/reject', [AdminController::class, 'rejectUser'])->name('admin.users.reject');

    // Plotting & Kelompok PKL
    Route::post('/dashboard/admin/plotting', [AdminController::class, 'storePlotting'])->name('admin.plotting.store');

    // Timeline, Kuota & Pengaturan Sistem
    Route::post('/admin/timeline/update', [AdminController::class, 'updateTimeline'])->name('admin.timeline.update');
    Route::post('/admin/settings/umum', [AdminController::class, 'updateSettingUmum'])->name('admin.settings.umum');
    Route::post('/admin/settings/sekolah', [AdminController::class, 'updateSettingSekolah'])->name('admin.settings.sekolah');
    Route::post('/admin/settings/keamanan', [AdminController::class, 'updateSettingKeamanan'])->name('admin.settings.keamanan');
    Route::post('/admin/settings/notifikasi', [AdminController::class, 'updateSettingNotifikasi'])->name('admin.settings.notifikasi');

    // Ekspor Laporan & Sertifikat (Dibatasi Throttle Anti-DDoS)
    Route::get('/admin/export-laporan', [AdminController::class, 'exportLaporan'])->name('admin.export.laporan')->middleware('throttle:6,1');
    Route::get('/admin/export-sertifikat', [AdminController::class, 'exportSertifikat'])->name('admin.export.sertifikat')->middleware('throttle:6,1');
});

// B. Role: GURU PEMBIMBING (Sekolah)
Route::middleware(['auth', 'role:pembimbing'])->group(function () {
    Route::get('/dashboard/pembimbing', [PembimbingController::class, 'index'])->name('dashboard.pembimbing');
    Route::post('/dashboard/pembimbing/nilai/{id}', [PembimbingController::class, 'updateNilaiLaporan'])->name('pembimbing.update.laporan');
    Route::get('/dashboard/pembimbing/logbook/export/{id}', [PembimbingController::class, 'exportLogbook'])->name('pembimbing.export.logbook')->middleware('throttle:6,1');
    Route::get('/dashboard/pembimbing/export-excel', [PembimbingController::class, 'exportExcel'])->name('pembimbing.export.excel')->middleware('throttle:6,1');
    Route::post('/dashboard/pembimbing/profile/update', [PembimbingController::class, 'updateProfile'])->name('pembimbing.update.profile');
});

// C. Role: MENTOR INDUSTRI (DUDI)
Route::middleware(['auth', 'role:mentor,mentor_dudi'])->group(function () {
    Route::get('/dashboard/mentor-dudi', [MentorController::class, 'index'])->name('dashboard.mentor');
    Route::post('/dashboard/mentor/logbook/{id}', [MentorController::class, 'updateLogbookStatus'])->name('mentor.logbook.update');
    Route::post('/dashboard/mentor/nilai', [MentorController::class, 'storeNilai'])->name('mentor.store.nilai');
});

// D. Role: SISWA MAGANG
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/dashboard/siswa', [SiswaController::class, 'index'])->name('dashboard.siswa');
    Route::get('/dashboard/siswa/logbook/create', [LogbookController::class, 'create'])->name('siswa.logbook.create');
    Route::post('/dashboard/siswa/logbook', [LogbookController::class, 'store'])->name('siswa.logbook.store')->middleware('throttle:15,1');
    Route::post('/dashboard/siswa/attendance', [AttendanceController::class, 'store'])->name('attendance.store')->middleware('throttle:10,1');
    Route::put('/dashboard/siswa/profile/update', [SiswaController::class, 'updateProfile'])->name('siswa.profile.update');
    Route::put('/dashboard/siswa/password/update', [SiswaController::class, 'updatePassword'])->name('siswa.password.update')->middleware('throttle:5,1');
});

// E. Rute Bersama yang Memerlukan Login
Route::middleware(['auth'])->group(function () {
    Route::get('/export/sertifikat', [AdminController::class, 'exportSertifikat'])->name('export.sertifikat')->middleware('throttle:6,1');
});
