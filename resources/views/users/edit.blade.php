
// resources/views/users/edit.blade.php
<x-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold mb-6">Edit User</h2>

                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Name
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   id="name" 
                                   type="text" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                Password (leave blank to keep current)
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   id="password" 
                                   type="password" 
                                   name="password">
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                                Confirm Password
                            </label>
                            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                                   id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation">
                        </div>

                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" 
                                    type="submit">
                                Update User
                            </button>
                            <a href="{{ route('users.index') }}" 
                               class="text-gray-500 hover:text-gray-700">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>