<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meeting - Key Board</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-slate-900">

    @include('keyboard._nav')
    
    <main class="flex-grow pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Meeting</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Update meeting details</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">
                <form action="{{ route('meetings.update', $meetingDetail) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Title *</label>
                            <input type="text" name="title" value="{{ old('title', $meetingDetail->title) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                            <input type="date" name="date" value="{{ old('date', $meetingDetail->date->format('Y-m-d')) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Time *</label>
                            <input type="text" name="time" value="{{ old('time', $meetingDetail->time) }}" required 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Venue</label>
                            <input type="text" name="venue" value="{{ old('venue', $meetingDetail->venue) }}" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Type</label>
                            <select name="type_id" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Type</option>
                                @foreach($meetingTypes as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id', $meetingDetail->type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Update Meeting
                        </button>
                        <a href="{{ route('keyboard.index') }}" class="bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-500 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
