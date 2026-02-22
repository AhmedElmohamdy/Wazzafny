<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Job Details — {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <!-- Notifications -->
    <div class="overflow-x-auto p-6">
        <x-notification />
    </div>

    <div class="overflow-x-auto p-6">

        <!-- Back Button -->
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('job-vacanceies.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                ← Back to Jobs List
            </a>
        </div>

        <!-- Job Information -->
        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow mb-6">
            <h3 class="text-xl font-bold mb-4">Job Information</h3>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Job Description" />
                <p class="mt-1 text-gray-700">
                    {{ $jobVacancy->description }}
                </p>
            </div>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Location" />
                <p class="mt-1 text-gray-700">
                    {{ $jobVacancy->company->address }}
                </p>
            </div>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Salary" />
                <p class="mt-1 text-gray-700">
                    {{ number_format($jobVacancy->salary, 2) }}
                </p>
            </div>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" value="Job Type" />
                <p class="mt-1 text-gray-700">
                    {{ ucfirst($jobVacancy->type) }}
                </p>
            </div>
        </div>

        <!-- Tabs -->
        <div class="max-w-2xl mx-auto mt-6">
            <ul class="flex border-b">
                <li class="mr-1">
                    <a href="{{ route('job-vacanceies.details', ['jobVacancy' => $jobVacancy->id, 'tab' => 'applications']) }}"
                        class="inline-block px-4 py-2 rounded-t-lg bg-white font-semibold
                        {{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2 border-blue-600' :'' }}">
                        Job Applications
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="max-w-2xl mx-auto mt-4">
            <div id="applications" class="{{ request('tab') == 'applications' || request('tab') =='' ? 'block' : 'hidden' }}">

                <h3 class="text-2xl font-bold mb-4">Job Applications</h3>

                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 text-left">Applicant Name</th>
                            <th class="px-4 py-2 text-left">Job Title</th>
                            <th class="px-4 py-2 text-left">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($jobVacancy->jobApplications as $application)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ $application->user->name }}
                                </td>

                                <td class="px-4 py-2">
                                    {{ $jobVacancy->title }}
                                </td>

                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 text-sm rounded
                                        {{ $application->status === 'accepted'
                                            ? 'bg-green-100 text-green-700'
                                            : ($application->status === 'rejected'
                                                ? 'bg-red-100 text-red-700'
                                                : 'bg-yellow-100 text-yellow-700') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                    No applications found for this job.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
</x-app-layout>
