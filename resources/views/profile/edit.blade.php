@extends('layouts.app')

@section('title', 'Pengaturan Akun')

@section('content')
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pengaturan Akun /</span> Profil</h4>

    <div class="row">
        <div class="col-md-12">

            @if (session('status') === 'profile-updated' || session('status') === 'password-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Data berhasil diperbarui.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <h5 class="card-header">Profil Pengguna</h5>
                <div class="card-body">

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('patch')

                        <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                            <img src="{{ $user->photo_url }}" alt="user-avatar" class="d-block rounded" height="100"
                                width="100" id="uploadedAvatar" style="object-fit: cover;">

                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                    <span class="d-none d-sm-block">Upload foto baru</span>
                                    <i class="bx bx-upload d-block d-sm-none"></i>
                                    <input type="file" id="upload" name="photo" class="account-file-input" hidden
                                        accept="image/png, image/jpeg" />
                                </label>
                                <p class="text-muted mb-0">Diizinkan JPG, GIF atau PNG. Ukuran maksimal 1MB</p>

                                @error('photo')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <hr class="my-0 mb-4">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="name" class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="email" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="no_telepon" class="form-label">No. Telepon / WhatsApp</label>
                                <input class="form-control" type="text" id="no_telepon" name="no_telepon"
                                    value="{{ old('no_telepon', $user->no_telepon) }}" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                                <input class="form-control" type="text" id="asal_sekolah" name="asal_sekolah"
                                    value="{{ old('asal_sekolah', $user->asal_sekolah) }}" />
                            </div>

                            <div class="mb-3 col-md-12">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat"
                                    rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-4">
                <h5 class="card-header">Ganti Password</h5>
                <div class="card-body">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="current_password" class="form-label">Password Saat Ini</label>
                                <input
                                    class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                                    type="password" id="current_password" name="current_password"
                                    autocomplete="current-password" />
                                @error('current_password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">Password Baru</label>
                                <input class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                                    type="password" id="password" name="password" autocomplete="new-password" />
                                @error('password', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                <input
                                    class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror"
                                    type="password" id="password_confirmation" name="password_confirmation"
                                    autocomplete="new-password" />
                                @error('password_confirmation', 'updatePassword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header text-danger">Hapus Akun</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">Apakah Anda yakin ingin menghapus akun Anda?</h6>
                            <p class="mb-0">Setelah akun dihapus, semua sumber daya dan data akan dihapus secara permanen.
                                Silakan unduh data apa pun yang ingin Anda simpan sebelum melanjutkan.</p>
                        </div>
                    </div>

                    <button type="button" class="btn btn-danger deactivate-account" data-bs-toggle="modal"
                        data-bs-target="#modalDeleteAccount">
                        Hapus Akun Saya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteAccount" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-body">
                        <p>Apakah Anda yakin? Masukkan password Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun
                            secara permanen.</p>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="password_delete" class="form-label">Password</label>
                                <input type="password" id="password_delete" name="password"
                                    class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                    placeholder="Masukkan password Anda" />
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

{{-- Jika ada error validation pada modal delete, buka modalnya kembali secara otomatis --}}
@if($errors->userDeletion->isNotEmpty())
    @push('scripts')
        <script>
            $(document).ready(function () {
                var myModal = new bootstrap.Modal(document.getElementById('modalDeleteAccount'));
                myModal.show();
            });
        </script>
    @endpush
@endif

@push('scripts')
    <script>
        document.getElementById('upload').onchange = function (evt) {
            var tgt = evt.target || window.event.srcElement,
                files = tgt.files;

            // FileReader support
            if (FileReader && files && files.length) {
                var fr = new FileReader();
                fr.onload = function () {
                    document.getElementById('uploadedAvatar').src = fr.result;
                }
                fr.readAsDataURL(files[0]);
            }
        }
    </script>
@endpush