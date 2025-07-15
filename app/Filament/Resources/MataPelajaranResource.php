<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataPelajaranResource\Pages;
use App\Models\MataPelajaran;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('nama')
                        ->label('Nama')
                        ->required()
                        ->maxLength(255),

                    Select::make('tingkat')
                        ->label('Tingkat')
                        ->multiple()
                        ->options([
                            1 => 'Kelas 1',
                            2 => 'Kelas 2',
                            3 => 'Kelas 3',
                            4 => 'Kelas 4',
                            5 => 'Kelas 5',
                            6 => 'Kelas 6',
                        ])
                        ->required(),

                    Textarea::make('deskripsi')
                        ->label('Deskripsi')
                        ->rows(3)
                        ->maxLength(500)
                        ->nullable(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')->sortable()->searchable(),
                TextColumn::make('nama')->sortable()->searchable(),
                BadgeColumn::make('tingkat')
                    ->label('Tingkat')
                    ->getStateUsing(fn(MataPelajaran $record) => implode(', ', $record->tingkat ?? [])),
                TextColumn::make('deskripsi')
                    ->limit(50)
                    ->wrap(),
            ])
            ->filters([])
            ->actions(
                array_merge(
                    addActions(['tu', 'superadmin'], Tables\Actions\EditAction::make()),
                )
            )
            ->bulkActions(
                array_merge(
                    addActions(
                        ['tu', 'superadmin'],
                        Tables\Actions\DeleteBulkAction::make()
                    ),
                )
            );
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Mata Pelajaran';
    }

    public static function getModelLabel(): string
    {
        return 'Mata Pelajaran';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Mata Pelajaran';
    }
}
