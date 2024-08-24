<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thank you for verifying your account! Please wait for the Admin to confirm your registration.') }}
    </div>

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log In') }}
            </button>
        </form>
    </div>

    <x-auto-refresh-component />

</x-guest-layout>
