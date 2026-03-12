@php
    $today = now();
    $monthStart = $today->copy()->startOfMonth();
    $monthEnd = $today->copy()->endOfMonth();
    $leadingBlankDays = $monthStart->dayOfWeekIso - 1;
    $daysInMonth = $monthEnd->day;

    $bookingsByDay = [
        1 => ['count' => 4, 'hours' => 10],
        2 => ['count' => 5, 'hours' => 12],
        3 => ['count' => 3, 'hours' => 7],
        4 => ['count' => 6, 'hours' => 15],
        5 => ['count' => 2, 'hours' => 4],
        6 => ['count' => 7, 'hours' => 16],
        7 => ['count' => 4, 'hours' => 9],
        8 => ['count' => 5, 'hours' => 11],
        9 => ['count' => 6, 'hours' => 13],
        10 => ['count' => 3, 'hours' => 8],
        11 => ['count' => 5, 'hours' => 12],
        12 => ['count' => 4, 'hours' => 10],
        13 => ['count' => 8, 'hours' => 18],
        14 => ['count' => 7, 'hours' => 17],
        15 => ['count' => 3, 'hours' => 6],
        16 => ['count' => 5, 'hours' => 11],
        17 => ['count' => 4, 'hours' => 9],
        18 => ['count' => 6, 'hours' => 14],
        19 => ['count' => 5, 'hours' => 12],
        20 => ['count' => 7, 'hours' => 16],
        21 => ['count' => 2, 'hours' => 5],
        22 => ['count' => 4, 'hours' => 9],
        23 => ['count' => 6, 'hours' => 13],
        24 => ['count' => 8, 'hours' => 19],
        25 => ['count' => 7, 'hours' => 16],
        26 => ['count' => 4, 'hours' => 8],
        27 => ['count' => 5, 'hours' => 11],
        28 => ['count' => 6, 'hours' => 14],
        29 => ['count' => 3, 'hours' => 7],
        30 => ['count' => 5, 'hours' => 12],
        31 => ['count' => 4, 'hours' => 9],
    ];

    $dailyHours = [
        ['time' => '08:00', 'client' => 'Maria Santos', 'service' => 'Deep Cleaning', 'duration' => '2h'],
        ['time' => '10:30', 'client' => 'John Cruz', 'service' => 'Regular Cleaning', 'duration' => '1.5h'],
        ['time' => '13:00', 'client' => 'Liza Gomez', 'service' => 'Move-out Cleaning', 'duration' => '3h'],
        ['time' => '16:30', 'client' => 'Carlos dela Cruz', 'service' => 'Office Cleaning', 'duration' => '2h'],
    ];

    $weeklyServices = [
        ['day' => 'Mon', 'services' => 12],
        ['day' => 'Tue', 'services' => 15],
        ['day' => 'Wed', 'services' => 10],
        ['day' => 'Thu', 'services' => 16],
        ['day' => 'Fri', 'services' => 14],
        ['day' => 'Sat', 'services' => 9],
        ['day' => 'Sun', 'services' => 6],
    ];

    $monthlyServices = [
        ['label' => 'Regular Cleaning', 'count' => 82, 'color' => 'bg-blue-500'],
        ['label' => 'Deep Cleaning', 'count' => 46, 'color' => 'bg-emerald-500'],
        ['label' => 'Move-out Cleaning', 'count' => 28, 'color' => 'bg-amber-500'],
        ['label' => 'Office Cleaning', 'count' => 34, 'color' => 'bg-violet-500'],
    ];

    $maxWeekly = collect($weeklyServices)->max('services');
@endphp

