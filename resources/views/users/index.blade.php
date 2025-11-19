
<x-layout>
    <div class="py-12 mt-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-8 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800">Users</h2>
                        <a href="{{ route('users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                            <span class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New User
                            </span>
                        </a>
                    </div>

                    <div class="overflow-x-auto rounded-lg shadow">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Team</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Level</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->team }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->level }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form class="inline-block" method="POST" action="{{ route('users.destroy', $user) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 flex items-center" 
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>