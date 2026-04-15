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

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Client Name</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest->client->name }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Requested Date</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ \Carbon\Carbon::parse($serviceRequest->date)->toDateString() }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Request Type</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest->frequency }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Status</p>
                <p class="mt-1 inline-flex rounded-full border border-zinc-500/40 bg-zinc-500/15 px-2.5 py-1 text-xs font-semibold text-zinc-200">{{ $serviceRequest->status }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-zinc-500">Service Charged</p>
                <p class="mt-1 font-semibold text-zinc-100">{{ $serviceRequest->service_charged }}</p>
            </div>
            <div class="md:col-span-2 xl:col-span-1">
                <p class="text-xs uppercase tracking-wide text-zinc-500">Notes</p>
                <p class="mt-1 text-sm text-zinc-300">{{ $serviceRequest->notes ?: 'No notes provided' }}</p>
            </div>
        </div>
    </section>

    <section class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-400">Service Charge Form</h2>

        <form action="" class="space-y-6">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-zinc-300" for="service_id">Service</label>
                    <select name="service_id" id="service_id" wire:model="service_id" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30">
                        <option value="">Select a service</option>
                        @foreach ($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                    @error('service_id')
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

                <div>
                    <label class="block text-sm font-medium text-zinc-300" for="service_date">Service Date</label>
                    <input type="date" name="service_date" id="service_date" wire:model="service_date" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30">
                    @error('service_date')
                        <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-300" for="end_date">End Date</label>
                    <input type="date" name="end_date" id="end_date" wire:model="end_date" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30">
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-300" for="worked_hours">Worked Hours</label>
                    <input type="number" name="worked_hours" id="worked_hours" placeholder="Enter total worked hours" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="worked_hours">
                    @error('worked_hours')
                        <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-zinc-300" for="assigned_maids">Assigned Maids</label>
                    <input type="number" name="assigned_maids" id="assigned_maids" placeholder="Enter assigned maid count" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="assigned_maids">
                    @error('assigned_maids')
                        <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-300" for="amount">Amount</label>
                    <input type="number" name="amount" id="amount" placeholder="Enter total amount" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="amount">
                    @error('amount')
                        <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-zinc-300" for="description">Description</label>
                    <textarea name="description" id="description" rows="4" placeholder="Provide a detailed description of the service charge..." class="mt-2 block w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 py-3 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="description"></textarea>
                    @error('description')
                        <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" wire:click="saveForm" class="inline-flex items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-wide text-zinc-950 shadow-md transition hover:-translate-y-0.5 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-zinc-900">
                    Add Service Charge
                </button>
            </div>
        </form>
    </section>
</div>
