<x-layout>
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('main.index') }}" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 flex items-center gap-1 mb-6 font-semibold transition">
                <i class="material-icons">arrow_back</i>
                Back to Content
            </a>
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-900 dark:to-blue-800 rounded-lg shadow-lg p-8 text-white">
                <h1 class="text-3xl font-bold mb-2">Create New Content</h1>
                <p class="text-blue-100">Add a new main content item to your system</p>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-8">
            <form action="{{ route('main.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Title Field -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        placeholder="Enter a descriptive title for your content"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('title') border-red-500 @enderror"
                        required
                    >
                    @error('title')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <i class="material-icons text-sm">error</i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Make it clear and descriptive</p>
                </div>

                <!-- Type Field -->
                <div>
                    <label for="type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Type <span class="text-red-500">*</span>
                    </label>
                    <select 
                        id="type" 
                        name="type" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('type') border-red-500 @enderror"
                        required
                    >
                        <option value="">-- Select Type --</option>
                        @foreach(\App\Models\Main::getTypes() as $key => $value)
                            <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <i class="material-icons text-sm">error</i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Choose whether this is a Request or Report</p>
                </div>

                <!-- Description Field -->
                <div>
                    <label for="details" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Details <span class="text-red-500">*</span>
                    </label>
                    <textarea 
                        id="details" 
                        name="details" 
                        rows="10"
                        placeholder="Enter detailed information..."
                        class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none @error('details') border-red-500 @enderror"
                        required
                    >{{ old('details') }}</textarea>
                    @error('details')
                        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
                            <i class="material-icons text-sm">error</i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Provide comprehensive details about your content</p>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-8 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('main.index') }}" class="flex-1 px-4 py-3 rounded-lg font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition text-center">
                        Cancel
                    </a>
                    <button type="submit" class="flex-1 px-4 py-3 rounded-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 transition flex items-center justify-center gap-2">
                        <i class="material-icons">add</i>
                        Create Content
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
