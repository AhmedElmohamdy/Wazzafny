<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           Users  {{ request()->input('Archived') == 'true' ? '(Archived)' : '' }}
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
                        <!--- Active users -->
                        <a href="{{ route('users.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            View Active users
                        </a>
                    @else
                        <!--Archived-->
                        <a href="{{ route('users.index', ['Archived' => 'true']) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray font-semibold rounded-lg shadow hover:bg-gray-300">
                            View Archived users
                        </a>
                    @endif
                </div>
            </div>





            <table class="w-full rounded-lg shadow bg-white border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            User Name
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            User Email
                        </th>

                         <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            User Role
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

               <tbody class="bg-white">
                    @forelse ($User as $Users)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <!-- User Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $Users->name }}
                            </td>
                             <!-- User Email -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $Users->email }}
                            </td>
                             <!-- User Role -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $Users->role }}
                            </td>


                            <!-- Actions -->
                            <td class="px-6 py-5 text-sm flex gap-4">
                                @if (request()->input('Archived') == 'true')
                                    <!-- Restore -->
                                    <form action="{{ route('users.Restore', $Users->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900 font-medium"
                                            onclick="return confirm('Restore this category?')">
                                            Restore
                                        </button>
                                    </form>
                                @else
                                   

                                    <!-- Edit -->
                                    <a href="{{ route('users.edit', $Users->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>

                                    <!-- Archive -->
                                    <form action="{{ route('users.Archive', $Users->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('Archive this category?')">
                                            Archive
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No Users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $User->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
