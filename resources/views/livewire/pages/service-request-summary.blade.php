<div class="space-y-6 p-6" x-data="{ tab: 'all' }">

    @if (session('message'))
        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700 dark:bg-green-900/20 dark:text-green-300">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('new-service-request') }}" class="px-4 py-2 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700">New Service Request</a>

    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Service Request Summary</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Track service requested, service-hour history, completion status, and client review performance.</p>
        </div>
        <div class="rounded-lg border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-200">
            Last updated: {{ now()->format('M d, Y h:i A') }}
        </div>
    </div>

    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Total Requests</p>
            <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $serviceRequests->count() }}</p>
        </div>
        <div class="rounded-xl border border-zinc-200 bg-white p-4 dark:border-zinc-700 dark:bg-zinc-900">
            <p class="text-xs font-medium uppercase tracking-wide text-zinc-500">Total Service Hours</p>
            <p class="mt-2 text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($serviceRequests->pluck('serviceRequestPeriods')->flatten()->sum('duration_hours'), 1) }}</p>
        </div>
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 dark:border-emerald-800 dark:bg-emerald-900/20">
            <p class="text-xs font-medium uppercase tracking-wide text-emerald-700 dark:text-emerald-300">Completed</p>
            <p class="mt-2 text-3xl font-bold text-emerald-700 dark:text-emerald-300">{{ $serviceRequests->where('status', 'completed')->count() }}</p>
        </div>
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-800 dark:bg-blue-900/20">
            <p class="text-xs font-medium uppercase tracking-wide text-blue-700 dark:text-blue-300">In Progress</p>
            <p class="mt-2 text-3xl font-bold text-blue-700 dark:text-blue-300">{{ $serviceRequests->where('status', 'in_progress')->count() }}</p>
        </div>
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 dark:border-amber-800 dark:bg-amber-900/20">
            <p class="text-xs font-medium uppercase tracking-wide text-amber-700 dark:text-amber-300">Pending + Cancelled</p>
            <p class="mt-2 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $serviceRequests->whereIn('status', ['pending', 'cancelled'])->count() }}</p>
        </div>
    </section>

    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex flex-col gap-4 border-b border-zinc-100 px-5 py-4 dark:border-zinc-700 sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Service Request Records</h2>
                <div class="inline-flex rounded-lg border border-zinc-200 bg-zinc-50 p-1 dark:border-zinc-700 dark:bg-zinc-800">
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'all' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="tab = 'all'">All</button>
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'completed' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="tab = 'completed'">Completed</button>
                    <button type="button" class="rounded-md px-3 py-1.5 text-xs font-medium" :class="tab === 'open' ? 'bg-white text-zinc-900 shadow-sm dark:bg-zinc-900 dark:text-zinc-100' : 'text-zinc-600 dark:text-zinc-300'" @click="tab = 'open'">Open</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-225 text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 text-left dark:border-zinc-700">
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Request</th>
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Service Requested</th>
                             <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Frequency</th>
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Service Hours</th>
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Completion Status</th>
                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">Assigned Maid </span></th>

                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700">
                        @foreach ($serviceRequests as $request)
                            @php
                                $status = strtolower($request->status);
                                $isCompleted = $status === 'completed';
                                $isOpen = in_array($status, ['in progress', 'pending']);
                            @endphp
                            <tr
                                x-show="tab === 'all' || (tab === 'completed' && {{ $isCompleted ? 'true' : 'false' }}) || (tab === 'open' && {{ $isOpen ? 'true' : 'false' }})"
                                class="align-top hover:bg-zinc-50 dark:hover:bg-zinc-800/40"
                            >
                                <td class="px-5 py-4">
                                    {{-- <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $request['code'] }}</p> --}}
                                    <p class="mt-1 text-xs text-zinc-500">
                                        {{ $request->client->name }}
                                    </p>
                                    <p class="text-xs text-zinc-500">Requested on {{ $request->service_request_date }}</p>
                                </td>
                                <td class="px-5 py-4 text-zinc-700 dark:text-zinc-200">
                                    {{ $request->serviceRequestPeriods?->first()?->service->name ?? 'N/A' }}
                                </td>

                                 <td class="px-5 py-4 text-zinc-700 dark:text-zinc-200">
                                    {{ $request->frequency ? ucfirst($request->frequency) : 'N/A' }}
                                </td>

                                <td class="px-5 py-4">
                                    <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ number_format($request->serviceRequestPeriods?->sum('duration_hours') ?? 0, 1) }} hrs</p>
                                    <div class="mt-2 h-1.5 w-24 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                         <div class="h-1.5 rounded-full bg-blue-500" style="width: {{ min(100, ($request->serviceRequestPeriods?->sum('duration_hours') ?? 0) * 20) }}%"></div>
                                    </div>
                                </td>

                                <td class="px-5 py-4">
                                    @if ($request->status === 'completed')
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">Completed</span>
                                    @elseif ($request->status === 'in progress')
                                        <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">In Progress</span>
                                    @elseif ($request->status === 'pending')
                                        <span class="inline-flex rounded-full bg-amber-100 px-2.5 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">Pending</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-zinc-200 px-2.5 py-1 text-xs font-semibold text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300">Cancelled</span>
                                    @endif
                                </td>


                            {{--  Assigned Maid --}}



                                <td class="px-5 py-4">
                                    @if ($request->serviceRequestPeriods?->isNotEmpty())

                                    {{-- @dump($request->serviceRequestPeriods->maids?>->count()) --}}

                                        {{-- @dump($request->assignedMaids) --}}
                                        <div class="flex items-center gap-1">
                                           <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $request->assignedMaids->count() }}</span>
                                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                                {{ $request->assignedMaids?->pluck('maid.name')->join(', ') }}
                                            </span>

                                        </div>
                                    @else
                                        <span class="text-xs text-zinc-500">No maid assigned</span>
                                    @endif
                                </td>
                                {{-- <td class="px-5 py-4">
                                    @if ($request->review > 0)
                                        <div class="flex items-center gap-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="size-3.5 {{ $i <= $request->review ? 'text-amber-400' : 'text-zinc-300 dark:text-zinc-600' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">

                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87L18.18 21 12 17.77 5.82 21 7 14.14 2 9.27l6.91-1.01L12 2z" />
                                                </svg>
                                            @endfor
                                            <span class="ml-1 text-xs font-semibold text-zinc-700 dark:text-zinc-200">{{ $request->review }}/5</span>
                                        </div>
                                        <p class="mt-1 max-w-55 text-xs text-zinc-500">{{ $request->comment }}</p>
                                    @else
                                        <span class="text-xs text-zinc-500">No review yet</span>
                                        <p class="mt-1 max-w-55 text-xs text-zinc-500">{{ $request->comment }}</p>
                                    @endif
                                </td> --}}


                                <td class="px-5 py-4 flex items-center gap-2">
                                    <a href="
                                    {{ route('service-request-view', ['id' => $request->id]) }}" class="text-blue-500 hover:text-blue-700 border border-blue-500 rounded px-2 py-1">view</a>

                                     <a href="
                                    {{ route('new-service-request', ['id' => $request->id]) }}" class="text-blue-500 hover:text-blue-700 border border-blue-500 rounded px-2 py-1">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Service Hours History</h2>
                <p class="mt-1 text-xs text-zinc-500">Weekly service-hour trend</p>

                <div class="mt-4 space-y-4">
                    @foreach ($serviceRequests->pluck('serviceRequestPeriods')->flatten() as $item)
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-600 dark:text-zinc-300">
                                <span>{{ $item->period }}</span>
                                <span class="font-semibold">{{ $item->duration_hours }} hrs</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                {{-- <div class="h-2 rounded-full bg-indigo-500" style="width: {{ round(($item->duration_hours / $maxHistoryHours) * 100) }}%"></div> --}}
                            </div>


                        </div>
                    @endforeach
                </div>
            </div>

            {{-- <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Completion Status Breakdown</h2>
                <div class="mt-4 space-y-3 text-sm">
                    <div class="flex items-center justify-between"><span class="text-zinc-600 dark:text-zinc-300">Completed</span><span class="font-semibold text-emerald-600">{{ $completedCount }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600 dark:text-zinc-300">In Progress</span><span class="font-semibold text-blue-600">{{ $inProgressCount }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600 dark:text-zinc-300">Pending</span><span class="font-semibold text-amber-600">{{ $pendingCount }}</span></div>
                    <div class="flex items-center justify-between"><span class="text-zinc-600 dark:text-zinc-300">Cancelled</span><span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ $cancelledCount }}</span></div>
                </div>
            </div> --}}

            {{-- <div class="rounded-xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Client Review Summary</h2>
                <p class="mt-1 text-xs text-zinc-500">Average rating: <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $avgReview }}/5</span></p>

                <div class="mt-4 space-y-2">
                    @for ($star = 5; $star >= 1; $star--)
                        @php
                            $count = $ratingBreakdown[$star];
                            $width = $reviewed->count() > 0 ? round(($count / $reviewed->count()) * 100) : 0;
                        @endphp
                        <div>
                            <div class="mb-1 flex items-center justify-between text-xs text-zinc-600 dark:text-zinc-300">
                                <span>{{ $star }} Star</span>
                                <span>{{ $count }}</span>
                            </div>
                            <div class="h-2 rounded-full bg-zinc-100 dark:bg-zinc-700">
                                <div class="h-2 rounded-full bg-amber-400" style="width: {{ $width }}%"></div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div> --}}
        </div>
    </section>
</div>
