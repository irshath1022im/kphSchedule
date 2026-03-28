<div>
 {{-- @dump($bookings) --}}

    <h3>Today {{ $selectedDate->format('F j, Y') }} Schedule</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach ($bookings as $booking)
            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="text-lg font-semibold mb-2">{{ $booking->service->name }}</h4>
                <p>Requested Date: {{ \Carbon\Carbon::parse($booking->serviceRequest->requested_date)->format('F j, Y') }}</p>

                <p class="text-gray-600 mb-1">Time: {{ \Carbon\Carbon::parse($booking->start_time)->format('g:i A') }}</p>

                <p>Requested Hours : {{ $booking->duration_hours }}</p>
                <p class="text-gray-600 mb-1">Client: {{ $booking->serviceRequest->client->name }}</p>
                <p class="text-gray-600 mb-1">Status: {{ $booking->serviceRequest->status }}</p>
            </div>
        @endforeach

</div>

