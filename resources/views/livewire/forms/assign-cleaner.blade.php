<div>
    <h3 class="text-lg font-bold tracking-tight text-slate-50 ">Assign Cleaner for
    {{  $service_request_id ? 'Service Request '.$service_request_id.' ' : 'Indivustual' }}

   </h3>

<p class="mt-1 text-sm text-slate-300/72">Use the blue assignment panel below to select a cleaner and set their assignment status.</p>

 {{-- // each requst can have 1 ore more cleaners assigned to it, but each cleaner can only be assigned to 1 request at a time.

 // --}}
<div wire:loading>
    <div class="flex items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
    </div>
</div>

<form action="" wire:loading.remove class="mt-5 space-y-5">
    <div class="rounded-2xl border border-sky-300/12 bg-slate-950/55 p-4">
        <div class="flex flex-col gap-4 md:flex-row md:items-end">
        <div class="w-full">
        <label for="cleaner" class="block text-sm font-semibold text-slate-200">Select Cleaner</label>
        <select id="cleaner" name="cleaner" class="mt-2 block w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 py-3 text-sm text-slate-100 shadow-sm focus:border-sky-400 focus:ring-sky-300/25"
            wire:model="maid_id"
        >
            <option value="">-- Select a cleaner --</option>
            @foreach ($maids as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>

        @error('maid_id')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
        </div>
    </div>

    {{-- status --}}
    <div class="mt-4">
        <label for="status" class="block text-sm font-semibold text-slate-200">Status</label>
        <select id="status" name="status" class="mt-2 block w-full rounded-xl border-sky-300/14 bg-slate-900 px-4 py-3 text-sm text-slate-100 shadow-sm focus:border-sky-400 focus:ring-sky-300/25"
            wire:model="status"
        >
            <option value="">-- Select status --</option>
            <option value="assigned">Assigned</option>
            <option value="day_off">Day Off</option>
            <option value="absent">Absent</option>
            <option value="replaced">Replaced</option>
        </select>
        @error('status')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror

    </div>
    </div>

    {{-- assign button --}}
    <div class="mt-4">

        @if ($editMaidAssignmentId)
            <button class="inline-flex items-center rounded-full bg-sky-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-sky-300" wire:click.prevent="assignedCleanerUpdate" type="button">Update</button>
        @else


        <button class="inline-flex items-center rounded-full bg-sky-400 px-4 py-2 text-sm font-semibold text-slate-950 transition hover:bg-sky-300" wire:click.prevent="assignCleaner" type="button" wire:click="assignCleaner">Assign</button>

        @endif

    </div>

        <ul class="mt-4 space-y-3">

            @foreach ($selectedCleaner as $item)
                <li class="rounded-2xl border border-sky-300/12 bg-slate-950/55">

                    <div class="flex flex-col gap-3 p-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="font-semibold text-slate-50">{{ $item->maid->name }}</p>
                            <p class="mt-1 text-xs uppercase tracking-[0.22em] text-sky-100/50">{{ $item->status }}</p>
                        </div>
                        <div class="flex gap-2">
                            <button class="inline-flex items-center rounded-full border border-sky-300/18 bg-sky-400/10 px-3 py-1.5 text-xs font-semibold text-sky-100 transition hover:bg-sky-400/18" type="button" wire:click="editCleaner({{ $item->id }})">Edit</button>
                            <button class="inline-flex items-center rounded-full border border-slate-300/18 bg-slate-100/10 px-3 py-1.5 text-xs font-semibold text-slate-100 transition hover:bg-slate-100/16" wire:click="deleteCleaner({{ $item->id }})">Delete</button>
                        </div>
                    </div>
                </li>
            @endforeach

                <div class="mt-4">
                    <button class="inline-flex items-center rounded-full border border-slate-300/18 bg-slate-100/10 px-4 py-2 text-sm font-semibold text-slate-100 transition hover:bg-slate-100/16" wire:click.prevent="removeAssignment" type="button">Remove Assignment</button>
                </div>

        </ul>



</form>






</div>
