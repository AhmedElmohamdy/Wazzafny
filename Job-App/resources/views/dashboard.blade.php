<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Section -->
            <div class="bg-black shadow-lg rounded-xl p-6 mb-8">
                <h3 class="text-white text-3xl font-bold mb-2">
                    Welcome, {{ Auth::user()->name }} 👋
                </h3>
                <p class="text-gray-300">
                    Explore the latest job opportunities tailored for you.
                </p>
            </div>

            <!-- Search & Filter Section -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                <!-- Search Bar -->
                <form action="{{ route('dashboard') }}" method="GET" class="flex w-full md:w-1/2">
                    <input type="text"
                        name="search"
                        placeholder="Search by title, company, or location..."
                        value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 text-gray-900" />

                    <button type="submit"
                        class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-r-lg hover:bg-indigo-700 transition duration-200">
                        Search
                    </button>
                </form>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-3">
                    @foreach (['Full-Time', 'Part-Time', 'Contract', 'Hybrid'] as $type)
                        <a href="{{ route('dashboard', array_merge(request()->query(), ['type' => $type])) }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition duration-200
                            {{ request('type') == $type 
                                ? 'bg-indigo-600 text-white shadow-md' 
                                : 'bg-gray-200 text-gray-800 hover:bg-gray-300' }}">
                            {{ $type }}
                        </a>
                    @endforeach

                    @if(request('type'))
                        <a href="{{ route('dashboard', request()->except('type')) }}"
                            class="px-4 py-2 rounded-lg text-sm font-medium bg-red-500 text-white hover:bg-red-600 transition duration-200">
                            Clear
                        </a>
                    @endif
                </div>
            </div>

            <!-- Job Listings -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($jobVacancies as $job)
                    <div class="bg-gray-800 rounded-xl p-6 shadow-md hover:shadow-xl transition duration-300 flex flex-col justify-between">

                        <div>
                            <a href="{{ route('Job-Vacancies.show', $job->id) }}"
                                class="text-xl font-semibold text-blue-400 hover:underline">
                                {{ $job->title }}
                            </a>

                            <p class="text-gray-300 mt-2">
                                {{ optional($job->company)->name ?? 'No Company' }}
                                • {{ $job->location }}
                            </p>

                            <p class="text-gray-400 mt-1">
                                Salary: {{ $job->salary   ? '$' . number_format($job->salary) : 'Not Disclosed' }}
                            </p>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                {{ $job->type }}
                            </span>

                            <span class="text-gray-400 text-xs">
                                {{ $job->created_at->diffForHumans() }}
                            </span>
                        </div>

                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-400 text-lg py-10">
                        🚫 No job vacancies found.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $jobVacancies->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
