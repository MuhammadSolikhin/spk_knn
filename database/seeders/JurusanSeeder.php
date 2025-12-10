<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_jurusan' => 'IPA',
                'deskripsi' => 'Fokus pada Ilmu Pengetahuan Alam, Kedokteran, Sains.'
            ],
            [
                'nama_jurusan' => 'IPS',
                'deskripsi' => 'Fokus pada Sosial, Ekonomi, Hukum, Komunikasi.'
            ],
            [
                'nama_jurusan' => 'Teknik Komputer',
                'deskripsi' => 'Fokus pada Rekayasa Perangkat Lunak dan Jaringan.'
            ],
        ];

        foreach ($data as $item) {
            Jurusan::create($item);
        }
    }
}