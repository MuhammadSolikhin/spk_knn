@extends('layouts.app')

@section('title', 'Edit Kriteria')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Data / Kriteria /</span> Edit Data</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Form Edit Kriteria</h5>
            <div class="card-body">
                <form action="{{ route('admin.kriteria.update', $kriteria->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Kriteria</label>
                        <input type="text" class="form-control @error('kode') is-invalid @enderror" 
                            id="kode" name="kode" value="{{ old('kode', $kriteria->kode) }}" required />
                        @error('kode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                        <input type="text" class="form-control @error('nama_kriteria') is-invalid @enderror" 
                            id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required />
                        @error('nama_kriteria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe Kriteria</label>
                        <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                            <option value="core" {{ old('tipe', $kriteria->tipe) == 'core' ? 'selected' : '' }}>Core Factor (Utama)</option>
                            <option value="secondary" {{ old('tipe', $kriteria->tipe) == 'secondary' ? 'selected' : '' }}>Secondary Factor (Pendukung)</option>
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Update</button>
                        <a href="{{ route('admin.kriteria.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection