<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller AttendanceController menangani presensi digital siswa magang
 * berbasis geolokasi GPS dengan perhitungan matematis formula Haversine.
 */
class AttendanceController extends Controller
{
    /**
     * Menyimpan data presensi masuk / pulang / izin / sakit siswa.
     *
     * Logika Alur Bisnis:
     * 1. Validasi masukan: status kehadiran dan koordinat lintang/bujur (wajib jika Hadir).
     * 2. Pengambilan koordinat referensi kantor DUDIKA siswa.
     * 3. Kalkulasi jarak bola bumi (Great-circle distance) via formula Haversine.
     * 4. Evaluasi toleransi radius 150 meter. Jika melampaui, status ditandai 'Diluar Radius DUDI'.
     * 5. Pencatatan presensi masuk jika belum ada, atau presensi pulang jika sudah absen masuk.
     */
    public function store(Request $request): RedirectResponse
    {
        // --- LANGKAH 1: Inisialisasi Pengguna & Penentuan Waktu Lokal ---
        $user = Auth::user();
        $userId = $user->id;

        $timezone = config('app.timezone', 'Asia/Jakarta');
        $today = Carbon::now($timezone)->toDateString();
        $currentTime = Carbon::now($timezone)->format('H:i:s');

        // --- LANGKAH 2: Validasi Ketat Parameter Presensi ---
        $request->validate([
            'status' => 'required|in:Hadir,Izin,Sakit',
            'alasan' => 'nullable|string|max:255',
            'lat' => 'required_if:status,Hadir|nullable|numeric|between:-90,90',
            'lng' => 'required_if:status,Hadir|nullable|numeric|between:-180,180',
        ], [
            'lat.required_if' => 'Koordinat garis lintang (latitude) wajib disertakan untuk presensi Hadir.',
            'lng.required_if' => 'Koordinat garis bujur (longitude) wajib disertakan untuk presensi Hadir.',
        ]);

        $pilihanStatus = $request->status;
        $jarakKeterangan = '';

        // --- LANGKAH 3: Ambil Titik Koordinat Kantor Industri (DUDIKA) Siswa ---
        $lokasiDudi = $user->tempat_dudi ?? 'Lokasi DUDI Belum Ditentukan';
        $dudiLat = $user->dudi_lat ?? -6.4025; // Koordinat default fallback
        $dudiLng = $user->dudi_lng ?? 106.8186;

        // --- LANGKAH 4: Perhitungan Jarak GPS Menggunakan Formula Haversine ---
        if ($pilihanStatus === 'Hadir') {
            $studentLat = (float) $request->lat;
            $studentLng = (float) $request->lng;

            // Jari-jari rata-rata bumi dalam satuan meter
            $earthRadius = 6371000;

            // Konversi selisih koordinat dari derajat ke radian
            $dLat = deg2rad($studentLat - (float) $dudiLat);
            $dLon = deg2rad($studentLng - (float) $dudiLng);

            // Perhitungan busur lingkaran besar (Haversine formula)
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad((float) $dudiLat)) * cos(deg2rad($studentLat)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = (int) round($earthRadius * $c);

            // Evaluasi toleransi radius: maksimal 150 meter dari kantor industri
            if ($distance > 150) {
                $pilihanStatus = 'Diluar Radius DUDI';
                $jarakKeterangan = "⚠️ Peringatan: Jarak Anda terlalu jauh dari DUDI ({$distance} meter).";
            } else {
                $jarakKeterangan = "✓ Dalam radius valid ({$distance}m).";
            }
        } elseif ($pilihanStatus === 'Izin' || $pilihanStatus === 'Sakit') {
            $jarakKeterangan = 'Keterangan '.$pilihanStatus.($request->alasan ? ': '.$request->alasan : '');
        }

        // --- LANGKAH 5: Cek Riwayat Presensi Hari Ini (Masuk vs Pulang) ---
        $attendance = Attendance::where('user_id', $userId)->where('tanggal', $today)->first();

        if (! $attendance) {
            // A. Presensi Masuk (Check-In) Pertama Hari Ini
            $jamPulangOtomatis = ($pilihanStatus === 'Izin' || $pilihanStatus === 'Sakit') ? $currentTime : null;

            Attendance::create([
                'user_id' => $userId,
                'tanggal' => $today,
                'jam_masuk' => $currentTime,
                'jam_pulang' => $jamPulangOtomatis,
                'status' => $pilihanStatus,
                'alasan' => $jarakKeterangan,
                'lokasi' => $lokasiDudi,
            ]);

            return redirect('/dashboard/siswa#attendance')->with('success', 'Presensi berhasil dicatat!');
        } else {
            // B. Presensi Pulang (Check-Out) Kedua Hari Ini
            if (empty($attendance->jam_pulang)) {
                $attendance->update([
                    'jam_pulang' => $currentTime,
                ]);

                return redirect('/dashboard/siswa#attendance')->with('success', 'Presensi pulang berhasil dicatat!');
            }

            return redirect('/dashboard/siswa#attendance')->with('info', 'Anda sudah menyelesaikan presensi hari ini.');
        }
    }
}
