<x-jet-form-section submit="updatePassword">
    <x-slot name="title">
        {{ __('Update Password') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </x-slot>


    <x-slot name="form">
        @if (auth()->user()->role_id == 3)
            <div class="text-warning">Disabled in Demo</div>
        @else
            <div class="row">
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <div class="mb-1">
                        <x-jet-label class="form-label" for="current_password"
                            value="{{ __('Current Password') }}" />
                        <x-jet-input id="current_password" type="password"
                            class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}"
                            wire:model.defer="state.current_password" autocomplete="current-password" />
                        <x-jet-input-error for="current_password" />
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">
                    <div class="mb-1">
                        <x-jet-label class="form-label" for="password" value="{{ __('New Password') }}" />
                        <x-jet-input id="password" type="password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            wire:model.defer="state.password" autocomplete="new-password" />
                        <x-jet-input-error for="password" />
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-lg-4">

                    <div class="mb-1">
                        <x-jet-label class="form-label" for="password_confirmation"
                            value="{{ __('Confirm Password') }}" />
                        <x-jet-input id="password_confirmation" type="password"
                            class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                        <x-jet-input-error for="password_confirmation" />
                    </div>
                </div>
            </div>
        @endif
    </x-slot>

    @if (auth()->user()->role_id != 3)
        <x-slot name="actions">
            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    @endif
</x-jet-form-section>
