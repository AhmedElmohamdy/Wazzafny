<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admins
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
                    <!-- add company button -->
                    <a href="{{ route('admins.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-gray font-semibold rounded-lg shadow hover:bg-blue-700">
                        Add New Admin
                    </a>

                </div>
            </div>





            <table class="w-full rounded-lg shadow bg-white border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                             Name
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                             Email
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                             Role
                        </th>

                        <th
                            class="px-6 py-4 text-left text-sm font-bold text-gray-700 uppercase tracking-wider border-b-2 border-gray-300">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="bg-white">
                    @forelse ($admins as $admin)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            <!-- Admin Name -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $admin->name }}
                            </td>
                            <!-- Admin Email -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ $admin->email }}
                            </td>
                            <!-- Admin Role -->
                            <td class="px-6 py-5 text-sm font-semibold text-gray-900">
                                {{ ucfirst($admin->role) }}
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-5 text-sm flex gap-4">
                                <!-- Edit -->
                                <a href="{{ route('admins.edit', $admin->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900">
                                    Edit
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admins.delete', $admin->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-medium"
                                            onclick="return confirm('Delete this admin?')">
                                            Delete
                                        </button>
                                    </form>
                                
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                No admins found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
