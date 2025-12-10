@extends('layouts.app')

@section('title', 'Data Kriteria')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Data /</span> Kriteria</h4>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Kriteria</h5>
        <a href="{{ route('admin.kriteria.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Kriteria
        </a>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="10%">Kode</th>
                    <th>Nama Kriteria</th>
                    <th>Tipe</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($kriterias as $item)
                    <tr>
                        <td><strong>{{ $item->kode }}</strong></td>
                        <td>{{ $item->nama_kriteria }}</td>
                        <td>
                            @if($item->tipe == 'core')
                                <span class="badge bg-label-primary">Core Factor</span>
                            @else
                                <span class="badge bg-label-info">Secondary Factor</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.kriteria.edit', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    
                                    <form action="{{ route('admin.kriteria.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bx bx-trash me-1"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data kriteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection