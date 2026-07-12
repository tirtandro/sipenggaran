<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Exports\PelanggaranExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $kelas = Kelas::where('tahun_ajaran_id', $tahunAktif?->id)->orderBy('nama')->get();

        $query = Pelanggaran::with(['murid.kelas', 'jenisPelanggaran.kategori', 'pencatat'])
            ->where('tahun_ajaran_id', $tahunAktif?->id);

        if ($request->filled('kelas_id')) {
            $query->whereHas('murid', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_kejadian', $request->bulan);
        }

        $pelanggaran = $query->latest('tanggal_kejadian')->paginate(20)->withQueryString();

        return view('laporan.index', compact('pelanggaran', 'kelas'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PelanggaranExport($request->kelas_id, $request->bulan),
            'Laporan_Pelanggaran_' . date('Y-m-d') . '.xlsx'
        );
    }

    public function exportPdf(Request $request)
    {
        $tahunAktif = TahunAjaran::getAktif();

        $query = Pelanggaran::with(['murid.kelas', 'jenisPelanggaran.kategori', 'pencatat'])
            ->where('tahun_ajaran_id', $tahunAktif?->id);

        if ($request->filled('kelas_id')) {
            $query->whereHas('murid', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_kejadian', $request->bulan);
        }

        $pelanggaran = $query->latest('tanggal_kejadian')->get();
        $kelasNama = $request->filled('kelas_id') ? Kelas::find($request->kelas_id)?->nama : 'Semua Kelas';

        $pdf = Pdf::loadView('laporan.cetak', compact('pelanggaran', 'kelasNama', 'tahunAktif'))
            ->setPaper('a4', 'landscape');
        return $pdf->stream('Laporan_Pelanggaran_' . date('Y-m-d') . '.pdf');
    }
}
