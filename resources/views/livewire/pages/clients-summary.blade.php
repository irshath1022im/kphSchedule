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
                                    <h3 class="font-semibold text-slate-100 uppercase">
                                    <a href="{{ route('client-view', ['id' => $client->id]) }}">{{ $client['name'] }}</a></h3>
                                    <p class="text-xs text-slate-500">{{ $client['id'] }}</p>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('new-client', ['client_id' => $client->id]) }}" class="text-slate-400 hover:text-slate-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712zM19.513 8.199l-3.712-3.712L4 14.287V18h3.713l11.8-11.801z" />
                                    </svg>
                                </a>
                            </div>
                        </div>



                        <div class="mt-4 space-y-2 text-sm">
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

                              {{-- total earning --}}

                        <div>
                          <span class="text-white">Total Earnings: {{ number_format($client->serviceRequests->pluck('serviceCharge.amount')->sum(), 2) }} QR</span>
                        </div>

                        </div>

                        <p class="mt-3 rounded-xl bg-slate-900 px-3 py-2 text-xs text-slate-400">{{ $client['notes'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>


    </section>
</div>
</div>
