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
                    <div class="sched-card-body">
                        @foreach ($requests as $request)
                            @if ($request->serviceRequestPeriods->isNotEmpty())
                                @foreach ($request->serviceRequestPeriods as $item)
                                    @php
                                        $statusStyle = match($item->status) {
                                            'In Progress' => 'status-in-progress',
                                            'Scheduled'   => 'status-scheduled',
                                            'Pending'     => 'status-pending',
                                            'Completed'   => 'status-completed',
                                            'Cancelled'   => 'status-cancelled',
                                            default       => 'status-default',
                                        };
                                    @endphp

                                    <div class="period-card {{ $statusStyle }}">

                                        {{-- Status + Service --}}
                                        <div class="period-status-row">
                                            <span class="period-status-badge {{ $statusStyle }}">
                                                {{ $item->status ?? 'Unknown' }}
                                            </span>
                                            @if ($item->service)
                                                <span class="period-service-name" title="{{ $item->service->name }}">
                                                    {{ $item->service->name }}
                                                </span>
                                            @endif
                                            <a href="{{ route('service-request-view', $request->id) }}">View</a>
                                        </div>

                                        {{-- Time Range --}}
                                        <div class="period-meta-row">
                                            <svg class="period-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span>
                                                {{ \Carbon\Carbon::parse($item->start_time)->format('g:i A') }}
                                                &ndash;
                                                {{ \Carbon\Carbon::parse($item->start_time)->addHours(intval($item->duration_hours))->format('g:i A') }}
                                            </span>
                                        </div>

                                        {{-- Duration --}}
                                        <div class="period-meta-row">
                                            <svg class="period-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                                                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                                            </svg>
                                            <span>{{ $item->duration_hours }}h required</span>
                                        </div>

                                        {{-- Client --}}
                                        @if ($request->client)
                                            <div class="period-meta-row-last">
                                                <svg class="period-meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <span class="truncate">{{ $request->client->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            @else
                                <div class="no-periods-card">
                                    <span class="no-periods-label">No periods assigned</span>
                                </div>
                            @endif
                        @endforeach
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
