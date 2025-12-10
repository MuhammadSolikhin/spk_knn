<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Konsultasi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar riwayat konsultasi semua siswa.
     */
    public function index()
    {
        // Load relasi 'user' dan 'hasilJurusan' agar bisa menampilkan Nama Siswa & Hasil Rekomendasi
        $riwayat = Konsultasi::with(['user', 'hasilJurusan'])
            ->latest('tanggal_konsultasi') // Urutkan dari yg terbaru
            ->get();

        return view('admin.riwayat.index', compact('riwayat'));
    }

    /**
     * Menampilkan detail perhitungan/input nilai siswa pada konsultasi tertentu.
     */
    public function show($id)
    {
        // Load relasi user, hasilJurusan, dan nilais (serta kriteria di dalam nilais)
        // Ini sesuai dengan model KonsultasiNilai.php yang Anda upload
        $riwayat = Konsultasi::with(['user', 'hasilJurusan', 'nilais.kriteria'])
            ->findOrFail($id);

        return view('admin.riwayat.show', compact('riwayat'));
    }

    /**
     * Menghapus riwayat konsultasi.
     */
    public function destroy($id)
    {
        $riwayat = Konsultasi::findOrFail($id);

        // Data di tabel konsultasi_nilais akan otomatis terhapus jika Anda setting ON DELETE CASCADE di migration.
        // Jika tidak, Anda mungkin perlu menghapus nilainya dulu: $riwayat->nilais()->delete();

        $riwayat->delete();

        return redirect()->route('admin.riwayat.index')
            ->with('success', 'Riwayat rekomendasi berhasil dihapus.');
    }
}