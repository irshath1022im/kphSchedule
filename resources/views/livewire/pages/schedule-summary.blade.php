<div class="ops-page">
<div class="schedule-page">

    @php
        $totalPeriods = $schedule->sum(fn ($requests) => $requests->count());
        $totalHours = $schedule->flatten()->sum('duration_hours');
        $assignedCount = $schedule
            ->flatten()
            ->filter(fn ($item) => $item->maidAssignments?->isNotEmpty())
            ->count();
    @endphp

    {{-- Page Header --}}
    <div class="schedule-header">
        <div>
            <h1 class="schedule-title">Schedule Summary</h1>
            <p class="schedule-subtitle">Browse your schedule in a row-based timeline with visible time ranges</p>
        </div>
        <span class="schedule-count-badge">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $schedule->count() }} Date(s)
        </span>
    </div>

    {{-- Filter Panel --}}
    <div class="filter-panel">

        {{-- Quick Filter Buttons --}}
        <div class="filter-btn-group">
            <button wire:click="setYesterday"  class="btn-filter-secondary">Yesterday</button>
            <button wire:click="setToday"      class="btn-filter-primary">Today</button>
            <button wire:click="setTomorrow"   class="btn-filter-secondary">Tomorrow</button>
            <button wire:click="setThisWeek"   class="btn-filter-cyan">This Week</button>
            <button wire:click="setThisMonth"  class="btn-filter-violet">This Month</button>
        </div>

        {{-- Date Range Row --}}
        <div class="date-range-row">
            <div class="flex flex-col gap-1">
                <label class="date-label">From</label>
                <input type="date" wire:model.live="search_startDate" class="date-input">
            </div>
            <div class="flex flex-col gap-1">
                <label class="date-label">To</label>
                <input type="date" wire:model.live="search_endDate" class="date-input">
            </div>
            <button wire:click="$refresh"     class="btn-search">Search</button>
            <button wire:click="clearFilters" class="btn-clear">Clear</button>
        </div>
    </div>

    @if ($schedule->isNotEmpty())
        <div class="mb-6 grid gap-3 md:grid-cols-3">
            <div class="ops-stat-card-accent rounded-3xl p-5">
                <p class="ops-stat-label text-cyan-100/75">Periods</p>
                <p class="mt-2 text-3xl font-black text-slate-50">{{ $totalPeriods }}</p>
                <p class="mt-1 text-sm text-cyan-100/70">Rows in the current date range</p>
            </div>
            <div class="ops-stat-card rounded-3xl p-5">
                <p class="ops-stat-label">Hours</p>
                <p class="mt-2 text-3xl font-black text-slate-50">{{ rtrim(rtrim(number_format($totalHours, 1), '0'), '.') }}</p>
                <p class="mt-1 text-sm text-slate-300/72">Scheduled service duration</p>
            </div>
            <div class="ops-stat-card rounded-3xl p-5">
                <p class="ops-stat-label">Assigned</p>
                <p class="mt-2 text-3xl font-black text-slate-50">{{ $assignedCount }}</p>
                <p class="mt-1 text-sm text-slate-300/72">Periods with maid assignments</p>
            </div>
        </div>
    @endif

    {{-- Table View --}}
    @if ($schedule->isNotEmpty())
        <div class="space-y-6">
            @foreach ($schedule as $date => $requests)
                <section class="overflow-hidden rounded-[28px] border border-sky-300/14 bg-linear-to-b from-slate-900 to-slate-950 shadow-[0_24px_60px_-32px_rgba(14,165,233,0.25)]">
                    <div class="flex flex-col gap-3 border-b border-sky-300/10 bg-linear-to-r from-slate-950 via-slate-900 to-sky-950/40 px-5 py-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.24em] text-sky-100/55">
                                {{ \Carbon\Carbon::parse($date)->format('l') }}
                            </p>
                            <p class="mt-1 text-xl font-black text-slate-50">
                                {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 text-sm font-semibold">
                            <span class="inline-flex items-center rounded-full border border-sky-300/22 bg-slate-950 px-3 py-1.5 text-slate-100">
                                {{ $requests->count() }} row{{ $requests->count() > 1 ? 's' : '' }}
                            </span>
                            <span class="inline-flex items-center rounded-full border border-cyan-400/40 bg-cyan-500/15 px-3 py-1.5 text-cyan-200">
                                {{ rtrim(rtrim(number_format($requests->sum('duration_hours'), 1), '0'), '.') }}h total
                            </span>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-sky-300/10 text-sm text-slate-300">
                            <thead class="bg-slate-950/60 text-left text-[11px] font-bold uppercase tracking-[0.22em] text-sky-100/50">
                                <tr>
                                    <th class="px-5 py-3">Time Range</th>
                                    <th class="px-5 py-3">Status</th>
                                    <th class="px-5 py-3">Service</th>
                                    <th class="px-5 py-3">Client</th>
                                    <th class="px-5 py-3">Assigned Maids</th>
                                    <th class="px-5 py-3">Duration</th>
                                    <th class="px-5 py-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-sky-300/8 bg-slate-950/30">
                            @forelse ($requests as $request)
                                @php
                                    $statusStyle = match($request->status) {
                                        'In Progress' => 'status-in-progress',
                                        'Scheduled'   => 'status-scheduled',
                                        'Pending'     => 'status-pending',
                                        'Completed'   => 'status-completed',
                                        'Cancelled'   => 'status-cancelled',
                                        default       => 'status-default',
                                    };
                                    $statusRail = match($request->status) {
                                        'In Progress' => 'bg-blue-500',
                                        'Scheduled'   => 'bg-emerald-500',
                                        'Pending'     => 'bg-violet-500',
                                        'Completed'   => 'bg-green-500',
                                        'Cancelled'   => 'bg-red-500',
                                        default       => 'bg-zinc-400',
                                    };
                                    $assignedMaids = $request->maidAssignments?->pluck('maid.name')->filter()->unique()->values() ?? collect();
                                    $clientName = $request->serviceRequest->client->name ?? 'No client linked';
                                    $startTime = \Carbon\Carbon::parse($request->start_time);
                                    $endTime = $request->end_time
                                        ? \Carbon\Carbon::parse($request->end_time)
                                        : $startTime->copy()->addMinutes((int) round(((float) $request->duration_hours) * 60));
                                @endphp

                                <tr class="align-top transition hover:bg-sky-400/6">
                                    <td class="px-5 py-4">
                                        <div class="flex items-start gap-3">
                                            <span class="mt-0.5 inline-block h-10 w-1.5 rounded-full {{ $statusRail }}"></span>
                                            <div>
                                                <p class="font-bold text-slate-50">{{ $startTime->format('g:i A') }} - {{ $endTime->format('g:i A') }}</p>
                                                <p class="mt-1 text-xs font-medium uppercase tracking-[0.16em] text-slate-400">{{ $request->day_of_week ?: \Carbon\Carbon::parse($date)->format('l') }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="period-status-badge {{ $statusStyle }}">
                                            {{ $request->status ?? 'Unknown' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-slate-100">
                                        {{ $request->service->name ?? 'No service selected' }}
                                    </td>
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-slate-100">{{ $clientName }}</p>
                                        <p class="mt-1 text-xs text-slate-400">Request #{{ $request->request_id }}</p>
                                    </td>
                                    <td class="px-5 py-4">
                                        <span class="block max-w-xs text-sm leading-6 text-slate-400">
                                            {{ $assignedMaids->isNotEmpty() ? $assignedMaids->join(', ') : 'No maids assigned' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4 font-semibold text-slate-100">
                                        {{ rtrim(rtrim(number_format($request->duration_hours, 1), '0'), '.') }}h
                                    </td>
                                    <td class="px-5 py-4 text-right">
                                        <a href="{{ route('service-request-view', $request->request_id) }}" class="inline-flex items-center rounded-full border border-cyan-400/35 bg-cyan-500/10 px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-cyan-200 transition hover:border-cyan-300/50 hover:bg-cyan-500/20 hover:text-cyan-100">
                                            Open
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-5 py-8 text-center text-sm font-medium text-slate-400">
                                        No periods assigned for this date.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>
            @endforeach

        </div>
    @else
        <div class="empty-state">
            <svg class="w-20 h-20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="empty-state-title">No schedules found</p>
            <p class="empty-state-text">Try adjusting your date filters above</p>
        </div>
    @endif

</div>

</div>
