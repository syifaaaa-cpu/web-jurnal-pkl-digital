<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Grade mewakili penilaian gabungan ganda (Dual-Assessment) siswa PKL.
 *
 * Rumus Perhitungan:
 * Nilai DUDI = (nilai_teknis + nilai_disiplin + nilai_kerjasama + nilai_inisiatif) / 4
 * Nilai Akhir = (Nilai DUDI * 0.60) + (Nilai Laporan * 0.40)
 * Predikat: A (>= 85), B (75 - 84), C (< 75)
 *
 * @property int $id Primary Key (Auto-Increment)
 * @property int $student_id Foreign Key unik ke tabel users (Siswa yang dinilai)
 * @property int|null $mentor_id Foreign Key ke tabel users (Mentor industri penilai)
 * @property float|null $nilai_teknis Nilai penguasaan teknis/kejuruan dari DUDI (Skala 0-100)
 * @property float|null $nilai_disiplin Nilai kedisiplinan & kehadiran dari DUDI (Skala 0-100)
 * @property float|null $nilai_kerjasama Nilai kemampuan kerjasama tim dari DUDI (Skala 0-100)
 * @property float|null $nilai_inisiatif Nilai inisiatif & keaktifan dari DUDI (Skala 0-100)
 * @property float|null $nilai_dudi Nilai akumulasi rata-rata DUDI (Bobot 60%)
 * @property float|null $nilai_laporan Nilai evaluasi laporan PKL oleh Guru Pembimbing (Bobot 40%)
 * @property float|null $nilai_akhir Nilai total gabungan kelulusan PKL
 * @property string|null $predikat Predikat huruf mutu: 'A', 'B', 'C'
 * @property string|null $catatan_mentor Pesan evaluasi khusus dari mentor DUDI
 * @property Carbon|null $created_at Waktu record dibuat
 * @property Carbon|null $updated_at Waktu record diperbarui
 */
class Grade extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignment Protection).
     *
     * @var list<string>
     */
    protected $fillable = [
        'student_id',
        'mentor_id',
        'nilai_teknis',
        'nilai_disiplin',
        'nilai_kerjasama',
        'nilai_inisiatif',
        'nilai_dudi',
        'nilai_laporan',
        'nilai_akhir',
        'predikat',
        'catatan_mentor',
    ];

    /**
     * Konversi tipe data otomatis (Type Casting) Eloquent.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'nilai_teknis' => 'float',
            'nilai_disiplin' => 'float',
            'nilai_kerjasama' => 'float',
            'nilai_inisiatif' => 'float',
            'nilai_dudi' => 'float',
            'nilai_laporan' => 'float',
            'nilai_akhir' => 'float',
        ];
    }

    /**
     * Relasi Many-to-1: Nilai ini milik seorang siswa tertentu.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relasi Many-to-1: Nilai ini diverifikasi oleh seorang mentor industri.
     */
    public function mentor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
