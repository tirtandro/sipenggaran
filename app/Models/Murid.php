<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    protected $table = 'murid';

    protected $fillable = [
        'nis', 'nisn', 'nama', 'jenis_kelamin', 'kelas_id',
        'tempat_lahir', 'tanggal_lahir', 'alamat',
        'nama_ortu', 'no_hp_ortu', 'foto', 'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'is_aktif' => 'boolean',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }

    public function sanksi()
    {
        return $this->hasMany(Sanksi::class);
    }

    public function suratPeringatan()
    {
        return $this->hasMany(SuratPeringatan::class);
    }

    public function getTotalPoinAttribute(): int
    {
        $tahunAktif = TahunAjaran::getAktif();
        if (!$tahunAktif) return 0;

        return $this->pelanggaran()
            ->where('tahun_ajaran_id', $tahunAktif->id)
            ->sum('poin');
    }

    public function getStatusPoinAttribute(): string
    {
        $poin = $this->total_poin;
        if ($poin <= 30) return 'hijau';
        if ($poin <= 60) return 'kuning';
        if ($poin <= 100) return 'oranye';
        return 'merah';
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status_poin) {
            'hijau' => 'Normal',
            'kuning' => 'Peringatan',
            'oranye' => 'Pembinaan Khusus',
            'merah' => 'Kritis',
        };
    }
}
