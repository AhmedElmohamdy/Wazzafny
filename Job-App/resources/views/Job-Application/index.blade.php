<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            My Applications
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Applications List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-2xl font-bold mb-6">Your Job Applications</h3>

                    @if($JobApplications->count() > 0)
                        <div class="space-y-4">
                            @foreach($JobApplications as $application)
                                <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex-1">
                                            <!-- Job Title -->
                                            <h4 class="text-xl font-semibold text-gray-900">
                                                {{ $application->jobVacancy->title ?? 'N/A' }}
                                            </h4>
                                            
                                            <!-- Company Name -->
                                            <p class="text-gray-600">
                                                {{ $application->jobVacancy->company->name ?? 'N/A' }}
                                            </p>
                                            
                                            <!-- Applied Date -->
                                            <p class="text-sm text-gray-500 mt-2">
                                                Applied: {{ $application->created_at->format('M d, Y') }}
                                            </p>
                                        </div>

                                        <!-- AI Match Score -->
                                        <div class="text-center ml-4">
                                            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full
                                                @if($application->aiGeneratedScore >= 80) bg-green-100 text-green-700
                                                @elseif($application->aiGeneratedScore >= 60) bg-yellow-100 text-yellow-700
                                                @else bg-red-100 text-red-700
                                                @endif">
                                                <div>
                                                    <div class="text-2xl font-bold">
                                                        {{ $application->aiGeneratedScore ?? 0 }}
                                                    </div>
                                                    <div class="text-xs">Match</div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Status Badge -->
                                        <div class="ml-4">
                                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                                @if($application->status == 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($application->status == 'accepted') bg-green-100 text-green-800
                                                @elseif($application->status == 'rejected') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($application->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- AI Feedback -->
                                    @if($application->aigeneratedFeedback)
                                        <div class="mt-4 bg-blue-50 p-4 rounded-lg">
                                            <h5 class="font-semibold text-blue-900 mb-2 flex items-center">
                                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                                </svg>
                                                AI Feedback
                                            </h5>
                                            <p class="text-gray-700 text-sm">{{ $application->aigeneratedFeedback }}</p>
                                        </div>
                                    @endif

                                    <!-- Cover Letter Preview -->
                                    @if($application->cover_letter)
                                        <div class="mt-4">
                                            <button 
                                                onclick="toggleCoverLetter({{ $application->id }})" 
                                                class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                View Cover Letter
                                            </button>
                                            <div id="cover-letter-{{ $application->id }}" class="hidden mt-2 p-4 bg-gray-50 rounded-lg">
                                                <p class="text-gray-700 whitespace-pre-line">{{ $application->cover_letter }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Resume Link -->
                                    @if($application->resume)
                                        <div class="mt-4">
                                            <a href="{{ $application->resume->file_url }}" 
                                               target="_blank"
                                               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                View Resume
                                            </a>
                                        </div>
                                    @endif

                                    <!-- Job Details Link -->
                                    <div class="mt-4 pt-4 border-t">
                                        <a href="{{ route('Job-Vacancies.show', $application->jobVacancy->id) }}" 
                                           class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                            View Job Details →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                      

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No applications yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by applying to your first job.</p>
                            <div class="mt-6">
                                <a href="{{ route('dashboard') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse Jobs
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Cover Letter Toggle -->
    <script>
        function toggleCoverLetter(applicationId) {
            const element = document.getElementById('cover-letter-' + applicationId);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        }
    </script>
</x-app-layout>