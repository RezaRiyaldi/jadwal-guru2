<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\Kelas;
use App\Models\Murid;
use Filament\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;

class ViewKelasCustom extends ViewRecord implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = KelasResource::class;

    // public Kelas $record;
    // public static ?string $slug = '{record}';
    public static string $view = 'filament.resources.kelas-resource.pages.view-kelas-custom';

    public function getTitle(): string
    {
        return 'Detail Kelas - ' . $this->record->nama_kelas;
    }

    public function mount($record): void
    {
        $this->record = KelasResource::resolveRecordRouteBinding($record);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Murid::query()->where('kelas_id', $this->record->id)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nis'),
                Tables\Columns\TextColumn::make('nama_lengkap'),
                Tables\Columns\TextColumn::make('jenis_kelamin'),
                Tables\Columns\TextColumn::make('status')->badge(),
            ]);
    }
}
