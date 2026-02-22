<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ $jobVacancy->title }}  - Job Details
        </h2>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-slate-900 via-blue-900 to-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 text-white/70 hover:text-white transition-colors duration-300 group">
                    <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    <span>Back to Jobs</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Job Header Card -->
                    <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 shadow-2xl">
                        <!-- Company Logo & Title -->
                        <div class="flex items-start gap-6 mb-6">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-20 h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-3xl font-bold text-white">
                                        {{ substr($jobVacancy->company->name, 0, 1) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h1 class="text-3xl sm:text-4xl font-bold text-white mb-2">
                                    {{ $jobVacancy->title }}
                                </h1>
                                <p class="text-xl text-blue-400 font-semibold">
                                    {{ $jobVacancy->company->name }}
                                </p>
                            </div>
                        </div>

                        <!-- Job Meta Information -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Location -->
                            <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/60 text-xs">Location</p>
                                    <p class="text-white font-medium">{{ $jobVacancy->location }}</p>
                                </div>
                            </div>

                            <!-- Job Type -->
                            <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/60 text-xs">Job Type</p>
                                    <p class="text-white font-medium">{{ $jobVacancy->type }}</p>
                                </div>
                            </div>

                            <!-- Salary -->
                            <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/60 text-xs">Salary</p>
                                    <p class="text-white font-medium">
                                        @if (isset($jobVacancy->salary))
                                            ${{ number_format($jobVacancy->salary) }}
                                        @else
                                            Competitive
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <!-- Posted Date -->
                            <div class="flex items-center gap-3 bg-white/5 rounded-xl p-4 border border-white/10">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/60 text-xs">Posted</p>
                                    <p class="text-white font-medium">{{ $jobVacancy->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Job Description Card -->
                    <div class="bg-white/10 backdrop-blur-xl rounded-3xl border border-white/20 p-8 shadow-2xl">
                        <h2 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Job Description
                        </h2>
                        <div class="prose prose-invert prose-lg max-w-none text-white/80 leading-relaxed space-y-4">
                            {!! nl2br(e($jobVacancy->description)) !!}
                        </div>
                    </div>

                    <!-- Apply Button -->
                    <div class="text-center">
                        <a href="{{ route('Job-Application.apply', $jobVacancy->id) }}"
                            class="inline-block bg-gradient-to-r from-green-400 to-blue-500 text-white font-semibold px-8 py-3 rounded-full shadow-lg hover:shadow-xl transition-shadow duration-300">
                            Apply Now
                        </a>
                    </div>

                    
                    
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
