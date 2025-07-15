<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nip', 'nama_lengkap', 'jenis_kelamin', 'tempat_lahir',
        'tanggal_lahir', 'alamat', 'no_hp', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }

    public function kelasDiampu()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }
}
