<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Details of Companies {{ request()->input('Archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <!-- Notification Component -->
    <div class="overflow-x-auto p-6">
        <x-notification />
    </div>

    <div class="overflow-x-auto p-6">

        @if(auth()->user()->role=='admin')
        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">
            <a href="{{ route('companies.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-semibold rounded-md shadow hover:bg-gray-300">
                Back to Companies List
            </a>
        </div>
        @endif

        <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow mb-6">

             @if(auth()->user()->role=='admin')
            <!-- Edit -->
            <a href="{{ route('companies.edit ' ) }}" class="text-indigo-600 hover:text-indigo-900">
                Edit
            </a>
            @else

            <a href="{{ route('My-Company.edit', $company->id) }}" class="text-indigo-600 hover:text-indigo-900">
                Edit Information
            </a>
            @endif

        </div>



        <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow">
            <h3 class="text-xl font-bold mb-4">Company Information</h3>

            <div class="mb-4">
                <x-input-label :value="__('Company Address :')" class="font-semibold text-gray-800" />
                <p class="mt-1 text-gray-700">{{ $company->address }}</p>
            </div>

            <div class="mb-4">
                <x-input-label :value="__('Company Email :')" class="font-semibold text-gray-800" />
                <p class="mt-1 text-gray-700">{{ $company->owner->email }}</p>
            </div>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" :value="__('Website :')" />
                <p class="text-blue-600 hover:text-blue-800"><a href="{{ $company->website }}" target="_blank"
                        class="text-blue-600 underline hover:text-blue-800">{{ $company->website }}</a></p>
            </div>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" :value="__('Industry :')" />
                <p class="mt-1 text-gray-700">{{ $company->industry }}</p>
            </div>

            <div class="mb-4">
                <x-input-label class="font-semibold text-gray-800" :value="__('Owner :')" />
                <p class="mt-1 text-gray-700">{{ $company->owner->name }}</p>
            </div>





        </div>


        @if(auth()->user()->role=='admin')

        <!--  Tabs Navigation -->
        <div class="mt-6">
            <ul class="flex border-b">
                <li class="mr-1">
                    <a href="{{ route('companies.details', ['company' => $company->id, 'tab' => 'jobs']) }}"
                        class="inline-block px-4 py-2 rounded-t-lg bg-white font-semibold text-blue-600 border-b-2 border-blue-600 {{ request('tab') == 'jobs' || request('tab') == '' ? 'border-blue-600  border-b-2' : '' }} ">
                        Jobs
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="mt-4">



            <!-- Jobs Tab -->
            <div class="{{ request('tab') == 'jobs' ? 'block' : 'hidden' }}">
                <h3 class="text-2xl font-bold mb-4">Jobs</h3>

                <table class="min-w-full bg-gray-50 rounded-lg shadow">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 bg-gray-200">Job Title</th>
                            <th class="px-4 py-2 bg-gray-200">Type</th>
                            <th class="px-4 py-2 bg-gray-200">Location</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($company->jobVacancies as $job)
                            <tr class="border-b hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $job->title }}</td>
                                <td class="px-4 py-2">{{ $job->type }}</td>
                                <td class="px-4 py-2">{{ $job->location }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                                    No jobs found for this company.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
        @endif
    </div>

    </div>
















</x-app-layout>
