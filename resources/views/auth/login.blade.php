<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-softwhite" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" class="text-softwhite" />

            <x-text-input id="password" class="block mt-1 w-full pr-10"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <!-- Eye Icon -->
            <span onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                <i id="eyeIcon" class="fa fa-eye text-gray-500  mt-6"></i>
            </span>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300  text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-100">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-100 hover:text-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <span class="text-sm text-gray-100  ">
                {{ __("Don't have an account?") }}
            </span>
            <a class="underline text-sm text-gray-100  hover:text-gray-300 " href="{{ route('register') }}">
                {{ __('Register here') }}
            </a>
        </div>
    </form>
</x-guest-layout>
