<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User - ' . $users->name) }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">

            <!-- Back Button -->
            <a href="{{ route('users.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300 mb-4">
                Back to Users List
            </a>

            <!-- Form -->
            <form action="{{ route('users.update', $users->id) }}" method="POST">
                @csrf
               
                 <div class="mb-4">
                       
                        <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id"
                            value="{{ old('id', $users->id) }}"  />
                        <x-input-error :messages="$errors->get('id')" class="mt-2" />
                    </div>

                <!-- User Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">User Details</h3>

                    <!-- Name -->
                    <div class="mb-4">
                        <x-input-label for="name" value="User Name" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            value="{{ old('name', $users->name) }}" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <x-input-label for="email" value="User Email" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            value="{{ old('email', $users->email) }}" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <x-input-label for="role" value="Role" />
                        <x-text-input id="role" class="block mt-1 w-full" type="text" name="role"
                            value="{{ old('role', $users->role) }}" required />
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-input-label for="password" value="Password (Leave blank if not changing)" />

                        <div class="relative flex items-center">
                            <x-text-input id="password" class="block mt-1 w-full pr-12"
                                x-bind:type="show ? 'text' : 'password'" 
                                name="password"
                                autocomplete="new-password" />

                            <button type="button"
                                class="absolute right-0 pr-4 text-gray-500 hover:text-gray-700"
                                @click="show = !show">

                                <!-- Show Icon -->
                                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                </svg>

                                <!-- Hide Icon -->
                                <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3l18 18" />
                                </svg>
                            </button>
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                </div>

                <!-- Submit -->
                <div class="flex justify-end mt-4">
                    <x-primary-button>
                        Update User
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>

</x-app-layout>
