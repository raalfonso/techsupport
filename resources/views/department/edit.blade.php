<x-layout>
    <div class="container mx-auto p-4">
        <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Department</h1>

            <form action="{{ route('department.update', $department->id) }}" method="post" class="bg-white p-6 rounded-lg shadow-sm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" class="input w-full rounded-md @error('title') ring-2 ring-red-500 @enderror" value="{{ old('title', $department->title) }}">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="acronym" class="block text-sm font-medium text-gray-700 mb-2">Acronym</label>
                        <input type="text" name="acronym" class="input w-full rounded-md @error('acronym') ring-2 ring-red-500 @enderror" value="{{ old('acronym', $department->acronym) }}">
                        @error('acronym')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <label for="active" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="active" class="input w-full rounded-md @error('active') ring-2 ring-red-500 @enderror">
                        <option value="1" {{ old('active', $department->active) == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('active', $department->active) == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('active')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex gap-4">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">Update Department</button>
                    <a href="{{ route('department.index') }}" class="btn bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-md transition duration-200">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</x-layout>