<div class="space-y-6 p-6" x-data="{ period: 'daily' }">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Schedule Summary</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                Calendar overview for daily hours, weekly services, and monthly service volume.
            </p>
        </div>

        <div class="inline-flex rounded-lg border border-zinc-200 bg-white p-1 dark:border-zinc-700 dark:bg-zinc-900">
            <button
                type="button"
                class="rounded-md px-4 py-2 text-sm font-medium transition"
                :class="period === 'daily' ? 'bg-blue-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'"
                @click="period = 'daily'"
            >
                Daily Hours
            </button>
            <button
                type="button"
                class="rounded-md px-4 py-2 text-sm font-medium transition"
                :class="period === 'weekly' ? 'bg-blue-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'"
                @click="period = 'weekly'"
            >
                Weekly Services
            </button>
            <button
                type="button"
                class="rounded-md px-4 py-2 text-sm font-medium transition"
                :class="period === 'monthly' ? 'bg-blue-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'"
                @click="period = 'monthly'"
            >
                Monthly Services
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <section class="xl:col-span-2 rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="mb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $today->format('F Y') }}</h2>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">Booking activity by day</p>
                </div>
                <div class="rounded-md bg-zinc-100 px-3 py-1 text-xs font-medium text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">
                    {{ collect($bookingsByDay)->sum('count') }} total services
                </div>
            </div>

            <div class="grid grid-cols-7 gap-2 text-center text-xs font-semibold text-zinc-500 dark:text-zinc-400">
                <div>Mon</div>
                <div>Tue</div>
                <div>Wed</div>
                <div>Thu</div>
                <div>Fri</div>
                <div>Sat</div>
                <div>Sun</div>
            </div>

            <div class="mt-2 grid grid-cols-7 gap-2">
                @for ($i = 0; $i < $leadingBlankDays; $i++)
                    <div class="h-24 rounded-lg bg-zinc-50 dark:bg-zinc-800/40"></div>
                @endfor

                @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $data = $bookingsByDay[$day] ?? ['count' => 0, 'hours' => 0];
                        $isToday = $day === $today->day;
                    @endphp
                    <a href="{{ route('schedule-daily') }}" class="h-24 rounded-lg border p-2 transition hover:border-blue-400 hover:shadow-sm {{ $isToday ? 'border-blue-500 bg-blue-50 dark:border-blue-500 dark:bg-blue-900/20' : 'border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900' }}">
                        <div class="flex items-start justify-between">
                            <span class="text-xs font-semibold {{ $isToday ? 'text-blue-700 dark:text-blue-300' : 'text-zinc-700 dark:text-zinc-200' }}">{{ $day }}</span>
                            @if ($data['count'] > 0)
                                <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                    {{ $data['count'] }}
                                </span>
                            @endif
                        </div>

                        <div class="mt-3 space-y-1">
                            <div class="h-1.5 rounded-full bg-zinc-100 dark:bg-zinc-800">
                                <div class="h-1.5 rounded-full bg-blue-500" style="width: {{ min(100, $data['hours'] * 5) }}%"></div>
                            </div>
                            <p class="text-[10px] text-zinc-500 dark:text-zinc-400">{{ $data['hours'] }} booked hours</p>
                        </div>
                    </a>
                @endfor
            </div>
        </section>

        <aside class="space-y-4">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Current Snapshot</h3>
                <div class="mt-4 grid grid-cols-2 gap-3 text-center">
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/50">
                        <p class="text-xs text-zinc-500">Today Hours</p>
                        <p class="mt-1 text-xl font-bold text-zinc-900 dark:text-zinc-100">8.5</p>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/50">
                        <p class="text-xs text-zinc-500">Today Services</p>
                        <p class="mt-1 text-xl font-bold text-zinc-900 dark:text-zinc-100">4</p>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/50">
                        <p class="text-xs text-zinc-500">Week Total</p>
                        <p class="mt-1 text-xl font-bold text-zinc-900 dark:text-zinc-100">82</p>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/50">
                        <p class="text-xs text-zinc-500">Month Total</p>
                        <p class="mt-1 text-xl font-bold text-zinc-900 dark:text-zinc-100">190</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900" x-show="period === 'daily'" x-cloak>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Daily Hours ({{ $today->format('M d') }})</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($dailyHours as $slot)
                        <li class="rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $slot['time'] }}</p>
                                <span class="text-xs text-zinc-500">{{ $slot['duration'] }}</span>
                            </div>
                            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-300">{{ $slot['client'] }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $slot['service'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900" x-show="period === 'weekly'" x-cloak>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Weekly Services</h3>
                <div class="mt-4 space-y-3">
                    @foreach ($weeklyServices as $row)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-500 dark:text-zinc-400">
                                <span>{{ $row['day'] }}</span>
                                <span>{{ $row['services'] }} services</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-100 dark:bg-zinc-800">
                                <div class="h-2 rounded-full bg-emerald-500" style="width: {{ round(($row['services'] / $maxWeekly) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900" x-show="period === 'monthly'" x-cloak>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Monthly Service Types</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($monthlyServices as $service)
                        <li class="flex items-center justify-between rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                            <div class="flex items-center gap-2">
                                <span class="inline-block size-2.5 rounded-full {{ $service['color'] }}"></span>
                                <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $service['label'] }}</span>
                            </div>
                            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $service['count'] }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </div>
</div>
