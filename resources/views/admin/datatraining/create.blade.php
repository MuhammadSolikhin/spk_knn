@extends('layouts.app')

@section('title', 'Tambah Data Training')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dataset / Data Training /</span> Tambah Baru</h4>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Form Data Alumni</h5>
            <div class="card-body">
                <form action="{{ route('admin.datatraining.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3 text-muted">Informasi Umum</h6>
                            
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa Alumni</label>
                                <input type="text" class="form-control" name="nama_siswa" required placeholder="Nama Lengkap">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jurusan Yang Diambil (Label)</label>
                                <select class="form-select" name="jurusan_id" required>
                                    <option value="" disabled selected>Pilih Jurusan</option>
                                    @foreach($jurusans as $j)
                                        <option value="{{ $j->id }}">{{ $j->nama_jurusan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h6 class="mb-3 text-muted">Input Nilai Kriteria</h6>
                            
                            @foreach($kriterias as $k)
                                <div class="mb-3 row">
                                    <label class="col-sm-6 col-form-label">{{ $k->nama_kriteria }} ({{ $k->kode }})</label>
                                    <div class="col-sm-6">
                                        <input type="number" step="0.01" class="form-control" 
                                            name="nilai[{{ $k->id }}]" required placeholder="0 - 100">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary me-2">Simpan Data</button>
                        <a href="{{ route('admin.datatraining.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection