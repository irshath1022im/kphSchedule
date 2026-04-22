<div>
    <div class="ops-hero border-sky-200/80 bg-linear-to-br from-sky-100 via-blue-100 to-cyan-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.5)]">
        <div class="flex flex-col gap-5 xl:flex-row xl:items-start xl:justify-between">
        <div>
            <p class="ops-eyebrow text-sky-700">Request Reporting</p>
            <h1 class="ops-title text-sky-950">Service Request Summary - <span class="text-sky-700 uppercase">{{ $frequency }}</span></h1>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('new-service-request') }}" class="ops-btn-primary">New Service Request</a>
            <div class="rounded-full border border-sky-200/80 bg-white/75 px-4 py-2 text-sm font-medium text-sky-800 shadow-sm">
                Last updated: {{ now()->format('M d, Y h:i A') }}
            </div>
        </div>
        </div>
    </div>

     {{--filter by Last Month, Upcoming Month  --}}

    @livewire('filter')




    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="ops-stat-card border-sky-200/70 bg-white/78 shadow-sm">
            <p class="ops-stat-label text-sky-700">Total Requests</p>
            <p class="ops-stat-value text-sky-950">{{ $serviceRequests->count() }}</p>
        </div>
        <div class="ops-stat-card border-sky-200/70 bg-white/78 shadow-sm">
            <p class="ops-stat-label text-sky-700">Total Service Hours</p>
            <p class="ops-stat-value text-sky-950">{{ number_format($serviceRequests->pluck('serviceRequestPeriods')->flatten()->sum('duration_hours'), 1) }}</p>
        </div>
        <div class="ops-stat-card-accent border-sky-200/70 bg-sky-100/88 shadow-sm">
            <p class="ops-stat-label text-sky-700">Completed</p>
            <p class="ops-stat-value text-sky-950">{{ $serviceRequests->where('status', 'completed')->count() }}</p>
        </div>
        {{-- total service charges --}}
        <div class="ops-stat-card border-sky-200/70 bg-white/78 shadow-sm">
            <p class="ops-stat-label text-sky-700">Service Charges</p>
            <p class="ops-stat-value text-sky-950">Qr {{ $serviceRequests->pluck('serviceCharge.amount')->sum() }}</p>
        </div>

        <div class="ops-stat-card border-sky-200/70 bg-white/78 shadow-sm">
            <p class="ops-stat-label text-sky-700">In Progress</p>
            <p class="ops-stat-value text-sky-950">{{ $serviceRequests->where('status', 'in_progress')->count() }}</p>
        </div>

    </section>

    <section class="grid grid-cols-1 gap-6 ">
        <div class="xl:col-span-2 ops-panel border-sky-200/70 bg-white/84 shadow-[0_24px_60px_-36px_rgba(59,130,246,0.18)]">
            <div class="ops-panel-header border-sky-200/70 bg-sky-100/72">
                <div>
                    <h2 class="ops-panel-title text-sky-950">Service Request Records</h2>
                    <p class="ops-panel-copy text-sky-700/85">Filter request records by state while keeping charges, hours, and assignments visible.</p>
                </div>
                {{-- <div class="inline-flex rounded-full border border-sky-200/80 bg-white/78 p-1 shadow-sm">
                    <button type="button" class="rounded-full px-3 py-1.5 text-xs font-medium transition" :class="tab === 'all' ? 'bg-sky-300 text-sky-950 shadow-sm' : 'text-sky-800 hover:bg-sky-100'" @click="tab = 'all'">All</button>
                    <button type="button" class="rounded-full px-3 py-1.5 text-xs font-medium transition" :class="tab === 'completed' ? 'bg-sky-300 text-sky-950 shadow-sm' : 'text-sky-800 hover:bg-sky-100'" @click="tab = 'completed'">Completed</button>
                    <button type="button" class="rounded-full px-3 py-1.5 text-xs font-medium transition" :class="tab === 'open' ? 'bg-sky-300 text-sky-950 shadow-sm' : 'text-sky-800 hover:bg-sky-100'" @click="tab = 'open'">Open</button>
                </div> --}}
            </div>

            {{-- @dump($serviceRequests); --}}



            <div class="overflow-x-auto">
                <table class="w-full min-w-225 text-sm">
                    <thead>
                        <tr class="ops-table-head border-sky-300/18 bg-sky-950/85 text-white/85">
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
                    <tbody class="ops-table-body bg-sky-900/72 text-white">
                        @foreach ($serviceRequests as $request)
                            @php
                                $status = strtolower($request->status);
                                $isCompleted = $status === 'completed';
                                $isOpen = in_array($status, ['in progress', 'pending']);
                            @endphp

                            {{-- @dump($request) --}}


                            <tr
                                {{-- x-show="tab === 'all' || (tab === 'completed' && {{ $isCompleted ? 'true' : 'false' }}) || (tab === 'open' && {{ $isOpen ? 'true' : 'false' }})" --}}
                                class="align-top transition hover:bg-sky-800/70"
                            >

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-white">{{ $request->id }}</p>
                                </td>
                                <td class="px-5 py-4">
                                    {{-- <p class="font-semibold text-zinc-900">{{ $request['code'] }}</p> --}}
                                    <p class="mt-1 text-xs text-white">
                                        {{ $request->client->name }}
                                    </p>
                                    <p class="text-xs text-white/80">Requested on {{ $request->service_request_date }}</p>
                                </td>
                                <td class="px-5 py-4 text-white">
                                    {{ $request->serviceRequestPeriods?->first()?->service->name ?? 'N/A' }}
                                </td>

                                 <td class="px-5 py-4 text-white">
                                    {{ $request->frequency ? ucfirst($request->frequency) : 'N/A' }}
                                </td>



                                <td class="px-5 py-4">
                                     <p class="font-semibold text-white">{{ number_format($request->serviceRequestPeriods?->sum('duration_hours') ?? 0, 0) }} hrs</p>
                                     <div class="mt-2 h-1.5 w-24 rounded-full bg-sky-950/60">
                                         <div class="h-1.5 rounded-full bg-sky-500" style="width: {{ min(100, ($request->serviceRequestPeriods?->sum('duration_hours') ?? 0) * 20) }}%"></div>
                                    </div>
                                </td>

                                {{-- service charge --}}

                                @if ($request->serviceCharge)
                                    <td class="px-5 py-4">
                                        <p class="font-semibold text-white">{{ $request->serviceCharge?->amount ? 'QR ' . number_format($request->serviceCharge->amount, 0) : 'N/A' }}</p>
                                        <p class="mt-1 text-xs text-white/80">{{ $request->serviceCharge?->invoice_date ? \Carbon\Carbon::parse($request->serviceCharge->invoice_date)->toDateString() : 'N/A' }}</p>
                                    </td>

                                @else

                                    <td class="px-5 py-4">
                                        <span class="text-xs text-white/80">N/A</span>
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




                                <td class="px-5 py-4">
                                    @if ($request->serviceRequestPeriods?->isNotEmpty())

                                    {{-- @dump($request->serviceRequestPeriods->maids?>->count()) --}}

                                        {{-- @dump($request->assignedMaids) --}}
                                        <div class="flex items-center gap-1">
                                           <span class="rounded-full border border-sky-300/24 bg-sky-400/16 px-2.5 py-1 text-xs font-semibold text-sky-100">{{ $request->assignedMaids?->groupBy('maid_id')?->count() ?? 0  }}</span>
                                            <span class="text-sm font-medium text-white">
                                                {{ $request->assignedMaids?->groupBy('maid_id')?->map(fn($group) => $group->first()->maid?->name)->join(', ') ?? 'N/A' }}
                                            </span>

                                        </div>
                                    @else
                                        <span class="text-xs text-white/80">No maid assigned</span>
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


                                <td class="flex items-center gap-2 px-5 py-4">
                                    <a href="
                                    {{ route('service-request-view', ['id' => $request->id]) }}" class="inline-flex items-center rounded-full border border-sky-300/24 bg-sky-400/16 px-3 py-1.5 text-xs font-semibold text-sky-100 transition hover:bg-sky-400/24">view</a>

                                     <a href="
                                    {{ route('new-service-request', ['id' => $request->id]) }}" class="inline-flex items-center rounded-full border border-sky-300/24 bg-sky-400/16 px-3 py-1.5 text-xs font-semibold text-sky-100 transition hover:bg-sky-400/24">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

</div>
