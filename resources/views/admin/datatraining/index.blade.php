@extends('layouts.app')

@section('title', 'Data Training')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dataset /</span> Data Training</h4>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Data Alumni (Dataset)</h5>
        <a href="{{ route('admin.datatraining.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Data
        </a>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama Siswa</th>
                    <th>Jurusan (Label)</th>
                    <th width="15%">Aksi</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($dataTrainings as $index => $item)
                    <tr>
                        <td>{{ $dataTrainings->firstItem() + $index }}</td>
                        <td><strong>{{ $item->nama_siswa }}</strong></td>
                        <td>
                            <span class="badge bg-label-success">{{ $item->jurusan->nama_jurusan }}</span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('admin.datatraining.show', $item->id) }}">
                                        <i class="bx bx-show me-1"></i> Detail Nilai
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.datatraining.edit', $item->id) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.datatraining.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                        @csrf @method('DELETE')
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
                        <td colspan="4" class="text-center">Belum ada data training.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $dataTrainings->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection