<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add New Job') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('job-vacanceies.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                 ← Back to List
            </a>

            <form action="{{ route('job-vacanceies.store') }}" method="POST"
                class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
                @csrf

                <!-- Job Details -->
                <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Job Details</h3>
                    <!--  Title -->
                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Job Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Job Description')" />
                        <textarea id="description" name="description" rows="4"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <!-- Location -->
                    <div class="mb-4">
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input id="location" class="block mt-1 w-full" type="text" name="location"
                            :value="old('location')" required />
                        <x-input-error :messages="$errors->get('location')" class="mt-2" />
                    </div>

                    <!-- Salary -->
                    <div class="mb-4">
                        <x-input-label for="salary" :value="__('Salary')" />
                        <x-text-input id="salary" class="block mt-1 w-full" type="number" name="salary"
                            :value="old('salary')" step="0.01" />
                        <x-input-error :messages="$errors->get('salary')" class="mt-2" />
                    </div>
                    <!-- Job Type -->
                    <div class="mb-4">
                        <x-input-label for="type" :value="__('Job Type')" />
                        <select id="type" name="type"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="full-time" {{ old('type') == 'full-time' ? 'selected' : '' }}>Full-time
                            </option>
                            <option value="part-time" {{ old('type') == 'part-time' ? 'selected' : '' }}>Part-time
                            </option>
                            <option value="contract" {{ old('type') == 'contract' ? 'selected' : '' }}>Contract
                            </option>
                            <option value="hybrid" {{ old('type') == 'hybrid' ? 'selected' : '' }}>Hybrid
                            </option>
                        </select>
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>

                    <!-- Company -->
                    <div class="mb-4">
                        <x-input-label for="company_id" :value="__('Company')" />
                        <select id="company_id" name="company_id"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="">Select a Company</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('company_id')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Job Category')" />
                        <select id="category_id" name="category_id"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            required>
                            <option value="">Select a Category</option>
                            @foreach ($jobCategories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                </div>


                <!-- Submit Button -->
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ml-4">
                        {{ __('Create Job') }}
                    </x-primary-button>
                </div>
            </form>
        </div>

</x-app-layout>
