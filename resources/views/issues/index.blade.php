<x-layout>
    <div class="container mx-auto p-8">
        <div class="mx-auto max-w-screen-lg mt-8 bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Issues Management</h1>

            <button id="toggleFormButton" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-plus mr-2"></i>Add New Issue
            </button>

            <div class="add-form mt-8 bg-gray-50 p-6 rounded-lg shadow-md" style="display: none;">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Create New Issue</h2>
                <form action="{{ route('issues.store') }}" method="post">
                    @csrf
                    <div class="mb-6">
                        <label for="mains_id" class="block text-sm font-medium text-gray-700 mb-2">Primary</label>
                        <select name="mains_id" id="mains_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Select Primary Category</option>
                            @foreach($mains as $main)
                                <option value="{{ $main->id }}">{{ $main->title }}</option>
                            @endforeach
                        </select>
                        @error('mains_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('title') border-red-500 @enderror" value="{{ old('title')}}">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div class="mb-6">
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                        <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <div class="mb-6">
                        <label for="resolution_timeline" class="block text-sm font-medium text-gray-700 mb-2">Resolution Time</label>
                        <input type="text" name="resolution_timeline" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 @error('resolution_timeline') border-red-500 @enderror" value="{{ old('resolution_timeline')}}">
                        @error('resolution_timeline')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
    
                    <button class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                        Create Issue
                    </button>
                </form>
            </div>

            <div class="overflow-x-auto mt-8">
                <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-lg">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Resolution Time</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Primary</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Category</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($issues as $issue)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $issue->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $issue->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $issue->resolution_timeline }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $issue->mains->id }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $issue->category->title }}</td>
                                <td class="px-6 py-4 text-sm space-x-3">
                                    <a href="{{ route('issues.edit', $issue->id) }}" class="text-blue-500 hover:text-blue-600 font-medium hover:underline">Edit</a>
                                    <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-600 font-medium hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $issues->links() }}
                </div>
            </div>
        </div>
    </div>


    <script>
        document.getElementById('toggleFormButton').addEventListener('click', function() {
            var form = document.querySelector('.add-form');
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block';
                form.classList.add('animate-fade-in');
            } else {
                form.style.display = 'none';
                form.classList.remove('animate-fade-in');
            }
        });
    </script>
</x-layout>    
 
 
