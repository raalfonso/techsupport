<x-layout>

    <div class="container max-w-4xl mx-auto p-6 bg-white shadow-lg text-black rounded-lg mt-10 dark:bg-slate-800 dark:text-white">
        <div class="flex items-center space-x-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $user->name }}</h2>
                <p class="text-gray-600 dark:text-gray-100">{{ $user->email }}</p>
                <p class="text-gray-600 dark:text-gray-100">Joined: {{ $user->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Profile Information</h3>
            <div class="bg-gray-200 dark:bg-gray-600 p-4 rounded-lg shadow-md mt-2">
                <p><strong>Team: </strong> {{ $user->team ?? 'N/A' }}</p>
                <p><strong>Level: </strong> {{ $user->level ?? 'N/A' }}</p>
            </div>
        </div>
    
        <!-- Change Password Section -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold">Change Password</h3>
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg my-2">
                    {{ session('success') }}
                </div>
            @endif
            <form method="POST" action="{{ route('profile.change-password') }}" class="mt-4 p-4 rounded-lg">
                @csrf
    
                <div>
                    <label class="block font-medium text-gray-700 dark:text-gray-100">Current Password</label>
                    <input type="password" name="current_password" class="w-full mt-1 p-2 border rounded-lg">
                    @error('current_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="mt-3">
                    <label class="block font-medium text-gray-700  dark:text-gray-100"">New Password</label>
                    <input type="password" name="new_password" class="w-full mt-1 p-2 border rounded-lg">
                    @error('new_password')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
    
                <div class="mt-3">
                    <label class="block font-medium text-gray-700  dark:text-gray-100"">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" class="w-full mt-1 p-2 border rounded-lg">
                </div>
    
                <div class="mt-4">
                    <button type="submit" class="bg-teal-700 hover:bg-teal-900 text-white py-2 px-4 rounded-lg">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>   
