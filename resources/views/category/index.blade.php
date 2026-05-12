<x-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-green-600 to-green-700 dark:from-green-900 dark:to-green-800 rounded-lg shadow-lg p-8 text-white">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold mb-2">Category Management</h1>
                    <p class="text-green-100">Manage and organize your categories</p>
                </div>
                <button id="toggleFormButton" class="bg-white text-green-600 hover:bg-green-50 px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                    <i class="material-icons">add</i>
                    Add New Category
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

        <!-- Create Category Form -->
        <div class="add-form bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-8" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Category</h2>
                <button id="closeFormButton" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200">
                    <i class="material-icons text-2xl">close</i>
                </button>
            </div>

            <form action="{{ route('category.store') }}" method="post" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" placeholder="Enter category title" value="{{ old('title') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('title') border-red-500 @enderror">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                            <i class="material-icons text-sm">error</i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Timeline -->
                <div>
                    <label for="timeline" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Timeline <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="timeline" id="timeline" placeholder="e.g., 24 hours, 2 days" value="{{ old('timeline') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 @error('timeline') border-red-500 @enderror">
                    @error('timeline')
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
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg font-semibold text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 transition flex items-center justify-center gap-2">
                        <i class="material-icons">add</i>
                        Create Category
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Section -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <form action="{{ route('category.index') }}" method="GET" class="space-y-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <i class="material-icons text-green-600">filter_list</i>
                        Filter & Search
                    </h3>
                    @if(request('search') || request('sort'))
                        <a href="{{ route('category.index') }}" class="text-green-600 hover:text-green-700 dark:text-green-400 text-sm font-semibold flex items-center gap-1">
                            <i class="material-icons text-sm">refresh</i>
                            Clear Filters
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <div class="relative">
                            <i class="material-icons absolute left-3 top-3 text-gray-400 text-lg">search</i>
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ request('search') }}"
                                placeholder="Search categories..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition"
                            >
                        </div>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                        <select name="sort" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 transition">
                            <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest First</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="title_asc" {{ request('sort') === 'title_asc' ? 'selected' : '' }}>Title (A-Z)</option>
                            <option value="title_desc" {{ request('sort') === 'title_desc' ? 'selected' : '' }}>Title (Z-A)</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                            <i class="material-icons text-lg">search</i>
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Stats Section -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold">Total Categories</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ \App\Models\Category::count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <i class="material-icons text-green-600 text-2xl">category</i>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            @if($categories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Timeline</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @foreach($categories as $category)
                                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition duration-150">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                            #{{ $category->id }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                                <i class="material-icons text-white text-lg">category</i>
                                            </div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $category->title }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                            <i class="material-icons text-sm">schedule</i>
                                            {{ $category->timeline }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                        {{ $category->created_at ? $category->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('category.edit', $category->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 dark:hover:bg-slate-600 dark:text-blue-400 rounded-lg transition" title="Edit">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
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
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            @else
                <div class="px-6 py-16 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full mb-4">
                        <i class="material-icons text-4xl text-gray-400 dark:text-gray-600">folder_open</i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-lg font-semibold mb-2">No categories found</p>
                    <p class="text-gray-500 dark:text-gray-500 mb-6">Try adjusting your filters or create your first category</p>
                    <button id="toggleFormButtonEmpty" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 dark:text-green-400 font-semibold">
                        <i class="material-icons">add</i>
                        Create your first category
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
