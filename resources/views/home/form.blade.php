
<x-layout>    

<meta name="csrf-token" content="{{ csrf_token() }}">
<form action="{{ route('home.data') }}" method="post">
@csrf
    <div class="mb-4">
        <label for="requestor_name">Name</label>
        <input type="text" name="requestor_name" class="input @error('title') ring-red-500 @enderror" value="{{ old('title')}}">
        @error('requestor_name')
            <p class="error">{{ $message }}</p>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "{{ $message }}",
                    });
            </script>
        @enderror
    </div>

    <div class="mb-4">
        <label for="department_id">Department</label>
        <select name="department_id" id="department_id" class="input">
            <option value="">Select department</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->title }}</option>
            @endforeach
        </select>
        @error('department_id')
        <p class="error">{{ $message }}</p>
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ $message }}",
                });
        </script>
    @enderror
    </div>

    <div class="mb-4">
        <label for="issues_id">Issue</label>
        <select name="issues_id" id="issues_id" class="input">
            <option value="">Select issue</option>
            @foreach($issues as $issue)
                <option value="{{ $issue->id }}">{{ $issue->title }}</option>
            @endforeach
        </select>
        @error('issues_id')
        <p class="error">{{ $message }}</p>
        <script>
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "{{ $message }}",
                });
        </script>
    @enderror
    </div>

    <div class="mb-4">
        <label for="remarks">Remarks</label>
        <textarea rows="4" class="w-full h-32 p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
    </div>


{{-- submit button --}}
    <button class="btn">Create</button>
</form>


</x-layout>    
