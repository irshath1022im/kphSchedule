 <div class="lg:col-span-2 ops-panel">
            <div class="ops-panel-header">
                <div>
                    <h2 class="ops-panel-title">Recent Service Requests</h2>
                    <p class="ops-panel-copy">Latest bookings flowing through the daily operations queue.</p>
                </div>
                <a href="#" class="ops-link">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="ops-table-head">
                            <th class="px-5 py-3">Client</th>
                            <th class="px-5 py-3">Service Type</th>
                            <th class="px-5 py-3">Scheduled</th>
                            <th class="px-5 py-3">Assigned To</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="ops-table-body">
                        @php
                            $requests = [
                                ['client'=>'Maria Santos',   'service'=>'Deep Cleaning',     'date'=>'Today, 09:00 AM', 'cleaner'=>'Ana Reyes',    'status'=>'in-progress', 'color'=>'blue'],
                                ['client'=>'John Cruz',      'service'=>'Regular Cleaning',  'date'=>'Today, 11:00 AM', 'cleaner'=>'Ben Torres',   'status'=>'pending',     'color'=>'amber'],
                                ['client'=>'Liza Gomez',     'service'=>'Move-out Clean',    'date'=>'Today, 02:00 PM', 'cleaner'=>'Unassigned',   'status'=>'pending',     'color'=>'amber'],
                                ['client'=>'Carlos dela Cruz','service'=>'Office Cleaning',  'date'=>'Mar 13, 08:00 AM','cleaner'=>'Joy Villanueva','status'=>'scheduled',  'color'=>'emerald'],
                                ['client'=>'Rosa Mendez',    'service'=>'Post-Event Clean',  'date'=>'Mar 14, 10:00 AM','cleaner'=>'Unassigned',   'status'=>'pending',     'color'=>'amber'],
                                ['client'=>'Pedro Bautista', 'service'=>'Regular Cleaning',  'date'=>'Mar 15, 09:00 AM','cleaner'=>'Ana Reyes',    'status'=>'scheduled',   'color'=>'emerald'],
                            ];
                        @endphp
                        @foreach($requests as $req)
                        <tr class="ops-table-row">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    @php $parts = explode(' ', $req['client']); $ini = strtoupper(substr($parts[0],0,1).(isset($parts[1])?substr($parts[1],0,1):'')); @endphp
                                    <div class="ops-avatar">{{ $ini }}</div>
                                    <span class="font-medium text-slate-100">{{ $req['client'] }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-slate-300">{{ $req['service'] }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-400">{{ $req['date'] }}</td>
                            <td class="px-5 py-3.5 text-slate-300">{{ $req['cleaner'] }}</td>
                            <td class="px-5 py-3.5">
                                @if($req['status'] === 'in-progress')
                                    <span class="ops-status-chip ops-status-busy">In Progress</span>
                                @elseif($req['status'] === 'pending')
                                    <span class="ops-status-chip ops-status-scheduled">Pending</span>
                                @else
                                    <span class="ops-status-chip ops-status-available">Scheduled</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
</div>
