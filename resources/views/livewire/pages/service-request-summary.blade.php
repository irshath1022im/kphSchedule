<div class="ops-page">

    {{-- @dump($grouped) --}}

<div class="ops-shell w-full max-w-none space-y-6 border-sky-200/70 bg-white/72 text-sky-900 shadow-[0_24px_80px_-36px_rgba(59,130,246,0.24)]" x-data="{ tab: 'all' }">


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
                    <article class="rounded-2xl border border-sky-200/80 bg-white/85 p-4 shadow-sm">
                        <div class="mb-3 flex items-center justify-between gap-3 border-b border-sky-100 pb-3">
                            <h3 class="text-base font-semibold text-sky-950">{{ $frequency }}</h3>
                            <a href="{{ route('service-request-summary-frequency', ['frequency' => $frequency]) }}" class="rounded-full border border-sky-200 bg-sky-100 px-2.5 py-1 text-xs font-semibold text-sky-800">
                               view all
                            </a>
                        </div>

                        <div class="space-y-2.5">
                            @foreach ($requests as $request)
                                <div class="rounded-xl border border-sky-100 bg-sky-50/50 p-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-sky-950">#{{ $request->id }} {{ $request->client?->name ? '- ' . $request->client->name : '' }}</p>
                                            <p class="text-xs text-sky-700">
                                                {{ $request->serviceRequestPeriods?->first()?->service?->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        <span class="rounded-full bg-white px-2 py-0.5 text-[11px] font-semibold text-sky-700 capitalize">{{ str_replace('_', ' ', $request->status) }}</span>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between gap-2 text-xs text-sky-700/85">
                                        <span>{{ $request->service_request_date ? \Illuminate\Support\Carbon::parse($request->service_request_date)->format('M d, Y') : 'No date' }}</span>
                                        <a href="{{ route('service-request-view', ['id' => $request->id]) }}" class="font-semibold text-sky-800 hover:text-sky-950">View</a>
                                    </div>

                                    {{-- service charge --}}

                                    <div>
                                        @if ($request->serviceCharge)
                                            <p class="mt-2 text-xs text-blue-900">
                                                Charge: {{ $request->serviceCharge?->amount ? 'QR ' . number_format($request->serviceCharge->amount, 0) : 'N/A' }}
                                            </p>
                                            <p class="text-xs text-sky-700/85">
                                                Invoice Date: {{ $request->serviceCharge?->invoice_date ? \Carbon\Carbon::parse($request->serviceCharge->invoice_date)->toDateString() : 'N/A' }}
                                            </p>
                                        @else
                                            <p class="mt-2 text-xs text-sky-700/85">No charge information</p>
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
