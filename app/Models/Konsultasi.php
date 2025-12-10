<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal_konsultasi',
        'hasil_jurusan_id' // Bisa null saat baru dibuat
    ];

    /**
     * Relasi: Konsultasi ini milik user siapa.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: Hasil rekomendasinya jurusan apa.
     */
    public function hasilJurusan()
    {
        return $this->belongsTo(Jurusan::class, 'hasil_jurusan_id');
    }

    /**
     * Relasi: Detail nilai inputan siswa.
     */
    public function nilais()
    {
        return $this->hasMany(KonsultasiNilai::class);
    }
}