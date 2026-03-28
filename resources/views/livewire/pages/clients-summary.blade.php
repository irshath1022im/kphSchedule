<div>


<div class="space-y-6 p-6" x-data="{ tab: 'history' }">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Clients Summary</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Manage client profiles, locations, service request history, and assigned maids.</p>
        </div>
        <div class="flex items-center gap-2">
            <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">Add Client</button>
            <button class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">Export</button>
        </div>
    </div>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs uppercase tracking-wide text-zinc-500">Total Clients</p>
            <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ count($clients) }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
            <p class="text-xs uppercase tracking-wide text-emerald-700 dark:text-emerald-300">Active Clients</p>
            {{-- <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $activeClients }}</p> --}}
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-900/20">
            <p class="text-xs uppercase tracking-wide text-amber-700 dark:text-amber-300">Pending Clients</p>
            {{-- <p class="mt-2 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $pendingClients }}</p> --}}
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
            <p class="text-xs uppercase tracking-wide text-blue-700 dark:text-blue-300">Service Hours (Recent)</p>
            {{-- <p class="mt-2 text-3xl font-bold text-blue-700 dark:text-blue-300">{{ number_format($totalServiceHistoryHours, 1) }}</p> --}}
        </div>
    </section>

    <section class="rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
        <div class="flex flex-wrap items-center gap-2 border-b border-zinc-100 px-5 py-4 dark:border-zinc-700">
            <button type="button" class="rounded-md px-3 py-1.5 text-sm font-medium" :class="tab === 'profiles' ? 'bg-blue-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'" @click="tab = 'profiles'">Client Profiles</button>
            <button type="button" class="rounded-md px-3 py-1.5 text-sm font-medium" :class="tab === 'history' ? 'bg-blue-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'" @click="tab = 'history'">Service Request History</button>
            <button type="button" class="rounded-md px-3 py-1.5 text-sm font-medium" :class="tab === 'maids' ? 'bg-blue-600 text-white' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800'" @click="tab = 'maids'">Assigned Maids</button>
        </div>

        <div class="p-5" x-show="tab === 'profiles'" x-cloak>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @foreach ($clients as $client)
                    @php
                        $parts = explode(' ', $client['name']);
                        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                    @endphp

                      {{-- @dump($client) --}}
                    <article class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="flex size-10 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $initials }}</div>
                                <div>
                                    <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $client['name'] }}</h3>
                                    <p class="text-xs text-zinc-500">{{ $client['id'] }}</p>
                                </div>
                            </div>
                            @if ($client['status'] === 'active')
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Active</span>
                            @else
                                <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">Pending</span>
                            @endif
                        </div>

                        <dl class="mt-4 space-y-2 text-sm">
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-zinc-500">Profile</dt>
                                <dd class="text-zinc-700 dark:text-zinc-200">{{ $client['email'] }}<br>{{ $client['phone'] }}</dd>
                            </div>
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-zinc-500">Location</dt>
                                <dd class="text-zinc-700 dark:text-zinc-200">{{ $client['location'] }}<br><span class="text-xs text-zinc-500">{{ $client['address'] }}</span></dd>
                            </div>
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-zinc-500">Requested</dt>
                                <dd class="flex flex-wrap gap-1.5">

                                    @foreach ($client->serviceRequests as $serviceRequest)
                                        <span class="rounded-full bg-zinc-100 px-2 py-0.5 text-xs text-zinc-700 dark:bg-zinc-800 dark:text-zinc-300">{{ $serviceRequest }}</span>
                                    @endforeach
                                </dd>
                            </div>
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-zinc-500">Assigned Maid</dt>
                                <dd class="text-zinc-700 dark:text-zinc-200">{{ $client['assigned_maid'] }}</dd>
                            </div>
                        </dl>

                        <p class="mt-3 rounded-lg bg-zinc-50 px-3 py-2 text-xs text-zinc-600 dark:bg-zinc-800/70 dark:text-zinc-300">{{ $client['notes'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="p-5" x-show="tab === 'history'" x-cloak>
            <div class="overflow-x-auto">
                <table class="w-full min-w-200 text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 text-left dark:border-zinc-700">
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Date</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Client</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Service Request</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Hours</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Assigned Maid</th>
                            <th class="px-3 py-2 text-xs font-semibold uppercase tracking-wide text-zinc-500">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($clients->pluck('serviceRequests')->flatten() as $row)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40">
                                <td class="px-3 py-3 text-zinc-600 dark:text-zinc-300">{{ $row->service_request_date }}</td>
                                <td class="px-3 py-3 font-medium text-zinc-900 dark:text-zinc-100">{{ $row->client->name }}</td>
                                <td class="px-3 py-3 text-zinc-700 dark:text-zinc-200">{{ $row->frequency }}</td>
                                {{-- <td class="px-3 py-3">

                                    @php
                                        $startTime = \Carbon\Carbon::parse($row->start_time);
                                        $endTime = \Carbon\Carbon::parse($row->end_time);
                                        $hours = $endTime->diffInMinutes($startTime) / 60;
                                        $row->hours = $hours;

                                    @endphp
                                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ number_format($row->hours, 1) }} h</span>
                                </td>
                                <td class="px-3 py-3 text-zinc-700 dark:text-zinc-200">{{ $row->maid ? $row->maid->name : 'N/A' }}</td>
                                <td class="px-3 py-3">
                                    @if ($row->status === 'completed')
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Completed</span>
                                    @elseif ($row->status === 'pending')
                                        <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">Pending</span>
                                    @elseif ($row->status === 'cancelled')
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-300">Cancelled</span>
                                    @endif
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="p-5" x-show="tab === 'maids'" x-cloak>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($maids as $maid)
                    @php
                        $parts = explode(' ', $maid['name']);
                        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                    @endphp
                    <article class="rounded-xl border border-zinc-200 p-4 dark:border-zinc-700">
                        <div class="flex items-center gap-3">
                            <div class="flex size-10 items-center justify-center rounded-full bg-zinc-100 text-sm font-semibold text-zinc-700 dark:bg-zinc-800 dark:text-zinc-200">{{ $initials }}</div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $maid['name'] }}</h3>
                                <p class="text-xs text-zinc-500">{{ $maid['clients'] }} active client assignments</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs text-zinc-500">Current availability</span>
                            @if ($maid['status'] === 'available')
                                <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Available</span>
                            @elseif ($maid['status'] === 'busy')
                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">Busy</span>
                            @elseif ($maid['status'] === 'scheduled')
                                <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">Scheduled</span>
                            @else
                                <span class="rounded-full bg-zinc-200 px-2.5 py-1 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">Off</span>
                            @endif
                        </div>

                        <button class="mt-4 w-full rounded-lg border border-zinc-200 px-3 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-50 dark:border-zinc-700 dark:text-zinc-200 dark:hover:bg-zinc-800">
                            Reassign Clients
                        </button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
</div>
