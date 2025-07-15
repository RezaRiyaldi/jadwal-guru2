<?php

namespace App\Filament\Resources\MataPelajaranResource\Pages;

use App\Filament\Resources\MataPelajaranResource;
use App\Models\MataPelajaran;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMataPelajaran extends EditRecord
{
    protected static string $resource = MataPelajaranResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Ambil 4 huruf pertama dari nama
        $nama = strtoupper($data['nama']);
        $namaPotong = str_replace(' ', '', $nama);
        $prefix = substr($namaPotong, 0, 4); // 4 huruf nama mapel

        // Ambil dan format tingkat jadi 6 digit
        sort($data['tingkat']);
        $tingkatArray = is_array($data['tingkat']) ? $data['tingkat'] : [];
        $kodeTingkat = str_pad(implode('', $tingkatArray), 6, '0', STR_PAD_LEFT); // ex: 000136

        // Prefix awal
        $prefixKode = $prefix . $kodeTingkat;

        // Hitung jumlah mapel dengan prefix tersebut
        $count = MataPelajaran::where('kode', 'like', $prefixKode . '%')->count() + 1;
        $nomorUrut = str_pad($count, 4, '0', STR_PAD_LEFT); // ex: 0001

        // Gabungkan semuanya
        $data['kode'] = $prefixKode . $nomorUrut;

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
