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
        $assignedMaidNames = $serviceRequest->serviceRequestPeriods
            ->flatMap(fn ($period) => $period->maidAssignments ?? collect())
            ->pluck('maid.name')
            ->filter()
            ->unique();
        $assignedCleanerCount = $assignedMaidNames->count();
        $requestStatusClass = match (strtolower((string) $serviceRequest->status)) {
            'scheduled' => 'service-request-status-scheduled',
            'pending' => 'service-request-status-pending',
            'in progress' => 'service-request-status-in-progress',
            'completed' => 'service-request-status-completed',
            'cancelled' => 'service-request-status-cancelled',
            default => 'service-request-status-default',
        };
    @endphp

    <div class="service-request-shell w-full max-w-none border-sky-200/70 bg-sky-100/80 text-sky-900 shadow-[0_24px_80px_-36px_rgba(59,130,246,0.24)]">
        <div class="service-request-hero border-sky-300/70 bg-linear-to-br from-sky-200 via-blue-400 to-cyan-400 shadow-[inset_0_1px_0_rgba(255,255,255,0.4)]">
            <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                <div>
                    <p class="service-request-section-title text-sky-700">Request Overview</p>
                    <h2 class="service-request-heading text-sky-950">Service Request Details</h2>
                    <p class="mt-3 max-w-3xl text-sm leading-6 text-sky-800/90 sm:text-base">
                        Review the request summary, scheduling details, payment reference, and assigned team from one operational view.
                    </p>
                </div>

                <div class="service-request-action-row lg:max-w-xl lg:justify-end">
                    <button x-on:click="showScheduleModal = true" class="service-request-primary-btn">
                        Schedule
                    </button>

                    @if ($serviceRequest->serviceCharge)
                        <a href="{{ route('new-service-charge', ['id' => $serviceRequest->id, 'sc' => $serviceRequest->serviceCharge->id]) }}" class="service-request-secondary-btn border-sky-300/35 bg-sky-100/85 text-sky-800 hover:bg-sky-200">
                            Edit Service Charge
                        </a>

                    @else
                        <a href="{{ route('new-service-charge', ['id' => $serviceRequest->id ]) }}" class="service-request-secondary-btn border-sky-300/35 bg-sky-100/85 text-sky-800 hover:bg-sky-200">
                            Service Charge
                        </a>

                    @endif

                    <a href="{{ route('new-service-request', ['id' => $serviceRequest->id]) }}" class="service-request-secondary-btn border-sky-300/35 bg-sky-100/85 text-sky-800 hover:bg-sky-200">
                        Edit Request
                    </a>
                </div>
            </div>

            <div class="service-request-stat-grid">
                <div class="service-request-stat-card border-sky-200/70 bg-sky-100/80 shadow-sm">
                    <p class="service-request-stat-label text-sky-700">Client</p>
                    <p class="service-request-stat-value text-sky-950">{{ $serviceRequest->client?->name ?? 'N/A' }}</p>
                    <p class="service-request-stat-note text-sky-700/85">Primary request owner</p>
                </div>
                <div class="service-request-stat-card border-sky-200/70 bg-sky-100/80 shadow-sm">
                    <p class="service-request-stat-label text-sky-700">Requested Date</p>
                    <p class="service-request-stat-value text-sky-950">{{ $serviceRequest->service_request_date ?? 'N/A' }}</p>
                    <p class="service-request-stat-note text-sky-700/85">Initial service request date</p>
                </div>
                <div class="service-request-stat-card border-sky-200/70 bg-sky-100/80 shadow-sm">
                    <p class="service-request-stat-label text-sky-700">Status</p>
                    <p class="mt-2"><span class="service-request-status-pill bg-green-400 {{ $requestStatusClass }}">{{ $serviceRequest->status ?? 'N/A' }}</span></p>
                    <p class="service-request-stat-note text-sky-700/85">Live request state</p>
                </div>
                <div class="service-request-stat-card border-sky-200/70 bg-sky-100/80 shadow-sm">
                    <p class="service-request-stat-label text-sky-700">Service Charge</p>
                    <p class="service-request-stat-value text-sky-950">{{ $serviceRequest->serviceCharge?->amount ? 'QR ' . number_format($serviceRequest->serviceCharge->amount, 0) : 'Pending' }}</p>
                    <p class="service-request-stat-note text-sky-700/85">Quotation and payment status</p>
                </div>
            </div>

            <div class="mt-6 grid gap-4 xl:grid-cols-[minmax(0,1.35fr)_minmax(320px,0.85fr)]">
                <div class="space-y-4">
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="service-request-info-item border-sky-200/70 bg-sky-100/78 shadow-sm">
                            <p class="service-request-info-label text-sky-700">Frequency</p>
                            <p class="service-request-info-value text-sky-950">{{ $serviceRequest->frequency ?? 'N/A' }}</p>
                        </div>
                        <div class="service-request-info-item border-sky-200/70 bg-sky-100/78 shadow-sm">
                            <p class="service-request-info-label text-sky-700">Periods</p>
                            <p class="service-request-info-value text-sky-950">{{ $totalPeriods }}</p>
                        </div>
                        <div class="service-request-info-item border-sky-200/70 bg-sky-100/78 shadow-sm">
                            <p class="service-request-info-label text-sky-700">Request ID</p>
                            <p class="service-request-info-value text-sky-950">#{{ $serviceRequest->id }}</p>
                        </div>
                        <div class="service-request-info-item border-sky-200/70 bg-sky-100/78 shadow-sm">
                            <p class="service-request-info-label text-sky-700">Receipt No.</p>
                            <p class="service-request-info-value text-sky-950">{{ $serviceRequest->serviceCharge?->receipt_no ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="service-request-note-card border-sky-200/70 bg-sky-100/78 shadow-sm">
                        <div class="flex items-center justify-between gap-3">
                            <p class="service-request-info-label text-sky-700">Notes</p>
                            <span class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-600/80">Internal</span>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-sky-800">{{ $serviceRequest->notes ?: 'No notes provided.' }}</p>
                    </div>
                </div>

                <div class="service-request-assignees border-sky-200/70 bg-sky-100/78 shadow-sm">
                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <p class="service-request-info-label text-sky-700">Assigned Maids</p>
                            <p class="mt-1 text-sm text-sky-800/85">Current cleaners linked to this request.</p>
                        </div>
                        <span class="inline-flex items-center rounded-full border border-sky-300/35 bg-sky-200/70 px-3 py-1 text-xs font-semibold text-sky-800">
                            {{ $assignedCleanerCount }} Total
                        </span>
                    </div>

                    @if($assignedMaidNames->isNotEmpty())
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($assignedMaidNames as $assignedMaidName)
                                <div class="service-request-assignee border-sky-300/30 bg-sky-100 text-sky-800">
                                    {{ $assignedMaidName }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="mt-4 text-sm leading-6 text-sky-800">No maids assigned.</p>
                    @endif
                </div>
            </div>

        </div>

        <x-success></x-success>

        {{-- service periods --}}

        @if ($serviceRequest->serviceRequestPeriods->isNotEmpty())
            <div class="service-request-table-shell border-sky-200/70 bg-sky-100/84 shadow-[0_24px_60px_-36px_rgba(59,130,246,0.18)] text-white">
                <div class="service-request-table-header border-sky-300/65 bg-sky-200/72">
                    <div>
                        <h3 class="service-request-table-title text-sky-950">Service Periods</h3>
                        <p class="service-request-table-subtitle text-sky-700/85">A blue-toned operational view of each scheduled period and its assigned cleaner.</p>
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
                            <tr class="service-request-table-head border-sky-200/70 text-white">
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
                        <tbody class="divide-y divide-sky-200/70">
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
                                <tr class="service-request-table-row hover:bg-sky-100/70 text-white">
                                    <td class="px-4 py-3 text-white">{{ $period->id }}</td>
                                    <td class="px-4 py-3 font-semibold text-white">{{ $period->service?->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-white">{{ $period->start_date }}</td>
                                    <td class="px-4 py-3 text-white">{{ \Carbon\Carbon::parse($period->start_time)->format('g:i A') }}</td>
                                    <td class="px-4 py-3 text-white">{{ \Carbon\Carbon::parse($period->start_time)->addHours(intval($period->duration_hours))->format('g:i A') }}</td>
                                    <td class="px-4 py-3 text-white">{{ \Carbon\Carbon::parse($period->end_date)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-3 text-white">{{ \Carbon\Carbon::parse($period->start_date)->format('l') }}</td>
                                    <td class="px-4 py-3 text-white">{{ number_format($period->duration_hours, 1) }} hrs</td>
                                    <td class="px-4 py-3"><span class="service-request-status-pill {{ $periodStatusClass }}">{{ $period->status }}</span></td>
                                    <td class="px-4 py-3">
                                        @if($period->maidAssignments?->isNotEmpty())
                                            <div class="space-y-1">
                                                @foreach($period->maidAssignments as $assignedMaid)
                                                    <div class="service-request-assignee border-sky-300/30 bg-sky-100 text-sky-800">
                                                        {{ $assignedMaid->maid?->name }} / {{ $assignedMaid->status }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-sky-600/85">No cleaner assigned</span>
                                        @endif

                                        <button
                                            wire:click.prevent="assignCleaner({{ $period->id }})"
                                            class="mt-3 inline-flex items-center rounded-full border border-sky-300/30 bg-sky-100 px-3 py-1.5 text-xs font-semibold text-sky-800 transition hover:bg-sky-200"
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
                                                class="inline-flex items-center rounded-full border border-sky-300/24 bg-sky-100 px-3 py-1.5 text-xs font-semibold text-sky-800 transition hover:bg-sky-200"
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
            <div class="service-request-empty border-sky-200/70 bg-sky-100/84 text-sky-800 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-700">No Periods Yet</p>
                <p class="mt-3 text-lg font-semibold text-sky-950">No service periods found for this request.</p>
                <p class="mt-2 text-sm text-sky-700/85">Create a schedule to populate this page with working periods and cleaner assignments.</p>
            </div>
        @endif
    </div>





    {{-- Schedule modal popup --}}
    <div
        x-show="showScheduleModal"
        x-cloak
        class="fixed inset-0 z-120 flex items-start justify-center overflow-y-auto p-4 pt-8 sm:pt-12"
        aria-labelledby="assign-cleaner-modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="absolute inset-0 z-0 bg-sky-950/30 backdrop-blur-sm"
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
            class="service-request-modal-panel z-10"
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
        class="fixed inset-0 z-120 flex items-start justify-center overflow-y-auto p-4 pt-8 sm:pt-12"
        aria-labelledby="assign-cleaner-modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            class="absolute inset-0 z-0 bg-black/50"
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
            class="service-request-modal-panel z-10"
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
