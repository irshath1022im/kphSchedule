<div class="space-y-6 p-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Dashboard</h1>
            <p class="mt-0.5 text-sm text-zinc-500 dark:text-zinc-400">Cleaning Service Overview &mdash; {{ now()->format('l, F j, Y') }}</p>
        </div>
        <div class="flex items-center gap-2 mt-3 sm:mt-0">
            <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-blue-700">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Request
            </a>
            <a href="{{ route('schedule-summary') }}" class="inline-flex items-center gap-2 rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 shadow-sm transition hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                Schedule
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Clients --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Clients</p>
                <div class="flex size-9 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/30">
                    <svg class="size-5 text-blue-600 dark:text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">48</p>
                <p class="mt-1 text-xs text-green-600 dark:text-green-400">&#8593; 4 new this month</p>
            </div>
        </div>

        {{-- Pending Requests --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending Requests</p>
                <div class="flex size-9 items-center justify-center rounded-lg bg-amber-100 dark:bg-amber-900/30">
                    <svg class="size-5 text-amber-600 dark:text-amber-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">12</p>
                <p class="mt-1 text-xs text-amber-600 dark:text-amber-400">3 urgent today</p>
            </div>
        </div>

        {{-- Active Jobs Today --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Active Jobs Today</p>
                <div class="flex size-9 items-center justify-center rounded-lg bg-emerald-100 dark:bg-emerald-900/30">
                    <svg class="size-5 text-emerald-600 dark:text-emerald-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">8</p>
                <p class="mt-1 text-xs text-emerald-600 dark:text-emerald-400">5 completed, 3 in-progress</p>
            </div>
        </div>

        {{-- Available Cleaners --}}
        <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Available Cleaners</p>
                <div class="flex size-9 items-center justify-center rounded-lg bg-purple-100 dark:bg-purple-900/30">
                    <svg class="size-5 text-purple-600 dark:text-purple-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">7 <span class="text-base font-normal text-zinc-400">/ 15</span></p>
                <p class="mt-1 text-xs text-purple-600 dark:text-purple-400">8 currently assigned</p>
            </div>
        </div>

    </div>

    {{-- Middle Section: Requests + Cleaner Status --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        {{-- Recent Service Requests --}}
        <div class="lg:col-span-2 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4 dark:border-zinc-700/60">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Recent Service Requests</h2>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/60">
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Client</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Service Type</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Scheduled</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Assigned To</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700/60">
                        @php
                            $requests = [
                                ['client'=>'Maria Santos',   'service'=>'Deep Cleaning',     'date'=>'Today, 09:00 AM', 'cleaner'=>'Ana Reyes',    'status'=>'in-progress', 'color'=>'blue'],
                                ['client'=>'John Cruz',      'service'=>'Regular Cleaning',  'date'=>'Today, 11:00 AM', 'cleaner'=>'Ben Torres',   'status'=>'pending',     'color'=>'amber'],
                                ['client'=>'Liza Gomez',     'service'=>'Move-out Clean',    'date'=>'Today, 02:00 PM', 'cleaner'=>'Unassigned',   'status'=>'pending',     'color'=>'amber'],
                                ['client'=>'Carlos dela Cruz','service'=>'Office Cleaning',  'date'=>'Mar 13, 08:00 AM','cleaner'=>'Joy Villanueva','status'=>'scheduled',  'color'=>'emerald'],
                                ['client'=>'Rosa Mendez',    'service'=>'Post-Event Clean',  'date'=>'Mar 14, 10:00 AM','cleaner'=>'Unassigned',   'status'=>'pending',     'color'=>'amber'],
                                ['client'=>'Pedro Bautista', 'service'=>'Regular Cleaning',  'date'=>'Mar 15, 09:00 AM','cleaner'=>'Ana Reyes',    'status'=>'scheduled',   'color'=>'emerald'],
                            ];
                        @endphp
                        @foreach($requests as $req)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    @php $parts = explode(' ', $req['client']); $ini = strtoupper(substr($parts[0],0,1).(isset($parts[1])?substr($parts[1],0,1):'')); @endphp
                                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $ini }}</div>
                                    <span class="font-medium text-zinc-800 dark:text-zinc-100">{{ $req['client'] }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-300">{{ $req['service'] }}</td>
                            <td class="px-5 py-3.5 text-zinc-500 dark:text-zinc-400 whitespace-nowrap">{{ $req['date'] }}</td>
                            <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-300">{{ $req['cleaner'] }}</td>
                            <td class="px-5 py-3.5">
                                @if($req['status'] === 'in-progress')
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">In Progress</span>
                                @elseif($req['status'] === 'pending')
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Pending</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Scheduled</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Cleaner Status --}}
        <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4 dark:border-zinc-700/60">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Cleaner Status</h2>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">Manage</a>
            </div>
            <div class="divide-y divide-zinc-100 dark:divide-zinc-700/60">
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
                <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                    @php $cp = explode(' ', $cleaner['name']); $ci = strtoupper(substr($cp[0],0,1).(isset($cp[1])?substr($cp[1],0,1):'')); @endphp
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-zinc-200 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-200">{{ $ci }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-zinc-800 truncate dark:text-zinc-100">{{ $cleaner['name'] }}</p>
                        <p class="text-xs text-zinc-500 truncate dark:text-zinc-400">{{ $cleaner['job'] }}</p>
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

                <div class="px-5 py-3 text-xs text-zinc-400 dark:text-zinc-500">
                    <span class="inline-block size-2 rounded-full bg-emerald-500 mr-1"></span>Available &nbsp;
                    <span class="inline-block size-2 rounded-full bg-blue-500 mr-1"></span>Busy &nbsp;
                    <span class="inline-block size-2 rounded-full bg-amber-400 mr-1"></span>Scheduled &nbsp;
                    <span class="inline-block size-2 rounded-full bg-zinc-400 mr-1"></span>Off
                </div>
            </div>
        </div>

    </div>

    {{-- Recently Completed Services --}}
    <div class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4 dark:border-zinc-700/60">
            <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Recently Completed Services</h2>
            <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">View all</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-zinc-100 dark:border-zinc-700/60">
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Client</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Service</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Cleaner</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Completed</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Duration</th>
                        <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Rating</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700/60">
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
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                @php $jp = explode(' ', $job['client']); $ji = strtoupper(substr($jp[0],0,1).(isset($jp[1])?substr($jp[1],0,1):'')); @endphp
                                <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">{{ $ji }}</div>
                                <span class="font-medium text-zinc-800 dark:text-zinc-100">{{ $job['client'] }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-300">{{ $job['service'] }}</td>
                        <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-300">{{ $job['cleaner'] }}</td>
                        <td class="px-5 py-3.5 text-zinc-500 dark:text-zinc-400 whitespace-nowrap">{{ $job['date'] }}</td>
                        <td class="px-5 py-3.5 text-zinc-500 dark:text-zinc-400">{{ $job['duration'] }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-0.5">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="size-3.5 {{ $i <= $job['rating'] ? 'text-amber-400' : 'text-zinc-300 dark:text-zinc-600' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
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
