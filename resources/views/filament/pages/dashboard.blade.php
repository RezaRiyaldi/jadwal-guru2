<x-filament::page>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Jumlah Guru</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ \App\Models\Guru::count() }}
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Jumlah Murid</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ \App\Models\Murid::count() }}
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
            <div class="text-lg font-semibold text-gray-700 dark:text-gray-200">Total Jadwal</div>
            <div class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ \App\Models\Jadwal::count() }}
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white dark:bg-gray-800 p-4 rounded-xl shadow overflow-x-auto">
        <div id="calendar" class="w-full max-w-full"></div>
    </div>

    @push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: @json($events),
                locale: 'id',
                // height: 'auto',
                // contentHeight: 'auto',
                expandRows: true,
                hiddenDays: [0],
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                }
            });
            calendar.render();

            setTimeout(() => {
                calendar.updateSize();
            }, 100);
        });
    </script>
    @endpush
</x-filament::page>