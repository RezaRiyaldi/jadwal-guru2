<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables;
use Filament\Tables\Table;

class GuruResource extends Resource
{
    protected static ?string $model = Guru::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Data Akun')
                ->schema([
                    TextInput::make('nama_lengkap')->required(),
                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->afterStateHydrated(function (TextInput $component, $state, $record) {
                            $component->state($record?->user?->email);
                        })
                        ->afterStateUpdated(function ($state, $livewire) {
                            $livewire->emailForUser = $state;
                        })
                        ->rules([
                            function (Get $get, Component $component) {
                                return function (string $attribute, $value, \Closure $fail) use ($get, $component) {
                                    $email = $get('email');
                                    $recordId = $component->getLivewire()->record?->id;

                                    $exists = Guru::join('users', 'users.id', '=', 'gurus.user_id')
                                        ->where('users.email', $email)
                                        ->when($recordId, fn($q) => $q->where('gurus.id', '!=', $recordId))
                                        ->exists();

                                    if ($exists) {
                                        $fail('Email sudah terdaftar');
                                    }
                                };
                            }
                        ]),
                    TextInput::make('nip')->label('NIP')->nullable(),
                    TextInput::make('no_hp')->label('No HP')->nullable(),
                ])->columns(2),

            Section::make('Data Pribadi')
                ->schema([
                    TextInput::make('tempat_lahir')->required(),
                    DatePicker::make('tanggal_lahir')
                        ->displayFormat('d/m/Y')
                        ->native(false)
                        ->required(),
                    Radio::make('jenis_kelamin')->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])->required(),
                    Textarea::make('alamat')->nullable(),
                ])->columns(2),

            Section::make('Status')
                ->schema([
                    Radio::make('status')->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                    ])->default('aktif')
                ])->hidden(fn($livewire) => $livewire instanceof Pages\CreateGuru),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('nip')->label('NIP'),
            Tables\Columns\TextColumn::make('nama_lengkap'),
            Tables\Columns\TextColumn::make('jenis_kelamin'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn($state) => match ($state) {
                    'aktif' => 'success',
                    'tidak_aktif' => 'danger',
                    default => 'gray',
                })
                ->formatStateUsing(fn($state) => match ($state) {
                    'aktif' => 'Aktif',
                    'tidak_aktif' => 'Tidak Aktif',
                    default => ucfirst($state), // fallback aman
                }),
        ])
            ->actions(
                array_merge(
                    addActions(['tu', 'superadmin'], Tables\Actions\EditAction::make()),
                )
            )
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Guru';
    }

    public static function getModelLabel(): string
    {
        return 'Guru';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Guru';
    }
}
