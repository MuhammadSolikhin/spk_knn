@extends('layouts.app')

@section('title', 'Detail Data Training')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dataset / Data Training /</span> Detail</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <h5 class="card-header">Profil Alumni</h5>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Nama</th>
                        <td>: {{ $dataTraining->nama_siswa }}</td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td>: <span class="badge bg-success">{{ $dataTraining->jurusan->nama_jurusan }}</span></td>
                    </tr>
                    <tr>
                        <th>Tanggal Input</th>
                        <td>: {{ $dataTraining->created_at->format('d M Y') }}</td>
                    </tr>
                </table>
                <div class="mt-3">
                    <a href="{{ route('admin.datatraining.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-4">
            <h5 class="card-header">Detail Nilai</h5>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Kriteria</th>
                            <th>Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dataTraining->nilais as $nilai)
                        <tr>
                            <td>{{ $nilai->kriteria->kode }}</td>
                            <td>{{ $nilai->kriteria->nama_kriteria }}</td>
                            <td><strong>{{ $nilai->nilai }}</strong></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection