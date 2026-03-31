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
            wire:model.live="maid_id"
        >
            <option value="">-- Select a cleaner --</option>
            @foreach ($maids as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>


        <ul class="mt-4">

            @foreach ($selectedCleaner as $item)
                <li class="border rounded mb-2">
                    <div class="flex items-center justify-between p-2 ">
                        {{ $item->maid->name }} <button class="text-red-500" wire:click="deleteCleaner({{ $item->id }})">Delete</button>
                    </div>
                </li>
            @endforeach

                <div>
                    <button class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600" wire:click.prevent="removeAssignment">Remove Assignment</button>
                </div>

        </ul>

   
</form>






</div>
