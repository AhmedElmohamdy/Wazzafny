<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Company') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('companies.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                Back to Companies List
            </a>

            <form action="{{ route('companies.store') }}" method="POST"
                class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
                @csrf

                <!-- Company Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Company Details</h3>
                    <!--  Name -->
                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Company Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!--  Address -->
                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Company Address')" />
                        <x-text-input id="address" class="block mt-1 w-full" type="text" name="address"
                            :value="old('address')" required />
                        <x-input-error :messages="$errors->get('address')" class="mt-2" />

                    </div>

                    <!--  Website -->
                    <div class="mb-4">
                        <x-input-label for="website" :value="__('Company Website')" />
                        <x-text-input id="website" class="block mt-1 w-full" type="url" name="website"
                            :value="old('website')" />
                        <x-input-error :messages="$errors->get('website')" class="mt-2" />
                    </div>


                    <!--  Industry -->
                    <div class="mb-4">
                        <x-input-label for="industry" :value="__('Company Industry')" />
                        <x-text-input id="industry" class="block mt-1 w-full" type="text" name="industry"
                            :value="old('industry')" required />
                        <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                    </div>
                </div>

                <!--Company Owner -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Company Owner Details</h3>

                    <!--  Name -->
                    <div class="mb-4">
                        <x-input-label for="owner_name" :value="__('Owner Name')" />
                        <x-text-input id="owner_name" class="block mt-1 w-full" type="text" name="owner_name"
                            :value="old('owner_name')" required autofocus />
                        <x-input-error :messages="$errors->get('owner_name')" class="mt-2" />
                    </div>

                    <!--  Email -->
                    <div class="mb-4">
                        <x-input-label for="owner_email" :value="__('Owner Email')" />
                        <x-text-input id="owner_email" class="block mt-1 w-full" type="email" name="owner_email"
                            :value="old('owner_email')" required />
                        <x-input-error :messages="$errors->get('owner_email')" class="mt-2" />
                    </div>
                    <!--  Phone -->
                    <div class="mb-4">
                        <x-input-label for="owner_phone" :value="__('Owner Phone')" />
                        <x-text-input id="owner_phone" class="block mt-1 w-full" type="text" name="owner_phone"
                            :value="old('owner_phone')" required />
                        <x-input-error :messages="$errors->get('owner_phone')" class="mt-2" />
                    </div>

                    <!-- Owner Password -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-input-label for="owner_password" :value="__('Password')" />

                        <div class="relative flex items-center">
                            <x-text-input id="owner_password" class="block mt-1 w-full pr-12"
                                x-bind:type="show ? 'text' : 'password'" name="owner_password" required
                                autocomplete="current-password" />
                            <!-- Eye Icon for Show/Hide Password -->
                            <button type="button"
                                class="absolute right-0 pr-4 text-gray-500 hover:text-gray-700 focus:outline-none"
                                @click="show = !show">
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825a9.56 9.56 0 01-1.875.175c-4.478 0-8.268-2.943-9.542-7 1.002-3.364 3.843-6 7.542-7.575M15 12a3 3 0 00-6 0 3 3 0 006 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Create Company') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

</x-app-layout>
