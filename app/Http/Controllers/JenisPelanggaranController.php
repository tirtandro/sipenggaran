<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\Request;

class JenisPelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $kategori = KategoriPelanggaran::with(['jenisPelanggaran' => function ($q) {
            $q->orderBy('kode');
        }])->orderBy('kode')->get();

        return view('referensi.index', compact('kategori'));
    }

    public function edit(JenisPelanggaran $jenisPelanggaran)
    {
        $kategori = KategoriPelanggaran::orderBy('kode')->get();
        return view('referensi.edit', compact('jenisPelanggaran', 'kategori'));
    }

    public function create()
    {
        $kategori = KategoriPelanggaran::orderBy('kode')->get();
        return view('referensi.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_pelanggaran,id',
            'kode' => 'required|string|max:50|unique:jenis_pelanggaran,kode',
            'deskripsi' => 'required|string',
            'tingkat' => 'required|in:ringan,sedang,berat',
            'poin' => 'required|integer|min:1|max:100',
        ]);

        JenisPelanggaran::create($validated);

        return redirect()->route('referensi.index')->with('success', 'Jenis pelanggaran baru berhasil ditambahkan.');
    }

    public function update(Request $request, JenisPelanggaran $jenisPelanggaran)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:jenis_pelanggaran,kode,' . $jenisPelanggaran->id,
            'deskripsi' => 'required|string',
            'tingkat' => 'required|in:ringan,sedang,berat',
            'poin' => 'required|integer|min:1|max:100',
        ]);

        $jenisPelanggaran->update($validated);

        return redirect()->route('referensi.index')->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(JenisPelanggaran $jenisPelanggaran)
    {
        $jenisPelanggaran->delete();
        return redirect()->route('referensi.index')->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}
