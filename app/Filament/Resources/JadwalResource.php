<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JadwalResource\Pages;
use App\Models\Jadwal;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JadwalResource extends Resource
{
    protected static ?string $model = Jadwal::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-date-range';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Waktu')
                    ->schema([
                        Select::make('hari')
                            ->label('Hari')
                            ->options([
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                                'Sabtu' => 'Sabtu',
                            ])
                            ->required(),

                        Section::make([
                            Select::make('jam_mulai')
                                ->label('Jam Mulai')
                                ->options(self::generateJamList())
                                ->required(),

                            Select::make('jam_selesai')
                                ->label('Jam Selesai')
                                ->options(self::generateJamList())
                                ->required(),
                        ])->columns(2)
                    ]),

                Section::make('Akademik')
                    ->schema([
                        Select::make('kelas_id')
                            ->label('Kelas')
                            ->relationship('kelas', 'nama_kelas')
                            ->required()
                            ->rules([
                                function (Get $get, Component $component) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get, $component) {
                                        $hari = $get('hari');
                                        $jamMulai = $get('jam_mulai');
                                        $jamSelesai = $get('jam_selesai');
                                        $recordId = $component->getLivewire()->record?->id;

                                        $exists = \App\Models\Jadwal::where('kelas_id', $value)
                                            ->where('hari', $hari)
                                            ->when($recordId, fn($q) => $q->where('id', '!=', $recordId))
                                            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                                                $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                                                        $q->where('jam_mulai', '<', $jamMulai)
                                                            ->where('jam_selesai', '>', $jamSelesai);
                                                    });
                                            })
                                            ->exists();

                                        if ($exists) {
                                            $fail("Kelas ini sudah memiliki jadwal lain di waktu tersebut.");
                                        }
                                    };
                                }
                            ]),

                        Select::make('guru_id')
                            ->label('Guru')
                            ->relationship('guru', 'nama_lengkap')
                            ->options(function () {
                                return \App\Models\Guru::where('status', 'aktif')
                                    ->pluck('nama_lengkap', 'id');
                            })
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->nama_lengkap)
                            ->required()
                            ->rules([
                                function (Get $get, Component $component) {
                                    return function (string $attribute, $value, \Closure $fail) use ($get, $component) {
                                        $hari = $get('hari');
                                        $jamMulai = $get('jam_mulai');
                                        $jamSelesai = $get('jam_selesai');
                                        $recordId = $component->getLivewire()->record?->id;

                                        $exists = \App\Models\Jadwal::where('guru_id', $value)
                                            ->where('hari', $hari)
                                            ->when($recordId, fn($q) => $q->where('id', '!=', $recordId))
                                            ->where(function ($query) use ($jamMulai, $jamSelesai) {
                                                $query->where(function ($q) use ($jamMulai, $jamSelesai) {
                                                        $q->where('jam_mulai', '<', $jamMulai)
                                                            ->where('jam_selesai', '>', $jamSelesai);
                                                    });
                                            })
                                            ->exists();

                                        if ($exists) {
                                            $fail("Guru ini sudah mengajar di waktu tersebut.");
                                        }
                                    };
                                }
                            ]),

                        Select::make('mata_pelajaran_id')
                            ->label('Mata Pelajaran')
                            ->relationship('mataPelajaran', 'nama')
                            ->required(),
                    ])
                    ->columns(2),

                Section::make('Lain-lain')
                    ->schema([
                        TextInput::make('ruangan')
                            ->label('Ruangan')
                            ->maxLength(50),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(2),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $query = Jadwal::query();

                if (auth()->user()->role === 'guru') {
                    $guruId = auth()->user()?->guru?->id;

                    $query->where('guru_id', '=', $guruId);
                } else if (auth()->user()->role === 'murid') {
                    $kelasId = auth()->user()?->murid?->kelas_id;

                    $query->where('kelas_id', '=', $kelasId);
                }

                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                Tables\Columns\TextColumn::make('guru.nama_lengkap')->label('Guru'),
                Tables\Columns\TextColumn::make('mataPelajaran.nama')->label('Mata Pelajaran'),
                Tables\Columns\TextColumn::make('hari'),
                Tables\Columns\TextColumn::make('jam_mulai')->time('H:i'),
                Tables\Columns\TextColumn::make('jam_selesai')->time('H:i'),
                Tables\Columns\TextColumn::make('ruangan'),
            ])
            ->filters([])
            ->actions(
                array_merge(
                    addActions(['tu', 'superadmin'], Tables\Actions\EditAction::make()),
                )
            )
            ->bulkActions(
                array_merge(
                    addActions(['tu', 'superadmin'], Tables\Actions\DeleteBulkAction::make()),
                )
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
            'index' => Pages\ListJadwals::route('/'),
            'create' => Pages\CreateJadwal::route('/create'),
            'edit' => Pages\EditJadwal::route('/{record}/edit'),
        ];
    }

    public static function generateJamList(): array
    {
        $list = [];
        $start = \Carbon\Carbon::createFromTime(7, 0); // 07:00
        $end = \Carbon\Carbon::createFromTime(17, 0);  // 17:00

        while ($start <= $end) {
            $time = $start->format('H:i:s'); // format sesuai DB
            $label = $start->format('H:i');  // label di dropdown

            $list[$time] = $label;

            $start->addMinutes(30);
        }

        return $list;
    }

    public static function getNavigationLabel(): string
    {
        return 'Jadwal';
    }

    public static function getModelLabel(): string
    {
        return 'Jadwal';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Jadwal';
    }
}
