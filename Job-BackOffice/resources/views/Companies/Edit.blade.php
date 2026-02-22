@php
    $isAdmin = auth()->user()->role === 'admin';
    $FormAction = $isAdmin 
        ? route('companies.store') 
        : route('My-Company.update');

    $owner = $owner ?? $company->owner;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Company - ') . $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">

            @if ($isAdmin)
                <a href="{{ route('companies.index') }}"
                    class="inline-flex items-center px-4 py-2 mb-4 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                    Back to Companies List
                </a>
            @endif

            <form action="{{ $FormAction }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $company->id }}">

                <!-- Company Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Company Details</h3>

                    <div class="mb-4">
                        <x-input-label for="name" value="Company Name" />
                        <x-text-input id="name" class="block mt-1 w-full" name="name" type="text"
                            value="{{ old('name', $company->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" value="Company Address" />
                        <x-text-input id="address" class="block mt-1 w-full" name="address" type="text"
                            value="{{ old('address', $company->address) }}" required />
                        <x-input-error :messages="$errors->get('address')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="website" value="Company Website" />
                        <x-text-input id="website" class="block mt-1 w-full" name="website" type="url"
                            value="{{ old('website', $company->website) }}" />
                        <x-input-error :messages="$errors->get('website')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="industry" value="Company Industry" />
                        <x-text-input id="industry" class="block mt-1 w-full" name="industry" type="text"
                            value="{{ old('industry', $company->industry) }}" required />
                        <x-input-error :messages="$errors->get('industry')" />
                    </div>
                </div>

                <!-- Owner Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Company Owner Details</h3>

                    <div class="mb-4">
                        <x-input-label for="owner_name" value="Owner Name" />
                        <x-text-input id="owner_name" class="block mt-1 w-full" name="owner_name" type="text"
                            value="{{ old('owner_name', $owner?->name) }}" required />
                        <x-input-error :messages="$errors->get('owner_name')" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="owner_email" value="Owner Email" />
                        <x-text-input id="owner_email" class="block mt-1 w-full bg-gray-100"
                            name="owner_email" type="email"
                            value="{{ old('owner_email', $owner?->email) }}" readonly />
                    </div>

                    <!-- Password -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-input-label value="Password (leave blank if not changing)" />

                        <div class="relative flex items-center">
                            <x-text-input id="owner_password" class="block mt-1 w-full pr-12"
                                x-bind:type="show ? 'text' : 'password'" name="owner_password" />

                            <button type="button"
                                class="absolute right-0 pr-4 text-gray-500 hover:text-gray-700"
                                @click="show = !show">

                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                    <path stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-width="2" d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('owner_password')" />
                    </div>
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        Update Company
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
