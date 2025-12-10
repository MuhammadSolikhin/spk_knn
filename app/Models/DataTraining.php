<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTraining extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_siswa',
        'jurusan_id', // Foreign Key
    ];

    /**
     * Relasi: Data training ini milik Jurusan apa (Labelnya).
     */
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    /**
     * Relasi: Data training punya banyak nilai per kriteria.
     */
    public function nilais()
    {
        return $this->hasMany(DataTrainingNilai::class);
    }
}