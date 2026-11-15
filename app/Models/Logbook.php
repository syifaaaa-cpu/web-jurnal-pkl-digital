<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Logbook mewakili jurnal kegiatan harian siswa di tempat magang.
 *
 * @property int $id Primary Key (Auto-Increment)
 * @property int $user_id Foreign Key ke tabel users (Siswa pemilik logbook)
 * @property Carbon $tanggal Tanggal kegiatan dilaksanakan
 * @property string $jam_kerja Durasi jam kerja (contoh: "08:00 - 16:00")
 * @property string $judul_kegiatan Judul ringkas pekerjaan/tugas yang dilakukan
 * @property string $deskripsi Uraian detail proses kerja dan capaian harian
 * @property string $status Status verifikasi mentor: 'Pending', 'Approved', 'Revisi'
 * @property string|null $catatan_mentor Umpan balik koreksi atau apresiasi dari mentor industri
 * @property string|null $foto_dokumentasi Path file foto bukti kegiatan jika diunggah
 * @property Carbon|null $created_at Waktu pengiriman logbook
 * @property Carbon|null $updated_at Waktu validasi / pembaruan logbook
 */
class Logbook extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment Protection).
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_kerja',
        'judul_kegiatan',
        'deskripsi',
        'status',
        'catatan_mentor',
        'foto_dokumentasi',
    ];

    /**
     * Konversi tipe data otomatis (Type Casting) Eloquent.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    /**
     * Relasi Many-to-1: Setiap logbook kegiatan dimiliki oleh satu orang siswa (User).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
