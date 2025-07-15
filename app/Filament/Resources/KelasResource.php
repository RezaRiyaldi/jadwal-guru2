<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Filament\Resources\KelasResource\RelationManagers\MuridsRelationManager;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-m-rectangle-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_kelas')->required(),
                Select::make('wali_kelas_id')
                    ->label('Wali Kelas')
                    ->relationship('waliKelas', 'nama_lengkap')
                    // ->searchable()
                    ->required(),
                Select::make('tingkat')
                    ->options([
                        1 => 'Kelas 1',
                        2 => 'Kelas 2',
                        3 => 'Kelas 3',
                        4 => 'Kelas 4',
                        5 => 'Kelas 5',
                        6 => 'Kelas 6',
                    ])
                    ->required(),
                Textarea::make('keterangan')->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $query = Kelas::query();

                if (auth()->user()->role === 'guru') {
                    $guruId = auth()->user()?->guru?->id;

                    $query->whereHas('jadwals', function ($q) use ($guruId) {
                        $q->where('guru_id', $guruId);
                    });
                } else if (auth()->user()->role === 'murid') {
                    $kelasId = auth()->user()?->murid?->kelas_id;

                    $query->where('id', '=', $kelasId);
                }

                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('nama_kelas')->label('Nama Kelas')->searchable(),
                Tables\Columns\TextColumn::make('waliKelas.nama_lengkap')->label('Wali Kelas')->searchable(),
                Tables\Columns\TextColumn::make('tingkat')->label('Tingkat'),
                // Tables\Columns\TextColumn::make('created_at')->label('Dibuat')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tingkat')
                    ->options([
                        1 => 'Kelas 1',
                        2 => 'Kelas 2',
                        3 => 'Kelas 3',
                        4 => 'Kelas 4',
                        5 => 'Kelas 5',
                        6 => 'Kelas 6',
                    ]),
            ])
            ->actions(
                array_merge(
                    addActions(['tu', 'superadmin'], Tables\Actions\EditAction::make()),
                    [
                        Tables\Actions\ViewAction::make(),
                    ],
                )
            )
            ->bulkActions(
                array_merge(
                    addActions(
                        ['tu', 'superadmin'],

                        Tables\Actions\BulkActionGroup::make([
                            Tables\Actions\DeleteBulkAction::make(),
                        ]),
                    )
                )
            );
    }

    public static function getRelations(): array
    {
        return [
            // MuridsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
            'view' => Pages\ViewKelasCustom::route('/{record}'),
        ];
    }
}
