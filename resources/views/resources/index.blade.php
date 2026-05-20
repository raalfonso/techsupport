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
            <div class="bg-gradient-to-r from-indigo-600 to-blue-700 dark:from-slate-900 dark:to-slate-800 rounded-lg shadow-lg p-8 text-white">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-4xl font-bold mb-1">Resource Management</h1>
                        <p class="text-indigo-100">Manage available items for request personnel selection.</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('resources.create') }}" class="inline-flex items-center gap-2 bg-white text-indigo-700 hover:bg-indigo-50 px-5 py-3 rounded-lg font-semibold shadow-sm transition">
                            <i class="material-icons">add</i>
                            Add Resource
                        </a>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg flex items-center gap-3 shadow-sm">
                    <i class="material-icons text-green-500">check_circle</i>
                    <div>
                        <p class="font-semibold">Success!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <form action="{{ route('resources.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search resources..." class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sort</label>
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-3">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold transition">Apply</button>
                        <a href="{{ route('resources.index') }}" class="w-full inline-flex items-center justify-center bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-200 px-4 py-3 rounded-lg font-semibold transition hover:bg-gray-200 dark:hover:bg-slate-600">Reset</a>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">ID</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">Item Name</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">Status</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300">Created At</th>
                                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wide text-gray-600 dark:text-gray-300 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($resources as $resource)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition">
                                    <td class="px-6 py-4">#{{ $resource->id }}</td>
                                    <td class="px-6 py-4">{{ $resource->item_name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $resource->is_active ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' }}">
                                            {{ $resource->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ optional($resource->created_at)->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('resources.edit', $resource->id) }}" class="p-2 rounded-lg text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-slate-700 transition" title="Edit">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" onsubmit="return confirm('Delete this resource?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 rounded-lg text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-slate-700 transition" title="Delete">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-gray-500 dark:text-gray-400">
                                        No resources yet. <a href="{{ route('resources.create') }}" class="text-blue-600 hover:underline">Add one now.</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                    {{ $resources->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
        </div>
    </main>
</body>
</html>