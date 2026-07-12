<?php

namespace App\Services;

use App\Models\Murid;
use App\Models\TahunAjaran;

class PoinService
{
    public function getTotalPoin(Murid $murid, ?int $tahunAjaranId = null): int
    {
        $tahunAjaranId = $tahunAjaranId ?? TahunAjaran::getAktif()?->id;
        if (!$tahunAjaranId) return 0;

        return $murid->pelanggaran()
            ->where('tahun_ajaran_id', $tahunAjaranId)
            ->sum('poin');
    }

    public function getStatusPoin(int $totalPoin): array
    {
        if ($totalPoin <= 30) {
            return ['status' => 'hijau', 'label' => 'Normal', 'color' => 'green', 'bg' => 'bg-green-100 text-green-800'];
        }
        if ($totalPoin <= 60) {
            return ['status' => 'kuning', 'label' => 'Peringatan', 'color' => 'yellow', 'bg' => 'bg-yellow-100 text-yellow-800'];
        }
        if ($totalPoin <= 100) {
            return ['status' => 'oranye', 'label' => 'Pembinaan Khusus', 'color' => 'orange', 'bg' => 'bg-orange-100 text-orange-800'];
        }
        return ['status' => 'merah', 'label' => 'Kritis', 'color' => 'red', 'bg' => 'bg-red-100 text-red-800'];
    }

    public function getSanksiRekomendasi(int $totalPoin): string
    {
        if ($totalPoin <= 30) return 'teguran_lisan';
        if ($totalPoin <= 60) return 'peringatan_tertulis';
        if ($totalPoin <= 100) return 'pembinaan_khusus';
        return 'diserahkan_pihak_berwajib';
    }

    public function getSuratJenis(int $totalPoin): ?string
    {
        if ($totalPoin > 100) return 'SP3';
        if ($totalPoin > 60) return 'SP2';
        if ($totalPoin > 30) return 'SP1';
        return null;
    }
}
