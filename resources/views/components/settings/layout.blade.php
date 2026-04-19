<div class="settings-shell">
    <div class="settings-nav-card">
        <flux:navlist aria-label="{{ __('Settings') }}">
            <flux:navlist.item :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
            <flux:navlist.item :href="route('security.edit')" wire:navigate>{{ __('Security') }}</flux:navlist.item>
            <flux:navlist.item :href="route('appearance.edit')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
        </flux:navlist>
    </div>

    <flux:separator class="md:hidden" />

    <div class="settings-content-card max-md:pt-6">
        <flux:heading class="settings-section-title">{{ $heading ?? '' }}</flux:heading>
        <flux:subheading class="settings-section-copy">{{ $subheading ?? '' }}</flux:subheading>

        <div class="settings-form-shell">
            {{ $slot }}
        </div>
    </div>
</div>
