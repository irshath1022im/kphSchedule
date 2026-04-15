<div>

<div class="schedule-page space-y-6" x-data="{ tab: 'roster' }">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-100">Cleaners Management</h1>
            <p class="text-sm text-zinc-400">Maintain cleaner profiles, worked hours, earnings, attendance, and job performance.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('new-maid') }}" class="rounded-lg bg-cyan-500 px-4 py-2 text-sm font-medium text-zinc-950 hover:bg-cyan-400">Add Cleaner</a>
            <button class="rounded-lg border border-zinc-700 bg-zinc-900 px-4 py-2 text-sm font-medium text-zinc-300 hover:bg-zinc-800">Generate Payroll</button>
        </div>
    </div>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-4">
            <p class="text-xs uppercase tracking-wide text-zinc-400">Total Cleaners</p>
            <p class="mt-2 text-3xl font-bold text-zinc-100">{{ $maids->count()}}</p>
        </div>
        <div class="rounded-xl border border-emerald-400/30 bg-emerald-500/10 p-4">
            <p class="text-xs uppercase tracking-wide text-emerald-200">Active / Scheduled</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700"></p>
        </div>
        <div class="rounded-xl border border-blue-400/30 bg-blue-500/10 p-4">
            <p class="text-xs uppercase tracking-wide text-blue-200">Worked Hours (Week)</p>
            <p class="mt-2 text-3xl font-bold text-blue-200">
                {{-- {{ $totalHoursWeek }} --}} {{ $maids->flatMap->serviceRequestPeriods->sum('duration_hours') }} hours
            </p>
        </div>
        <div class="rounded-xl border border-violet-400/30 bg-violet-500/10 p-4">
            <p class="text-xs uppercase tracking-wide text-violet-200">Earned (Month)</p>
            <p class="mt-2 text-3xl font-bold text-violet-200">
                {{-- PHP {{ number_format($totalEarnedMonth) }} --}} {{ $totalEarning}} QR
            </p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-xl border border-zinc-700 bg-zinc-900/75">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-zinc-700 px-5 py-4">
                <h2 class="text-base font-semibold text-zinc-100">Cleaners Directory</h2>
                <div class="inline-flex rounded-lg border border-zinc-700 bg-zinc-900 p-1">
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'roster' ? 'bg-cyan-500 text-zinc-950 shadow-sm' : 'text-zinc-300'" @click="tab = 'roster'">Roster</button>
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'hours' ? 'bg-cyan-500 text-zinc-950 shadow-sm' : 'text-zinc-300'" @click="tab = 'hours'">Worked Hours</button>
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'earnings' ? 'bg-cyan-500 text-zinc-950 shadow-sm' : 'text-zinc-300'" @click="tab = 'earnings'">Earnings</button>

                    <input type="date" name="" id="" class="rounded border border-zinc-700 bg-zinc-950 px-2 py-1 text-zinc-200" wire:model="maidScheduleSearchDate" @change="$wire.set('maidScheduleSearchDate', $event.target.value);">

                </div>
            </div>

            <div class="p-5" x-show="tab === 'roster'" x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-225 text-sm">
                        <thead>
                            <tr class="border-b border-zinc-700 text-left">
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Cleaner Profile</th>

                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Status as of <span class="text-blue-500">{{ $maidScheduleSearchDate }}</span></th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Jobs Completed</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-800">
                            @foreach ($maids as $maid)
                                @php
                                    $parts = explode(' ', $maid['name']);
                                    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                                @endphp
                                <tr class="hover:bg-zinc-800/40">
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex size-9 items-center justify-center rounded-full bg-zinc-800 text-xs font-semibold text-zinc-200">{{ $initials }}</div>
                                            <div>
                                                <a href="{{ route('cleaner-view',['id' => $maid->id]) }}" class="font-semibold text-zinc-100">{{ $maid['name'] }}</a>
                                                <p class="text-xs text-zinc-500">{{ $maid['id'] }} · {{ $maid['phone'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3">

                             @if($maid->has('assignments') && $maid->assignments?->count() > 0)
                                            @php
                                                $today = \Carbon\Carbon::now()->toDateString();
                                                $todayAssignment = $maid->assignments?->pluck('serviceRequestPeriod')?->where('start_date', $today)->first();

                                                $inProgress = $maid->assignments?->pluck('serviceRequestPeriod')?->where('start_date', $today)->count() ?? 0;
                                                $scheduledAppointments = $maid->assignments?->pluck('serviceRequestPeriod')?->where('start_date', '>', $today)->count() ?? 0;

                                                $completedSchudule = $maid->assignments?->pluck('serviceRequestPeriod')?->where('start_date', '<', $today)->count() ?? 0;
                                            @endphp



                                             <span class="rounded-full border border-green-400/40 bg-green-500/15 px-2.5 py-1 text-xs font-semibold text-green-200">Completed - <span>
                                                {{ $completedSchudule }}</span></span>


                                             <span class="rounded-full border border-blue-400/40 bg-blue-500/15 px-2.5 py-1 text-xs font-semibold text-blue-200">In Progress - <span>
                                                {{ $inProgress }}</span></span>


                                            <span class="rounded-full border border-yellow-400/40 bg-yellow-500/15 px-2.5 py-1 text-xs font-semibold text-yellow-200">Scheduled <span class="">
                                                {{ $scheduledAppointments }}</span>
                                            </span>

                                @endif
                                    </td>


                                    <td class="px-3 py-3 font-semibold text-zinc-100">{{ $maid['jobs_completed'] }}</td>
                                    <td class="px-3 py-3">
                                        <div class="flex items-center gap-0.5">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="size-3.5 {{ $i <= $maid['rating'] ? 'text-amber-400' : 'text-zinc-300' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
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
                    {{-- @foreach ($maids as $cleaner)
                        @php
                            $weekPct = min(100, round(($cleaner['worked_hours_week'] / 45) * 100));
                            $monthPct = min(100, round(($cleaner['worked_hours_month'] / 180) * 100));
                        @endphp
                        <div class="rounded-xl border border-zinc-200 p-4">
                            <div class="mb-2 flex items-center justify-between">
                                <p class="font-semibold text-zinc-900">{{ $cleaner['name'] }}</p>
                                <p class="text-xs text-zinc-500">Rate: PHP {{ number_format($cleaner['rate_per_hour']) }}/h</p>
                            </div>
                            <div class="space-y-2">
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">
                                        <span>Weekly Hours</span>
                                        <span>{{ $cleaner['worked_hours_week'] }}h</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-zinc-100">
                                        <div class="h-2 rounded-full bg-blue-500" style="width: {{ $weekPct }}%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">
                                        <span>Monthly Hours</span>
                                        <span>{{ $cleaner['worked_hours_month'] }}h</span>
                                    </div>
                                    <div class="h-2 rounded-full bg-zinc-100">
                                        <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $monthPct }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach --}}
                </div>
            </div>

            {{-- <div class="p-5" x-show="tab === 'earnings'" x-cloak>
                <div class="overflow-x-auto">
                    <table class="w-full min-w-190 text-sm">
                        <thead>
                            <tr class="border-b border-zinc-100 text-left">
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Cleaner</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Rate / Hour</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Hours (Week)</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Earned (Week)</th>
                                <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Earned (Month)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100">
                            @foreach ($cleaners as $cleaner)
                                <tr class="hover:bg-zinc-50">
                                    <td class="px-3 py-3 font-semibold text-zinc-900">{{ $cleaner['name'] }}</td>
                                    <td class="px-3 py-3 text-zinc-700">PHP {{ number_format($cleaner['rate_per_hour']) }}</td>
                                    <td class="px-3 py-3 text-zinc-700">{{ $cleaner['worked_hours_week'] }}h</td>
                                    <td class="px-3 py-3 font-semibold text-blue-700">PHP {{ number_format($cleaner['earned_week']) }}</td>
                                    <td class="px-3 py-3 font-semibold text-violet-700">PHP {{ number_format($cleaner['earned_month']) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div> --}}
        </div>

        <div class="space-y-6">
            {{-- <div class="rounded-xl border border-zinc-200 bg-white p-5">
                <h3 class="text-base font-semibold text-zinc-900">Team Hours Trend</h3>
                <p class="mt-1 text-xs text-zinc-500">Total worked hours by day (all cleaners)</p>
                <div class="mt-4 space-y-3">
                    @foreach ($weeklyHours as $row)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-500">
                                <span>{{ $row['day'] }}</span>
                                <span>{{ $row['hours'] }}h</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-100">
                                <div class="h-2 rounded-full bg-indigo-500" style="width: {{ round(($row['hours'] / $maxWeeklyHours) * 100) }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
{{--    <div class="rounded-xl border border-zinc-200 bg-white p-5">
            <div class="rounded-xl border border-zinc-200 bg-white p-5">
                <h3 class="text-base font-semibold text-zinc-900">Quick Workforce Snapshot</h3>
                <div class="mt-4 grid grid-cols-2 gap-3 text-center">
                    <div class="rounded-lg bg-zinc-50 p-3">
                        <p class="text-xs text-zinc-500">On Duty</p>
                        <p class="mt-1 text-2xl font-bold text-zinc-900">{{ $onDutyCount }}</p>
                    </div>
                    <div class="rounded-lg bg-zinc-50 p-3">
                        <p class="text-xs text-zinc-500">Avg Hours / Cleaner</p>
                        <p class="mt-1 text-2xl font-bold text-zinc-900">{{ round($totalHoursWeek / count($cleaners), 1) }}</p>
                    </div>
                </div>
            </div> --}}

            <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5">
                <h3 class="text-base font-semibold text-zinc-100">Recent Activity Logs</h3>
                <ul class="mt-4 space-y-3">
                    {{-- @foreach ($recentLogs as $log)
                        <li class="rounded-lg border border-zinc-200 p-3">
                            <div class="flex items-center justify-between">
                                <p class="text-xs font-medium text-zinc-500">{{ $log['time'] }}</p>
                                <span class="text-xs font-semibold text-emerald-600">{{ $log['hours'] }}</span>
                            </div>
                            <p class="mt-1 text-sm font-semibold text-zinc-900">{{ $log['cleaner'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $log['activity'] }}</p>
                        </li>
                    @endforeach --}}
                </ul>
            </div>
        </div>
    </section>
</div>
</div>
