<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MuridResource\Pages;
use App\Filament\Resources\MuridResource\RelationManagers;
use App\Models\Murid;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MuridResource extends Resource
{
    protected static ?string $model = Murid::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Akun')
                    ->schema([
                        TextInput::make('nama_lengkap')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->afterStateHydrated(
                                function (TextInput $component, $state, $record) {
                                    $component->state($record?->user?->email);
                                }
                            )
                            ->afterStateUpdated(
                                function ($state, $livewire) {
                                    $livewire->emailForUser = $state;
                                }
                            )
                            ->rules([
                                function (Get $get, Component $component) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get, $component) {
                                        $email = $get('email');
                                        $recordId = $component->getLivewire()->record?->id;

                                        $exists = Murid::join('users', 'users.id', '=', 'murids.user_id')
                                            ->where('users.email', $email)
                                            ->when($recordId, fn($q) => $q->where('murids.id', '!=', $recordId))
                                            ->exists();

                                        if ($exists) {
                                            $fail('Email sudah terdaftar');
                                        }
                                    };
                                }
                            ]),

                        TextInput::make('no_hp')
                            ->label('No. HP')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columns(2),


                Section::make('Data Pribadi')
                    ->schema([

                        TextInput::make('tempat_lahir')
                            ->label('Tempat Lahir')
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->displayFormat('d/m/Y') // Tampilkan dd/mm/yyyy
                            ->native(false)
                            ->required(),

                        Radio::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->options([
                                'L' => 'Laki-laki',
                                'P' => 'Perempuan',
                            ])
                            ->required(),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Akademik')
                    ->schema([
                        BelongsToSelect::make('kelas_id')
                            ->label('Kelas')
                            ->relationship('kelas', 'nama_kelas')
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'aktif' => 'Aktif',
                                'lulus' => 'Lulus',
                                'keluar' => 'Keluar',
                                'pindah' => 'Pindah',
                                'meninggal' => 'Meninggal',
                            ])
                            ->default('aktif')
                            ->hidden(fn(Page $livewire) => $livewire instanceof \App\Filament\Resources\MuridResource\Pages\CreateMurid),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis'),
                Tables\Columns\TextColumn::make('nama_lengkap')->label('Nama Lengkap'),
                Tables\Columns\TextColumn::make('jenis_kelamin')->label('Jenis Kelamin'),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'aktif' => 'success',
                        'lulus' => 'info',
                        'keluar' => 'gray',
                        'pindah' => 'warning',
                        'meninggal' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn($state) => match ($state) {
                        default => ucfirst($state), // fallback aman
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'aktif' => 'Aktif',
                        'lulus' => 'Lulus',
                        'keluar' => 'Keluar',
                        'pindah' => 'Pindah',
                        'meninggal' => 'Meninggal',
                    ]),
            ])
            ->actions(
                array_merge(
                    addActions(['tu', 'superadmin'], Tables\Actions\EditAction::make()),
                )
            )
            ->bulkActions(
                []
                // array_merge(
                //     addActions(
                //         ['tu', 'superadmin'],
                //         Tables\Actions\BulkActionGroup::make([
                //             Tables\Actions\DeleteBulkAction::make(),
                //         ]),
                //     ),
                // )
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMurids::route('/'),
            'create' => Pages\CreateMurid::route('/create'),
            'edit' => Pages\EditMurid::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Murid';
    }

    public static function getModelLabel(): string
    {
        return 'Murid';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Murid';
    }
}

