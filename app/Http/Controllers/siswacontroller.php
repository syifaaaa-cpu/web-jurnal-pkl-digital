<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaController extends Controller
{
    // Menampilkan halaman Dashboard Siswa
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil data logbook siswa yang sedang login
        $logbooks = DB::table('logbooks')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data absensi siswa yang sedang login
        $attendances = DB::table('attendances')
            ->where('user_id', $user->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        // Ambil nilai akhir/rekap nilai siswa dari tabel grades
        $grade = DB::table('grades')
            ->where('student_id', $user->id)
            ->first();

        return view('dashboards.siswa', compact(
            'user',
            'logbooks',
            'attendances',
            'grade'
        ));
    }

    // Memperbarui Profil dan Titik Koordinat DUDI Siswa
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'departemen'  => 'nullable|string|max:255',
            'nis'         => 'nullable|string|max:50',
            'tempat_dudi' => 'required|string|max:255',
            'dudi_lat'    => 'required|numeric',
            'dudi_lng'    => 'required|numeric',
        ]);

        $user->departemen  = $request->input('departemen');
        $user->nis         = $request->input('nis');
        $user->tempat_dudi = $request->input('tempat_dudi');
        $user->dudi_lat    = $request->input('dudi_lat');
        $user->dudi_lng    = $request->input('dudi_lng');
        $user->save();

        return back()->with('success', 'Profil dan titik koordinat DUDI siswa berhasil diperbarui!');
    }
    // Memperbarui Kata Sandi / Password Siswa
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed', // Membutuhkan input konfirmasi dengan name="new_password_confirmation"
        ]);

        $user = Auth::user();

        // Periksa apakah sandi saat ini cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok!']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Kata sandi akun berhasil diperbarui!');
    }
}
