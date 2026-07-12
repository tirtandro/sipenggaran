<?php

namespace App\Services;

use App\Models\Murid;
use App\Models\SuratPeringatan;
use App\Models\TahunAjaran;

class SuratService
{
    public function generateNomorSurat(string $jenisSurat): string
    {
        $tahun = date('Y');
        $count = SuratPeringatan::whereYear('created_at', $tahun)->count() + 1;
        return sprintf('%s/%03d/SMAN2W/%s', $jenisSurat, $count, $tahun);
    }

    public function cekPerluSurat(Murid $murid): ?string
    {
        $poinService = new PoinService();
        $totalPoin = $poinService->getTotalPoin($murid);
        $jenisSurat = $poinService->getSuratJenis($totalPoin);

        if (!$jenisSurat) return null;

        $tahunAktif = TahunAjaran::getAktif();
        if (!$tahunAktif) return null;

        // Cek apakah surat jenis ini sudah pernah dibuat
        $sudahAda = SuratPeringatan::where('murid_id', $murid->id)
            ->where('tahun_ajaran_id', $tahunAktif->id)
            ->where('jenis_surat', $jenisSurat)
            ->exists();

        return $sudahAda ? null : $jenisSurat;
    }
}
