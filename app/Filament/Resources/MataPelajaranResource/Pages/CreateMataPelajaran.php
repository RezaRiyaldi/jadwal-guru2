<?php

namespace App\Filament\Resources\MataPelajaranResource\Pages;

use App\Filament\Resources\MataPelajaranResource;
use App\Models\MataPelajaran;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMataPelajaran extends CreateRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $nama = strtoupper($data['nama']);
        $namaBersih = preg_replace('/[^A-Z]/', '', $nama); // Hanya huruf A-Z
        $prefix = substr($namaBersih, 0, 4);

        // Ambil dan format tingkat jadi 6 digit
        sort($data['tingkat']);
        $tingkatArray = is_array($data['tingkat']) ? $data['tingkat'] : [];
        $kodeTingkat = str_pad(implode('', $tingkatArray), 6, '0', STR_PAD_LEFT); // ex: 000136

        // Prefix awal
        $prefixKode = $prefix . $kodeTingkat;

        // Hitung jumlah mapel dengan prefix tersebut
        $count = MataPelajaran::count() + 1;
        $nomorUrut = str_pad($count, 4, '0', STR_PAD_LEFT); // ex: 0001

        // Gabungkan semuanya
        $data['kode'] = $prefixKode . $nomorUrut;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
