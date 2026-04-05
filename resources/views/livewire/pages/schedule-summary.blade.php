<div class="schedule-page">

    {{-- Page Header --}}
    <div class="schedule-header">
        <div>
            <h1 class="schedule-title">Schedule Summary</h1>
            <p class="schedule-subtitle">Browse and filter your service requests by date</p>
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

    {{-- Cards Grid --}}
    @if ($schedule->isNotEmpty())
        <div class="schedule-grid">
            @foreach ($schedule as $date => $requests)
                @php
                    $palettes = [
                        ['border' => 'border-indigo-400', 'header' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'badge' => 'bg-indigo-100 text-indigo-700'],
                        ['border' => 'border-emerald-400', 'header' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'badge' => 'bg-emerald-100 text-emerald-700'],
                        ['border' => 'border-amber-400',   'header' => 'bg-amber-50',   'text' => 'text-amber-700',   'badge' => 'bg-amber-100 text-amber-700'],
                        ['border' => 'border-rose-400',    'header' => 'bg-rose-50',    'text' => 'text-rose-700',    'badge' => 'bg-rose-100 text-rose-700'],
                        ['border' => 'border-cyan-400',    'header' => 'bg-cyan-50',    'text' => 'text-cyan-700',    'badge' => 'bg-cyan-100 text-cyan-700'],
                        ['border' => 'border-violet-400',  'header' => 'bg-violet-50',  'text' => 'text-violet-700',  'badge' => 'bg-violet-100 text-violet-700'],
                        ['border' => 'border-orange-400',  'header' => 'bg-orange-50',  'text' => 'text-orange-700',  'badge' => 'bg-orange-100 text-orange-700'],
                        ['border' => 'border-teal-400',    'header' => 'bg-teal-50',    'text' => 'text-teal-700',    'badge' => 'bg-teal-100 text-teal-700'],
                    ];
                    $p = $palettes[$loop->index % count($palettes)];
                @endphp

                <div class="sched-card {{ $p['border'] }}">

                    {{-- Card Header --}}
                    <div class="sched-card-header {{ $p['header'] }}">
                        <div>
                            <p class="sched-card-day">
                                {{ \Carbon\Carbon::parse($date)->format('l') }}
                            </p>
                            <p class="sched-card-date {{ $p['text'] }}">
                                {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}
                            </p>
                        </div>
                        <span class="sched-card-badge {{ $p['badge'] }}">
                            {{ $requests->count() }} req
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="sched-card-body bg-linear-to-b from-white via-zinc-50/70 to-slate-100/90">
                        <div class="grid grid-cols-3 gap-2 rounded-2xl border border-white/80 bg-white/70 p-3 shadow-sm backdrop-blur-sm">
                            <div class="rounded-xl bg-zinc-900 px-3 py-2 text-white">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-300">Requests</p>
                                <p class="mt-1 text-lg font-black">{{ $requests->count() }}</p>
                            </div>
                            <div class="rounded-xl bg-white px-3 py-2 ring-1 ring-zinc-200/80">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-400">Hours</p>
                                <p class="mt-1 text-lg font-black text-zinc-900">{{ rtrim(rtrim(number_format($requests->sum('duration_hours'), 1), '0'), '.') }}</p>
                            </div>
                            <div class="rounded-xl bg-white px-3 py-2 ring-1 ring-zinc-200/80">
                                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-zinc-400">Assigned</p>
                                <p class="mt-1 text-lg font-black text-zinc-900">{{ $requests->filter(fn($item) => $item->assignedMaids?->isNotEmpty())->count() }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
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
                                    $assignedMaids = $request->serviceRequest->assignedMaids?->pluck('maid.name')->filter()->unique()->values() ?? collect();
                                    $clientName = $request->serviceRequest->client->name ?? 'No client linked';
                                @endphp

                                <article class="group relative overflow-hidden rounded-2xl border border-white/80 bg-white/90 p-4 shadow-sm ring-1 ring-black/5 transition duration-200 hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="absolute inset-y-0 left-0 w-1.5 {{ $statusRail }}"></div>

                                    <div class="pl-3">
                                        <div class="flex items-start justify-between gap-3">
                                            <div class="min-w-0 flex-1">
                                                <div class="flex flex-wrap items-center gap-2">
                                                    <span class="period-status-badge {{ $statusStyle }}">
                                                        {{ $request->status ?? 'Unknown' }}
                                                    </span>
                                                    @if ($request->service)
                                                        <span class="inline-flex max-w-full items-center rounded-full bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-600" title="{{ $request->service->name }}">
                                                            {{ $request->service->name }}
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="mt-3 flex flex-wrap items-center gap-2 text-sm font-semibold text-zinc-900">
                                                    <svg class="h-4 w-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span>
                                                        {{ \Carbon\Carbon::parse($request->start_time)->format('g:i A') }}
                                                        &ndash;
                                                        {{ \Carbon\Carbon::parse($request->start_time)->addHours(intval($request->duration_hours))->format('g:i A') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <a href="{{ route('service-request-view', $request->request_id) }}" class="inline-flex shrink-0 items-center rounded-full border border-zinc-200 bg-white px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-zinc-700 transition hover:border-zinc-300 hover:bg-zinc-100 hover:text-zinc-900">
                                                Open
                                            </a>
                                        </div>

                                        <div class="mt-4 grid gap-2 sm:grid-cols-3">
                                            <div class="rounded-xl bg-zinc-50 px-3 py-2 ring-1 ring-zinc-200/70">
                                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Duration</p>
                                                <p class="mt-1 text-sm font-bold text-zinc-900">{{ $request->duration_hours }}h required</p>
                                            </div>

                                            <div class="rounded-xl bg-zinc-50 px-3 py-2 ring-1 ring-zinc-200/70">
                                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Client</p>
                                                <p class="mt-1 truncate text-sm font-bold text-zinc-900">{{ $clientName }}</p>
                                            </div>

                                            <div class="rounded-xl bg-zinc-50 px-3 py-2 ring-1 ring-zinc-200/70">
                                                <p class="text-[10px] font-semibold uppercase tracking-[0.16em] text-zinc-400">Assigned Maids</p>
                                                <p class="mt-1 truncate text-sm font-bold text-zinc-900">
                                                    {{ $assignedMaids->isNotEmpty() ? $assignedMaids->join(', ') : 'No maids assigned' }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @empty
                                <div class="no-periods-card">
                                    <span class="no-periods-label">No periods assigned</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
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
