<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sanksi extends Model
{
    protected $table = 'sanksi';

    protected $fillable = [
        'pelanggaran_id', 'murid_id', 'jenis_sanksi',
        'deskripsi', 'tanggal_sanksi', 'status', 'diberikan_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sanksi' => 'date',
        ];
    }

    public function pelanggaran()
    {
        return $this->belongsTo(Pelanggaran::class);
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function pemberiSanksi()
    {
        return $this->belongsTo(User::class, 'diberikan_oleh');
    }

    public function getJenisSanksiLabelAttribute(): string
    {
        return match($this->jenis_sanksi) {
            'teguran_lisan' => 'Teguran Lisan',
            'tugas_perbaikan' => 'Tugas Perbaikan',
            'peringatan_tertulis' => 'Peringatan Tertulis',
            'panggil_ortu' => 'Pemanggilan Orang Tua',
            'pembinaan_khusus' => 'Pembinaan Khusus',
            'diserahkan_pihak_berwajib' => 'Diserahkan Pihak Berwajib',
            'dikembalikan_ke_ortu' => 'Dikembalikan ke Orang Tua',
            default => $this->jenis_sanksi,
        };
    }
}
