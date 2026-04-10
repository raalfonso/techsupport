<x-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 dark:from-purple-900 dark:to-purple-800 rounded-lg shadow-lg p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Issues Management</h1>
                    <p class="text-purple-100">Track and manage all system issues efficiently</p>
                </div>
                <button id="toggleFormButton" class="bg-white text-purple-600 hover:bg-purple-50 px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                    <i class="material-icons">add</i>
                    Add New Issue
                </button>
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

        <!-- Create Issue Form -->
        <div class="add-form bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-8" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Issue</h2>
                <button id="closeFormButton" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <i class="material-icons text-2xl">close</i>
                </button>
            </div>
            
            <form action="{{ route('issues.store') }}" method="post" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Primary Category -->
                    <div>
                        <label for="mains_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Primary Category <span class="text-red-500">*</span>
                        </label>
                        <select name="mains_id" id="mains_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('mains_id') border-red-500 @enderror">
                            <option value="">-- Select Primary Category --</option>
                            @foreach($mains as $main)
                                <option value="{{ $main->id }}" {{ old('mains_id') == $main->id ? 'selected' : '' }}>{{ $main->title }}</option>
                            @endforeach
                        </select>
                        @error('mains_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('category_id') border-red-500 @enderror">
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" placeholder="Enter issue title" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                            <i class="material-icons text-sm">error</i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Resolution Timeline -->
                <div>
                    <label for="resolution_timeline" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Resolution Timeline <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="resolution_timeline" id="resolution_timeline" placeholder="e.g., 24 hours, 2 days" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 @error('resolution_timeline') border-red-500 @enderror" value="{{ old('resolution_timeline') }}">
                    @error('resolution_timeline')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                            <i class="material-icons text-sm">error</i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <button type="button" id="cancelFormButton" class="flex-1 px-4 py-2 rounded-lg font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 transition flex items-center justify-center gap-2">
                        <i class="material-icons">add</i>
                        Create Issue
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <form action="{{ route('issues.index') }}" method="GET" class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="material-icons text-purple-600">filter_list</i>
                        Filter & Search
                    </h3>
                    @if(request('search') || request('category') || request('main') || request('sort'))
                        <a href="{{ route('issues.index') }}" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 text-sm font-semibold flex items-center gap-1">
                            <i class="material-icons text-sm">refresh</i>
                            Clear Filters
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <div class="relative">
                            <i class="material-icons absolute left-3 top-3 text-gray-400 text-lg">search</i>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search issues..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition"
                            >
                        </div>
                    </div>

                    <!-- Filter by Category -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Primary -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Primary</label>
                        <select name="main" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                            <option value="">All Primary</option>
                            @foreach($mains as $main)
                                <option value="{{ $main->id }}" {{ request('main') == $main->id ? 'selected' : '' }}>{{ $main->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit" class="flex-1 md:flex-none bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
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
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Total Issues</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\Issues::count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                        <i class="material-icons text-purple-600 text-2xl">report_problem</i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Categories</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $categories->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <i class="material-icons text-blue-600 text-2xl">category</i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Primary Types</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $mains->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <i class="material-icons text-green-600 text-2xl">layers</i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Issues Table -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            @if($issues->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Category</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Primary</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Resolution Time</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($issues as $issue)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">
                                            #{{ $issue->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-purple-600 rounded-lg flex items-center justify-center">
                                                <i class="material-icons text-white text-lg">report_problem</i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $issue->title }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Created {{ $issue->created_at ? $issue->created_at->diffForHumans() : 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                            {{ $issue->category->title }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                            {{ $issue->mains->title }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                            <i class="material-icons text-sm">schedule</i>
                                            {{ $issue->resolution_timeline }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('issues.edit', $issue->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-600 dark:text-blue-400 rounded-lg transition" title="Edit">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this issue?');">
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
                    {{ $issues->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full mb-4">
                        <i class="material-icons text-4xl text-gray-400 dark:text-gray-600">folder_open</i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-lg font-semibold mb-2">No issues found</p>
                    <p class="text-gray-500 dark:text-gray-500 mb-6">Try adjusting your filters or create your first issue</p>
                    <button id="toggleFormButtonEmpty" class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 dark:text-purple-400 font-semibold">
                        <i class="material-icons">add</i>
                        Create your first issue
                    </button>
                </div>
            @endif
        </div>
    </div>

    <script>
        const toggleFormButton = document.getElementById('toggleFormButton');
        const toggleFormButtonEmpty = document.getElementById('toggleFormButtonEmpty');
        const closeFormButton = document.getElementById('closeFormButton');
        const cancelFormButton = document.getElementById('cancelFormButton');
        const addForm = document.querySelector('.add-form');

        function toggleForm() {
            if (addForm.style.display === 'none' || addForm.style.display === '') {
                addForm.style.display = 'block';
                addForm.classList.add('animate-fade-in');
                document.getElementById('title').focus();
            } else {
                addForm.style.display = 'none';
                addForm.classList.remove('animate-fade-in');
            }
        }

        toggleFormButton?.addEventListener('click', toggleForm);
        toggleFormButtonEmpty?.addEventListener('click', toggleForm);
        closeFormButton?.addEventListener('click', toggleForm);
        cancelFormButton?.addEventListener('click', toggleForm);
    </script>
</x-layout>
