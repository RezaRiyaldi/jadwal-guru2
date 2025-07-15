<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'tingkat', 'nama_kelas', 'wali_kelas_id', 'keterangan',
    ];

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function murids()
    {
        return $this->hasMany(Murid::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
