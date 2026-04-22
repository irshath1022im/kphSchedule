<div class="ops-page">

    {{-- @dump($grouped) --}}

<div class="ops-shell w-full max-w-none space-y-6 border-sky-200/70 bg-black text-sky-900 shadow-[0_24px_80px_-36px_rgba(59,130,246,0.24)]" x-data="{ tab: 'all' }">


    @if (session('message'))
        <div class="mb-4 rounded-lg border border-sky-200/70 bg-sky-100/80 p-4 text-sm text-sky-800">
            {{ session('message') }}
        </div>
    @endif



    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ route('new-service-request') }}" class="ops-btn-primary">New Service Request</a>
        <div class="rounded-full border border-sky-200/80 bg-white/75 px-4 py-2 text-sm font-medium text-sky-800 shadow-sm">
            Last updated: {{ now()->format('M d, Y h:i A') }}
        </div>
    </div>

    <section class="space-y-4">
        <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="ops-eyebrow text-sky-700">Frequency Overview</p>
                <h2 class="ops-title text-2xl text-sky-950">Latest 5 Records By Frequency</h2>
            </div>
            <p class="text-sm text-sky-700/85">Grouped by individual frequency type</p>
        </div>

        @if ($serviceRequests->isEmpty())
            <div class="rounded-2xl border border-sky-200/80 bg-white/80 p-5 text-sm text-sky-800 shadow-sm">
                No service requests found.
            </div>
        @else
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 2xl:grid-cols-3">
                @foreach ($serviceRequests as $frequency => $requests)
                    @php
                        $themes = [
                            [
                                'card' => 'border-emerald-300/60 bg-emerald-50/90',
                                'head' => 'border-emerald-200',
                                'title' => 'text-emerald-950',
                                'badge' => 'border-emerald-300 bg-emerald-100 text-emerald-900',
                                'item' => 'border-emerald-200/70 bg-white/90',
                                'service' => 'text-emerald-700',
                                'status' => 'bg-emerald-100 text-emerald-800',
                                'meta' => 'text-emerald-700/85',
                                'view' => 'text-emerald-800 hover:text-emerald-950',
                                'charge' => 'text-emerald-900',
                                'chargeMeta' => 'text-emerald-700/85',
                                'empty' => 'text-emerald-700/85',
                            ],
                            [
                                'card' => 'border-amber-300/60 bg-amber-50/90',
                                'head' => 'border-amber-200',
                                'title' => 'text-amber-950',
                                'badge' => 'border-amber-300 bg-amber-100 text-amber-900',
                                'item' => 'border-amber-200/70 bg-white/90',
                                'service' => 'text-amber-700',
                                'status' => 'bg-amber-100 text-amber-800',
                                'meta' => 'text-amber-700/85',
                                'view' => 'text-amber-800 hover:text-amber-950',
                                'charge' => 'text-amber-900',
                                'chargeMeta' => 'text-amber-700/85',
                                'empty' => 'text-amber-700/85',
                            ],
                            [
                                'card' => 'border-rose-300/60 bg-rose-50/90',
                                'head' => 'border-rose-200',
                                'title' => 'text-rose-950',
                                'badge' => 'border-rose-300 bg-rose-100 text-rose-900',
                                'item' => 'border-rose-200/70 bg-white/90',
                                'service' => 'text-rose-700',
                                'status' => 'bg-rose-100 text-rose-800',
                                'meta' => 'text-rose-700/85',
                                'view' => 'text-rose-800 hover:text-rose-950',
                                'charge' => 'text-rose-900',
                                'chargeMeta' => 'text-rose-700/85',
                                'empty' => 'text-rose-700/85',
                            ],
                        ];

                        $theme = $themes[$loop->index % count($themes)];
                    @endphp

                    <article class="rounded-2xl border p-4 shadow-sm {{ $theme['card'] }}">
                        <div class="mb-3 flex items-center justify-between gap-3 border-b pb-3 {{ $theme['head'] }}">
                            <h3 class="text-base font-semibold {{ $theme['title'] }}">{{ $frequency }}</h3>
                            <a href="{{ route('service-request-summary-frequency', ['frequency' => $frequency]) }}" class="rounded-full border px-2.5 py-1 text-xs font-semibold {{ $theme['badge'] }}">
                               view all
                            </a>
                        </div>

                        <div class="space-y-2.5">
                            @foreach ($requests as $request)
                                <div class="rounded-xl border p-3 {{ $theme['item'] }}">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold {{ $theme['title'] }}">#{{ $request->id }} {{ $request->client?->name ? '- ' . $request->client->name : '' }}</p>
                                            <p class="text-xs {{ $theme['service'] }}">
                                                {{ $request->serviceRequestPeriods?->first()?->service?->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <span class="rounded-full px-2 py-0.5 text-[11px] font-semibold capitalize {{ $theme['status'] }}">{{ str_replace('_', ' ', $request->status) }}</span>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between gap-2 text-xs {{ $theme['meta'] }}">
                                        <span>{{ $request->service_request_date ? \Illuminate\Support\Carbon::parse($request->service_request_date)->format('M d, Y') : 'No date' }}</span>
                                        <a href="{{ route('service-request-view', ['id' => $request->id]) }}" class="font-semibold {{ $theme['view'] }}">View</a>
                                    </div>

                                    {{-- service charge --}}

                                    <div>
                                        @if ($request->serviceCharge)
                                            <p class="mt-2 text-xs {{ $theme['charge'] }}">
                                                Charge: {{ $request->serviceCharge?->amount ? 'QR ' . number_format($request->serviceCharge->amount, 0) : 'N/A' }}
                                            </p>
                                            <p class="text-xs {{ $theme['chargeMeta'] }}">
                                                Invoice Date: {{ $request->serviceCharge?->invoice_date ? \Carbon\Carbon::parse($request->serviceCharge->invoice_date)->toDateString() : 'N/A' }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-xs {{ $theme['empty'] }}">No charge information</p>
                                        @endif
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>



</div>




</div>
