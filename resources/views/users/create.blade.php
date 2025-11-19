<x-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-8">
                    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Create New User</h2>

                    <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="name">
                                Name
                            </label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                                   id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="email">
                                Email
                            </label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                                   id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password">
                                Password
                            </label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                                   id="password" 
                                   type="password" 
                                   name="password" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700" for="password_confirmation">
                                Confirm Password
                            </label>
                            <input class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150 ease-in-out" 
                                   id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required>
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-8">
                            <a href="{{ route('users.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Cancel
                            </a>
                            <button type="submit"
                                     class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

