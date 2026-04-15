<div>
    {{-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius --}}
    <div class="overflow-hidden rounded-2xl border border-zinc-700 bg-linear-to-br from-zinc-950 via-zinc-900 to-slate-950 shadow-xl">
        <div class="border-b border-zinc-700 bg-zinc-900/80 px-6 py-5 backdrop-blur">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200">Service Operations</p>
            <h1 class="mt-1 text-3xl font-black tracking-tight text-zinc-100">
                {{ $request_id ? 'Update Service Request' : 'Create Service Request' }}
            </h1>
        </div>

        <div class="p-6 md:p-8">
            <form class="space-y-6">
                <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-400">Request Details</h2>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="client" class="block text-sm font-semibold text-zinc-300">Client</label>
                            <select id="client" name="client" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="client_id">
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
                            <label for="service_request_date" class="block text-sm font-semibold text-zinc-300">Service Request Date</label>
                            <input type="date" id="service_request_date" name="service_request_date" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="service_request_date">
                            @error('service_request_date')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="service_request_type" class="block text-sm font-semibold text-zinc-300">Service Request Type</label>
                            <select id="service_request_type" name="service_request_type" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="frequency" >
                                <option value="">Select a service request type</option>
                                @foreach ($frequencies as $frequency)
                                    <option value="{{ $frequency }}">{{ ucfirst($frequency) }}</option>
                                @endforeach
                            </select>
                            @error('frequency')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- status coloum --}}
                        <div>
                            <label for="status" class="block text-sm font-semibold text-zinc-300">Status</label>
                            <select id="status" name="status" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="status">
                                <option value="">Select a status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
                    <h2 class="mb-4 text-sm font-semibold uppercase tracking-wider text-zinc-400">Notes</h2>

                    <div>
                        <label for="service_request_description" class="block text-sm font-semibold text-zinc-300">Service Request Description</label>
                        <textarea id="service_request_description" name="service_request_description" rows="5" class="mt-2 block w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 py-3 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model="notes" placeholder="Write a clear description for this request..."></textarea>
                        @error('notes')
                            <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    @if ($request_id)
                        <button type="submit" class="inline-flex items-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-wide text-zinc-950 shadow-md transition hover:-translate-y-0.5 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-zinc-900" wire:click.prevent="newRequest">
                            Update Request
                        </button>
                    @else
                        <button type="submit" class="inline-flex items-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-wide text-zinc-950 shadow-md transition hover:-translate-y-0.5 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-zinc-900" wire:click.prevent="newRequest">
                            Submit Request
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
