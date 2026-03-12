<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-zinc-100 dark:bg-zinc-800" x-data="{ sidebarOpen: false }">

        {{-- Mobile overlay --}}
        <div
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 z-20 bg-black/50 lg:hidden"
            style="display:none"
        ></div>

        {{-- Sidebar --}}
        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col border-r border-zinc-200 bg-white transition-transform duration-300 dark:border-zinc-700 dark:bg-zinc-900 lg:translate-x-0"
        >
            {{-- Brand --}}
            <div class="flex h-16 shrink-0 items-center gap-3 border-b border-zinc-200 px-5 dark:border-zinc-700">
                <div class="flex size-8 items-center justify-center rounded-md bg-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">KPH Schedule</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6">

                <div>
                    <p class="mb-1 px-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Overview</p>
                    <a href="{{ route('dashboard') }}" wire:navigate
                        class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors
                            {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800' }}">
                        <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                        Dashboard
                    </a>
                </div>

                <div>
                    <p class="mb-1 px-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Management</p>
                    <div class="space-y-0.5">
                        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Clients
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                            Service Requests
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                            Schedule
                        </a>
                    </div>
                </div>

                <div>
                    <p class="mb-1 px-2 text-xs font-semibold uppercase tracking-wider text-zinc-400 dark:text-zinc-500">Team</p>
                    <div class="space-y-0.5">
                        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg>
                            Cleaners
                        </a>
                        <a href="#" class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                            Completed Services
                        </a>
                    </div>
                </div>

            </nav>

            {{-- Bottom: Settings + User --}}
            <div class="border-t border-zinc-200 px-3 py-3 dark:border-zinc-700 space-y-0.5">
                <a href="{{ route('profile.edit') }}" wire:navigate
                    class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                    <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
                    Settings
                </a>

                @php
                    $userName  = auth()->user()?->name  ?? 'User';
                    $userEmail = auth()->user()?->email ?? '';
                    $initials  = auth()->user()?->initials() ?? 'U';
                @endphp

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium text-zinc-700 transition-colors hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                        <div class="flex size-7 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold text-white">{{ $initials }}</div>
                        <div class="flex-1 min-w-0 text-left">
                            <p class="truncate text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $userName }}</p>
                            <p class="truncate text-xs text-zinc-500">{{ $userEmail }}</p>
                        </div>
                        <svg class="size-4 text-zinc-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m7 15 5 5 5-5"/><path d="m7 9 5-5 5 5"/></svg>
                    </button>

                    <div
                        x-show="open"
                        @click.outside="open = false"
                        x-transition
                        class="absolute bottom-full left-0 right-0 mb-1 rounded-lg border border-zinc-200 bg-white py-1 shadow-lg dark:border-zinc-700 dark:bg-zinc-900"
                        style="display:none"
                    >
                        <a href="{{ route('profile.edit') }}" wire:navigate
                            class="flex items-center gap-2 px-4 py-2 text-sm text-zinc-700 hover:bg-zinc-100 dark:text-zinc-300 dark:hover:bg-zinc-800">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Profile
                        </a>
                        <hr class="my-1 border-zinc-100 dark:border-zinc-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex w-full items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-zinc-100 dark:text-red-400 dark:hover:bg-zinc-800">
                                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                                Log out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        {{-- Top bar (mobile) --}}
        <div class="sticky top-0 z-10 flex h-14 items-center gap-3 border-b border-zinc-200 bg-white px-4 dark:border-zinc-700 dark:bg-zinc-900 lg:hidden">
            <button @click="sidebarOpen = true" class="rounded-md p-1.5 text-zinc-500 hover:bg-zinc-100 dark:hover:bg-zinc-800">
                <svg class="size-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">KPH Schedule</span>
        </div>

        {{-- Main content --}}
        <main class="min-h-screen lg:pl-64">
            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
