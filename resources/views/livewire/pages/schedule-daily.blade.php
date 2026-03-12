<div>
@php
    $selectedDate = now();

    $bookings = [
        ['id' => 'BK-2101', 'start' => 8, 'duration' => 3, 'client' => 'Maria Santos', 'service' => 'Deep Cleaning', 'cleaner' => 'Ana Reyes', 'status' => 'In Progress', 'color' => 'blue'],
        ['id' => 'BK-2102', 'start' => 9, 'duration' => 2, 'client' => 'John Cruz', 'service' => 'Regular Cleaning', 'cleaner' => 'Ben Torres', 'status' => 'Scheduled', 'color' => 'emerald'],
        ['id' => 'BK-2106', 'start' => 9, 'duration' => 1, 'client' => 'Rosa Mendez', 'service' => 'Quick Sanitizing', 'cleaner' => 'Claire Ong', 'status' => 'Scheduled', 'color' => 'rose'],
        ['id' => 'BK-2103', 'start' => 13, 'duration' => 3, 'client' => 'Liza Gomez', 'service' => 'Move-out Cleaning', 'cleaner' => 'Joy Villanueva', 'status' => 'Scheduled', 'color' => 'amber'],
        ['id' => 'BK-2107', 'start' => 14, 'duration' => 2, 'client' => 'Peter Lim', 'service' => 'Regular Cleaning', 'cleaner' => 'Mark Lim', 'status' => 'Scheduled', 'color' => 'blue'],
        ['id' => 'BK-2104', 'start' => 16, 'duration' => 2, 'client' => 'Carlos dela Cruz', 'service' => 'Office Cleaning', 'cleaner' => 'Mark Lim', 'status' => 'Pending', 'color' => 'violet'],
        ['id' => 'BK-2105', 'start' => 19, 'duration' => 1, 'client' => 'Grace Flores', 'service' => 'Post-Event Cleaning', 'cleaner' => 'Claire Ong', 'status' => 'Scheduled', 'color' => 'rose'],
    ];

    $hours = range(0, 23);

    $hourSummary = [];
    foreach ($hours as $hour) {
        $hourSummary[$hour] = collect($bookings)
            ->filter(fn ($b) => $hour >= $b['start'] && $hour < ($b['start'] + $b['duration']))
            ->values()
            ->all();
    }

    $totalBookings = count($bookings);
    $totalBookedHours = collect($bookings)->sum('duration');
    $maxConcurrent = collect($hourSummary)->map(fn ($slot) => count($slot))->max();
    $hoursWithTwo = collect($hourSummary)->filter(fn ($slot) => count($slot) === 2)->count();
    $hoursWithThreeOrMore = collect($hourSummary)->filter(fn ($slot) => count($slot) >= 3)->count();
    $activeNow = collect($bookings)->filter(function ($b) {
        $nowHour = now()->hour;
        return $nowHour >= $b['start'] && $nowHour < ($b['start'] + $b['duration']);
    })->count();
@endphp

