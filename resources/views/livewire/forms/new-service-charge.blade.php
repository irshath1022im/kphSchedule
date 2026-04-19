<div class="schedule-page space-y-6">
    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200">Billing Operations</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-zinc-100">Create Service Charge</h1>
            <p class="mt-2 text-sm text-zinc-400">Add a service charge entry for the selected request with dates, team size, and amount.</p>
        </div>
    </div>

    <section class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-400">Service Request Details</h2>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3 capitalize">
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Client Name</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest?->client?->name }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Requested Date</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest?->service_request_date ? \Carbon\Carbon::parse($serviceRequest->service_request_date)->toDateString() : 'N/A' }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Request Type</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest?->frequency }}</p>
            </div>


            {{-- start date and end date --}}
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Work Period</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest?->serviceRequestPeriods?->first()?->start_date ? \Carbon\Carbon::parse($serviceRequest->serviceRequestPeriods->first()->start_date)->toDateString() : 'N/A' }}</p>
                 <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest?->serviceRequestPeriods?->first()?->start_date ? \Carbon\Carbon::parse($serviceRequest->serviceRequestPeriods->last()->end_date)->toDateString() : 'N/A' }}</p>
            </div>


            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Status</p>
                <p class="mt-1 inline-flex rounded-full border border-zinc-500/40 bg-zinc-500/15 px-2.5 py-1 text-xs font-semibold text-zinc-200">{{ $serviceRequest?->status }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Service</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest?->services?->first()?->name ?? 'N/A' }}</p>
            </div>
            <div class="md:col-span-2 xl:col-span-1">
                <p class="text-xs uppercase tracking-wide text-zinc-500">Notes</p>
                <p class="mt-1 text-sm text-zinc-300">{{ $serviceRequest?->notes ?: 'No notes provided' }}</p>
            </div>
        </div>
    </section>

    <section class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-400">Service Charge Form</h2>

        <form action="" class="space-y-6">
            {{-- Service & Schedule --}}
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Service & Schedule</p>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    {{-- service date --}}

                    <div>
                        <label class="block text-sm font-medium text-zinc-300" for="invoice_date">Invoice Date</label>
                        <input type="date" name="invoice_date" id="invoice_date" placeholder="Enter invoice date" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="invoice_date">
                        @error('invoice_date')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300" for="material_consumption">Material Consumption</label>
                        <select name="material_consumption" id="material_consumption" wire:model="material_consumption" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30">
                            <option value="">Select an option</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                        @error('material_consumption')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>



                </div>
            </div>


            {{-- Payment --}}
            <div>
                <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-zinc-500">Payment</p>
                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-zinc-300" for="amount">Amount</label>
                        <input type="number" name="amount" id="amount" placeholder="Enter total amount" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="amount">
                        @error('amount')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300" for="receipt_no">Receipt No</label>
                        <input type="text" name="receipt_no" id="receipt_no" placeholder="Enter receipt number (optional)" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="receipt_no">
                        @error('receipt_no')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-300" for="payment_method">Payment Method</label>
                        <select name="payment_method" id="payment_method" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="payment_method">
                            <option value="">Select a payment method (optional)</option>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method }}">{{ $method }}</option>
                            @endforeach
                        </select>
                        @error('payment_method')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-medium text-zinc-300" for="description">Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Provide a detailed description of the service charge..." class="mt-2 block w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 py-3 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="description"></textarea>
                @error('description')
                    <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="button" wire:click="saveForm" class="inline-flex items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-wide text-zinc-950 shadow-md transition hover:-translate-y-0.5 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-zinc-900">
                    Add Service Charge
                </button>
            </div>
        </form>

    </section>
</div>
