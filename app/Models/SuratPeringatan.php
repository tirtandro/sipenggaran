<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratPeringatan extends Model
{
    protected $table = 'surat_peringatan';

    protected $fillable = [
        'nomor_surat', 'murid_id', 'tahun_ajaran_id',
        'jenis_surat', 'total_poin', 'tanggal_surat',
        'perihal', 'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
        ];
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}
