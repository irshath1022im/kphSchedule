   {{-- show all the errors in a list --}}
        <div>
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 p-4">
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
