<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\countOf;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Data User')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('email')
                        ->email()
                        ->required()
                        ->rules([
                            function (Get $get, Component $component) {
                                return function (string $attribute, $value, \Closure $fail) use ($get, $component) {
                                    $email = $get('email');
                                    $recordId = $component->getLivewire()->record?->id;

                                    $exists = User::where('email', $email)
                                        ->when($recordId, fn($q) => $q->where('id', '!=', $recordId))
                                        ->exists();

                                    if ($exists) {
                                        $fail('Email sudah terdaftar');
                                    }
                                };
                            }
                        ]),
                    TextInput::make('password')
                        ->label('Password')
                        ->password()
                        ->dehydrateStateUsing(fn($state) => filled($state) ? Hash::make($state) : null)
                        ->dehydrated(fn($state) => filled($state))
                        ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),

                    Select::make('role')
                        ->label('Role')
                        ->options(function ($livewire) {
                            $record = $livewire->record ?? null;

                            if ($livewire instanceof \Filament\Resources\Pages\CreateRecord) {
                                // Saat create, hanya bisa tu & superadmin
                                return [
                                    'tu' => 'Tata Usaha',
                                    'superadmin' => 'Superadmin',
                                ];
                            }

                            // Saat edit
                            if ($record?->role === 'murid') {
                                // Tidak bisa diubah, tapi tetap ditampilkan
                                return [
                                    'murid' => 'Murid',
                                ];
                            }

                            if (
                                $record?->role === 'guru'
                                || $record?->role === 'tu'
                            ) {
                                return [
                                    'guru' => 'Guru',
                                    'tu' => 'Tata Usaha',
                                ];
                            }

                            // Default (untuk tu/superadmin)
                            return [
                                'tu' => 'Tata Usaha',
                                'superadmin' => 'Superadmin',
                            ];
                        })
                        ->disabled(function ($livewire) {
                            $record = $livewire->record ?? null;

                            // Role murid tidak bisa diedit
                            return $record?->role === 'murid';
                        })
                        ->required()
                ])
                ->columns(2)
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                return User::query()
                    ->select(
                        'users.*',

                        'gurus.nama_lengkap AS nama_guru',
                        'gurus.nip',

                        'murids.nama_lengkap AS nama_murid',
                        'murids.nis'
                    )
                    ->leftJoin('gurus', 'gurus.user_id', '=', 'users.id')
                    ->leftJoin('murids', 'murids.user_id', '=', 'users.id')
                    ->orderByRaw("FIELD(role, 'superadmin', 'tu', 'guru', 'murid')");;
            })
            ->columns([
                Tables\Columns\TextColumn::make('nip')
                    ->label('Nomor Induk')
                    ->getStateUsing(function ($record) {
                        return $record->nip ?? $record->nis ?? '-';
                    }),
                Tables\Columns\TextColumn::make('name')->label('Username'),
                Tables\Columns\TextColumn::make('email')->label('Email'),
                Tables\Columns\TextColumn::make('nama_guru')
                    ->label('Nama Lengkap')
                    ->getStateUsing(function ($record) {
                        $namaLengkap = $record->nama_guru ?? $record->nama_murid ?? '-';

                        return strlen($namaLengkap) > 30 ? substr($namaLengkap, 0, 30) . '...' : $namaLengkap;
                    }),
                Tables\Columns\TextColumn::make('role')
                    ->label('Role')
                    ->formatStateUsing(fn(string $state) => match ($state) {
                        'superadmin' => 'Super Admin',
                        'tu' => 'Tata Usaha',
                        'guru' => 'Guru',
                        'murid' => 'Murid',
                        default => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'tu' => 'info',
                        'guru' => 'warning',
                        'murid' => 'success',
                        default => 'success',
                    }),

            ])
            ->filters([])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
