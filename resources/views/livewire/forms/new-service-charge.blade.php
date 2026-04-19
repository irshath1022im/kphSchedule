<div class="space-y-6">
    {{-- Page Header --}}
    <div class="ops-hero">
        <div>
            <p class="ops-eyebrow">Billing Operations</p>
            <h1 class="ops-title">Create Service Charge</h1>
            <p class="ops-subtitle">Add a service charge entry for the selected request with dates, team size, and amount.</p>
        </div>
    </div>

    {{-- Request Details --}}
    <section class="ops-form-section">
        <h2 class="ops-form-section-title">Service Request Details</h2>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3 capitalize">
            <div>
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Client Name</p>
                <p class="mt-1 font-semibold text-slate-100">{{ $serviceRequest?->client?->name }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Requested Date</p>
                <p class="mt-1 font-semibold text-slate-100">{{ $serviceRequest?->service_request_date ? \Carbon\Carbon::parse($serviceRequest->service_request_date)->toDateString() : 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Request Type</p>
                <p class="mt-1 font-semibold text-slate-100">{{ $serviceRequest?->frequency }}</p>
            </div>
            {{-- start date and end date --}}
            <div>
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Work Period</p>
                <p class="mt-1 font-semibold text-slate-100">{{ $serviceRequest?->serviceRequestPeriods?->first()?->start_date ? \Carbon\Carbon::parse($serviceRequest->serviceRequestPeriods->first()->start_date)->toDateString() : 'N/A' }}</p>
                <p class="mt-1 font-semibold text-slate-100">{{ $serviceRequest?->serviceRequestPeriods?->first()?->start_date ? \Carbon\Carbon::parse($serviceRequest->serviceRequestPeriods->last()->end_date)->toDateString() : 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Status</p>
                <p class="mt-1 inline-flex rounded-full border border-sky-300/22 bg-sky-400/12 px-2.5 py-1 text-xs font-semibold text-sky-100">{{ $serviceRequest?->status }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Service</p>
                <p class="mt-1 font-semibold text-slate-100">{{ $serviceRequest?->services?->first()?->name ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2 xl:col-span-1">
                <p class="text-xs uppercase tracking-wide text-sky-100/50">Notes</p>
                <p class="mt-1 text-sm text-slate-300">{{ $serviceRequest?->notes ?: 'No notes provided' }}</p>
            </div>
        </div>
    </section>

    {{-- Charge Form --}}
    <section class="ops-form-section">
        <h2 class="ops-form-section-title">Service Charge Form</h2>

        <form action="" class="space-y-6">
            {{-- Service & Schedule --}}
            <div>
                <p class="ops-form-subsection-label">Service &amp; Schedule</p>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    <div>
                        <label class="ops-form-label" for="invoice_date">Invoice Date</label>
                        <input type="date" name="invoice_date" id="invoice_date" placeholder="Enter invoice date" class="ops-form-input" wire:model="invoice_date">
                        @error('invoice_date')
                            <span class="ops-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="ops-form-label" for="material_consumption">Material Consumption</label>
                        <select name="material_consumption" id="material_consumption" wire:model="material_consumption" class="ops-form-input">
                            <option value="">Select an option</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('material_consumption')
                            <span class="ops-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Payment --}}
            <div>
                <p class="ops-form-subsection-label">Payment</p>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    <div>
                        <label class="ops-form-label" for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" placeholder="Enter total amount" class="ops-form-input" wire:model="amount">
                        @error('amount')
                            <span class="ops-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="ops-form-label" for="receipt_no">Receipt No</label>
                        <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter receipt number (optional)" class="ops-form-input" wire:model="receipt_no">
                        @error('receipt_no')
                            <span class="ops-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label class="ops-form-label" for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="ops-form-input" wire:model="payment_method">
                            <option value="">Select a payment method (optional)</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}">{{ $method }}</option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <span class="ops-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="ops-form-label" for="description">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Provide a detailed description of the service charge..." class="ops-form-textarea" wire:model="description"></textarea>
                @error('description')
                    <span class="ops-form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="button" wire:click="saveForm" class="ops-btn-primary">
                    Add Service Charge
                </button>
            </div>
        </form>
    </section>
</div>
