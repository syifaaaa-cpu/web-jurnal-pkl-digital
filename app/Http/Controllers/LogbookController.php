<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller LogbookController menangani pencatatan dan pengelolaan
 * jurnal aktivitas harian kerja praktik oleh siswa magang.
 */
class LogbookController extends Controller
{
    /**
     * Menampilkan formulir tambah logbook / jurnal kegiatan harian.
     */
    public function create(): View
    {
        return view('dashboards.create-logbook');
    }

    /**
     * Menyimpan data logbook kegiatan harian siswa ke database.
     *
     * Logika Alur Bisnis:
     * 1. Validasi masukan tanggal, jam kerja, judul aktivitas, dan deskripsi tugas.
     * 2. Otomatis membersihkan masukan dari tag skrip berbahaya via SanitizeInputMiddleware.
     * 3. Pengikatan kepemilikan logbook ke ID akun siswa yang sedang login (Auth::id()).
     * 4. Inisialisasi status logbook sebagai 'Pending' menunggu review mentor industri.
     */
    public function store(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Validasi Masukan Jurnal Harian ---
        $request->validate([
            'tanggal' => 'required|date',
            'jam_kerja' => 'required|string|max:50',
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // --- LANGKAH 2: Simpan Record Jurnal dengan Status 'Pending' ---
        Logbook::create([
            'user_id' => Auth::id(),
            'tanggal' => $request->tanggal,
            'jam_kerja' => $request->jam_kerja,
            'judul_kegiatan' => $request->judul_kegiatan,
            'deskripsi' => $request->deskripsi,
            'status' => 'Pending',
        ]);

        return redirect('/dashboard/siswa')->with('success', 'Logbook kegiatan harian berhasil dikirim!');
    }
}
