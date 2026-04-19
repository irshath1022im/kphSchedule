<div class="schedule-page space-y-6">
   {{-- profile summary section , get the data from maids table --}}

    @php
        $completedHours = $maid?->serviceRequestPeriods->where('status', 'completed')->sum('duration_hours') ?? 0;
        $inProgressHours = $maid?->serviceRequestPeriods->where('status', 'In Progress')->sum('duration_hours') ?? 0;
        $upcomingHours = $maid?->serviceRequestPeriods->where('status', 'Scheduled')->sum('duration_hours') ?? 0;
    @endphp

    <div class="rounded-[28px] border border-cyan-400/15 bg-linear-to-br from-sky-950/70 via-zinc-900 to-slate-950 p-6">
        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center gap-4">
                <div class="flex size-16 items-center justify-center rounded-full bg-cyan-500/12 text-lg font-semibold text-cyan-100 ring-1 ring-cyan-400/20">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($maid?->name, 0, 2)) }}</div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-cyan-100/55">Cleaner Profile</p>
                    <h1 class="mt-2 text-3xl font-semibold text-zinc-100">{{ $maid?->name }}</h1>
                    <p class="text-sm text-zinc-400">{{ $maid?->phone }}</p>
                </div>
            </div>

            <div>
                <input type="date" name="" id="" class="ops-input" value="{{ \Carbon\Carbon::now()->format('m-d-Y') }}" wire:model="maidScheduleSearchDate" @change="$wire.set('maidScheduleSearchDate', $event.target.value);">

                <button class="ml-2 rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-zinc-950" wire:click="$wire.set('maidScheduleSearchDate', null)">Clear</button>
            </div>
        </div>
    </div>


    {{-- maid summary card --}}
        {{-- Total Hours Worked --}}

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-2xl border border-zinc-700 bg-zinc-900/75 p-5">
                <h2 class="text-sm font-semibold uppercase tracking-[0.22em] text-zinc-400">Total Hours Worked</h2>
                <p class="mt-3 text-3xl font-bold text-zinc-100">{{ $completedHours }}</p>
                <p class="mt-1 text-sm text-zinc-400">Completed service hours</p>
            </div>

            <div class="rounded-2xl border border-cyan-400/18 bg-cyan-500/10 p-5">
                <h2 class="text-sm font-semibold uppercase tracking-[0.22em] text-cyan-100/70">In Progress</h2>
                <p class="mt-3 text-3xl font-bold text-cyan-100">{{ $inProgressHours }}</p>
                <p class="mt-1 text-sm text-cyan-100/72">Hours currently underway</p>
            </div>

            <div class="rounded-2xl border border-sky-400/18 bg-sky-500/10 p-5">
                <h2 class="text-sm font-semibold uppercase tracking-[0.22em] text-sky-100/70">Upcoming</h2>
                <p class="mt-3 text-3xl font-bold text-sky-100">{{ $upcomingHours }}</p>
                <p class="mt-1 text-sm text-sky-100/72">Scheduled upcoming hours</p>
            </div>
        </div>

{{-- create table view for maid assignments --}}

        <div class="overflow-hidden rounded-[28px] border border-zinc-700 bg-zinc-900/75">
            <div class="border-b border-zinc-700 px-5 py-4">
                <h2 class="text-lg font-semibold text-zinc-100">Assignment Timeline</h2>
                <p class="mt-1 text-sm text-zinc-400">Service request periods assigned to this cleaner.</p>
            </div>
            <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-zinc-700 text-[11px] uppercase tracking-[0.22em] text-zinc-500">
                    <th class="px-4 py-3 font-semibold">Service Request #</th>
                        <th class="px-4 py-3 font-semibold">Client Name</th>
                        <th class="px-4 py-3 font-semibold">Service</th>
                        <th class="px-4 py-3 font-semibold">Start Date</th>
                        <th class="px-4 py-3 font-semibold">End Date</th>
                           <th class="px-4 py-3 font-semibold">Duration Hours</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-800">

                    {{-- @dump($searchByDate) --}}
                    @isset($maid)

                        @if ($maid->assignments->isNotEmpty())
                            @foreach ($maid?->assignments as $assignment)
                            <tr class="hover:bg-zinc-800/40">
                                    <td class="px-4 py-3 text-sm text-zinc-400">
                                        <a class="font-medium text-cyan-200 hover:text-cyan-100" href="{{ route('service-request-view',['id' => $assignment->serviceRequestPeriod->serviceRequest->id]) }}">{{ $assignment?->serviceRequestPeriod?->serviceRequest?->id }}</a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->serviceRequest?->client?->name }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->service?->name }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->start_date }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->end_date }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->duration_hours }}</td>
                                    <td class="px-4 py-3 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->status }}</td>
                                </tr>
                            @endforeach

                        @else

                         <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-zinc-500">No assignments found</td>
                            </tr>

                        @endif


                    @endisset


                </tbody>
            </table>
            </div>
        </div>


</div>
