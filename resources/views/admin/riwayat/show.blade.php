@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Riwayat /</span> Detail Rekomendasi
    </h4>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title mb-4">Profil Siswa</h5>
                    
                    <img src="{{ $riwayat->user->photo_url }}" alt="User Image" class="rounded-circle mb-3" width="100" height="100" style="object-fit: cover;">
                    
                    <h4 class="mb-1">{{ $riwayat->user->name }}</h4>
                    <p class="text-muted">{{ $riwayat->user->email }}</p>

                    <div class="d-flex justify-content-center text-start mt-4">
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="bx bx-phone me-2"></i> {{ $riwayat->user->no_telepon ?? '-' }}</li>
                            <li class="mb-2"><i class="bx bx-buildings me-2"></i> {{ $riwayat->user->asal_sekolah ?? '-' }}</li>
                            <li class="mb-2"><i class="bx bx-calendar me-2"></i> {{ \Carbon\Carbon::parse($riwayat->tanggal_konsultasi)->format('d F Y, H:i') }} WIB</li>
                        </ul>
                    </div>

                    <hr>

                    <h5 class="mt-3">Hasil Rekomendasi</h5>
                    @if($riwayat->hasilJurusan)
                        <div class="alert alert-success mt-2" role="alert">
                            <h3 class="alert-heading mb-0 fw-bold">{{ $riwayat->hasilJurusan->nama_jurusan }}</h3>
                        </div>
                    @else
                        <div class="alert alert-warning" role="alert">
                            Tidak ada hasil
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Detail Nilai Input Siswa</h5>
                    <small class="text-muted">Data yang digunakan untuk perhitungan</small>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Kriteria</th>
                                    <th width="20%" class="text-center">Nilai Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat->nilais as $index => $nilai)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="fw-bold">{{ $nilai->kriteria->nama_kriteria ?? 'Kriteria Terhapus' }}</span>
                                        <br>
                                        <small class="text-muted">{{ $nilai->kriteria->kode_kriteria ?? '-' }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-label-primary fs-6">{{ $nilai->nilai_input }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada detail nilai yang ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.riwayat.index') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back me-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection