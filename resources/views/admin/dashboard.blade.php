@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row">
    
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang, {{ Auth::user()->name }}! 🎉</h5>
                        <p class="mb-4">
                            Sistem Penunjang Keputusan Minat Sekolah Lanjutan siap digunakan. 
                            Pantau data statistik dan aktivitas siswa di sini.
                        </p>
                    </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                    <div class="card-body pb-0 px-0 px-md-4">
                        <img src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}" 
                            height="140" alt="View Badge User" 
                            data-app-dark-img="illustrations/man-with-laptop-dark.png" 
                            data-app-light-img="illustrations/man-with-laptop-light.png">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-md-12 order-1">
        <div class="row">
            
            <div class="col-lg-3 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-user"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Total Siswa</span>
                        <h3 class="card-title mb-2">{{ $totalSiswa }}</h3>
                        <small class="text-success fw-semibold">Terdaftar</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-buildings"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Jurusan</span>
                        <h3 class="card-title mb-2">{{ $totalJurusan }}</h3>
                        <small class="text-success fw-semibold">Kelas Target</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-list-check"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Kriteria</span>
                        <h3 class="card-title mb-2">{{ $totalKriteria }}</h3>
                        <small class="text-warning fw-semibold">Parameter</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-data"></i></span>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Data Training</span>
                        <h3 class="card-title mb-2">{{ $totalDataTraining }}</h3>
                        <small class="text-primary fw-semibold">Dataset Alumni</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 order-2">
        <div class="card">
            <h5 class="card-header">5 Aktivitas Konsultasi Terakhir</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nama Siswa</th>
                            <th>Tanggal Tes</th>
                            <th>Hasil Rekomendasi</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($recentActivities as $activity)
                        <tr>
                            <td><strong>{{ $activity->user->name }}</strong></td>
                            <td>{{ $activity->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                @if($activity->hasilJurusan)
                                    <span class="badge bg-label-primary">{{ $activity->hasilJurusan->nama_jurusan }}</span>
                                @else
                                    <span class="badge bg-label-warning">Belum Ada Hasil</span>
                                @endif
                            </td>
                            <td><span class="badge bg-label-success">Selesai</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada aktivitas konsultasi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection