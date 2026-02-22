<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Companies {{ request()->input('Archived') == 'true' ? '(Archived)' : '' }}
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
                        <a href="{{ route('companies.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            View Active Companies
                        </a>
                    @else
                        <!--Archived-->
                        <a href="{{ route('companies.index', ['Archived' => 'true']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            View Archived Companies
                        </a>
                    @endif
                    <!-- add company button -->
                    <a href="{{ route('companies.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-gray font-semibold rounded-lg shadow hover:bg-blue-700">
                        Add New Company
                    </a>

                </div>
            </div>





            <table class="w-full rounded-lg shadow bg-white border-collapse">
                   <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Company Name
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

                 <tbody class="bg-white">
                    @forelse ($Companies as $Company)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <!-- Company Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $Company->name }}
                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5 text-sm flex gap-4">
                                @if (request()->input('Archived') == 'true')
                                    <!-- Restore -->
                                    <form action="{{ route('companies.Restore', $Company->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium"
                                            onclick="return confirm('Restore this company?')">
                                            Restore
                                        </button>
                                    </form>
                                @else
                                    <!-- Show -->
                                    <a href="{{ route('companies.details', $Company->id) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        View Details
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('companies.edit', $Company->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>

                                    <!-- Archive -->
                                    <form action="{{ route('companies.Archive', $Company->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('Archive this company?')">
                                            Archive
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No companies found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $Companies->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
