<x-layout>
    <div class="space-y-6">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow-lg p-8 text-white">
            <div class="flex items-start gap-4">
                <a href="{{ route('issues.index') }}" class="text-blue-100 hover:text-white transition">
                    <i class="material-icons text-2xl">arrow_back</i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold mb-2">Edit Issue #{{ isset($issues) ? $issues->id : 'N/A' }}</h1>
                    <p class="text-blue-100">Update the issue details</p>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-8">
            @if(isset($issues))
                <form action="{{ url('/issues/' . $issues->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Primary Category -->
                       
                        <div>
                            <label for="mains_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Primary Category <span class="text-red-500">*</span>
                            </label>
                            <select name="mains_id" id="mains_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mains_id') border-red-500 @enderror">
                                @if(isset($issues) && $issues->mains)
                                    <option value="{{ $issues->mains->id }}" selected>{{ $issues->mains->title }}</option>
                                @else
                                    <option value="">-- Select Primary Category --</option>
                                @endif
                                @if(isset($mains))
                                    @foreach($mains as $main)
                                        @if(!isset($issues) || $issues->mains_id != $main->id)
                                            <option value="{{ $main->id }}">{{ $main->title }}</option>
                                        @endif
                                    @endforeach
                                @endif
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
                            <select name="category_id" id="category_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                                @if(isset($issues) && $issues->category)
                                    <option value="{{ $issues->category->id }}" selected>{{ $issues->category->title }}</option>
                                @else
                                    <option value="">-- Select Category --</option>
                                @endif
                                @if(isset($categories))
                                    @foreach($categories as $category)
                                        @if(!isset($issues) || $issues->category_id != $category->id)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endif
                                    @endforeach
                                @endif
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
                        <input type="text" name="title" id="title" placeholder="Enter issue title" value="{{ old('title', $issues->title ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror">
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
                        <input type="text" name="resolution_timeline" id="resolution_timeline" placeholder="e.g., 24 hours, 2 days" value="{{ old('resolution_timeline', $issues->resolution_timeline ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('resolution_timeline') border-red-500 @enderror">
                        @error('resolution_timeline')
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
                            Issue Information
                        </h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Created</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $issues->created_at ? $issues->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 dark:text-gray-400">Last Updated</p>
                                <p class="font-semibold text-gray-900 dark:text-white mt-1">{{ $issues->updated_at ? $issues->updated_at->format('M d, Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3 pt-6 border-t border-gray-200 dark:border-slate-700">
                        <a href="{{ route('issues.index') }}" class="flex-1 px-4 py-3 rounded-lg font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition text-center">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 px-4 py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition flex items-center justify-center gap-2">
                            <i class="material-icons">save</i>
                            Update Issue
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full mb-4">
                        <i class="material-icons text-4xl text-red-600 dark:text-red-400">error</i>
                    </div>
                    <p class="text-red-600 dark:text-red-400 font-semibold text-lg mb-4">Error: Issue not found</p>
                    <a href="{{ route('issues.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 font-semibold">
                        Back to Issues
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-layout>
