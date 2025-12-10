<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kriteria;
use App\Models\DataTraining;
use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Khusus Admin
     */
    public function index()
    {
        // 1. Hitung Statistik Data
        $totalSiswa = User::where('role', 'siswa')->count();
        $totalJurusan = Jurusan::count();
        $totalKriteria = Kriteria::count();
        $totalDataTraining = DataTraining::count();

        // 2. Ambil 5 Riwayat Konsultasi Terbaru (Untuk Widget "Aktivitas Terbaru")
        $recentActivities = Konsultasi::with(['user', 'hasilJurusan'])
            ->latest()
            ->take(5)
            ->get();

        // 3. Kirim data ke View
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalJurusan',
            'totalKriteria',
            'totalDataTraining',
            'recentActivities'
        ));
    }

    public function indexSiswa()
    {
        // Ambil hasil tes terakhir milik siswa yang sedang login
        $riwayatTerakhir = Konsultasi::with('hasilJurusan')
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        return view('siswa.dashboard', compact('riwayatTerakhir'));
    }
}