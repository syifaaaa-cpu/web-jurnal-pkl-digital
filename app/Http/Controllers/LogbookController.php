<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logbook;
use Illuminate\Support\Facades\Auth;

class LogbookController extends Controller
{
    /**
     * Menampilkan Halaman Dashboard Siswa
     * Beserta daftar semua logbook dan logbook terbaru milik siswa yang sedang login.
     */
    public function index()
    {
        $userId = Auth::id();

        // Mengambil semua logbook milik siswa yang sedang login (diurutkan dari ID terbesar / terbaru)
        $logbooks = Logbook::where('user_id', $userId)->orderBy('id', 'desc')->get();

        // Mengambil logbook paling baru untuk ditampilkan di kartu aktivitas utama dashboard
        $latestLogbook = Logbook::where('user_id', $userId)->orderBy('id', 'desc')->first();

        // Kirim data ke view dashboards.siswa
        return view('dashboards.siswa', compact('logbooks', 'latestLogbook'));
    }

    /**
     * Menampilkan Form Tambah Logbook Baru
     */
    public function create()
    {
        return view('dashboards.create-logbook');
    }

    /**
     * Menyimpan Data Inputan Siswa ke Database
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'tanggal' => 'required|date',
            'jam_kerja' => 'required|string',
            'judul_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // Simpan data ke tabel logbooks
        Logbook::create([
            'user_id' => Auth::id(), // Mengambil ID siswa yang sedang aktif/login
            'tanggal' => $request->tanggal,
            'jam_kerja' => $request->jam_kerja,
            'judul_kegiatan' => $request->judul_kegiatan,
            'deskripsi' => $request->deskripsi,
            'status' => 'Pending', // Status awal saat pertama kali dikirim
        ]);

        // Arahkan kembali ke dashboard dengan pesan sukses
        return redirect('/dashboard/siswa')->with('success', 'Logbook berhasil dikirim!');
    }
}
