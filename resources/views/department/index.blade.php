<x-layout>
    <div class="container mx-auto p-4">
        <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Departments</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('department.store') }}" method="post" class="bg-white p-6 rounded-lg shadow-sm mb-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <input type="text" name="title" class="input w-full rounded-md @error('title') ring-2 ring-red-500 @enderror" value="{{ old('title')}}">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="acronym" class="block text-sm font-medium text-gray-700 mb-2">Acronym</label>
                        <input type="text" name="acronym" class="input w-full rounded-md @error('acronym') ring-2 ring-red-500 @enderror" value="{{ old('acronym')}}">
                        @error('acronym')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200">Create Department</button>
                </div>
            </form>

            {{-- Search Section --}}
            <div class="mb-6">
                <form method="GET" action="{{ route('department.index') }}" class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" id="search" class="input rounded-md w-full" placeholder="Search departments..." value="{{ request('search') }}">
                    </div>
                    <div>
                        <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Search</button>
                        @if(request('search'))
                            <a href="{{ route('department.index') }}" class="btn bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md ml-2">Clear</a>
                        @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto mt-5 bg-white rounded-lg shadow">
                <table class="table-auto w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acronym</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($departments as $department)
                            <tr class="hover:bg-gray-50 transition duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $department->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $department->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $department->acronym }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $department->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $department->active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('department.edit', $department->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                        <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this department?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-6 py-4 border-t">
                    {{ $departments->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>    
 
 
