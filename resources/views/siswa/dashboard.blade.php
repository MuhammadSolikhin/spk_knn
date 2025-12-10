@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@section('content')
    <div class="row">

        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Halo, {{ Auth::user()->name }}! 👋</h5>

                            @if($riwayatTerakhir)
                                <p class="mb-4">
                                    Berdasarkan tes terakhir pada
                                    <strong>{{ $riwayatTerakhir->created_at->format('d M Y') }}</strong>,<br>
                                    rekomendasi jurusan untuk kamu adalah:
                                </p>

                                @if($riwayatTerakhir->hasilJurusan)
                                    <h2 class="text-primary fw-bold mb-4">{{ $riwayatTerakhir->hasilJurusan->nama_jurusan }}</h2>
                                @else
                                    <h2 class="text-warning fw-bold mb-4">Belum Ada Hasil</h2>
                                @endif

                                <a href="{{ route('siswa.konsultasi.show', $riwayatTerakhir->id) }}"
                                    class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                <a href="{{ route('siswa.konsultasi.create') }}" class="btn btn-sm btn-primary">Tes Ulang</a>
                            @else
                                <p class="mb-4">
                                    Kamu belum mengetahui potensi minat jurusanmu? <br>
                                    Yuk, ikuti tes minat berbasis <strong>KNN (K-Nearest Neighbor)</strong> sekarang juga.
                                    Hanya butuh waktu 5 menit!
                                </p>
                                <a href="{{ route('siswa.konsultasi.create') }}" class="btn btn-primary">Mulai Tes Minat</a>
                            @endif

                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/illustrations/girl-doing-yoga-light.png') }}" height="140"
                                alt="View Badge User" data-app-dark-img="illustrations/girl-doing-yoga-dark.png"
                                data-app-light-img="illustrations/girl-doing-yoga-light.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h5 class="py-2">Mengenal Jurusan Sekolah Lanjutan</h5>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-atom fs-3"></i></span>
                    </div>
                    <h5 class="card-title">IPA (Sains)</h5>
                    <p class="card-text text-muted">
                        Fokus pada mata pelajaran Matematika, Fisika, Biologi, dan Kimia. Cocok untuk yang berminat di
                        bidang Kedokteran atau Teknik.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-warning"><i
                                class="bx bx-book-reader fs-3"></i></span>
                    </div>
                    <h5 class="card-title">IPS (Sosial)</h5>
                    <p class="card-text text-muted">
                        Fokus pada Ekonomi, Geografi, Sosiologi, dan Sejarah. Cocok untuk yang berminat di bidang Hukum,
                        Bisnis, atau Manajemen.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="avatar mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary"><i
                                class="bx bx-desktop fs-3"></i></span>
                    </div>
                    <h5 class="card-title">Teknik Komputer</h5>
                    <p class="card-text text-muted">
                        Fokus pada Rekayasa Perangkat Lunak, Jaringan, dan Hardware. Cocok untuk yang hobi *coding* dan
                        teknologi.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection