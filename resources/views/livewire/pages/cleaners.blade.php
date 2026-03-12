<div>
@php
    $cleaners = [
        [
            'id' => 'CLN-001',
            'name' => 'Ana Reyes',
            'phone' => '+63 917 111 2200',
            'location' => 'Makati',
            'status' => 'Available',
            'worked_hours_week' => 36,
            'worked_hours_month' => 142,
            'rate_per_hour' => 180,
            'earned_week' => 6480,
            'earned_month' => 25560,
            'jobs_completed' => 18,
            'rating' => 5,
        ],
        [
            'id' => 'CLN-002',
            'name' => 'Ben Torres',
            'phone' => '+63 917 333 1109',
            'location' => 'Taguig',
            'status' => 'On Duty',
            'worked_hours_week' => 40,
            'worked_hours_month' => 158,
            'rate_per_hour' => 170,
            'earned_week' => 6800,
            'earned_month' => 26860,
            'jobs_completed' => 21,
            'rating' => 4,
        ],
        [
            'id' => 'CLN-003',
            'name' => 'Joy Villanueva',
            'phone' => '+63 917 882 9004',
            'location' => 'Quezon City',
            'status' => 'Scheduled',
            'worked_hours_week' => 32,
            'worked_hours_month' => 129,
            'rate_per_hour' => 175,
            'earned_week' => 5600,
            'earned_month' => 22575,
            'jobs_completed' => 16,
            'rating' => 5,
        ],
        [
            'id' => 'CLN-004',
            'name' => 'Claire Ong',
            'phone' => '+63 917 777 5522',
            'location' => 'Pasig',
            'status' => 'Day Off',
            'worked_hours_week' => 24,
            'worked_hours_month' => 101,
            'rate_per_hour' => 165,
            'earned_week' => 3960,
            'earned_month' => 16665,
            'jobs_completed' => 12,
            'rating' => 4,
        ],
        [
            'id' => 'CLN-005',
            'name' => 'Mark Lim',
            'phone' => '+63 917 445 7781',
            'location' => 'Mandaluyong',
            'status' => 'On Duty',
            'worked_hours_week' => 38,
            'worked_hours_month' => 149,
            'rate_per_hour' => 172,
            'earned_week' => 6536,
            'earned_month' => 25628,
            'jobs_completed' => 19,
            'rating' => 4,
        ],
    ];

    $weeklyHours = [
        ['day' => 'Mon', 'hours' => 32],
        ['day' => 'Tue', 'hours' => 34],
        ['day' => 'Wed', 'hours' => 36],
        ['day' => 'Thu', 'hours' => 35],
        ['day' => 'Fri', 'hours' => 39],
        ['day' => 'Sat', 'hours' => 28],
        ['day' => 'Sun', 'hours' => 16],
    ];

    $recentLogs = [
        ['time' => '08:05 AM', 'cleaner' => 'Ben Torres', 'activity' => 'Checked in - Office Cleaning', 'hours' => '+2.0h'],
        ['time' => '09:30 AM', 'cleaner' => 'Ana Reyes', 'activity' => 'Completed Deep Cleaning', 'hours' => '+3.5h'],
        ['time' => '11:10 AM', 'cleaner' => 'Mark Lim', 'activity' => 'Started Regular Cleaning', 'hours' => '+1.5h'],
        ['time' => '01:45 PM', 'cleaner' => 'Joy Villanueva', 'activity' => 'Assigned Move-out Cleaning', 'hours' => '+4.0h'],
    ];

    $activeCount = collect($cleaners)->whereIn('status', ['Available', 'On Duty', 'Scheduled'])->count();
    $onDutyCount = collect($cleaners)->where('status', 'On Duty')->count();
    $totalHoursWeek = collect($cleaners)->sum('worked_hours_week');
    $totalEarnedMonth = collect($cleaners)->sum('earned_month');
    $maxWeeklyHours = collect($weeklyHours)->max('hours');
@endphp

