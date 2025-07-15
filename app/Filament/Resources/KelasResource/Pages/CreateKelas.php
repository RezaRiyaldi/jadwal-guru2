<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKelas extends CreateRecord
{
    protected static string $resource = KelasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['nama_kelas'] = strtoupper($data['nama_kelas']);
        
        return $data;
    }
}
