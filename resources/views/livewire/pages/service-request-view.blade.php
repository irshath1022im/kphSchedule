<div
    x-data="{
        showAssignCleanerModal: @entangle('showAssignCleanerModal'),
        showScheduleModal: @entangle('showScheduleModal'),
    }"
    x-cloak
>
    <div class="space-y-6">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Service Request Details</h2>
                    <p class="mt-1 text-sm text-gray-500">Review schedule periods, cleaner assignments, and quotation values.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <button x-on:click="showScheduleModal = true" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                        Schedule
                    </button>
                    <button x-on:click="showAssignCleanerModal = true" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
                        Assign Cleaner
                    </button>
                    <a href="{{ route('new-service-charge', ['sr' => $serviceRequest->id ]) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Service Charge
                    </a>

                    <a href="{{ route('new-service-request', ['id' => $serviceRequest->id]) }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                        Edit Request
                    </a>
                </div>
            </div>

            <div class="mt-5 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Client</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $serviceRequest->client?->name ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Requested Date</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $serviceRequest->service_request_date ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Status</p>
                    <p class="mt-1 inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-800">{{ $serviceRequest->status ?? 'N/A' }}</p>
                </div>
                <div class="rounded-lg border border-gray-200 bg-gray-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Frequency</p>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ $serviceRequest->frequency ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-3">
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Notes</p>
                <p class="mt-1 text-sm text-gray-700">{{ $serviceRequest->notes ?: 'No notes provided.' }}</p>
            </div>

            {{-- service charge --}}
            @if($serviceRequest->serviceCharges->isNotEmpty())
                <div class="mt-4 rounded-lg border border-green-200 bg-green-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-wide text-green-500">Service Charge</p>
                    <p class="mt-1 text-sm font-medium text-green-900">{{ $serviceRequest->serviceCharges->sum('amount') ?? 'N/A' }}</p>
                </div>

            @endif


        </div>

        <x-success></x-success>

        @if ($serviceRequest->serviceRequestPeriods->isNotEmpty())
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="flex flex-col gap-3 border-b border-gray-200 bg-gray-50 px-4 py-3 sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-sm font-semibold text-gray-800">Service Periods</h3>
                    <button
                        class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700"
                        wire:click.prevent="assignCleanerToAll({{ $id }})"
                    >
                        Assign To All
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs uppercase tracking-wide text-gray-600">
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Service Type</th>
                                <th class="px-4 py-3 text-left">Start Date</th>
                                <th class="px-4 py-3 text-left">Start Time</th>
                                <th class="px-4 py-3 text-left">End Time</th>
                                <th class="px-4 py-3 text-left">End Date</th>
                                <th class="px-4 py-3 text-left">Day</th>
                                <th class="px-4 py-3 text-left">Total Hours</th>
                                <th class="px-4 py-3 text-left">Assigned Cleaner</th>
                                <th class="px-4 py-3 text-left">Quotation</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($serviceRequest->serviceRequestPeriods as $period)
                                <tr class="align-top hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-700">{{ $period->id }}</td>
                                    <td class="px-4 py-3 text-gray-900">{{ $period->service?->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $period->start_date }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($period->start_time)->addHours(intval($period->duration_hours))->format('g:i A') }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ \Carbon\Carbon::parse($period->start_date)->format('l') }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ number_format($period->duration_hours, 1) }} hrs</td>
                                    <td class="px-4 py-3">
                                        @if($period->maidAssignments?->isNotEmpty())
                                            <div class="space-y-1">
                                                @foreach($period->maidAssignments as $assignedMaid)
                                                    <div class="rounded-md bg-gray-100 px-2 py-1 text-xs text-gray-700">
                                                        {{ $assignedMaid->maid?->name }} / {{ $assignedMaid->status }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-500">No cleaner assigned</span>
                                        @endif

                                        <button
                                            wire:click.prevent="assignCleaner({{ $period->id }})"
                                            class="mt-2 rounded-md border border-blue-200 px-2 py-1 text-xs font-medium text-blue-700 transition hover:bg-blue-50"
                                        >
                                            + Assign
                                        </button>
                                    </td>

                                    <td class="px-4 py-3 text-gray-700">{{ $period->quotation_value ?? 'N/A' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <button
                                                class="rounded-md bg-blue-600 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-blue-700"
                                                wire:click="editPeriod({{ $period->id }})"
                                                wire:loading.attr="disabled"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="rounded-md bg-red-600 px-2.5 py-1.5 text-xs font-medium text-white transition hover:bg-red-700"
                                                wire:click="deletePeriod({{ $period->id }})"
                                                wire:loading.attr="disabled"
                                                wire:confirm="Are you sure you want to delete this service period?"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm font-medium text-amber-800">
                No service periods found for this request.
            </div>
        @endif
    </div>





    {{-- Schedule modal popup --}}
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
            aria-hidden="true"
        ></div>

        <div
            x-show="showScheduleModal"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100 scale-250"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl"
        >
            <div class="flex items-start justify-between">
                <h3 id="assign-cleaner-modal-title" class="text-lg font-semibold text-gray-900">Assign Cleaner</h3>
                <button
                    type="button"
                    class="rounded px-2 py-1 text-gray-600 hover:bg-gray-100"
                    {{-- @click="showScheduleModal = false" --}}
                    wire:click="closeModal"
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


    {{-- Assign Cleaner modal popup --}}
    <div
        x-show="showAssignCleanerModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        aria-labelledby="assign-cleaner-modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="absolute inset-0 bg-black/50"
            aria-hidden="true"
        ></div>

        <div
            x-show="showAssignCleanerModal"
            x-transition:enter="transition ease-out duration-250"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-250"
            x-transition:leave-start="opacity-100 scale-250"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative w-full max-w-4xl rounded-lg bg-white p-6 shadow-xl"
        >
            <div class="flex items-start justify-between">
                <h3 id="assign-cleaner-modal-title" class="text-lg font-semibold text-gray-900">Assign Cleaner</h3>
                <button
                    type="button"
                    class="rounded px-2 py-1 text-gray-600 hover:bg-gray-100"
                    {{-- @click="showAssignCleanerModal = false" --}}
                    wire:click="closeAssignCleanerModal"
                    aria-label="Close modal"
                >
                    x
                </button>
            </div>

            <div class="mt-4 text-sm text-gray-700">
                @livewire('forms.assign-cleaner')
            </div>
        </div>
    </div>





</div>
