<div>
   <h3 class="underline">Assign Cleaner for
    {{  $service_request_id ? 'Service Request '.$service_request_id.' ' : 'Indivustual' }}

   </h3>

 {{-- // each requst can have 1 ore more cleaners assigned to it, but each cleaner can only be assigned to 1 request at a time.

 // --}}
<div wire:loading>
    <div class="flex items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12"></div>
    </div>
</div>

<form action="" wire:loading.remove>
    <div class="flex items-center gap-4 mb-4">
        <label for="cleaner" class="block text-sm font-medium text-gray-700">Select Cleaner:</label>
        <select id="cleaner" name="cleaner" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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

    {{-- status --}}
    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
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

    {{-- assign button --}}
    <div class="mt-4">

        @if ($editMaidAssignmentId)
            <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600" wire:click.prevent="assignedCleanerUpdate" type="button">Update</button>
        @else


        <button class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600" wire:click.prevent="assignCleaner" type="button" wire:click="assignCleaner">Assign</button>

        @endif

    </div>

        <ul class="mt-4">

            @foreach ($selectedCleaner as $item)
                <li class="border rounded mb-2">

                    <div class="flex items-center justify-between p-2 ">
                        {{ $item->maid->name }}
                         <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600" type="button" wire:click="editCleaner({{ $item->id }})">Edit</button>
                        <button class="text-red-500" wire:click="deleteCleaner({{ $item->id }})">Delete</button>
                    </div>
                </li>
            @endforeach

                <div class="mt-4">
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600" wire:click.prevent="removeAssignment" type="button">Remove Assignment</button>
                </div>

        </ul>



</form>






</div>
