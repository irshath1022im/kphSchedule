<div class="ops-page">
    <div class="ops-shell">
 {{-- @dump($bookings) --}}

    <div class="ops-hero">
        <p class="ops-eyebrow">Daily Schedule</p>
        <h3 class="ops-title">{{ $selectedDate->format('F j, Y') }} Schedule</h3>
        <p class="ops-subtitle">Today’s assigned bookings with timing, client, and request status in the shared blue operations theme.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($bookings as $booking)
            <div class="ops-panel p-5">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h4 class="mb-2 text-lg font-semibold text-slate-50">{{ $booking->service->name }}</h4>
                        <p class="text-sm text-slate-300">Requested Date: {{ \Carbon\Carbon::parse($booking->serviceRequest->requested_date)->format('F j, Y') }}</p>
                    </div>
                    <span class="ops-status-chip ops-status-busy">{{ $booking->serviceRequest->status }}</span>
                </div>

                <p class="mt-3 text-sm text-cyan-100">Time: {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</p>

                <div class="mt-4 space-y-2 text-sm text-slate-300">
                    <p>Requested Hours: {{ $booking->duration_hours }}</p>
                    <p>Client: {{ $booking->serviceRequest->client->name }}</p>
                </div>
            </div>
        @endforeach

    </div>

    </div>
</div>

