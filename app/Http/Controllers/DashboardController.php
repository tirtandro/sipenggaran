<?php

namespace App\Http\Controllers;

use App\Models\Murid;
use App\Models\Pelanggaran;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Services\PoinService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(PoinService $poinService)
    {
        $tahunAktif = TahunAjaran::getAktif();
        $user = auth()->user();

        $query = Pelanggaran::where('tahun_ajaran_id', $tahunAktif?->id);
        $muridQuery = Murid::query();

        // Filter untuk wali kelas - hanya lihat kelas mereka
        if ($user->isWaliKelas() && $user->kelas_id) {
            $query->whereHas('murid', fn($q) => $q->where('kelas_id', $user->kelas_id));
            $muridQuery->where('kelas_id', $user->kelas_id);
        }

        $totalPelanggaran = $query->count();
        $totalMurid = $muridQuery->where('is_aktif', true)->count();
        $totalPoinBulanIni = (clone $query)->whereMonth('tanggal_kejadian', now()->month)->sum('poin');

        // Pelanggaran terbaru
        $pelanggaranTerbaru = (clone $query)->with(['murid.kelas', 'jenisPelanggaran.kategori', 'pencatat'])
            ->latest('tanggal_kejadian')
            ->limit(10)
            ->get();

        // Murid dengan poin tertinggi
        $muridBermasalah = Murid::where('is_aktif', true)
            ->when($user->isWaliKelas() && $user->kelas_id, fn($q) => $q->where('kelas_id', $user->kelas_id))
            ->whereHas('pelanggaran', fn($q) => $q->where('tahun_ajaran_id', $tahunAktif?->id))
            ->withSum(['pelanggaran as total_poin_sum' => fn($q) => $q->where('tahun_ajaran_id', $tahunAktif?->id)], 'poin')
            ->orderByDesc('total_poin_sum')
            ->limit(10)
            ->with('kelas')
            ->get();

        // Statistik per bulan (6 bulan terakhir)
        $statistikBulanan = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = now()->subMonths($i);
            $count = Pelanggaran::where('tahun_ajaran_id', $tahunAktif?->id)
                ->when($user->isWaliKelas() && $user->kelas_id, fn($q) => $q->whereHas('murid', fn($sq) => $sq->where('kelas_id', $user->kelas_id)))
                ->whereYear('tanggal_kejadian', $bulan->year)
                ->whereMonth('tanggal_kejadian', $bulan->month)
                ->count();
            $statistikBulanan[] = [
                'bulan' => $bulan->translatedFormat('M Y'),
                'count' => $count,
            ];
        }

        // Statistik per kategori
        $statistikKategori = Pelanggaran::where('tahun_ajaran_id', $tahunAktif?->id)
            ->when($user->isWaliKelas() && $user->kelas_id, fn($q) => $q->whereHas('murid', fn($sq) => $sq->where('kelas_id', $user->kelas_id)))
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->join('kategori_pelanggaran', 'jenis_pelanggaran.kategori_id', '=', 'kategori_pelanggaran.id')
            ->selectRaw('kategori_pelanggaran.nama, COUNT(*) as total')
            ->groupBy('kategori_pelanggaran.nama')
            ->orderByDesc('total')
            ->get();

        // Hitung murid per status poin
        $statusCount = ['hijau' => 0, 'kuning' => 0, 'oranye' => 0, 'merah' => 0];
        $allMurid = Murid::where('is_aktif', true)
            ->when($user->isWaliKelas() && $user->kelas_id, fn($q) => $q->where('kelas_id', $user->kelas_id))
            ->withSum(['pelanggaran as poin_total' => fn($q) => $q->where('tahun_ajaran_id', $tahunAktif?->id)], 'poin')
            ->get();

        foreach ($allMurid as $m) {
            $status = $poinService->getStatusPoin($m->poin_total ?? 0);
            $statusCount[$status['status']]++;
        }

        return view('dashboard', compact(
            'totalPelanggaran', 'totalMurid', 'totalPoinBulanIni',
            'pelanggaranTerbaru', 'muridBermasalah', 'statistikBulanan',
            'statistikKategori', 'statusCount', 'tahunAktif'
        ));
    }
}
