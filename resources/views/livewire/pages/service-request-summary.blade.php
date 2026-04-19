<div class="ops-page">
<div class="ops-shell space-y-6" x-data="{ tab: 'all' }">

    @if (session('message'))
        <div class="mb-4 rounded-lg border border-emerald-400/30 bg-emerald-500/15 p-4 text-sm text-emerald-200">
            {{ session('message') }}
        </div>
    @endif

    <div class="ops-hero">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
        <div>
            <p class="ops-eyebrow">Request Reporting</p>
            <h1 class="ops-title">Service Request Summary</h1>
            <p class="ops-subtitle">Track requested services, service-hour history, completion status, and assignments with the same blue reporting language used across the app.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('new-service-request') }}" class="ops-btn-primary">New Service Request</a>
            <div class="rounded-full border border-sky-300/16 bg-slate-950/70 px-4 py-2 text-sm font-medium text-slate-300">
                Last updated: {{ now()->format('M d, Y h:i A') }}
            </div>
        </div>
        </div>
    </div>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="ops-stat-card">
            <p class="ops-stat-label">Total Requests</p>
            <p class="ops-stat-value">{{ $serviceRequests->count() }}</p>
        </div>
        <div class="ops-stat-card">
            <p class="ops-stat-label">Total Service Hours</p>
            <p class="ops-stat-value">{{ number_format($serviceRequests->pluck('serviceRequestPeriods')->flatten()->sum('duration_hours'), 1) }}</p>
        </div>
        <div class="ops-stat-card-accent">
            <p class="ops-stat-label text-cyan-100/75">Completed</p>
            <p class="ops-stat-value text-cyan-100">{{ $serviceRequests->where('status', 'completed')->count() }}</p>
        </div>
        <div class="ops-stat-card">
            <p class="ops-stat-label">In Progress</p>
            <p class="ops-stat-value">{{ $serviceRequests->where('status', 'in_progress')->count() }}</p>
        </div>
        <div class="ops-stat-card">
            <p class="ops-stat-label">Pending + Cancelled</p>
            <p class="ops-stat-value">{{ $serviceRequests->whereIn('status', ['pending', 'cancelled'])->count() }}</p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 ">
        <div class="xl:col-span-2 ops-panel">
            <div class="ops-panel-header">
                <div>
                    <h2 class="ops-panel-title">Service Request Records</h2>
                    <p class="ops-panel-copy">Filter request records by state while keeping charges, hours, and assignments visible.</p>
                </div>
                <div class="inline-flex rounded-full border border-sky-300/14 bg-slate-950/70 p-1">
                    <button type="button" class="rounded-full px-3 py-1.5 text-xs font-medium transition" :class="tab === 'all' ? 'bg-sky-400 text-slate-950 shadow-sm' : 'text-slate-300 hover:bg-sky-400/10'" @click="tab = 'all'">All</button>
                    <button type="button" class="rounded-full px-3 py-1.5 text-xs font-medium transition" :class="tab === 'completed' ? 'bg-sky-400 text-slate-950 shadow-sm' : 'text-slate-300 hover:bg-sky-400/10'" @click="tab = 'completed'">Completed</button>
                    <button type="button" class="rounded-full px-3 py-1.5 text-xs font-medium transition" :class="tab === 'open' ? 'bg-sky-400 text-slate-950 shadow-sm' : 'text-slate-300 hover:bg-sky-400/10'" @click="tab = 'open'">Open</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-225 text-sm">
                    <thead>
                        <tr class="ops-table-head">
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Request</th>
                            <th class="px-5 py-3">Service Requested</th>
                             <th class="px-5 py-3">Frequency</th>
                             <th class="px-5 py-3">Service Hours</th>
                             <th class="px-5 py-3">Service Charge</th>
                            <th class="px-5 py-3">Completion Status</th>
                            <th class="px-5 py-3">Assigned Maid </span></th>

                        </tr>
                    </thead>
                    <tbody class="ops-table-body">
                        @foreach ($serviceRequests as $request)
                            @php
                                $status = strtolower($request->status);
                                $isCompleted = $status === 'completed';
                                $isOpen = in_array($status, ['in progress', 'pending']);
                            @endphp


                            <tr
                                x-show="tab === 'all' || (tab === 'completed' && {{ $isCompleted ? 'true' : 'false' }}) || (tab === 'open' && {{ $isOpen ? 'true' : 'false' }})"
                                class="align-top transition hover:bg-sky-400/6"
                            >

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-slate-100">{{ $request->id }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    {{-- <p class="font-semibold text-zinc-900">{{ $request['code'] }}</p> --}}
                                    <p class="mt-1 text-xs text-slate-400">
                                        {{ $request->client->name }}
                                    </p>
                                    <p class="text-xs text-slate-500">Requested on {{ $request->service_request_date }}</p>
                                </td>
                                <td class="px-5 py-4 text-slate-300">
                                    {{ $request->serviceRequestPeriods?->first()?->service->name ?? 'N/A' }}
                                </td>

                                 <td class="px-5 py-4 text-slate-300">
                                    {{ $request->frequency ? ucfirst($request->frequency) : 'N/A' }}
                                </td>



                                <td class="px-5 py-4">
                                     <p class="font-semibold text-slate-100">{{ number_format($request->serviceRequestPeriods?->sum('duration_hours') ?? 0, 0) }} hrs</p>
                                     <div class="mt-2 h-1.5 w-24 rounded-full bg-slate-800">
                                         <div class="h-1.5 rounded-full bg-sky-400" style="width: {{ min(100, ($request->serviceRequestPeriods?->sum('duration_hours') ?? 0) * 20) }}%"></div>
                                    </div>
                                </td>

                                {{-- service charge --}}

                                @if ($request->serviceCharge)
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-slate-100">{{ $request->serviceCharge?->amount ? 'QR ' . number_format($request->serviceCharge->amount, 0) : 'N/A' }}</p>
                                        <p class="mt-1 text-xs text-slate-500">{{ $request->serviceCharge?->invoice_date ? \Carbon\Carbon::parse($request->serviceCharge->invoice_date)->toDateString() : 'N/A' }}</p>
                                    </td>

                                @else

                                    <td class="px-5 py-4">
                                        <span class="text-xs text-slate-500">N/A</span>
                                    </td>
                                @endif

                                <td class="px-5 py-4">
                                    @if ($request->status === 'completed')
                                        <span class="ops-status-chip ops-status-available">Completed</span>
                                    @elseif ($request->status === 'in progress')
                                        <span class="ops-status-chip ops-status-busy">In Progress</span>
                                    @elseif ($request->status === 'pending')
                                        <span class="ops-status-chip ops-status-scheduled">Pending</span>
                                    @else
                                        <span class="ops-status-chip ops-status-off">Cancelled</span>
                                    @endif
                                </td>


                            {{--  Assigned Maid --}}

                            {{-- @dump($request->assignedMaids?->groupBy('maid_id')?->map(fn($group) => $group->first()->maid?->name)->join(', ')) --}}



                                <td class="px-5 py-4">
                                    @if ($request->serviceRequestPeriods?->isNotEmpty())

                                    {{-- @dump($request->serviceRequestPeriods->maids?>->count()) --}}

                                        {{-- @dump($request->assignedMaids) --}}
                                        <div class="flex items-center gap-1">
                                           <span class="rounded-full border border-sky-300/16 bg-sky-400/10 px-2.5 py-1 text-xs font-semibold text-sky-100">{{ $request->assignedMaids?->groupBy('maid_id')?->count() ?? 0  }}</span>
                                            <span class="text-sm font-medium text-slate-100">
                                                {{ $request->assignedMaids?->groupBy('maid_id')?->map(fn($group) => $group->first()->maid?->name)->join(', ') ?? 'N/A' }}
                                            </span>

                                        </div>
                                    @else
                                        <span class="text-xs text-slate-500">No maid assigned</span>
                                    @endif
                                </td>
                                {{-- <td class="px-5 py-4">
                                    @if ($request->review > 0)
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="size-3.5 {{ $i <= $request->review ? 'text-amber-400' : 'text-zinc-300' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">

                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endfor
                                            <span class="ml-1 text-xs font-semibold text-zinc-700">{{ $request->review }}/5</span>
                                        </div>
                                        <p class="mt-1 max-w-55 text-xs text-zinc-500">{{ $request->comment }}</p>
                                    @else
                                        <span class="text-xs text-zinc-500">No review yet</span>
                                        <p class="mt-1 max-w-55 text-xs text-zinc-500">{{ $request->comment }}</p>
                                    @endif
                                </td> --}}


                                <td class="px-5 py-4 flex items-center gap-2">
                                    <a href="
                                    {{ route('service-request-view', ['id' => $request->id]) }}" class="ops-table-action">view</a>

                                     <a href="
                                    {{ route('new-service-request', ['id' => $request->id]) }}" class="ops-table-action">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="space-y-6">
            <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5">
                <h2 class="text-base font-semibold text-zinc-100">Service Hours History</h2>
                <p class="mt-1 text-xs text-zinc-500">Weekly service-hour trend</p>

                <div class="mt-4 space-y-4">
                    @foreach ($serviceRequests->pluck('serviceRequestPeriods')->flatten() as $item)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-600">
                                <span>{{ $item->period }}</span>
                                <span class="font-semibold">{{ $item->duration_hours }} hrs</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-800">
                            </div>


                        </div>
                    @endforeach
                </div>
            </div>

           <div class="rounded-xl border border-zinc-200 bg-white p-5">
                <h2 class="text-base font-semibold text-zinc-900">Completion Status Breakdown</h2>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Completed</span><span class="font-semibold text-emerald-600">{{ $completedCount }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600">In Progress</span><span class="font-semibold text-blue-600">{{ $inProgressCount }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Pending</span><span class="font-semibold text-amber-600">{{ $pendingCount }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600">Cancelled</span><span class="font-semibold text-zinc-600">{{ $cancelledCount }}</span></div>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-200 bg-white p-5">
                <h2 class="text-base font-semibold text-zinc-900">Client Review Summary</h2>
                <p class="mt-1 text-xs text-zinc-500">Average rating: <span class="font-semibold text-zinc-700">{{ $avgReview }}/5</span></p>

                <div class="mt-4 space-y-2">
                    @for ($star = 5; $star >= 1; $star--)
                        @php
                            $count = $ratingBreakdown[$star];
                            $width = $reviewed->count() > 0 ? round(($count / $reviewed->count()) * 100) : 0;
                        @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-600">
                                <span>{{ $star }} Star</span>
                                <span>{{ $count }}</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-100">
                                <div class="h-2 rounded-full bg-amber-400" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div> --}}
    </section>
</div>

</div>
