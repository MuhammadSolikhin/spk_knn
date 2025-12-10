@extends('layouts.app')

@section('title', 'Tes Minat Baru')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Konsultasi /</span> Tes Minat</h4>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card mb-4">
            <h5 class="card-header">Masukkan Nilai Akademik Anda</h5>
            <div class="card-body">
                <form action="{{ route('siswa.konsultasi.store') }}" method="POST">
                    @csrf
                    
                    <div class="alert alert-info">
                        Silakan masukkan nilai rata-rata rapor (Skala 0-100) untuk setiap mata pelajaran berikut.
                    </div>

                    @foreach($kriterias as $k)
                        <div class="mb-3 row">
                            <label class="col-sm-4 col-form-label fw-bold">{{ $k->nama_kriteria }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" max="100" class="form-control" 
                                        name="nilai[{{ $k->id }}]" required placeholder="0 - 100">
                                    <span class="input-group-text">Points</span>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4 d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bx bx-calculator me-1"></i> Analisa Minat Saya
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection