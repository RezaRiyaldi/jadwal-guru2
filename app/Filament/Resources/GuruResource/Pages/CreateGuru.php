<?php

namespace App\Filament\Resources\GuruResource\Pages;

use App\Filament\Resources\GuruResource;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateGuru extends CreateRecord
{
    protected static string $resource = GuruResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $tanggalLahir = Carbon::parse($data['tanggal_lahir']);
        $password = $tanggalLahir->format('dmY');
        
        $data['nama_lengkap'] = ucwords(strtolower($data['nama_lengkap']));
        $data['name'] = str_replace(' ', '_', strtolower($data['nama_lengkap']));

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
            'role' => 'guru',
        ]);

        $data['user_id'] = $user->id;

        unset($data['email']);

        return $data;
    }
}
