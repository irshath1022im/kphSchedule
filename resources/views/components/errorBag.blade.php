   {{-- show all the errors in a list --}}
        <div>
            @if ($errors->any())
                <div class="error-panel">
                    <ul class="error-panel-list">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
