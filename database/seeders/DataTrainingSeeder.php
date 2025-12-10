<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Kriteria;
use App\Models\DataTraining;
use App\Models\DataTrainingNilai;

class DataTrainingSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua data master yang sudah dibuat seeder sebelumnya
        $jurusans = Jurusan::all();
        $kriterias = Kriteria::all();

        // Pastikan master data ada
        if ($jurusans->isEmpty() || $kriterias->isEmpty()) {
            $this->command->info('Harap jalankan JurusanSeeder dan KriteriaSeeder terlebih dahulu.');
            return;
        }

        foreach ($jurusans as $jurusan) {
            // Buat 10 siswa per jurusan
            for ($i = 1; $i <= 10; $i++) {
                
                // 1. Buat Header Data Training
                $dataTraining = DataTraining::create([
                    'nama_siswa' => 'Alumni ' . $jurusan->nama_jurusan . ' ' . $i,
                    'jurusan_id' => $jurusan->id,
                ]);

                // 2. Buat Detail Nilai (Loop Kriteria)
                foreach ($kriterias as $kriteria) {
                    $nilai = 0;

                    // --- LOGIKA POLA NILAI ---
                    if ($jurusan->nama_jurusan == 'IPA') {
                        if ($kriteria->nama_kriteria == 'Nilai Matematika' || $kriteria->nama_kriteria == 'Nilai IPA / Sains') {
                            $nilai = rand(80, 95); 
                        } elseif ($kriteria->nama_kriteria == 'Nilai IPS / Sosial') {
                            $nilai = rand(60, 78);
                        } else {
                            $nilai = rand(70, 85); 
                        }
                    } elseif ($jurusan->nama_jurusan == 'IPS') {
                        if ($kriteria->nama_kriteria == 'Nilai IPS / Sosial' || $kriteria->nama_kriteria == 'Nilai Bahasa Indonesia') {
                            $nilai = rand(80, 95);
                        } elseif ($kriteria->nama_kriteria == 'Nilai Matematika' || $kriteria->nama_kriteria == 'Nilai IPA / Sains') {
                            $nilai = rand(60, 75);
                        } else {
                            $nilai = rand(70, 85);
                        }
                    } elseif ($jurusan->nama_jurusan == 'Teknik Komputer') {
                        if ($kriteria->nama_kriteria == 'Nilai Matematika' || $kriteria->nama_kriteria == 'Nilai Bahasa Inggris') {
                            $nilai = rand(82, 98);
                        } else {
                            $nilai = rand(65, 80);
                        }
                    } else {
                        // Default random jika ada jurusan baru lain
                        $nilai = rand(60, 90);
                    }

                    // Insert Nilai
                    DataTrainingNilai::create([
                        'data_training_id' => $dataTraining->id,
                        'kriteria_id' => $kriteria->id,
                        'nilai' => $nilai,
                    ]);
                }
            }
        }
    }
}