<div class="space-y-6 p-6" x-data="{ tab: 'roster' }">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Cleaners Management</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Maintain cleaner profiles, worked hours, earnings, attendance, and job performance.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Add Cleaner</button>
            <button class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Generate Payroll</button>
        </div>
    </div>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs uppercase tracking-wide text-zinc-500">Total Cleaners</p>
            <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ count($cleaners) }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
            <p class="text-xs uppercase tracking-wide text-emerald-700 dark:text-emerald-300">Active / Scheduled</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $activeCount }}</p>
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
            <p class="text-xs uppercase tracking-wide text-blue-700 dark:text-blue-300">Worked Hours (Week)</p>
            <p class="mt-2 text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $totalHoursWeek }}</p>
        </div>
        <div class="rounded-xl border border-violet-200 bg-violet-50 p-4 dark:border-violet-800 dark:bg-violet-900/20">
            <p class="text-xs uppercase tracking-wide text-violet-700 dark:text-violet-300">Earned (Month)</p>
            <p class="mt-2 text-3xl font-bold text-violet-700 dark:text-violet-300">PHP {{ number_format($totalEarnedMonth) }}</p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-100 px-5 py-4 dark:border-zinc-700">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Cleaners Directory</h2>
                <div class="inline-flex rounded-lg border border-zinc-200 bg-zinc-50 p-1 dark:border-zinc-700 dark:bg-zinc-800">
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'roster' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="tab = 'roster'">Roster</button>
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'hours' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="tab = 'hours'">Worked Hours</button>
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'earnings' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="tab = 'earnings'">Earnings</button>
                </div>
            </div>

            <div class="p-5" x-show="tab === 'roster'" x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-225 text-sm">
                        <thead>
                            <tr class="border-b border-zinc-100 text-left dark:border-zinc-700">
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Cleaner Profile</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Location</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Status</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Jobs Completed</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach ($cleaners as $cleaner)
                                @php
                                    $parts = explode(' ', $cleaner['name']);
                                    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                                @endphp
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-9 items-center justify-center rounded-full bg-zinc-100 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200">{{ $initials }}</div>
                                            <div>
                                                <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $cleaner['name'] }}</p>
                                                <p class="text-xs text-zinc-500">{{ $cleaner['id'] }} · {{ $cleaner['phone'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 text-zinc-700 dark:text-zinc-200">{{ $cleaner['location'] }}</td>
                                    <td class="px-3 py-3">
                                        @if ($cleaner['status'] === 'Available')
                                            <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Available</span>
                                        @elseif ($cleaner['status'] === 'On Duty')
                                            <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">On Duty</span>
                                        @elseif ($cleaner['status'] === 'Scheduled')
                                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">Scheduled</span>
                                        @else
                                            <span class="rounded-full bg-zinc-200 px-2.5 py-1 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">Day Off</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 font-semibold text-zinc-900 dark:text-zinc-100">{{ $cleaner['jobs_completed'] }}</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="size-3.5 {{ $i <= $cleaner['rating'] ? 'text-amber-400' : 'text-zinc-300 dark:text-zinc-600' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endfor
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="p-5" x-show="tab === 'hours'" x-cloak>
                <div class="space-y-4">
                    @foreach ($cleaners as $cleaner)
                        @php
                            $weekPct = min(100, round(($cleaner['worked_hours_week'] / 45) * 100));
                            $monthPct = min(100, round(($cleaner['worked_hours_month'] / 180) * 100));
                        @endphp
                        <div class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                            <div class="mb-2 flex items-center justify-between">
                                <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $cleaner['name'] }}</p>
                                <p class="text-xs text-zinc-500">Rate: PHP {{ number_format($cleaner['rate_per_hour']) }}/h</p>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">
                                        <span>Weekly Hours</span>
                                        <span>{{ $cleaner['worked_hours_week'] }}h</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                        <div class="h-2 rounded-full bg-blue-500" style="width: {{ $weekPct }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">
                                        <span>Monthly Hours</span>
                                        <span>{{ $cleaner['worked_hours_month'] }}h</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $monthPct }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="p-5" x-show="tab === 'earnings'" x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-190 text-sm">
                        <thead>
                            <tr class="border-b border-zinc-100 text-left dark:border-zinc-700">
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Cleaner</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Rate / Hour</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Hours (Week)</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Earned (Week)</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Earned (Month)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                            @foreach ($cleaners as $cleaner)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                    <td class="px-3 py-3 font-semibold text-zinc-900 dark:text-zinc-100">{{ $cleaner['name'] }}</td>
                                    <td class="px-3 py-3 text-zinc-700 dark:text-zinc-200">PHP {{ number_format($cleaner['rate_per_hour']) }}</td>
                                    <td class="px-3 py-3 text-zinc-700 dark:text-zinc-200">{{ $cleaner['worked_hours_week'] }}h</td>
                                    <td class="px-3 py-3 font-semibold text-blue-700 dark:text-blue-300">PHP {{ number_format($cleaner['earned_week']) }}</td>
                                    <td class="px-3 py-3 font-semibold text-violet-700 dark:text-violet-300">PHP {{ number_format($cleaner['earned_month']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Team Hours Trend</h3>
                <p class="mt-1 text-xs text-zinc-500">Total worked hours by day (all cleaners)</p>
                <div class="mt-4 space-y-3">
                    @foreach ($weeklyHours as $row)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">
                                <span>{{ $row['day'] }}</span>
                                <span>{{ $row['hours'] }}h</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ round(($row['hours'] / $maxWeeklyHours) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Quick Workforce Snapshot</h3>
                <div class="mt-4 grid grid-cols-2 gap-3 text-center">
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/70">
                        <p class="text-xs text-zinc-500">On Duty</p>
                        <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $onDutyCount }}</p>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3 dark:bg-zinc-800/70">
                        <p class="text-xs text-zinc-500">Avg Hours / Cleaner</p>
                        <p class="mt-1 text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ round($totalHoursWeek / count($cleaners), 1) }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h3 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Recent Activity Logs</h3>
                <ul class="mt-4 space-y-3">
                    @foreach ($recentLogs as $log)
                        <li class="rounded-lg border border-zinc-200 p-3 dark:border-zinc-700">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-medium text-zinc-500">{{ $log['time'] }}</p>
                                <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-300">{{ $log['hours'] }}</span>
                            </div>
                            <p class="mt-1 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $log['cleaner'] }}</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $log['activity'] }}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
</div>
</div>
