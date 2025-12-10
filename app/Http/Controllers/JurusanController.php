<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Menampilkan daftar jurusan.
     */
    public function index()
    {
        $jurusans = Jurusan::all();
        return view('admin.jurusan.index', compact('jurusans'));
    }

    /**
     * Menampilkan form tambah jurusan.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Menyimpan data jurusan baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan',
            'deskripsi' => 'nullable|string',
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi.',
            'nama_jurusan.unique' => 'Nama jurusan ini sudah terdaftar.',
        ]);

        // 2. Simpan
        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi,
        ]);

        // 3. Redirect
        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data Jurusan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit jurusan.
     */
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Mengupdate data jurusan.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi (Abaikan unique jika nama tidak berubah)
        $request->validate([
            'nama_jurusan' => 'required|string|max:100|unique:jurusans,nama_jurusan,'.$id,
            'deskripsi' => 'nullable|string',
        ]);

        // 2. Update
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data Jurusan berhasil diperbarui.');
    }

    /**
     * Menghapus jurusan.
     */
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        
        // Cek apakah jurusan dipakai di data training (Optional, untuk keamanan data)
        if($jurusan->dataTrainings()->count() > 0) {
            return back()->with('error', 'Jurusan tidak bisa dihapus karena sedang digunakan dalam Data Training.');
        }

        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')
            ->with('success', 'Data Jurusan berhasil dihapus.');
    }
}