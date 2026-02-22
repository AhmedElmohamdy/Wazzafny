<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Job Categories') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('job-categories.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                Back to CategoriesList
            </a>

        <form action="{{ route('job-categories.store') }}" method="POST" class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @csrf
            <!-- Hidden ID Field -->
            <div class="mb-4">
               
                <x-text-input id="id" class="block mt-1 w-full" type="hidden" name="id" :value="old('id', $jobCategory->id)"  />
            </div>

            <!-- Category Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Category Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $jobCategory->name)" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="ml-4">
                    {{ __('Update Category') }}
                </x-primary-button>
            </div>
        </form>
    </div>

</x-app-layout>