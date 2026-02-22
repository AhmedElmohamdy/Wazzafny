<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Jobs Applications {{ request()->input('Archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <!-- Notification Component -->
    <div class="overflow-x-auto p-6">
        <x-notification />
    </div>

    <!-- Full width container -->
    <div class="w-full px-6 py-6">

        <!-- Table wrapper -->
        <div class="w-full overflow-x-auto">
            <div class="flex justify-end items-center space-x-4 mb-4">
                <div>

                    @if (request()->input('Archived') == 'true')
                        <!--- Active Categories -->
                        <a href="{{ route('job-applications.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            View Active Job Applications
                        </a>
                    @else
                        <!--Archived-->
                        <a href="{{ route('job-applications.index', ['Archived' => 'true']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            View Archived Job Applications
                        </a>
                    @endif
                </div>
            </div>





            <table class="w-full rounded-lg shadow bg-white border-collapse">
                <thead class="bg-gray-50">
                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            <!-- Job Vacancy -->
                            Applicant Name
                        </th>

                        <th
                                class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                                Job Vacancy
                            </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Company Name
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Status
                        </th>
                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @forelse ($JobApplications as $JobApplication)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <!-- Applicant Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobApplication->user->name }}
                            </td>

                            <!-- Job Vacancy -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobApplication->jobVacancy->title }}
                            </td>

                            <!-- Company Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobApplication->jobVacancy->company->name }}
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobApplication->status }}   
                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5 text-sm flex gap-4">
                                @if (request()->input('Archived') == 'true')
                                    <!-- Restore -->
                                    <form action="{{ route('job-applications.Restore', $JobApplication->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium"
                                            onclick="return confirm('Restore this job application?')">
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Show -->
                                    <a href="{{ route('job-applications.details', $JobApplication->id) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        View Details
                                    </a>

                                    <!-- Archive -->
                                    <form action="{{ route('job-applications.Archive', $JobApplication->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('Archive this job application?')">
                                            Archive
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No job applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $JobApplications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
