<div class="schedule-page space-y-6">
   {{-- profile summary section , get the data from maids table --}}


    <div class="flex items-center gap-4">
        <div class="flex size-16 items-center justify-center rounded-full bg-zinc-800 text-lg font-semibold text-zinc-200">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($maid?->name, 0, 2)) }}</div>
        <div>
            <h1 class="text-2xl font-semibold text-zinc-100">{{ $maid?->name }}</h1>
            <p class="text-sm text-zinc-400">{{ $maid?->phone }}</p>
        </div>
    </div>


    {{-- maid summary card --}}
        {{-- Total Hours Worked --}}

        <div>
            <h2 class="text-lg font-semibold text-zinc-100">Total Hours Worked</h2>
            <p class="text-sm text-zinc-400">{{ $maid?->serviceRequestPeriods->where('status', 'completed')->sum('duration_hours') ?? 0 }} hours</p>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-zinc-100">In Progress</h2>
            <p class="text-sm text-zinc-400">{{ $maid?->serviceRequestPeriods->where('status', 'In Progress')->sum('duration_hours') ?? 0 }} hours</p>
        </div>

        <div>
            <h2 class="text-lg font-semibold text-zinc-100">Upcoming</h2>
            <p class="text-sm text-zinc-400">{{ $maid?->serviceRequestPeriods->where('status', 'Scheduled')->sum('duration_hours') ?? 0 }} hours</p>
        </div>



        <div>
            <input type="date" name="" id="" class="rounded border border-zinc-700 bg-zinc-950 px-2 py-1 text-zinc-200" value="{{ \Carbon\Carbon::now()->format('m-d-Y') }}" wire:model="maidScheduleSearchDate" @change="$wire.set('maidScheduleSearchDate', $event.target.value);">

            <button class="ml-2 rounded bg-cyan-500 px-4 py-2 text-sm font-semibold text-zinc-950" wire:click="$wire.set('maidScheduleSearchDate', null)">Clear</button>

        </div>

{{-- create table view for maid assignments --}}

        <div>
            <table class="w-full text-left">
                <thead>
                    <tr>
                    <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">Service Request #</th>
                        <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">Client Name</th>
                        <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">Service</th>
                        <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">Start Date</th>
                        <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">End Date</th>
                           <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">Duration Hours</th>
                        <th class="border-b border-zinc-700 px-4 py-2 text-sm font-semibold text-zinc-300">Status</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- @dump($searchByDate) --}}
                    @isset($maid)

                        @if ($maid->assignments->isNotEmpty())
                            @foreach ($maid?->assignments as $assignment)
                            <tr>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">
                                        <a href="{{ route('service-request-view',['id' => $assignment->serviceRequestPeriod->serviceRequest->id]) }}">{{ $assignment?->serviceRequestPeriod?->serviceRequest?->id }}</a>
                                    </td>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->serviceRequest?->client?->name }}</td>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->service?->name }}</td>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->start_date }}</td>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->end_date }}</td>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->duration_hours }}</td>
                                    <td class="border-b border-zinc-800 px-4 py-2 text-sm text-zinc-400">{{ $assignment?->serviceRequestPeriod?->status }}</td>
                                </tr>
                            @endforeach

                        @else

                         <tr>
                                <td colspan="7" class="border-b border-zinc-800 px-4 py-2 text-center text-sm text-zinc-500">No assignments found</td>
                            </tr>

                        @endif


                    @endisset


                </tbody>
            </table>
        </div>


</div>
