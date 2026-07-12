<?php

namespace Database\Seeders;

use App\Models\TahunAjaran;
use App\Models\Kelas;
use Illuminate\Database\Seeder;

class TahunAjaranSeeder extends Seeder
{
    public function run(): void
    {
        // Tahun Ajaran Terarsip (2025/2026)
        $tahunLalu = TahunAjaran::create([
            'nama' => '2025/2026',
            'tanggal_mulai' => '2025-07-14',
            'tanggal_selesai' => '2026-06-20',
            'is_aktif' => false,
        ]);

        // Tahun Ajaran Aktif Sekarang (2026/2027)
        $tahunAktif = TahunAjaran::create([
            'nama' => '2026/2027',
            'tanggal_mulai' => '2026-07-13',
            'tanggal_selesai' => '2027-06-19',
            'is_aktif' => true,
        ]);

        $tingkatList = ['X', 'XI', 'XII'];
        $abjadKelas = ['A', 'B', 'C', 'D', 'E'];

        // Buat kelas untuk tahun lalu
        foreach ($tingkatList as $tingkat) {
            foreach ($abjadKelas as $abjad) {
                Kelas::create([
                    'nama' => $tingkat . ' ' . $abjad,
                    'tingkat' => $tingkat,
                    'jurusan' => null,
                    'tahun_ajaran_id' => $tahunLalu->id,
                ]);
            }
        }

        // Buat kelas untuk tahun aktif sekarang
        foreach ($tingkatList as $tingkat) {
            foreach ($abjadKelas as $abjad) {
                Kelas::create([
                    'nama' => $tingkat . ' ' . $abjad,
                    'tingkat' => $tingkat,
                    'jurusan' => null,
                    'tahun_ajaran_id' => $tahunAktif->id,
                ]);
            }
        }
    }
}
