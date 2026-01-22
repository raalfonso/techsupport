<x-layout>
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold mb-6">Edit Auth Item Child</h1>

            <form action="{{ route('auth-child.update', $authChild) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="parent" class="block text-sm font-medium text-gray-700 mb-2">Parent</label>
                    <select name="parent" id="parent" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Parent</option>
                        @foreach($authItems as $item)
                            <option value="{{ $item->name }}" {{ old('parent', $authChild->parent) == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('parent')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="child" class="block text-sm font-medium text-gray-700 mb-2">Child</label>
                    <select name="child" id="child" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Child</option>
                        @foreach($authItems as $item)
                            <option value="{{ $item->name }}" {{ old('child', $authChild->child) == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    @error('child')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a href="{{ route('auth-child.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
                </div>
            </form>
        </div>
    </div>
</x-layout>