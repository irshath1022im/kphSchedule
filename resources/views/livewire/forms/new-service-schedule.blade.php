<div>
    {{-- Nothing in life is to be feared, it is only to be understood. Now is the time to understand more, so that we may fear less. - Maria Skłodowska-Curie --}}

    <div wire:loading wire:target="save" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-white"></div>
        </div>
    </div>


    <div class="overflow-hidden rounded-[24px] border border-sky-300/14 bg-linear-to-br from-slate-900 to-slate-950 shadow-[inset_0_1px_0_rgba(255,255,255,0.04)]">
        <div class="border-b border-sky-300/10 bg-sky-950/25 px-6 py-5 backdrop-blur">
            <h2 class="text-2xl font-bold tracking-tight text-slate-50">Create Service Schedule</h2>
            <p class="mt-1 text-sm font-medium text-slate-300/72">Request #{{ $request_id }}</p>
            @error('request_id')
                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="p-6 md:p-8">

            <div class="text-sm font-medium text-sky-100/70">{{ $frequecy }}</div>

            <form class="space-y-6">
                <div class="rounded-2xl border border-sky-300/12 bg-slate-950/55 p-5">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-[0.22em] text-sky-100/52">Service Details</h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="service_type" class="block text-sm font-semibold text-slate-200">Service Type</label>
                            <select id="service_type" name="service_type" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-sky-400 focus:ring focus:ring-sky-300/25 focus:ring-opacity-100" wire:model="service_id">
                                <option value="">Select a service type</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-semibold text-slate-200">Status</label>
                            <select id="status" name="status" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-sky-400 focus:ring focus:ring-sky-300/25 focus:ring-opacity-100" wire:model="status">
                                <option value="">Select a status</option>
                                @foreach($statusList as $statusOption)
                                    <option value="{{ $statusOption }}">{{ $statusOption }}</option>
                                @endforeach
                            </select>
                            @error('status')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- start date --}}
                        <div>
                            <label for="start_date" class="block text-sm font-semibold text-slate-200">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-300/25 focus:ring-opacity-100" wire:model.live="start_date">
                            @error('start_date')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- end date --}}
                        <div>
                            <label for="end_date" class="block text-sm font-semibold text-slate-200">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-300/25 focus:ring-opacity-100" wire:model="end_date">
                            @error('end_date')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-sky-300/12 bg-slate-950/55 p-5">
                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-[0.22em] text-sky-100/52">Timing</h3>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">


                        <div>
                            <label for="start_time" class="block text-sm font-semibold text-slate-200">Start Time</label>
                            <input type="time" id="start_time" name="start_time" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-300/25 focus:ring-opacity-100" wire:model="start_time">
                            @error('start_time')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>




                        <div>
                            <label for="duration_hours" class="block text-sm font-semibold text-slate-200">Duration (Hours)</label>
                            <input type="number" step="0.5" min="1" id="duration_hours" name="duration_hours" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-300/25 focus:ring-opacity-100" wire:model.live="duration_hours">
                            @error('duration_hours')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- duration hours --}}

                        <div>
                            <label for="end_time" class="block text-sm font-semibold text-slate-200">End Time</label>
                            <input type="time" id="end_time" name="end_time" class="mt-2 block h-12 w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 text-base text-slate-100 shadow-sm focus:border-cyan-400 focus:ring focus:ring-cyan-300/25 focus:ring-opacity-100" wire:model="end_time">
                            @error('end_time')
                                <span class="mt-1 block text-sm font-medium text-red-500">{{ $message }}</span>
                            @enderror
                        </div>


                    </div>
                </div>

                <div class="flex items-center justify-end">

                    @if ($editPeriodId)

                        <button type="submit" class="inline-flex items-center rounded-full bg-sky-400 px-6 py-2.5 text-sm font-bold tracking-wide text-slate-950 shadow-md transition hover:-translate-y-0.5 hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-950" wire:click.prevent="scheduleUpdate">
                            Update Schedule
                        </button>
                    @else

                    <button type="submit" class="inline-flex items-center rounded-full bg-sky-400 px-6 py-2.5 text-sm font-bold tracking-wide text-slate-950 shadow-md transition hover:-translate-y-0.5 hover:bg-sky-300 focus:outline-none focus:ring-2 focus:ring-sky-400 focus:ring-offset-2 focus:ring-offset-slate-950" wire:click.prevent="save">
                        Save Schedule
                    </button>
                    @endif



                </div>
            </form>
        </div>
    </div>

</div>
