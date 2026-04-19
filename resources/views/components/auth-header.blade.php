@props([
    'title',
    'description',
])

<div class="auth-header">
    <flux:heading size="xl" class="auth-title">{{ $title }}</flux:heading>
    <flux:subheading class="auth-description">{{ $description }}</flux:subheading>
</div>
