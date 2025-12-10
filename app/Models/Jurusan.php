<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_jurusan',
        'deskripsi'
    ];

    /**
     * Relasi: Satu jurusan dipakai oleh banyak data training (Alumni).
     */
    public function dataTrainings()
    {
        return $this->hasMany(DataTraining::class);
    }

    /**
     * Relasi: Satu jurusan bisa menjadi hasil rekomendasi di banyak konsultasi.
     */
    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class, 'hasil_jurusan_id');
    }
}