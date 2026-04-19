<div
    x-data="{
        showAssignCleanerModal: @entangle('showAssignCleanerModal'),
        showScheduleModal: @entangle('showScheduleModal'),
    }"
    x-cloak
    class="service-request-page"
>
    @php
        $totalPeriods = $serviceRequest->serviceRequestPeriods->count();
        $assignedCleanerCount = $serviceRequest->serviceRequestPeriods
            ->flatMap(fn ($period) => $period->maidAssignments ?? collect())
            ->pluck('maid.name')
            ->filter()
            ->unique()
            ->count();
        $requestStatusClass = match (strtolower((string) $serviceRequest->status)) {
            'scheduled' => 'service-request-status-scheduled',
            'pending' => 'service-request-status-pending',
            'in progress' => 'service-request-status-in-progress',
            'completed' => 'service-request-status-completed',
            'cancelled' => 'service-request-status-cancelled',
            default => 'service-request-status-default',
        };
    @endphp

    <div class="service-request-shell">
        <div class="service-request-hero">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="service-request-section-title">Request Overview</p>
                    <h2 class="service-request-heading">Service Request Details</h2>
                    <p class="service-request-subheading">Review schedule periods, cleaner assignments, and quotation values in a cleaner blue interface with a sharper typographic hierarchy.</p>
                </div>

                <div class="service-request-action-row lg:max-w-xl lg:justify-end">
                    <button x-on:click="showScheduleModal = true" class="service-request-primary-btn">
                        Schedule
                    </button>

                    @if ($serviceRequest->serviceCharge)
                        <a href="{{ route('new-service-charge', ['id' => $serviceRequest->id, 'sc' => $serviceRequest->serviceCharge->id]) }}" class="service-request-secondary-btn">
                            Edit Service Charge
                        </a>

                    @else
                        <a href="{{ route('new-service-charge', ['id' => $serviceRequest->id ]) }}" class="service-request-secondary-btn">
                            Service Charge
                        </a>

                    @endif

                    <a href="{{ route('new-service-request', ['id' => $serviceRequest->id]) }}" class="service-request-secondary-btn">
                        Edit Request
                    </a>
                </div>
            </div>

            <div class="service-request-stat-grid">
                <div class="service-request-stat-card">
                    <p class="service-request-stat-label">Client</p>
                    <p class="service-request-stat-value">{{ $serviceRequest->client?->name ?? 'N/A' }}</p>
                    <p class="service-request-stat-note">Primary request owner</p>
                </div>
                <div class="service-request-stat-card">
                    <p class="service-request-stat-label">Requested Date</p>
                    <p class="service-request-stat-value">{{ $serviceRequest->service_request_date ?? 'N/A' }}</p>
                    <p class="service-request-stat-note">Initial service request date</p>
                </div>
                <div class="service-request-stat-card">
                    <p class="service-request-stat-label">Status</p>
                    <p class="mt-2"><span class="service-request-status-pill {{ $requestStatusClass }}">{{ $serviceRequest->status ?? 'N/A' }}</span></p>
                    <p class="service-request-stat-note">Live request state</p>
                </div>
                <div class="service-request-stat-card">
                    <p class="service-request-stat-label">Service Charge</p>
                    <p class="service-request-stat-value">{{ $serviceRequest->serviceCharge?->amount ? 'QR ' . number_format($serviceRequest->serviceCharge->amount, 0) : 'Pending' }}</p>
                    <p class="service-request-stat-note">Quotation and payment status</p>
                </div>
            </div>

            <div class="service-request-info-grid">
                <div class="service-request-info-item">
                    <p class="service-request-info-label">Frequency</p>
                    <p class="service-request-info-value">{{ $serviceRequest->frequency ?? 'N/A' }}</p>
                </div>
                <div class="service-request-info-item">
                    <p class="service-request-info-label">Periods</p>
                    <p class="service-request-info-value">{{ $totalPeriods }}</p>
                </div>
                <div class="service-request-info-item">
                    <p class="service-request-info-label">Assigned Cleaners</p>
                    <p class="service-request-info-value">{{ $assignedCleanerCount }}</p>
                </div>
                <div class="service-request-info-item">
                    <p class="service-request-info-label">Receipt No.</p>
                    <p class="service-request-info-value">{{ $serviceRequest->serviceCharge?->receipt_no ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="service-request-note-card">
                <p class="service-request-info-label">Notes</p>
                <p class="mt-2 text-sm leading-6 text-slate-200">{{ $serviceRequest->notes ?: 'No notes provided.' }}</p>
            </div>

            {{-- service charge --}}
            @if($serviceRequest->serviceCharge)
                <div class="service-request-highlight">
                    <div>
                        <p class="service-request-highlight-label">Service Charge</p>
                        <p class="service-request-highlight-value">{{ $serviceRequest->serviceCharge->amount ? 'QR ' . number_format($serviceRequest->serviceCharge->amount, 0) : 'N/A' }}</p>
                    </div>


                {{-- receipt no --}}


                    <div>
                        <p class="service-request-highlight-label">Receipt No.</p>
                        <p class="service-request-highlight-value">{{ $serviceRequest->serviceCharge->receipt_no ?? 'N/A' }}</p>
                    </div>

                {{-- payment method --}}

                    <div>
                        <p class="service-request-highlight-label">Payment Method</p>
                        <p class="service-request-highlight-value">{{ $serviceRequest->serviceCharge->payment_method ?? 'N/A' }}</p>
                    </div>



                </div>

            @else
                <div class="service-request-warning">
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-100/80">No Service Charge</p>
                    <p class="mt-2 text-sm text-amber-100/88">This service request does not have an associated service charge yet.</p>
                </div>

            @endif


        </div>

        <x-success></x-success>

        @if ($serviceRequest->serviceRequestPeriods->isNotEmpty())
            <div class="service-request-table-shell">
                <div class="service-request-table-header">
                    <div>
                        <h3 class="service-request-table-title">Service Periods</h3>
                        <p class="service-request-table-subtitle">A blue-toned operational view of each scheduled period and its assigned cleaner.</p>
                    </div>
                    <button
                        class="service-request-primary-btn"
                        wire:click.prevent="assignCleanerToAll({{ $id }})"
                    >
                        Assign To All
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="service-request-table-head">
                                <th class="px-4 py-3 text-left">#</th>
                                <th class="px-4 py-3 text-left">Service Type</th>
                                <th class="px-4 py-3 text-left">Start Date</th>
                                <th class="px-4 py-3 text-left">Start Time</th>
                                <th class="px-4 py-3 text-left">End Time</th>
                                <th class="px-4 py-3 text-left">End Date</th>
                                <th class="px-4 py-3 text-left">Day</th>
                                <th class="px-4 py-3 text-left">Total Hours</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Assigned Cleaner</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-sky-300/10">
                            @foreach($serviceRequest->serviceRequestPeriods as $period)
                                @php
                                    $periodStatusClass = match (strtolower((string) $period->status)) {
                                        'scheduled' => 'service-request-status-scheduled',
                                        'pending' => 'service-request-status-pending',
                                        'in progress' => 'service-request-status-in-progress',
                                        'completed' => 'service-request-status-completed',
                                        'cancelled' => 'service-request-status-cancelled',
                                        default => 'service-request-status-default',
                                    };
                                @endphp
                                <tr class="service-request-table-row">
                                    <td class="px-4 py-3 text-slate-300">{{ $period->id }}</td>
                                    <td class="px-4 py-3 font-semibold text-slate-50">{{ $period->service?->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-slate-300">{{ $period->start_date }}</td>
                                    <td class="px-4 py-3 text-slate-300">{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }}</td>
                                    <td class="px-4 py-3 text-slate-300">{{ \Carbon\Carbon::parse($period->start_time)->addHours(intval($period->duration_hours))->format('g:i A') }}</td>
                                    <td class="px-4 py-3 text-slate-300">{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-slate-300">{{ \Carbon\Carbon::parse($period->start_date)->format('l') }}</td>
                                    <td class="px-4 py-3 text-slate-300">{{ number_format($period->duration_hours, 1) }} hrs</td>
                                    <td class="px-4 py-3"><span class="service-request-status-pill {{ $periodStatusClass }}">{{ $period->status }}</span></td>
                                    <td class="px-4 py-3">
                                        @if($period->maidAssignments?->isNotEmpty())
                                            <div class="space-y-1">
                                                @foreach($period->maidAssignments as $assignedMaid)
                                                    <div class="service-request-assignee">
                                                        {{ $assignedMaid->maid?->name }} / {{ $assignedMaid->status }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400">No cleaner assigned</span>
                                        @endif

                                        <button
                                            wire:click.prevent="assignCleaner({{ $period->id }})"
                                            class="mt-3 inline-flex items-center rounded-full border border-sky-300/18 bg-sky-400/10 px-3 py-1.5 text-xs font-semibold text-sky-100 transition hover:bg-sky-400/18"
                                        >
                                            + Assign
                                        </button>
                                    </td>

                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-2">
                                            <button
                                                class="inline-flex items-center rounded-full bg-sky-400 px-3 py-1.5 text-xs font-semibold text-slate-950 transition hover:bg-sky-300"
                                                wire:click="editPeriod({{ $period->id }})"
                                                wire:loading.attr="disabled"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                class="inline-flex items-center rounded-full border border-slate-300/18 bg-slate-100/10 px-3 py-1.5 text-xs font-semibold text-slate-100 transition hover:bg-slate-100/16"
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
            <div class="service-request-empty">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-100/55">No Periods Yet</p>
                <p class="mt-3 text-lg font-semibold text-slate-50">No service periods found for this request.</p>
                <p class="mt-2 text-sm text-slate-300/72">Create a schedule to populate this page with working periods and cleaner assignments.</p>
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
            class="service-request-modal-panel"
        >
            <div class="flex items-start justify-between">
                <h3 id="assign-cleaner-modal-title" class="text-lg font-semibold text-slate-50">Create Schedule</h3>
                <button
                    type="button"
                    class="service-request-modal-close"
                    {{-- @click="showScheduleModal = false" --}}
                    wire:click="closeModal"
                    aria-label="Close modal"
                >
                    x
                </button>
            </div>

            <div class="mt-4 text-sm text-slate-200">
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
            class="service-request-modal-panel"
        >
            <div class="flex items-start justify-between">
                <h3 id="assign-cleaner-modal-title" class="text-lg font-semibold text-slate-50">Assign Cleaner</h3>
                <button
                    type="button"
                    class="service-request-modal-close"
                    {{-- @click="showAssignCleanerModal = false" --}}
                    wire:click="closeAssignCleanerModal"
                    aria-label="Close modal"
                >
                    x
                </button>
            </div>

            <div class="mt-4 text-sm text-slate-200">
                @livewire('forms.assign-cleaner')
            </div>
        </div>
    </div>





</div>
