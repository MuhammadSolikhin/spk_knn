<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use App\Models\KonsultasiNilai;
use App\Models\DataTraining;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonsultasiController extends Controller
{
    // Tentukan Nilai K (Tetangga Terdekat)
    // Sebaiknya ganjil agar tidak seri saat voting (3, 5, 7, ...)
    private $k = 5;

    /**
     * Menampilkan riwayat konsultasi siswa.
     */
    public function index()
    {
        // Ambil data milik user yang sedang login saja
        $konsultasis = Konsultasi::with('hasilJurusan')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('siswa.konsultasi.index', compact('konsultasis'));
    }

    /**
     * Form tes minat baru.
     */
    public function create()
    {
        $kriterias = Kriteria::all();
        return view('siswa.konsultasi.create', compact('kriterias'));
    }

    /**
     * PROSES UTAMA: Simpan input & Hitung KNN
     */
    public function store(Request $request)
    {
        $request->validate([
            'nilai' => 'required|array',
        ]);

        // Gunakan Transaction agar data konsisten
        $konsultasiId = DB::transaction(function () use ($request) {
            
            // 1. Simpan Header Konsultasi
            $konsultasi = Konsultasi::create([
                'user_id' => Auth::id(),
                'tanggal_konsultasi' => now(),
                'hasil_jurusan_id' => null, // Nanti diupdate setelah hitung
            ]);

            // 2. Simpan Detail Nilai Input Siswa
            foreach ($request->nilai as $kriteria_id => $nilai_input) {
                KonsultasiNilai::create([
                    'konsultasi_id' => $konsultasi->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai_input' => $nilai_input,
                ]);
            }

            // 3. JALANKAN ALGORITMA KNN
            $hasilPrediksi = $this->hitungKNN($konsultasi);

            // 4. Update Hasil ke Database
            $konsultasi->update([
                'hasil_jurusan_id' => $hasilPrediksi['jurusan_terpilih_id']
            ]);

            return $konsultasi->id;
        });

        return redirect()->route('siswa.konsultasi.show', $konsultasiId)
            ->with('success', 'Perhitungan selesai! Berikut hasil rekomendasi Anda.');
    }

    /**
     * Menampilkan Detail Hasil & Penjelasan Perhitungan
     */
    public function show($id)
    {
        // Pastikan hanya pemilik data atau admin yang bisa lihat
        $konsultasi = Konsultasi::with(['user', 'hasilJurusan', 'nilais.kriteria'])->findOrFail($id);
        
        if (Auth::user()->role == 'siswa' && $konsultasi->user_id != Auth::id()) {
            abort(403);
        }

        // Kita hitung ulang (tanpa save) untuk mendapatkan data tetangga (neighbors)
        // agar bisa ditampilkan di tabel "Bukti Perhitungan"
        $hasilPerhitungan = $this->hitungKNN($konsultasi);

        return view('siswa.konsultasi.show', compact('konsultasi', 'hasilPerhitungan'));
    }

    /**
     * Fungsi Private: Inti Algoritma KNN
     */
    private function hitungKNN($konsultasi)
    {
        // A. Ambil Data Training beserta nilainya
        $dataTrainings = DataTraining::with('nilais')->get();
        
        // B. Ambil Inputan Siswa (Mapping: [kriteria_id => nilai])
        $inputSiswa = $konsultasi->nilais->pluck('nilai_input', 'kriteria_id')->toArray();

        $distances = [];

        // C. Loop setiap Data Training untuk hitung Euclidean Distance
        foreach ($dataTrainings as $dt) {
            $totalSelisihKuadrat = 0;

            // Mapping nilai training: [kriteria_id => nilai]
            $nilaiTraining = $dt->nilais->pluck('nilai', 'kriteria_id')->toArray();

            foreach ($inputSiswa as $kriteriaId => $nilaiAsli) {
                // Ambil nilai training untuk kriteria yang sama, jika tidak ada anggap 0
                $nilaiDt = $nilaiTraining[$kriteriaId] ?? 0;
                
                // Rumus: (x - y)^2
                $selisih = $nilaiAsli - $nilaiDt;
                $totalSelisihKuadrat += pow($selisih, 2);
            }

            // Akar Kuadrat dari Total Selisih (Euclidean Distance)
            $jarak = sqrt($totalSelisihKuadrat);

            // Simpan ke array
            $distances[] = [
                'id' => $dt->id,
                'nama_siswa' => $dt->nama_siswa,
                'jurusan_id' => $dt->jurusan_id,
                'nama_jurusan' => $dt->jurusan->nama_jurusan,
                'jarak' => $jarak
            ];
        }

        // D. Sorting: Urutkan dari jarak TERKECIL (Terdekat)
        usort($distances, function ($a, $b) {
            return $a['jarak'] <=> $b['jarak'];
        });

        // E. Ambil K Tetangga Teratas (Top K)
        $k_neighbors = array_slice($distances, 0, $this->k);

        // F. Voting: Hitung jurusan mana yang paling banyak muncul di K tetangga
        $votes = [];
        foreach ($k_neighbors as $neighbor) {
            $jurusanId = $neighbor['jurusan_id'];
            if (!isset($votes[$jurusanId])) {
                $votes[$jurusanId] = 0;
            }
            $votes[$jurusanId]++;
        }

        // G. Cari Pemenang Voting
        // arsort = sort array value descending (paling banyak vote di atas)
        arsort($votes);
        $pemenangJurusanId = array_key_first($votes);

        return [
            'neighbors' => $k_neighbors, // Data 5 tetangga terdekat (untuk ditampilkan di view)
            'jurusan_terpilih_id' => $pemenangJurusanId,
            'votes' => $votes
        ];
    }
    
    /**
     * Untuk Admin: Melihat laporan semua konsultasi
     */
    public function laporan()
    {
        $konsultasis = Konsultasi::with(['user', 'hasilJurusan'])->latest()->paginate(20);
        return view('admin.laporan.index', compact('konsultasis'));
    }
}