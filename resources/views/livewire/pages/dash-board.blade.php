<div class="space-y-6 p-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900">Dashboard</h1>
            <p class="mt-0.5 text-sm text-zinc-500">Cleaning Service Overview &mdash; {{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="flex items-center gap-2 mt-3 sm:mt-0">
            <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Request
            </a>
            <a href="{{ route('schedule-summary') }}" class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Schedule
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
        @livewire('dash-board.stats-cards')

    {{-- Middle Section: Requests + Cleaner Status --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Recent Service Requests --}}
        @livewire('dash-board.recent-service-requests')

        {{-- Cleaner Status --}}
        <div class="rounded-xl border border-zinc-200 bg-white">
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">
                <h2 class="text-base font-semibold text-zinc-900">Cleaner Status</h2>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">Manage</a>
            </div>
            <div class="divide-y divide-zinc-100">
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
                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-zinc-50 transition-colors">
                    @php $cp = explode(' ', $cleaner['name']); $ci = strtoupper(substr($cp[0],0,1).(isset($cp[1])?substr($cp[1],0,1):'')); @endphp
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-xs font-semibold text-zinc-700">{{ $ci }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-800 truncate">{{ $cleaner['name'] }}</p>
                        <p class="text-xs text-zinc-500 truncate">{{ $cleaner['job'] }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        @if($cleaner['status'] === 'busy')
                            <span class="inline-block size-2 rounded-full bg-blue-500"></span>
                        @elseif($cleaner['status'] === 'available')
                            <span class="inline-block size-2 rounded-full bg-emerald-500"></span>
                        @elseif($cleaner['status'] === 'scheduled')
                            <span class="inline-block size-2 rounded-full bg-amber-400"></span>
                        @else
                            <span class="inline-block size-2 rounded-full bg-zinc-400"></span>
                        @endif
                        <p class="text-xs text-zinc-400 mt-0.5">{{ $cleaner['time'] }}</p>
                    </div>
                </div>
                @endforeach

                <div class="px-5 py-3 text-xs text-zinc-400">
                    <span class="inline-block size-2 rounded-full bg-emerald-500 mr-1"></span>Available &nbsp;
                    <span class="inline-block size-2 rounded-full bg-blue-500 mr-1"></span>Busy &nbsp;
                    <span class="inline-block size-2 rounded-full bg-amber-400 mr-1"></span>Scheduled &nbsp;
                    <span class="inline-block size-2 rounded-full bg-zinc-400 mr-1"></span>Off
                </div>
            </div>
        </div>

    </div>

    {{-- Recently Completed Services --}}
    <div class="rounded-xl border border-zinc-200 bg-white">
        <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">
            <h2 class="text-base font-semibold text-zinc-900">Recently Completed Services</h2>
            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100">
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500">Client</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500">Service</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500">Cleaner</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500">Completed</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500">Duration</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500">Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100">
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
                    <tr class="hover:bg-zinc-50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                @php $jp = explode(' ', $job['client']); $ji = strtoupper(substr($jp[0],0,1).(isset($jp[1])?substr($jp[1],0,1):'')); @endphp
                                <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-semibold text-emerald-700">{{ $ji }}</div>
                                <span class="font-medium text-zinc-800">{{ $job['client'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-zinc-600">{{ $job['service'] }}</td>
                        <td class="px-5 py-3.5 text-zinc-600">{{ $job['cleaner'] }}</td>
                        <td class="px-5 py-3.5 text-zinc-500 whitespace-nowrap">{{ $job['date'] }}</td>
                        <td class="px-5 py-3.5 text-zinc-500">{{ $job['duration'] }}</td>
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
