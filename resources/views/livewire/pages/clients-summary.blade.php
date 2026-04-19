<div class="ops-page">
<div class="ops-shell w-full max-w-none" x-data="{ tab: 'profiles' }">
    <div class="ops-hero">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
        <div>
            <p class="ops-eyebrow">Client Operations</p>
            <h1 class="ops-title">Clients Summary</h1>
            <p class="ops-subtitle">Manage client profiles, locations, service request history, and assigned maids in the shared blue operations layout.</p>
        </div>
        <div class="ops-actions">
            <a href="{{ route('new-client') }}" class="ops-btn-primary">Add Client</a>
            <button class="ops-btn-secondary">Export</button>
        </div>
        </div>
    </div>

    <section class="ops-stats-grid">
        <div class="ops-stat-card">
            <p class="ops-stat-label">Total Clients</p>
            <p class="ops-stat-value">{{ count($clients) }}</p>
            <p class="ops-stat-meta">Current client profiles</p>
        </div>
        <div class="ops-stat-card-accent">
            <p class="ops-stat-label text-cyan-100/75">Active Clients</p>
            {{-- <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $activeClients }}</p> --}}
            <p class="ops-stat-meta text-cyan-100/70">Ready for live service</p>
        </div>
        <div class="ops-stat-card">
            <p class="ops-stat-label">Pending Clients</p>
            {{-- <p class="mt-2 text-3xl font-bold text-amber-700">{{ $pendingClients }}</p> --}}
            <p class="ops-stat-meta">Awaiting activation or follow-up</p>
        </div>
        <div class="ops-stat-card">
            <p class="ops-stat-label">Service Hours</p>
            {{-- <p class="mt-2 text-3xl font-bold text-blue-700">{{ number_format($totalServiceHistoryHours, 1) }}</p> --}}
            <p class="ops-stat-meta">Recent delivery volume</p>
        </div>
    </section>

    <section class="ops-panel">
        <div class="ops-panel-header">
            <div>
                <h2 class="ops-panel-title">Client Records</h2>
                <p class="ops-panel-copy">Switch between profiles, request history, and assigned cleaner relationships.</p>
            </div>
            <div class="inline-flex rounded-full border border-sky-300/14 bg-slate-950/70 p-1">
                <button type="button" class="rounded-full px-3 py-1.5 text-sm font-medium transition" :class="tab === 'profiles' ? 'bg-sky-400 text-slate-950' : 'text-slate-300 hover:bg-sky-400/10'" @click="tab = 'profiles'">Client Profiles</button>
                <button type="button" class="rounded-full px-3 py-1.5 text-sm font-medium transition" :class="tab === 'history' ? 'bg-sky-400 text-slate-950' : 'text-slate-300 hover:bg-sky-400/10'" @click="tab = 'history'">Service Request History</button>
                <button type="button" class="rounded-full px-3 py-1.5 text-sm font-medium transition" :class="tab === 'maids' ? 'bg-sky-400 text-slate-950' : 'text-slate-300 hover:bg-sky-400/10'" @click="tab = 'maids'">Assigned Maids</button>
            </div>
        </div>

        <div class="p-5" x-show="tab === 'profiles'" x-cloak>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                @foreach ($clients as $client)
                    @php
                        $parts = explode(' ', $client['name']);
                        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                    @endphp

                      {{-- @dump($client) --}}
                    <article class="rounded-2xl border border-sky-300/12 bg-slate-950/60 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="ops-avatar">{{ $initials }}</div>
                                <div>
                                    <h3 class="font-semibold text-slate-100">{{ $client['name'] }}</h3>
                                    <p class="text-xs text-slate-500">{{ $client['id'] }}</p>
                                </div>
                            </div>

                        </div>

                        <dl class="mt-4 space-y-2 text-sm">
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-slate-500">Profile</dt>
                                <dd class="text-slate-300">{{ $client['email'] }}<br>{{ $client['phone'] }}</dd>
                            </div>
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-slate-500">Location</dt>
                                <dd class="text-slate-300">{{ $client['location'] }}<br><span class="text-xs text-slate-500">{{ $client['address'] }}</span></dd>
                            </div>
                            <div class="grid grid-cols-[110px_1fr] gap-2">
                                <dt class="text-slate-500">Requested SR</dt>
                                <dd class="flex flex-wrap gap-1.5">
                                    <span class="rounded-full border border-sky-300/12 bg-sky-400/10 px-2 py-0.5 text-xs text-sky-100">
                                        {{ $client->serviceRequests->count() }}
                                    </span>

                                </dd>
                            </div>

                        </dl>

                        <p class="mt-3 rounded-xl bg-slate-900 px-3 py-2 text-xs text-slate-400">{{ $client['notes'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="p-5" x-show="tab === 'history'" x-cloak>
            <div class="overflow-x-auto">
                <table class="w-full min-w-200 text-sm">
                    <thead>
                        <tr class="ops-table-head">
                            <th class="px-3 py-3">Date</th>
                            <th class="px-3 py-3">Client</th>
                            <th class="px-3 py-3">Service Request</th>
                            <th class="px-3 py-3">Hours</th>
                            <th class="px-3 py-3">Assigned Maid</th>
                            <th class="px-3 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="ops-table-body">
                        @foreach ($clients->pluck('serviceRequests')->flatten() as $row)
                            <tr class="ops-table-row">
                                <td class="px-3 py-3 text-slate-400">{{ $row->service_request_date }}</td>
                                <td class="px-3 py-3 font-medium text-slate-100">{{ $row->client->name }}</td>
                                <td class="px-3 py-3 text-slate-300">{{ $row->frequency }}</td>
                                {{-- <td class="px-3 py-3">

                                    @php
                                        $startTime = \Carbon\Carbon::parse($row->start_time);
                                        $endTime = \Carbon\Carbon::parse($row->end_time);
                                        $hours = $endTime->diffInMinutes($startTime) / 60;
                                        $row->hours = $hours;

                                    @endphp
                                    <span class="font-semibold text-zinc-900">{{ number_format($row->hours, 1) }} h</span>
                                </td>
                                <td class="px-3 py-3 text-zinc-700">{{ $row->maid ? $row->maid->name : 'N/A' }}</td>
                                <td class="px-3 py-3">
                                    @if ($row->status === 'completed')
                                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">Completed</span>
                                    @elseif ($row->status === 'pending')
                                        <span class="rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700">Pending</span>
                                    @elseif ($row->status === 'cancelled')
                                        <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Cancelled</span>
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
                    <article class="rounded-2xl border border-sky-300/12 bg-slate-950/60 p-4">
                        <div class="flex items-center gap-3">
                            <div class="ops-avatar">{{ $initials }}</div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-slate-100">{{ $maid['name'] }}</h3>
                                <p class="text-xs text-slate-500">{{ $maid['clients'] }} active client assignments</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="text-xs text-slate-500">Current availability</span>
                            @if ($maid['status'] === 'available')
                                <span class="ops-status-chip ops-status-available">Available</span>
                            @elseif ($maid['status'] === 'busy')
                                <span class="ops-status-chip ops-status-busy">Busy</span>
                            @elseif ($maid['status'] === 'scheduled')
                                <span class="ops-status-chip ops-status-scheduled">Scheduled</span>
                            @else
                                <span class="ops-status-chip ops-status-off">Off</span>
                            @endif
                        </div>

                        <button class="mt-4 w-full rounded-full border border-sky-300/16 bg-sky-400/10 px-3 py-2 text-sm font-medium text-sky-100 transition hover:bg-sky-400/18">
                            Reassign Clients
                        </button>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</div>
</div>
