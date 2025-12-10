<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonsultasiNilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'konsultasi_id',
        'kriteria_id',
        'nilai_input'
    ];

    /**
     * Relasi: Balik ke header Konsultasi.
     */
    public function konsultasi()
    {
        return $this->belongsTo(Konsultasi::class);
    }

    /**
     * Relasi: Nilai input ini untuk kriteria apa.
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}