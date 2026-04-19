<div class="ops-page">
    <div class="ops-shell">

    {{-- Page Header --}}
    <div class="ops-hero">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
        <div>
            <p class="ops-eyebrow">Operations Overview</p>
            <h1 class="ops-title">Dashboard</h1>
            <p class="ops-subtitle">Cleaning service overview for {{ now()->format('l, F j, Y') }} with active requests, workforce availability, and recent completions in one blue command surface.</p>
        </div>
        <div class="ops-actions mt-1 xl:justify-end">
            <a href="#" class="ops-btn-primary">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Request
            </a>
            <a href="{{ route('schedule-summary') }}" class="ops-btn-secondary">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Schedule
            </a>
        </div>
        </div>
    </div>

    {{-- Stats Cards --}}
        @livewire('dash-board.stats-cards')

    {{-- Middle Section: Requests + Cleaner Status --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Recent Service Requests --}}
        @livewire('dash-board.recent-service-requests')

        {{-- Cleaner Status --}}
        <div class="ops-panel">
            <div class="ops-panel-header">
                <div>
                    <h2 class="ops-panel-title">Cleaner Status</h2>
                    <p class="ops-panel-copy">Live roster snapshot for current assignments and availability.</p>
                </div>
                <a href="#" class="ops-link">Manage</a>
            </div>
            <div class="divide-y divide-sky-300/10">
                @php
                    $cleaners = [
                        ['name'=>'Ana Reyes',      'job'=>'Deep Clean – Santos',   'status'=>'busy',      'time'=>'Until 11 AM'],
                        ['name'=>'Ben Torres',     'job'=>'Regular – Cruz',        'status'=>'busy',      'time'=>'Until 1 PM'],
                        ['name'=>'Joy Villanueva', 'job'=>'Office – dela Cruz',    'status'=>'scheduled', 'time'=>'Starts 8 AM'],
                        ['name'=>'Mark Lim',       'job'=>'—',                     'status'=>'available', 'time'=>'Free today'],
                        ['name'=>'Claire Ong',     'job'=>'—',                     'status'=>'available', 'time'=>'Free today'],
                        ['name'=>'Ruel Pascual',   'job'=>'Post-Event – Pending',  'status'=>'off',       'time'=>'Day Off'],
                        ['name'=>'Susan Navarro',  'job'=>'—',                     'status'=>'available', 'time'=>'Free today'],
                    ];
                @endphp
                @foreach($cleaners as $cleaner)
                <div class="flex items-center gap-3 px-5 py-3.5 transition-colors hover:bg-sky-400/6">
                    @php $cp = explode(' ', $cleaner['name']); $ci = strtoupper(substr($cp[0],0,1).(isset($cp[1])?substr($cp[1],0,1):'')); @endphp
                    <div class="ops-avatar">{{ $ci }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="truncate text-sm font-medium text-slate-100">{{ $cleaner['name'] }}</p>
                        <p class="truncate text-xs text-slate-400">{{ $cleaner['job'] }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        @if($cleaner['status'] === 'busy')
                            <span class="inline-block size-2 rounded-full bg-cyan-400"></span>
                        @elseif($cleaner['status'] === 'available')
                            <span class="inline-block size-2 rounded-full bg-sky-400"></span>
                        @elseif($cleaner['status'] === 'scheduled')
                            <span class="inline-block size-2 rounded-full bg-indigo-400"></span>
                        @else
                            <span class="inline-block size-2 rounded-full bg-slate-400"></span>
                        @endif
                        <p class="mt-0.5 text-xs text-slate-400">{{ $cleaner['time'] }}</p>
                    </div>
                </div>
                @endforeach

                <div class="px-5 py-3 text-xs text-slate-400">
                    <span class="mr-1 inline-block size-2 rounded-full bg-sky-400"></span>Available &nbsp;
                    <span class="mr-1 inline-block size-2 rounded-full bg-cyan-400"></span>Busy &nbsp;
                    <span class="mr-1 inline-block size-2 rounded-full bg-indigo-400"></span>Scheduled &nbsp;
                    <span class="mr-1 inline-block size-2 rounded-full bg-slate-400"></span>Off
                </div>
            </div>
        </div>

    </div>

    {{-- Recently Completed Services --}}
    <div class="ops-panel">
        <div class="ops-panel-header">
            <div>
                <h2 class="ops-panel-title">Recently Completed Services</h2>
                <p class="ops-panel-copy">Latest finished jobs with duration and rating context.</p>
            </div>
            <a href="#" class="ops-link">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="ops-table-head">
                        <th class="px-5 py-3">Client</th>
                        <th class="px-5 py-3">Service</th>
                        <th class="px-5 py-3">Cleaner</th>
                        <th class="px-5 py-3">Completed</th>
                        <th class="px-5 py-3">Duration</th>
                        <th class="px-5 py-3">Rating</th>
                    </tr>
                </thead>
                <tbody class="ops-table-body">
                    @php
                        $completed = [
                            ['client'=>'Ana Villanueva', 'service'=>'Deep Cleaning',     'cleaner'=>'Ana Reyes',     'date'=>'Mar 11, 2026', 'duration'=>'3h 20m', 'rating'=>5],
                            ['client'=>'Diego Tan',      'service'=>'Regular Cleaning',  'cleaner'=>'Ben Torres',    'date'=>'Mar 11, 2026', 'duration'=>'2h 00m', 'rating'=>4],
                            ['client'=>'Elena Flores',   'service'=>'Move-out Clean',    'cleaner'=>'Joy Villanueva','date'=>'Mar 10, 2026', 'duration'=>'4h 45m', 'rating'=>5],
                            ['client'=>'Frank Aquino',   'service'=>'Post-Event Clean',  'cleaner'=>'Mark Lim',      'date'=>'Mar 10, 2026', 'duration'=>'2h 30m', 'rating'=>4],
                            ['client'=>'Grace Santos',   'service'=>'Office Cleaning',   'cleaner'=>'Claire Ong',    'date'=>'Mar 9,  2026', 'duration'=>'3h 00m', 'rating'=>5],
                        ];
                    @endphp
                    @foreach($completed as $job)
                    <tr class="ops-table-row">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                @php $jp = explode(' ', $job['client']); $ji = strtoupper(substr($jp[0],0,1).(isset($jp[1])?substr($jp[1],0,1):'')); @endphp
                                <div class="ops-avatar">{{ $ji }}</div>
                                <span class="font-medium text-slate-100">{{ $job['client'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-300">{{ $job['service'] }}</td>
                        <td class="px-5 py-3.5 text-slate-300">{{ $job['cleaner'] }}</td>
                        <td class="px-5 py-3.5 whitespace-nowrap text-slate-400">{{ $job['date'] }}</td>
                        <td class="px-5 py-3.5 text-slate-400">{{ $job['duration'] }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="size-3.5 {{ $i <= $job['rating'] ? 'text-amber-400' : 'text-zinc-300' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z"/>
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

    </div>
</div>
