<?php

namespace App\Exports;

use App\Models\Pelanggaran;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PelanggaranExport implements FromCollection, WithHeadings, WithMapping, WithTitle, ShouldAutoSize
{
    protected $kelasId;
    protected $bulan;
    protected $tahunAjaranId;

    public function __construct(?int $kelasId = null, ?string $bulan = null, ?int $tahunAjaranId = null)
    {
        $this->kelasId = $kelasId;
        $this->bulan = $bulan;
        $this->tahunAjaranId = $tahunAjaranId ?? TahunAjaran::getAktif()?->id;
    }

    public function collection()
    {
        $query = Pelanggaran::with(['murid.kelas', 'jenisPelanggaran.kategori', 'pencatat'])
            ->where('tahun_ajaran_id', $this->tahunAjaranId);

        if ($this->kelasId) {
            $query->whereHas('murid', fn($q) => $q->where('kelas_id', $this->kelasId));
        }

        if ($this->bulan) {
            $query->whereMonth('tanggal_kejadian', $this->bulan);
        }

        return $query->orderBy('tanggal_kejadian', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Tanggal', 'NIS', 'Nama Murid', 'Kelas',
            'Kategori', 'Jenis Pelanggaran', 'Tingkat', 'Poin',
            'Keterangan', 'Dicatat Oleh',
        ];
    }

    public function map($pelanggaran): array
    {
        static $no = 0;
        $no++;
        return [
            $no,
            $pelanggaran->tanggal_kejadian->format('d/m/Y'),
            $pelanggaran->murid->nis,
            $pelanggaran->murid->nama,
            $pelanggaran->murid->kelas->nama,
            $pelanggaran->jenisPelanggaran->kategori->nama,
            $pelanggaran->jenisPelanggaran->deskripsi,
            ucfirst($pelanggaran->jenisPelanggaran->tingkat),
            $pelanggaran->poin,
            $pelanggaran->keterangan ?? '-',
            $pelanggaran->pencatat->name,
        ];
    }

    public function title(): string
    {
        return 'Laporan Pelanggaran';
    }
}
