<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';

    protected $fillable = [
        'murid_id', 'jenis_pelanggaran_id', 'pencatat_id',
        'tahun_ajaran_id', 'tanggal_kejadian', 'keterangan',
        'bukti_foto', 'poin',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kejadian' => 'date',
        ];
    }

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function jenisPelanggaran()
    {
        return $this->belongsTo(JenisPelanggaran::class);
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'pencatat_id');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function sanksi()
    {
        return $this->hasOne(Sanksi::class);
    }
}
