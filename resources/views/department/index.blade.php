<x-layout>
    <div class="container mx-auto p-4">
       

        <div class="mx-auto max-w-screen-lg card">
            <h1 class="title">departments</h1>

            <form action="{{ route('department.store') }}" method="post">
                @csrf
            <div class="mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="input @error('title') ring-red-500 @enderror" value="{{ old('title')}}">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="acronym">Acronym</label>
                <input type="text" name="acronym" class="input @error('acronym') ring-red-500 @enderror" value="{{ old('acronym')}}">
                @error('acronym')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- submit button --}}
                 <button class="btn">Create</button>
            </form>
            <div class="overflow-x-auto mt-5">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-200 text-left">
                            <th class="border border-gray-300 px-4 py-2">ID</th>
                            <th class="border border-gray-300 px-4 py-2">Title</th>
                            <th class="border border-gray-300 px-4 py-2">Acronym</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $department)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2">{{ $department->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $department->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $department->acronym }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('department.edit', $department->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $departments->links() }}
                </div>
            </div>
        </div>
        
    </div>
 </x-layout>    
 
 