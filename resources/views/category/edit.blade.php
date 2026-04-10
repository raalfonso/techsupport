<x-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow-lg p-8 text-white">
            <div class="flex items-start gap-4">
                <a href="{{ route('category.index') }}" class="text-blue-100 hover:text-white transition">
                    <i class="material-icons text-2xl">arrow_back</i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold mb-2">Edit Category #{{ isset($category) ? $category->id : 'N/A' }}</h1>
                    <p class="text-blue-100">Update the category details</p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-8">
            @if(isset($category))
                <form action="{{ url('/category/' . $category->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" id="title" placeholder="Enter category title" value="{{ old('title', $category->title ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
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
                        <input type="text" name="timeline" id="timeline" placeholder="e.g., 24 hours, 2 days" value="{{ old('timeline', $category->timeline ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('timeline') border-red-500 @enderror">
                        @error('timeline')
                            <p class="text-red-500 text-sm mt-1 flex items-center gap-1">
                                <i class="material-icons text-sm">error</i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Metadata -->
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-700 dark:to-slate-700/50 p-6 rounded-lg border border-gray-200 dark:border-slate-600">
                        <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                            <i class="material-icons text-lg">info</i>
                            Category Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Created</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $category->created_at ? $category->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Last Updated</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $category->updated_at ? $category->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-slate-700">
                        <a href="{{ route('category.index') }}" class="flex-1 px-4 py-3 rounded-lg font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 px-4 py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition flex items-center justify-center gap-2">
                            <i class="material-icons">save</i>
                            Update Category
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                        <i class="material-icons text-4xl text-red-600 dark:text-red-400">error</i>
                    </div>
                    <p class="text-red-600 dark:text-red-400 font-semibold text-lg mb-4">Error: Category not found</p>
                    <a href="{{ route('category.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-semibold">
                        Back to Categories
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layout>
