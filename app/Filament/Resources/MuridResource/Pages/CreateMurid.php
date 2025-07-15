<?php

namespace App\Filament\Resources\MuridResource\Pages;

use App\Filament\Resources\MuridResource;
use App\Models\Murid;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateMurid extends CreateRecord
{
    protected static string $resource = MuridResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tanggalLahir = Carbon::parse($data['tanggal_lahir']);
        $password = $tanggalLahir->format('dmY');

        $data['nama_lengkap'] = ucwords(strtolower($data['nama_lengkap']));
        $data['name'] = str_replace(' ', '_', strtolower($data['nama_lengkap']));

        // Ambil tahun dan bulan dari tanggal_masuk
        $tanggalMasuk = Carbon::parse($data['tanggal_masuk']);
        $prefix = $tanggalMasuk->format('ym'); // YYMM

        // Hitung jumlah murid yang memiliki prefix yg sama
        $count = Murid::whereRaw("LEFT(nis, 4) = ?", [$prefix])->count() + 1;
        $urut = str_pad($count, 4, '0', STR_PAD_LEFT);

        $data['nis'] = $prefix . $urut;

        // Buat akun user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'role' => 'murid',
        ]);

        $data['user_id'] = $user->id;

        unset($data['name'], $data['email'], $data['password']);

        return $data;
    }
}
