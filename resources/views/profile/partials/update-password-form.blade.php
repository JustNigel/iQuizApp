<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 ">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 ">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="relative">
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <i id="eyeIconCurrent" class="fas fa-eye absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer mt-6 text-gray-500 mt-9" onclick="togglePasswordVisibility('update_password_current_password', 'eyeIconCurrent')"></i>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div >

        <div class="relative">
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <i id="eyeIconNew" class="fas fa-eye absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer mt-6 text-gray-500 mt-9" onclick="togglePasswordVisibility('update_password_password', 'eyeIconNew')"></i>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div >

        <div class="relative">
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <i id="eyeIconConfirm" class="fas fa-eye absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer mt-6 text-gray-500 mt-9" onclick="togglePasswordVisibility('update_password_password_confirmation', 'eyeIconConfirm')"></i>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 "
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
@include('partials.password-eye')
