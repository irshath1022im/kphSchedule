<section class="settings-danger-panel mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading class="text-rose-50!">{{ __('Delete account') }}</flux:heading>
        <flux:subheading class="text-rose-100/78!">{{ __('Delete your account and all of its resources') }}</flux:subheading>
    </div>

    <flux:modal.trigger name="confirm-user-deletion">
        <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
            {{ __('Delete account') }}
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="settings-modal-panel max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <div>
                <flux:heading size="lg" class="text-slate-50!">{{ __('Are you sure you want to delete your account?') }}</flux:heading>

                <flux:subheading class="text-slate-300/72!">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </flux:subheading>
            </div>

            <flux:input wire:model="password" :label="__('Password')" type="password" viewable />

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <flux:modal.close>
                    <flux:button variant="filled">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" type="submit">{{ __('Delete account') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</section>
