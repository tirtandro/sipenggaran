<?php

namespace App\Http\Controllers;

use App\Models\SuratPeringatan;
use App\Models\Murid;
use App\Models\TahunAjaran;
use App\Services\PoinService;
use App\Services\SuratService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SuratPeringatanController extends Controller
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

        $query = SuratPeringatan::with(['murid.kelas', 'pembuat'])
            ->where('tahun_ajaran_id', $tahunAktif?->id);

        if ($request->filled('search')) {
            $query->whereHas('murid', fn($q) => $q->where('nama', 'like', "%{$request->search}%"));
        }

        $suratPeringatan = $query->latest('tanggal_surat')->paginate(20)->withQueryString();

        return view('surat.index', compact('suratPeringatan'));
    }

    public function create(Request $request)
    {
        $murid = Murid::with('kelas')->findOrFail($request->murid_id);
        $tahunAktif = TahunAjaran::getAktif();
        $totalPoin = $this->poinService->getTotalPoin($murid);
        $jenisSurat = $this->poinService->getSuratJenis($totalPoin);
        $nomorSurat = $this->suratService->generateNomorSurat($jenisSurat ?? 'SP1');

        return view('surat.create', compact('murid', 'totalPoin', 'jenisSurat', 'nomorSurat'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'murid_id' => 'required|exists:murid,id',
            'nomor_surat' => 'required|unique:surat_peringatan,nomor_surat',
            'jenis_surat' => 'required|in:SP1,SP2,SP3',
            'tanggal_surat' => 'required|date',
            'perihal' => 'nullable|string',
        ]);

        $tahunAktif = TahunAjaran::getAktif();
        $murid = Murid::findOrFail($validated['murid_id']);
        $totalPoin = $this->poinService->getTotalPoin($murid);

        SuratPeringatan::create([
            'nomor_surat' => $validated['nomor_surat'],
            'murid_id' => $validated['murid_id'],
            'tahun_ajaran_id' => $tahunAktif->id,
            'jenis_surat' => $validated['jenis_surat'],
            'total_poin' => $totalPoin,
            'tanggal_surat' => $validated['tanggal_surat'],
            'perihal' => $validated['perihal'],
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat peringatan berhasil dibuat.');
    }

    public function cetak(Request $request, SuratPeringatan $surat)
    {
        $surat->load(['murid.kelas', 'murid.pelanggaran' => function ($q) use ($surat) {
            $q->where('tahun_ajaran_id', $surat->tahun_ajaran_id)
              ->with('jenisPelanggaran.kategori')
              ->latest('tanggal_kejadian');
        }]);

        // Default value jika query parameter kosong
        $namaKepsek = $request->query('nama_kepsek', 'Tutik Sunarti, S.Pd., M.Pd.');
        $nipKepsek = $request->query('nip_kepsek', '197603182005012003'); // NIP Contoh/Default

        $tanggalCetakInput = $request->query('tanggal_cetak');
        if ($tanggalCetakInput) {
            $tanggalCetak = \Carbon\Carbon::parse($tanggalCetakInput);
        } else {
            $tanggalCetak = $surat->tanggal_surat;
        }

        $pdf = Pdf::loadView('surat.cetak', compact('surat', 'namaKepsek', 'nipKepsek', 'tanggalCetak'));
        $filename = 'Surat_Peringatan_' . str_replace('/', '-', $surat->nomor_surat) . '.pdf';
        return $pdf->stream($filename);
    }
}
