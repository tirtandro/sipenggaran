<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Murid;
use App\Models\JenisPelanggaran;
use App\Models\KategoriPelanggaran;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Services\PoinService;
use App\Services\SuratService;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    protected $poinService;
    protected $suratService;

    public function __construct(PoinService $poinService, SuratService $suratService)
    {
        $this->poinService = $poinService;
        $this->suratService = $suratService;
    }

    public function index(Request $request)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $user = auth()->user();

        $query = Pelanggaran::with(['murid.kelas', 'jenisPelanggaran.kategori', 'pencatat'])
            ->where('tahun_ajaran_id', $tahunAktif?->id);

        if ($user->isWaliKelas() && $user->kelas_id) {
            $query->whereHas('murid', fn($q) => $q->where('kelas_id', $user->kelas_id));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('murid', fn($q) => $q->where('nama', 'like', "%{$search}%")->orWhere('nis', 'like', "%{$search}%"));
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('murid', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('tingkat')) {
            $query->whereHas('jenisPelanggaran', fn($q) => $q->where('tingkat', $request->tingkat));
        }

        if ($request->filled('tanggal_dari')) {
            $query->where('tanggal_kejadian', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->where('tanggal_kejadian', '<=', $request->tanggal_sampai);
        }

        $pelanggaran = $query->latest('tanggal_kejadian')->paginate(20)->withQueryString();
        $kelas = Kelas::where('tahun_ajaran_id', $tahunAktif?->id)->orderBy('nama')->get();

        return view('pelanggaran.index', compact('pelanggaran', 'kelas'));
    }

    public function create(Request $request)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $user = auth()->user();

        $muridQuery = Murid::where('is_aktif', true)->with('kelas');
        if ($user->isWaliKelas() && $user->kelas_id) {
            $muridQuery->where('kelas_id', $user->kelas_id);
        }
        $murid = $muridQuery->orderBy('nama')->get();

        $kategori = KategoriPelanggaran::with('jenisPelanggaran')->get();
        $selectedMuridId = $request->murid_id;

        return view('pelanggaran.create', compact('murid', 'kategori', 'selectedMuridId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'murid_id' => 'required|exists:murid,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal_kejadian' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $tahunAktif = TahunAjaran::getAktif();
        $jenisPelanggaran = JenisPelanggaran::findOrFail($validated['jenis_pelanggaran_id']);

        $pelanggaran = Pelanggaran::create([
            'murid_id' => $validated['murid_id'],
            'jenis_pelanggaran_id' => $validated['jenis_pelanggaran_id'],
            'pencatat_id' => auth()->id(),
            'tahun_ajaran_id' => $tahunAktif->id,
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'keterangan' => $validated['keterangan'],
            'poin' => $jenisPelanggaran->poin,
        ]);

        // Cek apakah perlu surat peringatan
        $murid = Murid::find($validated['murid_id']);
        $perluSurat = $this->suratService->cekPerluSurat($murid);

        $message = 'Pelanggaran berhasil dicatat.';
        if ($perluSurat) {
            $message .= " PERHATIAN: Murid ini sudah mencapai threshold {$perluSurat}, silakan buat surat peringatan.";
        }

        return redirect()->route('pelanggaran.index')->with('success', $message);
    }

    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['murid.kelas', 'jenisPelanggaran.kategori', 'pencatat', 'sanksi']);
        return view('pelanggaran.show', compact('pelanggaran'));
    }

    public function edit(Pelanggaran $pelanggaran)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $murid = Murid::where('is_aktif', true)->with('kelas')->orderBy('nama')->get();
        $kategori = KategoriPelanggaran::with('jenisPelanggaran')->get();
        $pelanggaran->load(['jenisPelanggaran.kategori']);

        return view('pelanggaran.edit', compact('pelanggaran', 'murid', 'kategori'));
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $validated = $request->validate([
            'murid_id' => 'required|exists:murid,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal_kejadian' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $jenisPelanggaran = JenisPelanggaran::findOrFail($validated['jenis_pelanggaran_id']);

        $pelanggaran->update([
            'murid_id' => $validated['murid_id'],
            'jenis_pelanggaran_id' => $validated['jenis_pelanggaran_id'],
            'tanggal_kejadian' => $validated['tanggal_kejadian'],
            'keterangan' => $validated['keterangan'],
            'poin' => $jenisPelanggaran->poin,
        ]);

        return redirect()->route('pelanggaran.index')->with('success', 'Data pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();
        return redirect()->route('pelanggaran.index')->with('success', 'Data pelanggaran berhasil dihapus.');
    }

    public function getJenisByKategori(Request $request)
    {
        $jenis = JenisPelanggaran::where('kategori_id', $request->kategori_id)->get();
        return response()->json($jenis);
    }
}