<div class="space-y-6 p-6" x-data="{ viewMode: 'timeline' }">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Daily Schedule</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">24-hour view for {{ $selectedDate->format('l, F d, Y') }}</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Previous Day</button>
            <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Today</button>
            <button class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Next Day</button>
        </div>
    </div>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs uppercase tracking-wide text-zinc-500">Total Bookings</p>
            <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalBookings }}</p>
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
            <p class="text-xs uppercase tracking-wide text-blue-700 dark:text-blue-300">Booked Hours</p>
            <p class="mt-2 text-3xl font-bold text-blue-700 dark:text-blue-300">{{ number_format($totalBookedHours, 1) }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
            <p class="text-xs uppercase tracking-wide text-emerald-700 dark:text-emerald-300">Active Now</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $activeNow }}</p>
        </div>
        <div class="rounded-xl border border-violet-200 bg-violet-50 p-4 dark:border-violet-800 dark:bg-violet-900/20">
            <p class="text-xs uppercase tracking-wide text-violet-700 dark:text-violet-300">Peak Concurrent</p>
            <p class="mt-2 text-3xl font-bold text-violet-700 dark:text-violet-300">{{ $maxConcurrent }}</p>
            <p class="mt-1 text-xs text-violet-700/80 dark:text-violet-300/80">{{ $hoursWithTwo }} hrs with 2 bookings, {{ $hoursWithThreeOrMore }} hrs with 3+ bookings</p>
        </div>
    </section>

    <section class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-100 px-5 py-4 dark:border-zinc-700">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">24-Hour Planner</h2>
            <div class="inline-flex rounded-lg border border-zinc-200 bg-zinc-50 p-1 dark:border-zinc-700 dark:bg-zinc-800">
                <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="viewMode === 'timeline' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="viewMode = 'timeline'">Timeline</button>
                <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="viewMode === 'hourly' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="viewMode = 'hourly'">Hourly List</button>
            </div>
        </div>

        <div class="p-5" x-show="viewMode === 'timeline'" x-cloak>
            <div class="overflow-x-auto">
                <div class="min-w-225">
                    @foreach ($hours as $hour)
                        <div class="grid grid-cols-[90px_1fr] border-b border-zinc-100 last:border-b-0 dark:border-zinc-700">
                            <div class="py-3 pr-4 text-right">
                                <p class="text-xs font-semibold text-zinc-500">{{ str_pad((string) $hour, 2, '0', STR_PAD_LEFT) }}:00</p>
                                @if (count($hourSummary[$hour]) === 2)
                                    <span class="mt-1 inline-block rounded-full bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">2 bookings</span>
                                @elseif (count($hourSummary[$hour]) >= 3)
                                    <span class="mt-1 inline-block rounded-full bg-rose-100 px-2 py-0.5 text-[10px] font-semibold text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">3+ bookings</span>
                                @endif
                            </div>
                            <div class="space-y-2 py-2">
                                @if (count($hourSummary[$hour]) === 0)
                                    <div class="rounded-lg border border-dashed border-zinc-200 px-3 py-2 text-xs text-zinc-400 dark:border-zinc-700 dark:text-zinc-500">No booking</div>
                                @else
                                    @foreach ($hourSummary[$hour] as $booking)
                                        @php
                                            $colorClasses = match ($booking['color']) {
                                                'blue' => 'border-blue-200 bg-blue-50 text-blue-800 dark:border-blue-900 dark:bg-blue-900/20 dark:text-blue-300',
                                                'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-800 dark:border-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-300',
                                                'amber' => 'border-amber-200 bg-amber-50 text-amber-800 dark:border-amber-900 dark:bg-amber-900/20 dark:text-amber-300',
                                                'violet' => 'border-violet-200 bg-violet-50 text-violet-800 dark:border-violet-900 dark:bg-violet-900/20 dark:text-violet-300',
                                                default => 'border-rose-200 bg-rose-50 text-rose-800 dark:border-rose-900 dark:bg-rose-900/20 dark:text-rose-300',
                                            };
                                        @endphp
                                        <div class="rounded-lg border px-3 py-2 {{ $colorClasses }}">
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <p class="text-xs font-semibold">{{ $booking['id'] }} · {{ $booking['service'] }}</p>
                                                <span class="rounded-full bg-white/70 px-2 py-0.5 text-[11px] font-semibold dark:bg-black/20">{{ $booking['status'] }}</span>
                                            </div>
                                            <p class="mt-1 text-xs">{{ $booking['client'] }} · {{ $booking['cleaner'] }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="p-5" x-show="viewMode === 'hourly'" x-cloak>
            <div class="overflow-x-auto">
                <table class="w-full min-w-225 text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 text-left dark:border-zinc-700">
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Hour Block</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Bookings</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Assigned Cleaners</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($hours as $hour)
                            @php
                                $slot = $hourSummary[$hour];
                                $cleanerList = collect($slot)->pluck('cleaner')->unique()->values()->implode(', ');
                                $bookingIds = collect($slot)->pluck('id')->implode(', ');
                            @endphp
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                <td class="px-3 py-3 font-semibold text-zinc-900 dark:text-zinc-100">{{ str_pad((string) $hour, 2, '0', STR_PAD_LEFT) }}:00 - {{ str_pad((string) (($hour + 1) % 24), 2, '0', STR_PAD_LEFT) }}:00</td>
                                <td class="px-3 py-3 text-zinc-700 dark:text-zinc-200">
                                    <p>{{ count($slot) }}</p>
                                    @if (count($slot) > 0)
                                        <p class="text-xs text-zinc-500">{{ $bookingIds }}</p>
                                    @endif
                                </td>
                                <td class="px-3 py-3 text-zinc-600 dark:text-zinc-300">{{ $cleanerList !== '' ? $cleanerList : 'None' }}</td>
                                <td class="px-3 py-3">
                                    @if (count($slot) >= 3)
                                        <span class="rounded-full bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-700 dark:bg-rose-900/30 dark:text-rose-300">3 bookings same hour</span>
                                    @elseif (count($slot) === 2)
                                        <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">2 bookings same hour</span>
                                    @elseif (count($slot) === 1)
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Occupied</span>
                                    @else
                                        <span class="rounded-full bg-zinc-200 px-2.5 py-1 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">Free</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
</div>
