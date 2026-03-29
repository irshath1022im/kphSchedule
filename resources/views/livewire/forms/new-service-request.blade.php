<div>
    {{-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius --}}
    <div class="overflow-hidden rounded-2xl border border-sky-100 bg-linear-to-br from-white via-sky-50/70 to-emerald-50/70 shadow-xl">
        <div class="border-b border-sky-100/80 bg-white/80 px-6 py-5 backdrop-blur">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-sky-700">Service Operations</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-zinc-900">
                {{ $request_id ? 'Update Service Request' : 'Create Service Request' }}
            </h1>
        </div>

        <div class="p-6 md:p-8">
            <form class="space-y-6">
                <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-500">Request Details</h2>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="client" class="block text-sm font-semibold text-zinc-700">Client</label>
                            <select id="client" name="client" class="mt-2 block h-12 w-full rounded-lg border-zinc-300 bg-zinc-50/70 px-4 text-base text-zinc-900 shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-200 focus:ring-opacity-70" wire:model="client_id">
                                <option value="">Select a client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            @error('client_id')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="service_request_date" class="block text-sm font-semibold text-zinc-700">Service Request Date</label>
                            <input type="date" id="service_request_date" name="service_request_date" class="mt-2 block h-12 w-full rounded-lg border-zinc-300 bg-zinc-50/70 px-4 text-base text-zinc-900 shadow-sm focus:border-sky-500 focus:ring focus:ring-sky-200 focus:ring-opacity-70" wire:model="service_request_date">
                            @error('service_request_date')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="service_request_type" class="block text-sm font-semibold text-zinc-700">Service Request Type</label>
                            <select id="service_request_type" name="service_request_type" class="mt-2 block h-12 w-full rounded-lg border-zinc-300 bg-zinc-50/70 px-4 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-70" wire:model="frequency">
                                <option value="">Select a service request type</option>
                                @foreach ($frequencies as $frequency)
                                    <option value="{{ $frequency }}">{{ ucfirst($frequency) }}</option>
                                @endforeach
                            </select>
                            @error('frequency')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm">
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-500">Notes</h2>

                    <div>
                        <label for="service_request_description" class="block text-sm font-semibold text-zinc-700">Service Request Description</label>
                        <textarea id="service_request_description" name="service_request_description" rows="5" class="mt-2 block w-full rounded-lg border-zinc-300 bg-zinc-50/70 px-4 py-3 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200 focus:ring-opacity-70" wire:model="notes" placeholder="Write a clear description for this request..."></textarea>
                        @error('notes')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    @if ($request_id)
                        <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-600 px-6 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-md transition hover:-translate-y-0.5 hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2" wire:click.prevent="newRequest">
                            Update Request
                        </button>
                    @else
                        <button type="submit" class="inline-flex items-center rounded-lg bg-sky-600 px-6 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-md transition hover:-translate-y-0.5 hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2" wire:click.prevent="newRequest">
                            Submit Request
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
