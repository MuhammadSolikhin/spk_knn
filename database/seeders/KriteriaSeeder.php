<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriterias = [
            ['kode' => 'C1', 'nama' => 'Nilai Matematika'],
            ['kode' => 'C2', 'nama' => 'Nilai Bahasa Indonesia'],
            ['kode' => 'C3', 'nama' => 'Nilai Bahasa Inggris'],
            ['kode' => 'C4', 'nama' => 'Nilai IPA / Sains'],
            ['kode' => 'C5', 'nama' => 'Nilai IPS / Sosial'],
        ];

        foreach ($kriterias as $k) {
            Kriteria::create([
                'kode' => $k['kode'],
                'nama_kriteria' => $k['nama'],
                'tipe' => 'core'
            ]);
        }
    }
}