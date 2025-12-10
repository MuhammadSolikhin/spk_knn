@extends('layouts.app')

@section('title', 'Hasil Rekomendasi')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Konsultasi /</span> Hasil Analisa</h4>

<div class="card text-center mb-4">
    <div class="card-header">Kesimpulan Sistem</div>
    <div class="card-body">
        <h5 class="card-title">Berdasarkan perhitungan algoritma K-Nearest Neighbor (K=5)</h5>
        <p class="card-text">Minat jurusan yang paling sesuai untuk Anda adalah:</p>
        
        @if($konsultasi->hasilJurusan)
            <h1 class="display-4 text-primary fw-bold mb-3">{{ $konsultasi->hasilJurusan->nama_jurusan }}</h1>
            <p class="text-muted">{{ $konsultasi->hasilJurusan->deskripsi }}</p>
        @else
            <h1 class="text-danger">Belum dapat ditentukan</h1>
        @endif

        <a href="{{ route('siswa.konsultasi.create') }}" class="btn btn-outline-primary mt-3">Coba Tes Lagi</a>
        <a href="{{ route('siswa.konsultasi.index') }}" class="btn btn-outline-secondary mt-3">Kembali ke Riwayat</a>
    </div>
    <div class="card-footer text-muted">
        Dihitung pada: {{ $konsultasi->created_at->translatedFormat('d F Y, H:i') }}
    </div>
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <h5 class="card-header">Nilai Inputan Anda</h5>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th>Kriteria</th>
                            <th class="text-end">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($konsultasi->nilais as $nilai)
                            <tr>
                                <td>{{ $nilai->kriteria->nama_kriteria }}</td>
                                <td class="text-end fw-bold">{{ $nilai->nilai_input }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card mb-4">
            <h5 class="card-header d-flex justify-content-between align-items-center">
                Detail Perhitungan (K=5)
                <small class="text-muted fs-tiny">5 Data alumni dengan nilai paling mirip</small>
            </h5>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Rank</th>
                            <th>Nama Alumni</th>
                            <th>Jarak (Euclidean)</th>
                            <th>Jurusan Alumni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilPerhitungan['neighbors'] as $index => $neighbor)
                            <tr>
                                <td><span class="badge bg-label-secondary">{{ $index + 1 }}</span></td>
                                <td>{{ $neighbor['nama_siswa'] }}</td>
                                <td>{{ number_format($neighbor['jarak'], 4) }}</td>
                                <td>
                                    @if($neighbor['jurusan_id'] == $konsultasi->hasil_jurusan_id)
                                        <span class="badge bg-success">{{ $neighbor['nama_jurusan'] }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">{{ $neighbor['nama_jurusan'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-body bg-lighter">
                <small>
                    <strong>Penjelasan:</strong> Sistem mencari 5 alumni yang memiliki pola nilai paling mendekati nilai Anda (Jarak terkecil). 
                    Dari tabel di atas, jurusan <strong>{{ $konsultasi->hasilJurusan->nama_jurusan }}</strong> muncul paling banyak (Dominan).
                </small>
            </div>
        </div>
    </div>
</div>
@endsection