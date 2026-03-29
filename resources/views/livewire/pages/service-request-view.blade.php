<div x-data="{
    showAssignCleanerModal: false,
    showScheduleModal: false,

    }" @keydown.escape.window="showAssignCleanerModal = false">
    {{-- will show the service request and service requet perionds details --}}

    <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
        <h3 class="">Service Request Detailssss</h3>
        {{-- @dump($serviceRequest) --}}

        <div class="flex justify-end gap-4 mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
            <button x-on:click="showScheduleModal = true" class="btn-filter">Schedule</a>
            <button type="button" class="btn-filter" @click="showAssignCleanerModal = true">Assign Cleaner</button>
            <button class="btn-filter">Quotation</button>
        </div>

        <div class="mb-4 p-4 bg-gray-50 border border-gray-200 rounded">
            {{-- <p><strong>Code:</strong> {{ $serviceRequest->code }}</p> --}}
            <p><strong>Client:</strong> {{ $serviceRequest->client?->name }}</p>
            <p><strong>Requested Date:</strong> {{ $serviceRequest->service_request_date }}</p>
            <p><strong>Status:</strong> {{ $serviceRequest->status }}</p>
            <p><strong>Frequency:</strong> {{ $serviceRequest->frequency }}</p>
            <p><strong>Notes:</strong> {{ $serviceRequest->notes }}</p>
            <p><a href="{{ route('new-service-request', ['id' => $serviceRequest->id]) }}" class="btn-filter">Edit</a></p>

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
                            <th class="px-4 py-2 border-b text-left">End Date</th>
                            <th class="px-4 py-2 border-b text-left">Day of Week</th>
                            <th class="px-4 py-2 border-b text-left">Total Hours</th>
                            <th class="px-4 py-2 border-b text-left">Assigned Cleaner</th>
                            <th class="px-4 py-2 border-b text-left">Quotation Value</th>
                            <th class="px-4 py-2 border-b text-left">Actions</th>
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
                                 <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($period->start_date)->format('l') }}</td>
                                <td class="px-4 py-2 border-b">{{ number_format($period->duration_hours, 1) }} hours</td>
                                <td class="px-4 py-2 border-b">{{ $period->maidAssignments?->pluck('maid.name')->join(', ') ?? 'Not Assigned' }}</td>
                                <td class="px-4 py-2 border-b">{{ $period->quotation_value ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border-b">
                                    <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600"
                                        wire:click="deletePeriod({{ $period->id }})" wire:loading.attr="disabled" wire:confirm="Are you sure you want to delete this service period?"
                                    >Delete</button>
                                </td>

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





    {{-- Assign Cleaner modal popup --}}
    <div
        x-show="showScheduleModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        aria-labelledby="assign-cleaner-modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="absolute inset-0 bg-black/50"
            @click="showScheduleModal = false"
            aria-hidden="true"
        ></div>

        <div
            x-show="showScheduleModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl"
        >
            <div class="flex items-start justify-between">
                <h3 id="assign-cleaner-modal-title" class="text-lg font-semibold text-gray-900">Assign Cleaner</h3>
                <button
                    type="button"
                    class="rounded px-2 py-1 text-gray-600 hover:bg-gray-100"
                    @click="showScheduleModal = false"
                    aria-label="Close modal"
                >
                    x
                </button>
            </div>

            <div class="mt-4 text-sm text-gray-700">
                @livewire('forms.new-service-schedule', ['id' => $id])
            </div>
        </div>
    </div>
</div>
