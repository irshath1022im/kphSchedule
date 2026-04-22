<div class="ops-page">
    @php
        $requests = $client->serviceRequests;
        $totalRequests = $requests->count();
        $completedCount = $requests->where('status', 'completed')->count();
        $inProgressCount = $requests->whereIn('status', ['in progress', 'in_progress'])->count();
        $totalEarnings = $requests->pluck('serviceCharge.amount')->sum();
    @endphp

    <div class="ops-shell w-full max-w-none space-y-6 border-sky-200/70 bg-white/80 text-sky-900 shadow-[0_24px_80px_-36px_rgba(59,130,246,0.24)]">
        <section class="ops-hero border-sky-200/80 bg-linear-to-br from-sky-100 via-cyan-100 to-emerald-100 shadow-[inset_0_1px_0_rgba(255,255,255,0.6)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="ops-eyebrow text-sky-700">Client Profile</p>
                    <h1 class="ops-title text-sky-950">{{ $client->name }}</h1>
                    <p class="mt-2 text-sm text-sky-800/90">Client ID #{{ $client->id }} • Manage overview, contact info, and service requests in one place.</p>
                </div>
                <a href="{{ route('clients') }}" class="inline-flex items-center rounded-full border border-sky-200/80 bg-white/80 px-4 py-2 text-sm font-semibold text-sky-800 shadow-sm transition hover:bg-white">
                    Back to Clients
                </a>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-2xl border border-sky-200/70 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-sky-700">Total Requests</p>
                <p class="mt-2 text-2xl font-bold text-sky-950">{{ $totalRequests }}</p>
            </article>
            <article class="rounded-2xl border border-emerald-200/80 bg-emerald-50/70 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Completed</p>
                <p class="mt-2 text-2xl font-bold text-emerald-950">{{ $completedCount }}</p>
            </article>
            <article class="rounded-2xl border border-amber-200/80 bg-amber-50/70 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-amber-700">In Progress</p>
                <p class="mt-2 text-2xl font-bold text-amber-950">{{ $inProgressCount }}</p>
            </article>
            <article class="rounded-2xl border border-indigo-200/80 bg-indigo-50/70 p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-indigo-700">Total Earnings</p>
                <p class="mt-2 text-2xl font-bold text-indigo-950">QR {{ number_format($totalEarnings, 2) }}</p>
            </article>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <article class="rounded-2xl border border-sky-200/70 bg-white p-5 shadow-sm xl:col-span-1">
                <h2 class="text-base font-semibold text-sky-950">Contact & Address</h2>
                <div class="mt-4 space-y-3 text-sm text-sky-800">
                    <p><span class="font-semibold text-sky-950">Email:</span> {{ $client->email ?: 'N/A' }}</p>
                    <p><span class="font-semibold text-sky-950">Phone:</span> {{ $client->phone ?: 'N/A' }}</p>
                    <p><span class="font-semibold text-sky-950">Location:</span> {{ $client->location ?: 'N/A' }}</p>
                    <p><span class="font-semibold text-sky-950">Address:</span> {{ $client->address ?: 'N/A' }}</p>
                    <p><span class="font-semibold text-sky-950">Notes:</span> {{ $client->notes ?: 'No notes available.' }}</p>
                </div>
            </article>

            <article class="rounded-2xl border border-sky-200/70 bg-white p-5 shadow-sm xl:col-span-2">
                <div class="mb-4 flex items-center justify-between gap-3">
                    <h2 class="text-base font-semibold text-sky-950">Service Requests</h2>
                    <span class="rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold text-sky-800">{{ $totalRequests }} records</span>
                </div>

                @if ($requests->isNotEmpty())
                    <div class="space-y-3">
                        @foreach ($requests as $request)
                            @php
                                $status = strtolower($request->status ?? '');
                                $statusClasses = match ($status) {
                                    'completed' => 'border-emerald-200 bg-emerald-100 text-emerald-900',
                                    'in progress', 'in_progress' => 'border-amber-200 bg-amber-100 text-amber-900',
                                    'pending' => 'border-sky-200 bg-sky-100 text-sky-900',
                                    default => 'border-zinc-200 bg-zinc-100 text-zinc-800',
                                };
                            @endphp

                            <div class="rounded-xl border border-sky-100 bg-sky-50/35 p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="space-y-1">
                                        <p class="text-sm font-semibold text-sky-950">Request #{{ $request->id }}</p>
                                        <p class="text-xs text-sky-800">Frequency: {{ $request->frequency ? ucfirst($request->frequency) : 'N/A' }}</p>
                                        <p class="text-xs text-sky-700/90">Date: {{ $request->service_request_date ? \Carbon\Carbon::parse($request->service_request_date)->format('M d, Y') : 'N/A' }}</p>
                                        <p class="text-xs text-sky-700/90">Charge: {{ $request->serviceCharge?->amount ? 'QR ' . number_format($request->serviceCharge->amount, 2) : 'N/A' }}</p>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="rounded-full border px-2.5 py-1 text-xs font-semibold capitalize {{ $statusClasses }}">{{ str_replace('_', ' ', $request->status) }}</span>
                                        <a href="{{ route('service-request-view', ['id' => $request->id]) }}" class="inline-flex items-center rounded-full border border-sky-200 bg-white px-3 py-1.5 text-xs font-semibold text-sky-800 transition hover:bg-sky-100">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-sky-200 bg-sky-50/50 p-5 text-sm text-sky-800">
                        No service requests found for this client.
                    </div>
                @endif
            </article>
        </section>
    </div>
</div>
