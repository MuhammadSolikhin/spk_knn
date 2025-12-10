@extends('layouts.app')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Laporan /</span> Riwayat Rekomendasi
    </h4>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Riwayat Konsultasi</h5>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Nama Siswa</th>
                        <th>Asal Sekolah</th>
                        <th>Hasil Rekomendasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($riwayat as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->tanggal_konsultasi)->format('d M Y') }}
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($item->user->profile_photo_path)
                                    <img src="{{ asset('storage/' . $item->user->profile_photo_path) }}" alt="Avatar" class="rounded-circle me-2" width="30" height="30">
                                @else
                                    <div class="avatar avatar-xs me-2">
                                        <span class="avatar-initial rounded-circle bg-label-primary">{{ substr($item->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <strong>{{ $item->user->name }}</strong>
                            </div>
                        </td>
                        <td>{{ $item->user->asal_sekolah ?? '-' }}</td>
                        <td>
                            @if($item->hasilJurusan)
                                <span class="badge bg-success">{{ $item->hasilJurusan->nama_jurusan }}</span>
                            @else
                                <span class="badge bg-secondary">Belum ada hasil</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.riwayat.show', $item->id) }}" class="btn btn-sm btn-info me-2" title="Lihat Detail">
                                    <i class="bx bx-show-alt"></i> Detail
                                </a>
                                
                                <form action="{{ route('admin.riwayat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus riwayat ini? Data tidak bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            <div class="text-muted">Belum ada data riwayat rekomendasi.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection