<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode', 'nama', 'tingkat', 'deskripsi',
    ];

    protected $casts = [
        'tingkat' => 'array', // contoh: [1, 2, 3]
    ];

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class);
    }
}
