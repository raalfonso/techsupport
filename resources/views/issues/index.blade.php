<x-layout>
    <div class="container mx-auto p-4">
       

        <div class="mx-auto max-w-screen-lg card">
            <h1 class="title">Issues</h1>

            <form action="{{ route('issues.store') }}" method="post">
                @csrf

            <div class="mb-4">
                <label for="mains_id">Primary</label>
                <select name="mains_id" id="mains_id" class="input">
                    <option value="">Choose Primary</option>
                    @foreach($mains as $main)
                        <option value="{{ $main->id }}">{{ $main->title }}</option>
                    @endforeach
                </select>
                @error('mains_id')
                <p class="error">{{ $message }}</p>
            @enderror
            </div>
            <div class="mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="input @error('title') ring-red-500 @enderror" value="{{ old('title')}}">
                @error('title')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="input">
                    <option value="">Choose a category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="error">{{ $message }}</p>
            @enderror
            </div>

            <div class="mb-4">
                <label for="category_id">Type</label>
                <select name="category_id" id="category_id" class="input">
                    <option value="">Choose type</option>
                        <option value="Request">Request</option>
                        <option value="Report">Report</option>
                
                </select>
                @error('category_id')
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
                            <th class="border border-gray-300 px-4 py-2">Primary</th>
                            <th class="border border-gray-300 px-4 py-2">Category</th>
                            <th class="border border-gray-300 px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($issues as $issue)
                            <tr class="hover:bg-gray-100">
                                <td class="border border-gray-300 px-4 py-2">{{ $issue->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $issue->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $issue->mains->id }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $issue->category->title }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('issues.edit', $issue->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                    <form action="{{ route('issues.destroy', $issue->id) }}" method="POST" class="inline">
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
                    {{ $issues->links() }}
                </div>
            </div>
        </div>
        
    </div>
 </x-layout>    
 
 