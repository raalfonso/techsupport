<x-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow-lg p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Main Content Management</h1>
                    <p class="text-blue-100">Manage and organize your main content items efficiently</p>
                </div>
                <a href="{{ route('main.create') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                    <i class="material-icons">add</i>
                    Add New Content
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg flex items-center gap-3 shadow-sm">
                <i class="material-icons text-green-500">check_circle</i>
                <div>
                    <p class="font-semibold">Success!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <form action="{{ route('main.index') }}" method="GET" class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="material-icons text-blue-600">filter_list</i>
                        Filter Content
                    </h3>
                    @if(request('search') || request('type'))
                        <a href="{{ route('main.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 text-sm font-semibold flex items-center gap-1">
                            <i class="material-icons text-sm">refresh</i>
                            Clear Filters
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search by Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search by Title</label>
                        <div class="relative">
                            <i class="material-icons absolute left-3 top-3 text-gray-400 text-lg">search</i>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search content..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                            >
                        </div>
                    </div>

                    <!-- Filter by Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Filter by Type</label>
                        <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">All Types</option>
                            @foreach(\App\Models\Main::getTypes() as $key => $value)
                                <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort By -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                        <i class="material-icons text-lg">search</i>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Total Content</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\Main::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="material-icons text-blue-600 text-2xl">description</i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Content Types</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\Main::distinct()->count('type') }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="material-icons text-green-600 text-2xl">category</i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Recently Updated</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\Main::latest('updated_at')->first()?->updated_at?->diffForHumans() ?? 'N/A' }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <i class="material-icons text-purple-600 text-2xl">update</i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Table -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            @if($mains->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Details</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($mains as $main)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-lg flex items-center justify-center">
                                                <i class="material-icons text-white text-lg">article</i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $main->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $main->id }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                            {{ $main->type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 max-w-xs">
                                        <div class="truncate" title="{{ $main->details }}">{{ Str::limit($main->details, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        <div class="flex items-center gap-2">
                                            <i class="material-icons text-sm text-gray-400">schedule</i>
                                            {{ $main->created_at ? $main->created_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('main.show', $main) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-600 dark:text-blue-400 rounded-lg transition" title="View">
                                                <i class="material-icons">visibility</i>
                                            </a>
                                            <a href="{{ route('main.edit', $main) }}" class="p-2 text-green-600 hover:bg-green-50 dark:hover:bg-slate-600 dark:text-green-400 rounded-lg transition" title="Edit">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('main.destroy', $main) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this content?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-600 hover:bg-red-50 dark:hover:bg-slate-600 dark:text-red-400 rounded-lg transition" title="Delete">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-700/50">
                    {{ $mains->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full mb-4">
                        <i class="material-icons text-4xl text-gray-400 dark:text-gray-600">folder_open</i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-lg font-semibold mb-2">No content found</p>
                    <p class="text-gray-500 dark:text-gray-500 mb-6">Try adjusting your filters or create your first content</p>
                    <a href="{{ route('main.create') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 font-semibold">
                        <i class="material-icons">add</i>
                        Create your first content
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layout>
