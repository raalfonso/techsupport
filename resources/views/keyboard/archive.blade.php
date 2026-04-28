<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Archive - Key Board</title>
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
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Meeting Archive</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Past meetings and completed items</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Archive List -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Meeting</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Time</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Venue</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                            @forelse($meetings as $meeting)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 dark:text-white">{{ $meeting->title }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $meeting->agendas->count() }} agendas, {{ $meeting->tasks->count() }} tasks
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $meeting->date->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $meeting->time }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $meeting->venue ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($meeting->type)
                                            <span class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-1 rounded-full text-xs">
                                                {{ $meeting->type->title }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $totalItems = $meeting->agendas->count() + $meeting->tasks->count();
                                            $completedItems = $meeting->agendas->where('status', 'Done')->count() + $meeting->tasks->where('status', 'Done')->count();
                                            $percentage = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-gray-200 dark:bg-slate-600 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $percentage }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex gap-2">
                                            <a href="{{ route('meetings.edit', $meeting) }}" class="text-blue-600 hover:text-blue-700 p-2" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-700 p-2" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-16 text-center">
                                        <i class="fas fa-archive text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                        <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-2">No archived meetings</h3>
                                        <p class="text-gray-500 dark:text-gray-500">Past meetings will appear here</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($meetings->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                        {{ $meetings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
