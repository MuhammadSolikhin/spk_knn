<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataTraining;
use App\Models\DataTrainingNilai;
use App\Models\Jurusan;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataTrainingController extends Controller
{
    /**
     * Menampilkan daftar data training.
     */
    public function index()
    {
        // Eager loading 'jurusan' agar query lebih efisien
        $dataTrainings = DataTraining::with('jurusan')->paginate(10);
        return view('admin.datatraining.index', compact('dataTrainings'));
    }

    /**
     * Menampilkan form tambah data training.
     */
    public function create()
    {
        $jurusans = Jurusan::all();
        $kriterias = Kriteria::all();
        return view('admin.datatraining.create', compact('jurusans', 'kriterias'));
    }

    /**
     * Menyimpan data training beserta nilai-nilainya.
     */
    public function store(Request $request)
    {
        // 1. Validasi Umum
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
            'nilai' => 'required|array', // Nilai dikirim dalam bentuk array
        ]);

        // Gunakan DB Transaction agar jika gagal simpan nilai, header tidak tersimpan
        DB::transaction(function () use ($request) {
            
            // 2. Simpan Header Data Training
            $dataTraining = DataTraining::create([
                'nama_siswa' => $request->nama_siswa,
                'jurusan_id' => $request->jurusan_id,
            ]);

            // 3. Simpan Detail Nilai (Looping array dari form)
            foreach ($request->nilai as $kriteria_id => $nilai_input) {
                DataTrainingNilai::create([
                    'data_training_id' => $dataTraining->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai' => $nilai_input,
                ]);
            }
        });

        return redirect()->route('admin.datatraining.index')
            ->with('success', 'Data Training berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail data training.
     */
    public function show($id)
    {
        $dataTraining = DataTraining::with(['jurusan', 'nilais.kriteria'])->findOrFail($id);
        return view('admin.datatraining.show', compact('dataTraining'));
    }

    /**
     * Menampilkan form edit data training.
     */
    public function edit($id)
    {
        $dataTraining = DataTraining::with('nilais')->findOrFail($id);
        $jurusans = Jurusan::all();
        $kriterias = Kriteria::all();

        // Mapping nilai lama agar mudah dipanggil di view: [kriteria_id => nilai]
        $nilaiLama = $dataTraining->nilais->pluck('nilai', 'kriteria_id')->toArray();

        return view('admin.datatraining.edit', compact('dataTraining', 'jurusans', 'kriterias', 'nilaiLama'));
    }

    /**
     * Mengupdate data training dan nilainya.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_siswa' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
            'nilai' => 'required|array',
        ]);

        DB::transaction(function () use ($request, $id) {
            $dataTraining = DataTraining::findOrFail($id);

            // 1. Update Header
            $dataTraining->update([
                'nama_siswa' => $request->nama_siswa,
                'jurusan_id' => $request->jurusan_id,
            ]);

            // 2. Update Detail Nilai
            // Hapus nilai lama dulu, lalu buat baru (cara paling aman dan mudah)
            $dataTraining->nilais()->delete();

            foreach ($request->nilai as $kriteria_id => $nilai_input) {
                DataTrainingNilai::create([
                    'data_training_id' => $dataTraining->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai' => $nilai_input,
                ]);
            }
        });

        return redirect()->route('admin.datatraining.index')
            ->with('success', 'Data Training berhasil diperbarui.');
    }

    /**
     * Menghapus data training.
     */
    public function destroy($id)
    {
        $dataTraining = DataTraining::findOrFail($id);
        
        // Karena kita set onDelete('cascade') di migration, 
        // menghapus parent otomatis menghapus child (nilais)
        $dataTraining->delete();

        return redirect()->route('admin.datatraining.index')
            ->with('success', 'Data Training berhasil dihapus.');
    }
}