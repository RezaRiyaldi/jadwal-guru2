<?php

namespace App\Filament\Pages;

use App\Models\Jadwal;
use Filament\Pages\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $title = 'Dashboard';
    protected static string $view = 'filament.pages.dashboard';

    public array $events = [];

    public function mount(): void
    {
        $jadwals = Jadwal::with(['kelas', 'guru', 'mataPelajaran']);

        if (auth()->user()->role == 'guru') {
            $guruId = auth()->user()?->guru?->id;

            $jadwals = $jadwals->where('jadwals.guru_id', $guruId);
        } else if (auth()->user()->role == 'murid') {
            $kelasId = auth()->user()?->murid?->kelas?->id;

            $jadwals = $jadwals->where('kelas_id', $kelasId);
        }

        $jadwals = $jadwals->get();

        $events = collect();

        $hariMap = [
            'senin' => 'monday',
            'selasa' => 'tuesday',
            'rabu' => 'wednesday',
            'kamis' => 'thursday',
            'jumat' => 'friday',
            'sabtu' => 'saturday',
            'minggu' => 'sunday',
        ];

        foreach ($jadwals as $jadwal) {
            $hari = strtolower($jadwal->hari);
            $englishDay = $hariMap[$hari] ?? null;

            if (!$englishDay || !$jadwal->mataPelajaran) {
                continue;
            }

            for ($i = 0; $i < 4; $i++) {
                $startDate = now()->startOfWeek()->addWeeks($i)->modify("next $englishDay");

                $events->push([
                    'title' => $jadwal->mataPelajaran->nama
                        . ' - ' . $jadwal->kelas->nama_kelas
                        . ' (' . \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i')
                        . ' - ' . \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') . ')',

                    'start' => $startDate->toDateString(),
                    'allDay' => true,
                ]);
            }
        }

        $this->events = $events->toArray();
    }
}
