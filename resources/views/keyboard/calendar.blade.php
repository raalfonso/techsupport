<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar - Key Board</title>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meeting Calendar</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">View all meetings in calendar format</p>
                </div>
                <a href="{{ route('meetings.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> New Meeting
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Calendar View -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-6">
                <div class="space-y-6">
                    @php
                        $groupedMeetings = $meetings->groupBy(function($meeting) {
                            return $meeting->date->format('Y-m-d');
                        });
                    @endphp

                    @forelse($groupedMeetings as $date => $dayMeetings)
                        <div class="border-l-4 border-blue-600 pl-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                                {{ \Carbon\Carbon::parse($date)->format('l, F d, Y') }}
                            </h3>
                            <div class="space-y-4">
                                @foreach($dayMeetings as $meeting)
                                    <div class="bg-gray-50 dark:bg-slate-700 rounded-lg p-4 hover:shadow-md transition">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                                    {{ $meeting->title }}
                                                </h4>
                                                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                                                    <div class="flex items-center gap-2">
                                                        <i class="fas fa-clock"></i>
                                                        <span>{{ $meeting->time }}</span>
                                                    </div>
                                                    @if($meeting->venue)
                                                        <div class="flex items-center gap-2">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <span>{{ $meeting->venue }}</span>
                                                        </div>
                                                    @endif
                                                    @if($meeting->type)
                                                        <div class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-xs">
                                                            {{ $meeting->type->title }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mt-3 flex gap-4 text-sm">
                                                    <span class="text-gray-600 dark:text-gray-400">
                                                        <i class="fas fa-list-check text-blue-600"></i> {{ $meeting->agendas->count() }} Agendas
                                                    </span>
                                                    <span class="text-gray-600 dark:text-gray-400">
                                                        <i class="fas fa-tasks text-green-600"></i> {{ $meeting->tasks->count() }} Tasks
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex gap-2">
                                                <a href="{{ route('meetings.edit', $meeting) }}" class="text-blue-600 hover:text-blue-700 p-2">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-700 p-2">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-16">
                            <i class="fas fa-calendar-xmark text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">No meetings scheduled</h3>
                            <p class="text-gray-500 dark:text-gray-500 mb-6">Create your first meeting to get started</p>
                            <a href="{{ route('meetings.create') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-plus mr-2"></i> Create Meeting
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</body>
</html>
