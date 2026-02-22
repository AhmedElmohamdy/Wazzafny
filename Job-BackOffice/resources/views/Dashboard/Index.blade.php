<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 px-6 space-y-6">

        <!-- Overview Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Active Users Card -->
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Active Users</h3>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $activeUsers }}</p>
                        <p class="text-sm text-gray-500">Total Active Users in Last 30 Days</p>
                    </div>
                    <div class="bg-indigo-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a6 6 0 006-6V4a2 2 0 00-2-2H4a2 2 0 00-2 2v10a6 6 0 006 6z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Jobs Card -->
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Jobs</h3>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalJobs }}</p>
                        <p class="text-sm text-gray-500">All Times</p>
                    </div>
                    <div class="bg-indigo-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a6 6 0 006-6V4a2 2 0 00-2-2H4a2 2 0 00-2 2v10a6 6 0 006 6z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Applications Card -->
            <div class="bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Applications</h3>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ $totalApplications }}</p>
                        <p class="text-sm text-gray-500">All Times</p>
                    </div>
                    <div class="bg-indigo-100 rounded-full p-3">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a6 6 0 006-6V4a2 2 0 00-2-2H4a2 2 0 00-2 2v10a6 6 0 006 6z"/>
                        </svg>
                    </div>
                </div>
            </div>

        </div>

        <!-- Most Applied Jobs Table -->
        <div class="mt-8 bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Most Applied Jobs</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Applications</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($mostAppliedJobs as $job)
                            <tr class="hover:bg-gray-50 cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $job['title'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $job['company'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">
                                        {{ $job['applications'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Conversion Rate Table -->
        <div class="mt-8 bg-white shadow-md rounded-lg p-6 hover:shadow-lg transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Conversion Rate</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applications</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Conversion Rate</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($conversionJobs as $job)
                            <tr class="hover:bg-gray-50 cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $job['title'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">{{ $job['views'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">{{ $job['applications'] }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-medium">{{ $job['conversion'] }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
