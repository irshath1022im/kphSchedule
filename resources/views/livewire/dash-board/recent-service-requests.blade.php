 <div class="lg:col-span-2 rounded-xl border border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4 dark:border-zinc-700/60">
                <h2 class="text-base font-semibold text-zinc-900 dark:text-zinc-100">Recent Service Requests</h2>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 dark:text-blue-400">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/60">
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Client</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Service Type</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Scheduled</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Assigned To</th>
                            <th class="px-5 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-700/60">
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
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-2.5">
                                    @php $parts = explode(' ', $req['client']); $ini = strtoupper(substr($parts[0],0,1).(isset($parts[1])?substr($parts[1],0,1):'')); @endphp
                                    <div class="flex size-7 shrink-0 items-center justify-center rounded-full bg-blue-100 text-xs font-semibold text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $ini }}</div>
                                    <span class="font-medium text-zinc-800 dark:text-zinc-100">{{ $req['client'] }}</span>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-300">{{ $req['service'] }}</td>
                            <td class="px-5 py-3.5 text-zinc-500 dark:text-zinc-400 whitespace-nowrap">{{ $req['date'] }}</td>
                            <td class="px-5 py-3.5 text-zinc-600 dark:text-zinc-300">{{ $req['cleaner'] }}</td>
                            <td class="px-5 py-3.5">
                                @if($req['status'] === 'in-progress')
                                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">In Progress</span>
                                @elseif($req['status'] === 'pending')
                                    <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900/30 dark:text-amber-400">Pending</span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-medium text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">Scheduled</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
</div>
