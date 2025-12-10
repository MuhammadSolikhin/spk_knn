@extends('layouts.app')

@section('title', 'Riwayat Konsultasi')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Konsultasi /</span> Riwayat</h4>

<div class="card">
    <h5 class="card-header">Riwayat Tes Anda</h5>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Tanggal Tes</th>
                    <th>Hasil Rekomendasi</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($konsultasis as $index => $item)
                    <tr>
                        <td>{{ $konsultasis->firstItem() + $index }}</td>
                        <td>{{ $item->created_at->translatedFormat('d F Y') }}</td>
                        <td>
                            @if($item->hasilJurusan)
                                <span class="badge bg-success">{{ $item->hasilJurusan->nama_jurusan }}</span>
                            @else
                                <span class="badge bg-warning">Proses</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('siswa.konsultasi.show', $item->id) }}" class="btn btn-sm btn-info">
                                <i class="bx bx-show me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Anda belum pernah melakukan tes minat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $konsultasis->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection