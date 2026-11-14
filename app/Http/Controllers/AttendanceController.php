<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $userId = $user->id;

        $today = Carbon::now('Asia/Jakarta')->toDateString();
        $currentTime = Carbon::now('Asia/Jakarta')->format('H:i:s');

        $lokasiDudi = $user->tempat_dudi ?? 'PT Ciptadra Softindo';
        $dudiLat = $user->dudi_lat ?? -6.4025;
        $dudiLng = $user->dudi_lng ?? 106.8186;

        $request->validate([
            'status' => 'required|string',
            'alasan' => 'nullable|string|max:255',
            'lat' => 'nullable|numeric',
            'lng' => 'nullable|numeric',
        ]);

        $pilihanStatus = $request->status; // Bisa 'Hadir', 'Izin', atau 'Sakit'
        $jarakKeterangan = "";

        // Jika statusnya Hadir, cek jarak GPS
        if ($pilihanStatus === 'Hadir' && $request->filled('lat') && $request->filled('lng')) {
            $studentLat = $request->lat;
            $studentLng = $request->lng;

            $earthRadius = 6371000; // meter
            $dLat = deg2rad($studentLat - $dudiLat);
            $dLon = deg2rad($studentLng - $dudiLng);
            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos(deg2rad($dudiLat)) * cos(deg2rad($studentLat)) *
                sin($dLon / 2) * sin($dLon / 2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = round($earthRadius * $c);

            // Jika jarak > 150 meter, ubah status menjadi Diluar Radius DUDI
            if ($distance > 150) {
                $pilihanStatus = "Diluar Radius DUDI";
                $jarakKeterangan = "⚠️ Peringatan: Jarak Anda terlalu jauh dari DUDI ({$distance} meter).";
            } else {
                $jarakKeterangan = "✓ Dalam radius valid ({$distance}m).";
            }
        } elseif ($pilihanStatus === 'Izin' || $pilihanStatus === 'Sakit') {
            $jarakKeterangan = "Keterangan " . $pilihanStatus . ($request->alasan ? ": " . $request->alasan : "");
        }

        $attendance = Attendance::where('user_id', $userId)->where('tanggal', $today)->first();

        if (!$attendance) {
            // --- ABSEN MASUK / KETIDAKHADIRAN ---
            // Jika Izin atau Sakit, jam pulang langsung diisi / dianggap selesai hari itu
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
            // --- ABSEN PULANG ---
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
