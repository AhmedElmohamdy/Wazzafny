<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Job Vacancies {{ request()->input('Archived') == 'true' ? '(Archived)' : '' }}
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
                        <a href="{{ route('job-vacanceies.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            ← View Active Job Vacancies
                        </a>
                    @else
                        <!--Archived-->
                        <a href="{{ route('job-vacanceies.index', ['Archived' => 'true']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                        → View Archived Job Vacancies
                        </a>
                    @endif
                    <!-- add company button -->
                    <a href="{{ route('job-vacanceies.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-gray font-semibold rounded-lg shadow hover:bg-blue-700">
                        Add New Job Vacancy
                    </a>

                </div>
            </div>





            <table class="w-full rounded-lg shadow bg-white border-collapse">
                   <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Job Title
                        </th>



                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Company
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Category
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

                 <tbody class="bg-white">
                    @forelse ($JobVacancies as $JobVacancy)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <!-- Job Title -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobVacancy->title }}
                            </td>

                            <!-- Company Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobVacancy->company->name }}
                            </td>

                            <!-- Category Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $JobVacancy->category->name }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-5 text-sm flex gap-4">
                                @if (request()->input('Archived') == 'true')
                                    <!-- Restore -->
                                    <form action="{{ route('job-vacanceies.Restore', $JobVacancy->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium"
                                            onclick="return confirm('Restore this job vacancy?')">
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Show -->
                                    <a href="{{ route('job-vacanceies.details', $JobVacancy->id) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        View Details
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('job-vacanceies.edit', $JobVacancy->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>

                                    <!-- Archive -->
                                    <form action="{{ route('job-vacanceies.Archive', $JobVacancy->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('Archive this job vacancy?')">
                                            Archive
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No jobs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $JobVacancies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
