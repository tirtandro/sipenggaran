<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class MuridTemplateExport implements WithTitle, WithHeadings, WithEvents
{
    public function title(): string
    {
        return 'Template Import Murid';
    }

    public function headings(): array
    {
        return [
            'NIS (Wajib)',
            'NISN (Opsional)',
            'Nama Lengkap (Wajib)',
            'Jenis Kelamin (L/P) (Wajib)',
            'Nama Kelas (Wajib, Contoh: X MIPA 1)',
            'Tempat Lahir (Opsional)',
            'Tanggal Lahir (Opsional, format: YYYY-MM-DD)',
            'Alamat (Opsional)',
            'Nama Orang Tua/Wali (Opsional)',
            'No. HP Orang Tua (Opsional)',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Ambil daftar kelas aktif untuk referensi/validasi
                $tahunAktif = TahunAjaran::getAktif();
                $kelas = Kelas::where('tahun_ajaran_id', $tahunAktif?->id)->pluck('nama')->toArray();
                
                // Tambahkan keterangan/petunjuk pengisian di baris ke-2
                $sheet->getStyle('A1:J1')->getFont()->setBold(true);
                
                // Tambahkan validasi drop-down untuk Jenis Kelamin (L/P) pada kolom D (Baris 2-100)
                for ($i = 2; $i <= 100; $i++) {
                    $validationJK = $sheet->getCell("D{$i}")->getDataValidation();
                    $validationJK->setType(DataValidation::TYPE_LIST);
                    $validationJK->setErrorStyle(DataValidation::STYLE_STOP);
                    $validationJK->setAllowBlank(false);
                    $validationJK->setShowInputMessage(true);
                    $validationJK->setShowErrorMessage(true);
                    $validationJK->setShowDropDown(true);
                    $validationJK->setErrorTitle('Input Salah');
                    $validationJK->setError('Silakan pilih L (Laki-laki) atau P (Perempuan)');
                    $validationJK->setPromptTitle('Pilih Jenis Kelamin');
                    $validationJK->setPrompt('Pilih L atau P');
                    $validationJK->setFormula1('"L,P"');

                    // Validasi Drop-down untuk Kelas pada kolom E (Baris 2-100)
                    if (!empty($kelas)) {
                        $validationKelas = $sheet->getCell("E{$i}")->getDataValidation();
                        $validationKelas->setType(DataValidation::TYPE_LIST);
                        $validationKelas->setErrorStyle(DataValidation::STYLE_STOP);
                        $validationKelas->setAllowBlank(false);
                        $validationKelas->setShowInputMessage(true);
                        $validationKelas->setShowErrorMessage(true);
                        $validationKelas->setShowDropDown(true);
                        $validationKelas->setErrorTitle('Kelas Tidak Valid');
                        $validationKelas->setError('Nama kelas harus sesuai dengan daftar kelas yang ada di sistem.');
                        $validationKelas->setPromptTitle('Pilih Kelas');
                        $validationKelas->setPrompt('Pilih dari daftar kelas yang aktif');
                        $validationKelas->setFormula1('"' . implode(',', $kelas) . '"');
                    }
                }
                
                // Menata ukuran kolom secara otomatis
                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
