<x-guest-layout class="bg-white">
    <form method="POST" action="{{ route('register') }}">
        @csrf


        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('First Name')" class="text-softwhite" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Last Name -->
        <div class="mt-4">
            <x-input-label for="last_name" :value="__('Last Name')" class="text-softwhite"/>
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- UserName -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" class="text-softwhite"/>
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-softwhite"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4 relative">
            <x-input-label for="password" :value="__('Password')" class="text-softwhite"/>

            <x-text-input id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />

            <span onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                <i id="eyeIconPassword" class="fa fa-eye text-gray-500 mt-6"></i>
            </span>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>


        <!-- Confirm Password -->
        <div class="mt-4 relative">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-softwhite"/>

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />

            <span onclick="togglePasswordVisibility('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                <i id="eyeIcon" class="fa fa-eye text-gray-500 mt-6"></i>
            </span>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>


        <div class="flex items-center justify-end mt-4">
            <div class="text-center">
                <span class="text-sm text-gray-100  ">
                    {{ __("Already have an account?") }}
                </span>
                <a class="underline text-sm text-gray-100  hover:text-gray-300 " href="{{ route('login') }}">
                    {{ __('Login here') }}
                </a>
            </div>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>


