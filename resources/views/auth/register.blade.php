<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                          type="password"
                          name="password"
                          required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password"
                          name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <style>
        :root {
            --primary-green: #2e7d32;
            --light-green: #4caf50;
            --dark-green: #1b5e20;
        }

        .text-gray-600 {
            color: var(--primary-green);
        }

        .text-gray-900 {
            color: var(--dark-green);
        }

        .dark\:text-gray-400 {
            color: var(--primary-green);
        }

        .dark\:text-gray-100 {
            color: var(--light-green);
        }

        .focus\:ring-indigo-500 {
            --tw-ring-color: var(--primary-green);
        }

        .focus\:ring-green-500 {
            --tw-ring-color: var(--primary-green);
        }

        .bg-gray-900 {
            background-color: var(--dark-green);
        }

        .bg-gray-800 {
            background-color: var(--primary-green);
        }

        .bg-indigo-600 {
            background-color: var(--primary-green);
        }

        .bg-indigo-500 {
            background-color: var(--light-green);
        }

        .hover\:bg-indigo-700 {
            background-color: var(--dark-green);
        }

        .hover\:bg-indigo-600 {
            background-color: var(--primary-green);
        }

        .hover\:text-gray-900 {
            color: var(--dark-green);
        }

        .dark\:hover\:text-gray-100 {
            color: var(--light-green);
        }

        .border-gray-300 {
            border-color: #cbd5e1;
        }

        .border-gray-300:focus {
            border-color: var(--primary-green);
            --tw-ring-color: var(--primary-green);
        }

        .dark\:border-gray-700 {
            border-color: #4b5563;
        }

        .dark\:border-gray-700:focus {
            border-color: var(--primary-green);
            --tw-ring-color: var(--primary-green);
        }

        .text-red-600 {
            color: #dc2626;
        }

        .text-red-500 {
            color: #dc2626;
        }

        .dark\:text-red-400 {
            color: #f87171;
        }
    </style>
</x-guest-layout>
