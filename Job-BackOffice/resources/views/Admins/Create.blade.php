<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Admin') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('admins.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                Back to Admins List
            </a>

            <form action="{{ route('admins.store') }}" method="POST"
                class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
                @csrf



                <!-- Admin Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Details</h3>

                    <!--  Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Admin Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!--  Email -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Admin Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Admin Password -->
                    <div class="mt-4 relative" x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" />

                        <x-text-input id="password" class="block mt-1 w-full pr-12"
                            x-bind:type="show ? 'text' : 'password'" name="password" required />

                        <!-- Eye Icon -->
                        <button type="button"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700"
                            @click="show = !show">

                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7
                -1.274 4.057-5.064 7-9.542 7
                -4.478 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />


                </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Create Admin') }}
            </x-primary-button>
        </div>
        </form>
    </div>

</x-app-layout>
