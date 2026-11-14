<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'jam_kerja',
        'judul_kegiatan',
        'deskripsi',
        'status',
        'catatan_mentor'
    ];

    // Relasi balik ke User (Siswa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
