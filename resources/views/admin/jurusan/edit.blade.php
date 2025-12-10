@extends('layouts.app')

@section('title', 'Edit Jurusan')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Data / Jurusan /</span> Edit Data</h4>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <h5 class="card-header">Form Edit Jurusan</h5>
            <div class="card-body">
                <form action="{{ route('admin.jurusan.update', $jurusan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                        <input type="text" class="form-control @error('nama_jurusan') is-invalid @enderror" 
                            id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required />
                        @error('nama_jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $jurusan->deskripsi) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="{{ route('admin.jurusan.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection