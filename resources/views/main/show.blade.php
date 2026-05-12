<x-layout>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('main.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-1 mb-6 font-semibold transition">
                <i class="material-icons">arrow_back</i>
                Back to Content
            </a>
            <div class="flex justify-between items-start gap-4">
                <div class="flex-1">
                    <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">{{ $main->title }}</h1>
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                            <i class="material-icons text-sm mr-1">label</i>
                            {{ $main->type }}
                        </span>
                        <span class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-1">
                            <i class="material-icons text-sm">schedule</i>
                            {{ $main->created_at ? $main->created_at->format('M d, Y') : 'N/A' }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('main.edit', $main) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                        <i class="material-icons text-lg">edit</i>
                        Edit
                    </a>
                    <form action="{{ route('main.destroy', $main) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this content?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                            <i class="material-icons text-lg">delete</i>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <!-- Description Section -->
            <div class="p-8 border-b border-gray-200 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="material-icons text-blue-600">description</i>
                    Details
                </h2>
                <div class="prose dark:prose-invert max-w-none">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap text-base">{{ $main->details }}</p>
                </div>
            </div>

            <!-- Metadata Section -->
            <div class="p-8 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-slate-700/50 dark:to-slate-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <i class="material-icons text-gray-600 dark:text-gray-400">info</i>
                    Content Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg border border-gray-200 dark:border-slate-600">
                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Content ID</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">#{{ $main->id }}</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg border border-gray-200 dark:border-slate-600">
                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Type</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ $main->type }}</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg border border-gray-200 dark:border-slate-600">
                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Created</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ $main->created_at ? $main->created_at->format('M d, Y') : 'N/A' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $main->created_at ? $main->created_at->format('H:i A') : '' }}</p>
                    </div>
                    <div class="bg-white dark:bg-slate-800 p-4 rounded-lg border border-gray-200 dark:border-slate-600">
                        <p class="text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">Last Updated</p>
                        <p class="text-lg font-bold text-gray-900 dark:text-white mt-2">{{ $main->updated_at ? $main->updated_at->format('M d, Y') : 'N/A' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $main->updated_at ? $main->updated_at->format('H:i A') : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
