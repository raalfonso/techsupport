<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Personnel Request - {{ env('APP_NAME', 'IT Department') }}</title>
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
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">New Personnel Request</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Create a new request for personnel or resources</p>
            </div>

            <!-- Create Form -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                <form action="{{ route('request-personnel.store') }}" method="post" class="space-y-6">
                    @csrf

                    <!-- Hidden Requestor Field (defaults to logged-in user) -->
                    <input type="hidden" name="requestor_id" value="{{ old('requestor_id', auth()->id()) }}">

                    <!-- Event Title -->
                    <div>
                        <label for="event_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Event Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="event_title" id="event_title" placeholder="Enter event title" value="{{ old('event_title') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('event_title') border-red-500 @enderror">
                        @error('event_title')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Start Date/Time -->
                        <div>
                            <label for="start_date_time" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Start Date/Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="start_date_time" id="start_date_time" value="{{ old('start_date_time') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date_time') border-red-500 @enderror">
                            @error('start_date_time')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="material-icons text-sm">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- End Date/Time -->
                        <div>
                            <label for="end_date_time" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                End Date/Time <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="end_date_time" id="end_date_time" value="{{ old('end_date_time') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('end_date_time') border-red-500 @enderror">
                            @error('end_date_time')
                                <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                    <i class="material-icons text-sm">error</i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Point Person -->
                    <div>
                        <label for="point_person" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Point Person
                        </label>
                        <input type="text" name="point_person" id="point_person" placeholder="Enter point person name" value="{{ old('point_person') }}" maxlength="100" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('point_person') border-red-500 @enderror">
                        @error('point_person')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Resources Needed -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            Resources Needed
                        </label>
                        <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-4 border border-gray-200 dark:border-slate-600 max-h-64 overflow-y-auto">
                            @if($resources->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($resources as $resource)
                                        <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white dark:hover:bg-slate-700 cursor-pointer transition">
                                            <input type="checkbox" name="resources[]" value="{{ $resource->id }}" class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500" {{ (is_array(old('resources')) && in_array($resource->id, old('resources'))) ? 'checked' : '' }}>
                                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ $resource->item_name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                                    No resources available. <a href="{{ route('resources.create') }}" class="text-blue-600 dark:text-blue-400 hover:underline">Add one now</a>
                                </p>
                            @endif
                        </div>
                        @error('resources')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Meeting Link -->
                    <div>
                        <label for="meeting_link" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Meeting Link
                        </label>
                        <input type="url" name="meeting_link" id="meeting_link" placeholder="https://example.com" value="{{ old('meeting_link') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('meeting_link') border-red-500 @enderror">
                        @error('meeting_link')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Hidden Status Field (defaults to pending) -->
                    <input type="hidden" name="status" value="pending">

                    <!-- Buttons -->
                    <div class="flex gap-4 pt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                            <i class="material-icons">save</i>
                            Save Request
                        </button>
                        <a href="{{ route('request-personnel.index') }}" class="bg-gray-300 hover:bg-gray-400 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-900 dark:text-white px-6 py-3 rounded-lg font-semibold transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center space-y-2">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Powered by</span>
                    <img src="{{ asset('images/ICTD_Logo.png') }}" alt="ICTD Logo" class="h-8 w-auto" />
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © 2026 Personnel Request System • Bases Conversion and Development Authority (BCDA). All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
