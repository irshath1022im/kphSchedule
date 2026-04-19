<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="auth-shell-body">
        <div class="auth-shell-center">
            <div class="auth-shell-form-wrap auth-shell-form-wrap-narrow gap-4">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="auth-shell-brand-mark mb-1 h-9 w-9">
                        <x-app-logo-icon class="size-9 fill-current text-sky-100" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="auth-shell-card flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
