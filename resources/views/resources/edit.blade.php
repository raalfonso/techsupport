<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personnel Requests - {{ env('APP_NAME', 'IT Department') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen pt-16 bg-gray-50 dark:bg-slate-900 transition-colors duration-200">

    @include('request_personnel._nav')
    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
        <div class="space-y-6 py-8">
            <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Resource</h1>
                        <p class="text-gray-600 dark:text-gray-400">Update the selected item details.</p>
                    </div>
                    <a href="{{ route('resources.index') }}" class="inline-flex items-center gap-2 px-4 py-3 rounded-lg bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-slate-700 transition">
                        <i class="material-icons">arrow_back</i>
                        Back to resources
                    </a>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-slate-700 p-6">
                    <form action="{{ route('resources.update', $resource->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="item_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Item Name</label>
                            <input type="text" name="item_name" id="item_name" value="{{ old('item_name', $resource->item_name) }}" class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            @error('item_name')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_active" id="is_active" class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500" {{ old('is_active', $resource->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</label>
                        </div>

                        <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                            <a href="{{ route('resources.index') }}" class="inline-flex items-center justify-center px-5 py-3 rounded-lg border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-slate-700 transition">Cancel</a>
                            <button type="submit" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </main>
</body>
</html>
