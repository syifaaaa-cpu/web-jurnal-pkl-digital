<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// 1. Halaman Utama (Homepage)
Route::get('/', function () {
    return view('welcome-mockup');
});

// 2. Halaman Form Login Mockup
Route::get('/login', function (Request $request) {
    $role = $request->query('role', 'siswa'); // Menangkap role yang dipilih dari URL
    return view('login-mockup', ['role' => $role]);
});

// 3. Halaman Dashboard tiruan (Mockup) untuk 4 Role
Route::get('/dashboard/siswa', function () {
    return view('dashboards.siswa');
});

Route::get('/dashboard/mentor-dudi', function () {
    return view('dashboards.mentor-dudi');
});

Route::get('/dashboard/pembimbing', function () {
    return view('dashboards.pembimbing');
});

Route::get('/dashboard/Admin', function () {
    return view('dashboards.Admin');
});
