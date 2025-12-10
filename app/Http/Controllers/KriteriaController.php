<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Menampilkan daftar kriteria.
     */
    public function index()
    {
        // Mengambil semua data kriteria
        $kriterias = Kriteria::all();

        // Return ke view (pastikan buat folder admin/kriteria nanti)
        return view('admin.kriteria.index', compact('kriterias'));
    }

    /**
     * Menampilkan form tambah kriteria baru.
     */
    public function create()
    {
        return view('admin.kriteria.create');
    }

    /**
     * Menyimpan data kriteria baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'kode' => 'required|unique:kriterias,kode|max:10', // Kode harus unik (misal: C1)
            'nama_kriteria' => 'required|string|max:255',
            'tipe' => 'required|in:core,secondary', // Validasi enum
        ], [
            // Custom Error Messages (Opsional)
            'kode.unique' => 'Kode kriteria ini sudah ada, gunakan kode lain.',
            'kode.required' => 'Kode kriteria wajib diisi.',
        ]);

        // 2. Simpan Data
        Kriteria::create([
            'kode' => $request->kode,
            'nama_kriteria' => $request->nama_kriteria,
            'tipe' => $request->tipe,
        ]);

        // 3. Redirect dengan pesan sukses
        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data Kriteria berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kriteria.
     */
    public function edit($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    /**
     * Mengupdate data kriteria yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        // 1. Validasi Input
        $request->validate([
            // Unique tapi abaikan ID yang sedang diedit ini
            'kode' => 'required|max:10|unique:kriterias,kode,' . $id,
            'nama_kriteria' => 'required|string|max:255',
            'tipe' => 'required|in:core,secondary',
        ]);

        // 2. Cari dan Update
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->update([
            'kode' => $request->kode,
            'nama_kriteria' => $request->nama_kriteria,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data Kriteria berhasil diperbarui.');
    }

    /**
     * Menghapus data kriteria.
     */
    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        return redirect()->route('admin.kriteria.index')
            ->with('success', 'Data Kriteria berhasil dihapus.');
    }
}