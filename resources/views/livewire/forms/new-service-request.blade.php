<div>
    {{-- If you do not have a consistent goal in life, you can not live it in a consistent way. - Marcus Aurelius --}}
    <div class="ops-panel">
        <div class="ops-panel-header">
            <div>
                <p class="ops-eyebrow">Service Operations</p>
                <h1 class="mt-1 text-2xl font-bold text-slate-50">
                    {{ $request_id ? "Update Service Request" : "Create Service Request" }}
                </h1>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <form class="space-y-6">
                <div class="ops-form-section">
                    <h2 class="ops-form-section-title">Request Details</h2>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="client" class="ops-form-label">Client</label>
                            <select id="client" name="client" class="ops-form-input" wire:model="client_id">
                                <option value="">Select a client</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            @error("client_id")
                                <span class="ops-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="service_request_date" class="ops-form-label">Service Request Date</label>
                            <input type="date" id="service_request_date" name="service_request_date" class="ops-form-input" wire:model="service_request_date">
                            @error("service_request_date")
                                <span class="ops-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="service_request_type" class="ops-form-label">Service Request Type</label>
                            <select id="service_request_type" name="service_request_type" class="ops-form-input" wire:model="frequency">
                                <option value="">Select a service request type</option>
                                @foreach ($frequencies as $frequency)
                                    <option value="{{ $frequency }}">{{ ucfirst($frequency) }}</option>
                                @endforeach
                            </select>
                            @error("frequency")
                                <span class="ops-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- status column --}}
                        <div>
                            <label for="status" class="ops-form-label">Status</label>
                            <select id="status" name="status" class="ops-form-input" wire:model="status">
                                <option value="">Select a status</option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            @error("status")
                                <span class="ops-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="ops-form-section">
                    <h2 class="ops-form-section-title">Notes</h2>

                    <div>
                        <label for="service_request_description" class="ops-form-label">Service Request Description</label>
                        <textarea id="service_request_description" name="service_request_description" rows="5" class="ops-form-textarea" wire:model="notes" placeholder="Write a clear description for this request..."></textarea>
                        @error("notes")
                            <span class="ops-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    @if ($request_id)
                        <button type="submit" class="ops-btn-primary" wire:click.prevent="newRequest">
                            Update Request
                        </button>
                    @else
                        <button type="submit" class="ops-btn-primary" wire:click.prevent="newRequest">
                            Submit Request
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
