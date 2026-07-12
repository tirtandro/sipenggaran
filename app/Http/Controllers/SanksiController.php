<?php

namespace App\Http\Controllers;

use App\Models\Sanksi;
use App\Models\Pelanggaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index(Request $request)
    {
        $tahunAktif = TahunAjaran::getAktif();

        $query = Sanksi::with(['pelanggaran.jenisPelanggaran', 'murid.kelas', 'pemberiSanksi'])
            ->whereHas('pelanggaran', fn($q) => $q->where('tahun_ajaran_id', $tahunAktif?->id));

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sanksi = $query->latest('tanggal_sanksi')->paginate(20)->withQueryString();

        return view('sanksi.index', compact('sanksi'));
    }

    public function create(Request $request)
    {
        $pelanggaran = Pelanggaran::with(['murid', 'jenisPelanggaran'])->findOrFail($request->pelanggaran_id);
        return view('sanksi.create', compact('pelanggaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|in:teguran_lisan,tugas_perbaikan,peringatan_tertulis,panggil_ortu,pembinaan_khusus,diserahkan_pihak_berwajib,dikembalikan_ke_ortu',
            'deskripsi' => 'nullable|string',
            'tanggal_sanksi' => 'required|date',
        ]);

        $pelanggaran = Pelanggaran::findOrFail($validated['pelanggaran_id']);

        Sanksi::create([
            'pelanggaran_id' => $validated['pelanggaran_id'],
            'murid_id' => $pelanggaran->murid_id,
            'jenis_sanksi' => $validated['jenis_sanksi'],
            'deskripsi' => $validated['deskripsi'],
            'tanggal_sanksi' => $validated['tanggal_sanksi'],
            'status' => 'belum_dilaksanakan',
            'diberikan_oleh' => auth()->id(),
        ]);

        return redirect()->route('sanksi.index')->with('success', 'Sanksi berhasil diberikan.');
    }

    public function updateStatus(Request $request, Sanksi $sanksi)
    {
        $validated = $request->validate([
            'status' => 'required|in:belum_dilaksanakan,sedang_berlangsung,selesai',
        ]);

        $sanksi->update($validated);

        return redirect()->back()->with('success', 'Status sanksi berhasil diperbarui.');
    }
}
