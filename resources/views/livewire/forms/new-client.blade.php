<div>
    <div class="overflow-hidden rounded-2xl border border-zinc-700 bg-linear-to-br from-zinc-950 via-zinc-900 to-slate-950 shadow-xl">
        <div class="border-b border-zinc-700 bg-zinc-900/80 px-6 py-5 backdrop-blur">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-cyan-200">Client Operations</p>
                    <h1 class="mt-1 text-3xl font-black tracking-tight text-zinc-100">Create Client Profile</h1>
                    <p class="mt-2 max-w-2xl text-sm text-zinc-400">Capture the client&apos;s contact details and preferred service area in one place before creating service requests.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:min-w-80">
                    <div class="rounded-xl border border-cyan-400/30 bg-cyan-500/10 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-cyan-200">Required</p>
                        <p class="mt-1 text-sm font-semibold text-zinc-100">Name, email, and phone</p>
                    </div>
                    <div class="rounded-xl border border-emerald-400/30 bg-emerald-500/10 px-4 py-3">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-emerald-200">Coverage</p>
                        <p class="mt-1 text-sm font-semibold text-zinc-100">{{ count($locations) }} service areas</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form class="space-y-6" wire:submit.prevent="submit">
                <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
                    <div class="mb-5 flex flex-col gap-1">
                        <h2 class="text-sm font-semibold uppercase tracking-wider text-zinc-400">Primary Contact</h2>
                        <p class="text-sm text-zinc-500">Use the client&apos;s main contact information for scheduling and updates.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-zinc-300">Client Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter full client name" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model.live="name">
                            @error('name')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-semibold text-zinc-300">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="client@example.com" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model.live="email">
                            @error('email')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-semibold text-zinc-300">Phone Number</label>
                            <input type="tel" id="phone" name="phone" placeholder="Enter primary phone number" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model.live="phone">
                            @error('phone')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm">
                    <div class="mb-5 flex flex-col gap-1">
                        <h2 class="text-sm font-semibold uppercase tracking-wider text-zinc-400">Address Details</h2>
                        <p class="text-sm text-zinc-500">Optional location details help the operations team assign the right service area faster.</p>
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-zinc-300">Address</label>
                            <textarea id="address" name="address" rows="4" placeholder="Building, street, landmark, or unit details" class="mt-2 block w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 py-3 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model.live="address"></textarea>
                            @error('address')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-semibold text-zinc-300">City</label>
                            <input type="text" id="city" name="city" placeholder="Enter city" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model.live="city">
                            @error('city')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-semibold text-zinc-300">Service Area</label>
                            <select name="location" id="location" class="mt-2 block h-12 w-full rounded-lg border-zinc-700 bg-zinc-950 px-4 text-base text-zinc-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-400/30" wire:model.live="location">
                                <option value="">Select a service area</option>
                                @foreach ($locations as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                            @error('location')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 rounded-xl border border-zinc-700 bg-zinc-900/75 p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-zinc-100">Ready to create this client?</p>
                        <p class="mt-1 text-sm text-zinc-500">You can add service requests and assignments after saving the profile.</p>
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-cyan-500 px-6 py-3 text-sm font-bold uppercase tracking-wide text-zinc-950 shadow-md transition hover:-translate-y-0.5 hover:bg-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2 focus:ring-offset-zinc-900 disabled:cursor-not-allowed disabled:opacity-70" wire:loading.attr="disabled" wire:target="submit">
                        <span wire:loading.remove wire:target="submit">Add Client</span>
                        <span wire:loading wire:target="submit">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
