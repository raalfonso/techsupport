<x-layout>
    <div class="container mx-auto p-4">
       

        <div class="mx-auto max-w-screen-lg card">
            <h1 class="title">category</h1>

            <form action="{{ route('category.store') }}" method="post">
                @csrf
            <div class="mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="input @error('title') ring-red-500 @enderror" value="{{ old('title')}}">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="timeline">Timeline</label>
                <input type="text" name="timeline" class="input @error('timeline') ring-red-500 @enderror" value="{{ old('timeline')}}">
                @error('timeline')
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
                            <th class="border border-gray-300 px-4 py-2">Timeline</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2">{{ $category->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $category->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $category->timeline }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('category.edit', $category->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline">
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
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
        
    </div>
 </x-layout>    
 
 