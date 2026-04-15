<div>
 {{-- @dump($bookings) --}}

    <h3 class="mb-4 text-2xl font-black tracking-tight text-zinc-100">Today {{ $selectedDate->format('F j, Y') }} Schedule</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($bookings as $booking)
            <div class="rounded-2xl border border-zinc-700 bg-zinc-900/75 p-4 shadow-sm ring-1 ring-white/5">
                <h4 class="mb-2 text-lg font-semibold text-zinc-100">{{ $booking->service->name }}</h4>
                <p class="text-zinc-300">Requested Date: {{ \Carbon\Carbon::parse($booking->serviceRequest->requested_date)->format('F j, Y') }}</p>

                <p class="mb-1 text-cyan-200">Time: {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</p>

                <p class="text-zinc-300">Requested Hours : {{ $booking->duration_hours }}</p>
                <p class="mb-1 text-zinc-400">Client: {{ $booking->serviceRequest->client->name }}</p>
                <p class="mb-1 text-zinc-400">Status: {{ $booking->serviceRequest->status }}</p>
            </div>
        @endforeach

</div>

