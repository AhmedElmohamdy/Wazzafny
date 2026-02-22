<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" class="text-white" :value="__('Name')" />
            <x-text-input id="name" class="block mt-2 w-full text-gray-900" placeholder="Your name" type="text"
                name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" class="text-white" :value="__('Email')" />
            <x-text-input id="email" class="block mt-2 w-full text-gray-900" placeholder="you@example.com"
                type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label for="password" class="text-white" :value="__('Password')" />

            <div class="relative mt-2">
                <x-text-input x-bind:type="show ? 'text' : 'password'" id="password"
                    class="block mt-2 w-full pr-10 text-gray-700" placeholder="Choose a strong password" name="password"
                    required autocomplete="new-password" />

                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 3C5.5 3 1.73 6.11.5 10c1.23 3.89 5 7 9.5 7s8.27-3.11 9.5-7C18.27 6.11 14.5 3 10 3zM10 14a4 4 0 110-8 4 4 0 010 8z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0110 19c-4.5 0-8.27-3.11-9.5-7a10.05 10.05 0 012.59-4.11M6.18 6.18A9.97 9.97 0 0110 5c4.5 0 8.27 3.11 9.5 7a10.05 10.05 0 01-1.53 3.01M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4" x-data="{ show: false }">
            <x-input-label class="text-white" for="password_confirmation" :value="__('Confirm Password')" />

            <div class="relative mt-2">
                <x-text-input x-bind:type="show ? 'text' : 'password'" id="password_confirmation"
                    class="block mt-2 w-full pr-10 text-gray-700" placeholder="Confirm your password"
                    name="password_confirmation" required autocomplete="new-password" />

                <button type="button" @click="show = !show"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500">
                    <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path
                            d="M10 3C5.5 3 1.73 6.11.5 10c1.23 3.89 5 7 9.5 7s8.27-3.11 9.5-7C18.27 6.11 14.5 3 10 3zM10 14a4 4 0 110-8 4 4 0 010 8z" />
                    </svg>
                    <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0110 19c-4.5 0-8.27-3.11-9.5-7a10.05 10.05 0 012.59-4.11M6.18 6.18A9.97 9.97 0 0110 5c4.5 0 8.27 3.11 9.5 7a10.05 10.05 0 01-1.53 3.01M3 3l18 18" />
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}"
                class="group relative text-sm font-medium text-purple-400 transition duration-300">

                <span class="relative">
                    Already registered?
                    <span
                        class="absolute left-0 -bottom-1 h-[2px] w-0 bg-gradient-to-r from-purple-400 to-indigo-400 transition-all duration-300 group-hover:w-full"></span>
                </span>

            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
