<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::withCount('kelas')->orderBy('nama', 'desc')->get();
        return view('tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50|unique:tahun_ajaran,nama',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'salin_kelas_dari' => 'nullable|exists:tahun_ajaran,id',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $tahun = TahunAjaran::create([
                    'nama' => $validated['nama'],
                    'tanggal_mulai' => $validated['tanggal_mulai'],
                    'tanggal_selesai' => $validated['tanggal_selesai'],
                    'is_aktif' => false, // Default tidak aktif, harus diaktifkan secara eksplisit
                ]);

                // Opsional: Salin kelas dari tahun ajaran lain
                if (!empty($validated['salin_kelas_dari'])) {
                    $kelasLama = Kelas::where('tahun_ajaran_id', $validated['salin_kelas_dari'])->get();
                    foreach ($kelasLama as $kls) {
                        Kelas::create([
                            'nama' => $kls->nama,
                            'tingkat' => $kls->tingkat,
                            'jurusan' => $kls->jurusan,
                            'tahun_ajaran_id' => $tahun->id,
                        ]);
                    }
                } else {
                    // Default template kelas jika tidak menyalin
                    $tingkatList = ['X', 'XI', 'XII'];
                    $abjadKelas = ['A', 'B', 'C', 'D', 'E'];
                    foreach ($tingkatList as $tingkat) {
                        foreach ($abjadKelas as $abjad) {
                            Kelas::create([
                                'nama' => $tingkat . ' ' . $abjad,
                                'tingkat' => $tingkat,
                                'jurusan' => null,
                                'tahun_ajaran_id' => $tahun->id,
                            ]);
                        }
                    }
                }
            });

            return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat tahun ajaran: ' . $e->getMessage());
        }
    }

    public function aktifkan(TahunAjaran $tahunAjaran)
    {
        try {
            DB::transaction(function () use ($tahunAjaran) {
                // Nonaktifkan semua tahun ajaran lain
                TahunAjaran::query()->update(['is_aktif' => false]);

                // Aktifkan tahun ajaran yang dipilih
                $tahunAjaran->update(['is_aktif' => true]);
            });

            return redirect()->route('tahun-ajaran.index')->with('success', 'Tahun Ajaran ' . $tahunAjaran->nama . ' berhasil diaktifkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengaktifkan tahun ajaran: ' . $e->getMessage());
        }
    }
}
