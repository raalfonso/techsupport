<x-layout>

    <div class="container max-w-4xl mx-auto p-8 bg-white shadow-xl text-black rounded-2xl mt-10 dark:bg-slate-800 dark:text-white transition-all duration-300">
        <div class="flex items-center space-x-6">
            <div class="flex-1">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">{{ $user->name }}</h2>
                <p class="text-gray-600 dark:text-gray-300 text-lg">{{ $user->email }}</p>
                <p class="text-gray-500 dark:text-gray-400">Joined: {{ $user->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    
        <div class="mt-8">
            <h3 class="text-xl font-semibold mb-4">Profile Information</h3>
            <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-xl shadow-sm mt-2 backdrop-blur-sm">
                <p class="mb-3"><strong class="text-gray-700 dark:text-gray-300">Team: </strong> <span class="text-gray-600 dark:text-gray-400">{{ $user->team ?? 'N/A' }}</span></p>
                <p><strong class="text-gray-700 dark:text-gray-300">Level: </strong> <span class="text-gray-600 dark:text-gray-400">{{ $user->level ?? 'N/A' }}</span></p>
            </div>
        </div>
    
        <!-- Change Password Section -->
        <div class="mt-10">
            <h3 class="text-xl font-semibold mb-4">Change Password</h3>
            @if (session('success'))
                <div class="bg-green-50 text-green-700 p-4 rounded-xl my-4 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('profile.change-password') }}" class="mt-6 p-6 rounded-xl bg-gray-50 dark:bg-gray-700">
                @csrf
    
                <div class="space-y-6">
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-200 mb-2">Current Password</label>
                        <input type="password" name="current_password" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-800">
                        @error('current_password')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-200 mb-2">New Password</label>
                        <input type="password" name="new_password" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-800">
                        @error('new_password')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div>
                        <label class="block font-medium text-gray-700 dark:text-gray-200 mb-2">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" 
                               class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent transition-all duration-200 bg-white dark:bg-gray-800">
                    </div>
    
                    <div class="mt-8">
                        <button type="submit" 
                                class="w-full sm:w-auto bg-teal-600 hover:bg-teal-700 text-white py-3 px-6 rounded-lg transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                            Update Password
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layout>   
