<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode',          // C1, C2, dst
        'nama_kriteria', // Nilai MTK, dll
        'tipe'           // Core/Secondary
    ];

    // Relasi ke nilai training dan nilai konsultasi (opsional, jarang dipanggil langsung dari sini)
    public function dataTrainingNilais()
    {
        return $this->hasMany(DataTrainingNilai::class);
    }
}