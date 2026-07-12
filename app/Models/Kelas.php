<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = ['nama', 'tingkat', 'jurusan', 'tahun_ajaran_id'];

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function murid()
    {
        return $this->hasMany(Murid::class);
    }

    public function waliKelas()
    {
        return $this->hasOne(User::class, 'kelas_id');
    }
}
