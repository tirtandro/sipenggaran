<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Services\PoinService;
use App\Exports\MuridTemplateExport;
use App\Imports\MuridImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class MuridController extends Controller
{
    protected $poinService;

    public function __construct(PoinService $poinService)
    {
        $this->poinService = $poinService;
    }

    public function index(Request $request)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $user = auth()->user();

        $query = Murid::with('kelas')
            ->where('is_aktif', true)
            ->when($user->isWaliKelas() && $user->kelas_id, fn($q) => $q->where('kelas_id', $user->kelas_id));

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $murid = $query->orderBy('nama')->paginate(20)->withQueryString();

        // Add poin info
        $murid->getCollection()->transform(function ($m) {
            $m->poin_info = $this->poinService->getStatusPoin($m->total_poin);
            return $m;
        });

        $kelas = Kelas::where('tahun_ajaran_id', $tahunAktif?->id)->orderBy('nama')->get();

        return view('murid.index', compact('murid', 'kelas'));
    }

    public function create()
    {
        $tahunAktif = TahunAjaran::getAktif();
        $kelas = Kelas::where('tahun_ajaran_id', $tahunAktif?->id)->orderBy('nama')->get();
        return view('murid.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:murid,nis',
            'nisn' => 'nullable',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_ortu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string',
        ]);

        Murid::create($validated);

        return redirect()->route('murid.index')->with('success', 'Data murid berhasil ditambahkan.');
    }

    public function show(Murid $murid)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $murid->load(['kelas', 'pelanggaran' => function ($q) use ($tahunAktif) {
            $q->where('tahun_ajaran_id', $tahunAktif?->id)
              ->with(['jenisPelanggaran.kategori', 'pencatat', 'sanksi'])
              ->latest('tanggal_kejadian');
        }, 'suratPeringatan' => function ($q) use ($tahunAktif) {
            $q->where('tahun_ajaran_id', $tahunAktif?->id)->latest();
        }]);

        $totalPoin = $this->poinService->getTotalPoin($murid);
        $statusPoin = $this->poinService->getStatusPoin($totalPoin);

        return view('murid.show', compact('murid', 'totalPoin', 'statusPoin'));
    }

    public function edit(Murid $murid)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $kelas = Kelas::where('tahun_ajaran_id', $tahunAktif?->id)->orderBy('nama')->get();
        return view('murid.edit', compact('murid', 'kelas'));
    }

    public function update(Request $request, Murid $murid)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:murid,nis,' . $murid->id,
            'nisn' => 'nullable',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'kelas_id' => 'required|exists:kelas,id',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_ortu' => 'nullable|string',
            'no_hp_ortu' => 'nullable|string',
        ]);

        $murid->update($validated);

        return redirect()->route('murid.show', $murid)->with('success', 'Data murid berhasil diperbarui.');
    }

    public function destroy(Murid $murid)
    {
        $murid->update(['is_aktif' => false]);
        return redirect()->route('murid.index')->with('success', 'Data murid berhasil dinonaktifkan.');
    }

    public function downloadTemplate()
    {
        return Excel::download(new MuridTemplateExport(), 'Template_Import_Murid.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new MuridImport();
        
        try {
            Excel::import($import, $request->file('file_excel'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses file: ' . $e->getMessage());
        }

        $errors = $import->getErrors();
        $successCount = $import->getSuccessCount();

        if (count($errors) > 0) {
            $errorMessage = "Berhasil mengimport {$successCount} murid. Namun ada beberapa baris yang error:<br>" . implode('<br>', $errors);
            return redirect()->route('murid.index')->with('success', "Berhasil mengimport {$successCount} murid.")->with('error', $errorMessage);
        }

        return redirect()->route('murid.index')->with('success', "Berhasil mengimport {$successCount} data murid.");
    }
}
