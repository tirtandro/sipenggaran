<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriPelanggaran extends Model
{
    protected $table = 'kategori_pelanggaran';

    protected $fillable = ['kode', 'nama', 'deskripsi'];

    public function jenisPelanggaran()
    {
        return $this->hasMany(JenisPelanggaran::class, 'kategori_id');
    }
}
