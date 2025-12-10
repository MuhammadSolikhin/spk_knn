<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    /**
     * Menampilkan daftar siswa (User dengan role 'siswa').
     */
    public function index()
    {
        // Ambil user yang role-nya 'siswa'
        $siswa = User::where('role', 'siswa')->latest()->get();
        return view('admin.siswa.index', compact('siswa'));
    }

    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Menyimpan data siswa baru ke tabel users.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'no_telepon' => 'nullable|string|max:20',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            // Validasi khusus gambar: wajib image, format tertentu, maks 2MB (2048 KB)
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Siapkan data dasar
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
            'no_telepon' => $request->no_telepon,
            'asal_sekolah' => $request->asal_sekolah,
            'alamat' => $request->alamat,
        ];

        // 3. Proses Upload Foto (Jika Ada)
        if ($request->hasFile('profile_photo_path')) {
            // Simpan ke folder 'profile-photos' di dalam disk 'public'
            $path = $request->file('profile_photo_path')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        // 4. Simpan ke Database
        User::create($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data Siswa berhasil ditambahkan.');
    }

    public function edit($id)
    {
        // Cari user berdasarkan ID, pastikan dia siswa (opsional tapi aman)
        $siswa = User::where('role', 'siswa')->findOrFail($id);
        return view('admin.siswa.edit', compact('siswa'));
    }

    /**
     * Update data siswa.
     */
    public function update(Request $request, $id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            // Rule unique user tapi kecualikan ID user ini sendiri
            'email' => ['required', 'email', Rule::unique('users')->ignore($siswa->id)],
            'password' => 'nullable|string|min:8',
            'no_telepon' => 'nullable|string|max:20',
            'asal_sekolah' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // 2. Siapkan data update
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'no_telepon' => $request->no_telepon,
            'asal_sekolah' => $request->asal_sekolah,
            'alamat' => $request->alamat,
        ];

        // Cek apakah password diisi (jika kosong, jangan diupdate)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 3. Proses Ganti Foto
        if ($request->hasFile('profile_photo_path')) {
            // Hapus foto lama jika ada di storage
            if ($siswa->profile_photo_path && Storage::disk('public')->exists($siswa->profile_photo_path)) {
                Storage::disk('public')->delete($siswa->profile_photo_path);
            }

            // Upload foto baru
            $path = $request->file('profile_photo_path')->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        // 4. Update Database
        $siswa->update($data);

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data Siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = User::where('role', 'siswa')->findOrFail($id);

        // Hapus foto profil jika ada
        if ($siswa->profile_photo_path) {
            if (Storage::disk('public')->exists($siswa->profile_photo_path)) {
                Storage::disk('public')->delete($siswa->profile_photo_path);
            }
        }

        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data Siswa dan foto profil berhasil dihapus.');
    }
}