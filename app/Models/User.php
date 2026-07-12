<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kelas_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function pelanggaranDicatat()
    {
        return $this->hasMany(Pelanggaran::class, 'pencatat_id');
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isGuruBK(): bool
    {
        return $this->role === 'guru_bk';
    }

    public function isGuruPiket(): bool
    {
        return $this->role === 'guru_piket';
    }

    public function isWaliKelas(): bool
    {
        return $this->role === 'wali_kelas';
    }

    public function canCatatPelanggaran(): bool
    {
        return in_array($this->role, ['admin', 'guru_bk', 'guru_piket']);
    }

    public function canManageSanksi(): bool
    {
        return in_array($this->role, ['admin', 'guru_bk']);
    }

    public function canCetakSurat(): bool
    {
        return in_array($this->role, ['admin', 'guru_bk', 'wali_kelas']);
    }

    public function canManageUsers(): bool
    {
        return $this->role === 'admin';
    }

    public function canManageReferensi(): bool
    {
        return $this->role === 'admin';
    }
}
