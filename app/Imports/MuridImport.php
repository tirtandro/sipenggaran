<?php

namespace App\Imports;

use App\Models\Murid;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MuridImport implements ToCollection, WithHeadingRow
{
    protected $errors = [];
    protected $successCount = 0;

    public function collection(Collection $rows)
    {
        $tahunAktif = TahunAjaran::getAktif();
        if (!$tahunAktif) {
            throw new \Exception('Tidak ada Tahun Ajaran aktif di sistem.');
        }

        $rowNumber = 1; // Row 1 is header
        foreach ($rows as $row) {
            $rowNumber++;
            
            // Mengubah header ke lowercase dengan underscore agar cocok dengan key
            $data = [
                'nis' => isset($row['nis_wajib']) ? trim($row['nis_wajib']) : (isset($row['nis']) ? trim($row['nis']) : null),
                'nisn' => isset($row['nisn_opsional']) ? trim($row['nisn_opsional']) : (isset($row['nisn']) ? trim($row['nisn']) : null),
                'nama' => isset($row['nama_lengkap_wajib']) ? trim($row['nama_lengkap_wajib']) : (isset($row['nama']) ? trim($row['nama']) : null),
                'jenis_kelamin' => isset($row['jenis_kelamin_lp_wajib']) ? strtoupper(trim($row['jenis_kelamin_lp_wajib'])) : (isset($row['jenis_kelamin']) ? strtoupper(trim($row['jenis_kelamin'])) : null),
                'nama_kelas' => isset($row['nama_kelas_wajib_contoh_x_mipa_1']) ? trim($row['nama_kelas_wajib_contoh_x_mipa_1']) : (isset($row['nama_kelas']) ? trim($row['nama_kelas']) : (isset($row['kelas']) ? trim($row['kelas']) : null)),
                'tempat_lahir' => isset($row['tempat_lahir_opsional']) ? trim($row['tempat_lahir_opsional']) : (isset($row['tempat_lahir']) ? trim($row['tempat_lahir']) : null),
                'tanggal_lahir' => isset($row['tanggal_lahir_opsional_format_yyyy_mm_dd']) ? trim($row['tanggal_lahir_opsional_format_yyyy_mm_dd']) : (isset($row['tanggal_lahir']) ? trim($row['tanggal_lahir']) : null),
                'alamat' => isset($row['alamat_opsional']) ? trim($row['alamat_opsional']) : (isset($row['alamat']) ? trim($row['alamat']) : null),
                'nama_ortu' => isset($row['nama_orang_tua_wali_opsional']) ? trim($row['nama_orang_tua_wali_opsional']) : (isset($row['nama_ortu']) ? trim($row['nama_ortu']) : null),
                'no_hp_ortu' => isset($row['no_hp_orang_tua_opsional']) ? trim($row['no_hp_orang_tua_opsional']) : (isset($row['no_hp_ortu']) ? trim($row['no_hp_ortu']) : null),
            ];

            // Abaikan jika baris kosong
            if (empty($data['nis']) && empty($data['nama'])) {
                continue;
            }

            // Validasi data dasar
            $validator = Validator::make($data, [
                'nis' => 'required|unique:murid,nis',
                'nama' => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'nama_kelas' => 'required',
                'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            ], [
                'nis.required' => 'NIS wajib diisi.',
                'nis.unique' => 'NIS ' . $data['nis'] . ' sudah terdaftar di sistem.',
                'nama.required' => 'Nama lengkap wajib diisi.',
                'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
                'jenis_kelamin.in' => 'Jenis kelamin harus L atau P.',
                'nama_kelas.required' => 'Nama kelas wajib diisi.',
                'tanggal_lahir.date_format' => 'Format Tanggal Lahir harus YYYY-MM-DD.',
            ]);

            if ($validator->fails()) {
                $this->errors[] = "Baris {$rowNumber}: " . implode(', ', $validator->errors()->all());
                continue;
            }

            // Cari kelas berdasarkan nama kelas dan tahun ajaran aktif
            $kelas = Kelas::where('nama', $data['nama_kelas'])
                ->where('tahun_ajaran_id', $tahunAktif->id)
                ->first();

            if (!$kelas) {
                $this->errors[] = "Baris {$rowNumber}: Kelas '" . $data['nama_kelas'] . "' tidak ditemukan di sistem untuk Tahun Ajaran aktif.";
                continue;
            }

            // Simpan Murid
            Murid::create([
                'nis' => $data['nis'],
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'kelas_id' => $kelas->id,
                'tempat_lahir' => $data['tempat_lahir'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?: null,
                'alamat' => $data['alamat'],
                'nama_ortu' => $data['nama_ortu'],
                'no_hp_ortu' => $data['no_hp_ortu'],
                'is_aktif' => true,
            ]);

            $this->successCount++;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getSuccessCount(): int
    {
        return $this->successCount;
    }
}
