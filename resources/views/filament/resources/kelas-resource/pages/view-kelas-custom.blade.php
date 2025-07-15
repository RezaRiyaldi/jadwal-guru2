<x-filament::page>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-4">Detail Kelas: {{ $record->nama_kelas }}</h2>

        <p><strong>Wali Kelas:</strong> {{ $record->waliKelas->nama_lengkap ?? '-' }}</p>
        <p><strong>Tingkat:</strong> Kelas {{ $record->tingkat }}</p>
        <p><strong>Keterangan:</strong> {{ $record->keterangan ?? '-' }}</p>
    </x-filament::card>

    <x-filament::card class="mt-6">
        <h3 class="text-md font-semibold mb-2">Daftar Murid</h3>

        {{ $this->table }}
    </x-filament::card>
</x-filament::page>
