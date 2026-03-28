<div>
    {{-- will show the service request and service requet perionds details --}}

    <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
        <h3 class="">Service Request Detailssss</h3>
        {{-- @dump($serviceRequest) --}}

        <div class="flex justify-end gap-4 mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
            <button class="btn-filter">Assign Cleaner</button>
            <button class="btn-filter">Quotation</button>
        </div>

        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
            {{-- <p><strong>Code:</strong> {{ $serviceRequest->code }}</p> --}}
            <p><strong>Client:</strong> {{ $serviceRequest->client?->name }}</p>
            <p><strong>Requested Date:</strong> {{ $serviceRequest->service_request_date }}</p>
            <p><strong>Status:</strong> {{ $serviceRequest->status }}</p>

        </div>

        {{-- service request periods details --}}

           {{-- @dump($serviceRequest->has('maids')) --}}

        @if ($serviceRequest->serviceRequestPeriods->isNotEmpty())

        {{-- display in a table --}}

            <div class="table-overflow">
                <table class="min-w-full bg-white border border-gray-200 rounded">
                    <thead>
                        <tr class="bg-gray-100  ">
                            <th class="px-4 py-2 border-b text-left">#</th>
                            <th class="px-4 py-2 border-b text-left">Service Type</th>
                            <th class="px-4 py-2 border-b text-left">Start Date</th>
                            <th class="px-4 py-2 border-b text-left">Start Time</th>
                            <th class="px-4 py-2 border-b text-left">End Time</th>
                            <th class="px-4 py-2 border-b text-left">Total Hours</th>
                            <th class="px-4 py-2 border-b text-left">Assigned Cleaner</th>
                            <th class="px-4 py-2 border-b text-left">Quotation Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($serviceRequest->serviceRequestPeriods as $period)


                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ $period->id }}</td>
                                <td class="px-4 py-2 border-b">{{ $period->service?->name }}</td>
                                <td class="px-4 py-2 border-b">{{ $period->start_date }}</td>
                                <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }}</td>
                                <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($period->start_time)->addHours(intval($period->duration_hours))->format('g:i A') }}</td>
                                <td class="px-4 py-2 border-b">{{ number_format($period->duration_hours, 1) }} hours</td>
                                <td class="px-4 py-2 border-b">{{ $period->maidAssignments?->pluck('maid.name')->join(', ') ?? 'Not Assigned' }}</td>
                                <td class="px-4 py-2 border-b">{{ $period->quotation_value ?? 'N/A' }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="p-4 bg-yellow-100 text-yellow-800 rounded">
                No Service Request Found
            </div>
        @endif

        </div>

</div>
