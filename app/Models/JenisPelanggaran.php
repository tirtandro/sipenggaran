<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPelanggaran extends Model
{
    protected $table = 'jenis_pelanggaran';

    protected $fillable = ['kategori_id', 'kode', 'deskripsi', 'tingkat', 'poin'];

    public function kategori()
    {
        return $this->belongsTo(KategoriPelanggaran::class, 'kategori_id');
    }

    public function pelanggaran()
    {
        return $this->hasMany(Pelanggaran::class);
    }
}
