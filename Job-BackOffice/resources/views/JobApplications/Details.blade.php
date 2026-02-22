<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Application Details — {{ $JobApplication->jobVacancy->title }}
        </h2>
    </x-slot>

    <!-- Notifications -->
    <div class="overflow-x-auto p-6">
        <x-notification />
    </div>

    <div class="overflow-x-auto p-6">

        <!-- Back Button -->
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('job-applications.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                ← Back to Applications List
            </a>
        </div>

        <!-- Job Information -->
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-bold mb-4">Application Information</h3>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Applicant Name :" />
                <p class="mt-1 text-gray-700">
                    {{ $JobApplication->user->name }}
                </p>
            </div>

            <!-- Applicant Feedback -->
            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Feedback :" />
                <p class="mt-1 text-gray-700">
                    {{ $JobApplication->aigeneratedFeedback }}
                </p>
            </div>

            <!-- Applicant Score -->
            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Score :" />
                <p class="mt-1 text-gray-700">
                    {{ number_format($JobApplication->aiGeneratedScore, 2) }}
                </p>
            </div>

            <!-- Resume Link -->
            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Resume :" />
                <a href="{{ $JobApplication->resume?->file_url }}" class="text-blue-600 hover:underline"
                    target="_blank">
                    {{ $JobApplication->resume?->file_name ?? 'Not Available' }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
