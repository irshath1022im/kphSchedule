<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="auth-shell-body">
        <div class="auth-shell-grid">
            <div class="auth-shell-side">
                <a href="{{ route('home') }}" class="auth-shell-brand" wire:navigate>
                    <span class="auth-shell-brand-mark">
                        <x-app-logo-icon class="me-0 h-7 fill-current text-sky-100" />
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="auth-shell-quote">
                    <blockquote class="space-y-2">
                        <flux:heading size="lg" class="text-slate-50!">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                        <footer><flux:heading class="text-sky-100/75!">{{ trim($author) }}</flux:heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="auth-shell-main">
                <div class="auth-shell-form-wrap auth-shell-form-wrap-narrow">
                    <a href="{{ route('home') }}" class="auth-shell-logo-mobile" wire:navigate>
                        <span class="auth-shell-brand-mark h-9 w-9">
                            <x-app-logo-icon class="size-9 fill-current text-sky-100" />
                        </span>

                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <div class="auth-shell-card">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
