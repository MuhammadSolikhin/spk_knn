<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTrainingNilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_training_id',
        'kriteria_id',
        'nilai'
    ];

    /**
     * Relasi: Balik ke header DataTraining.
     */
    public function dataTraining()
    {
        return $this->belongsTo(DataTraining::class);
    }

    /**
     * Relasi: Nilai ini milik kriteria apa (misal: MTK).
     */
    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class);
    }
}