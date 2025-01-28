
<x-layout>    

<meta name="csrf-token" content="{{ csrf_token() }}">
<form action="{{ route('home.data') }}" method="post">
@csrf
    <div class="card px-10 py-10">
        <p class="text-lg">Requesting Form</p>
        <br>
        <div class="mb-4">
            <label for="requestor_name">Name</label>
            <input type="text" class="input @error('title') ring-red-500 @enderror" value="{{ $client->name}}" disabled>
            <input type="hidden" name="client_id" class="input" value="{{ $client->id}}">
        </div>

        <div class="mb-4">
            <label for="requestor_name">Email Address</label>
            <input type="text" class="input" value="{{ $client->email_address}}" disabled>
        </div>
        @if ($user_department)
            {{-- {{print_r($user_department);}} --}}
            <div class="mb-4">
                <label for="department_id">Department <span class="text-rose-500 text-xs">(Required)</span></label>
                <input type="hidden" id="department_id" name="department_id" value="{{$user_department->department_id }}">
                <input type="text" id="auto-department" class="input @error('department') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off" value="{{$user_department->department->title}}">
                <div id="suggestions" class="suggestions-box input cursor-pointer" style="display: none;"></div>
                @error('department')
                <p class="error">{{ $message }}</p>
                @enderror
            
            </div>
        @else
            <div class="mb-4">
                <label for="department_id">Department <span class="text-rose-500 text-xs">(Required)</span></label>
                <input type="hidden" id="department_id" name="department_id">
                <input type="text" id="auto-department" class="input @error('department') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off" >
                <div id="suggestions" class="suggestions-box input cursor-pointer" style="display: none;"></div>
                @error('department')
                <p class="error">{{ $message }}</p>
                @enderror
        
            </div>
        @endif
        
        <div class="mb-4">
            <label for="location">Location <span class="text-red-500 text-xs">(Required)</span></label>
            <select name="location" id="location" class="input @error('location') ring-red-500 @enderror"> 
                <option value="">Select Location</option>
                    <option value="BTC">BTC</option>
                    <option value="One west">One west</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="issues_id">Issue <span class="text-rose-500 text-xs">(Required)</span></label>
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
            <label for="remarks">Remarks <span class="text-green-600 text-xs">(Optional)</span></label>
            <textarea rows="4" class="w-full h-32 p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
        </div>


    {{-- submit button --}}
        <button class="btn">Create</button>
    </form>
</div>

<script>
     document.getElementById('auto-department').addEventListener('input', function () {
        const query = this.value;
            // console.log(query);
        if (query.length >= 3) {
            
            fetch(`/search-department?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const suggestionsBox = document.getElementById('suggestions');
                    suggestionsBox.innerHTML = '';

                    if (data.length) {
                        suggestionsBox.style.display = 'block';
                        data.forEach(item => {
                            const suggestion = document.createElement('div');
                            $('.suggestions-box').show();
                            suggestion.textContent = item.title; // Adjust based on your data structure
                            suggestion.addEventListener('click', () => {
                                // console.log('hi');
                                document.getElementById('auto-department').value = item.title;
                                document.getElementById('department_id').value = item.id;
                                suggestionsBox.style.display = 'none';
                               
                            });
                            suggestionsBox.appendChild(suggestion);
                        });
                    } else {
                        suggestionsBox.style.display = 'none';
                    }
                });
        } else {
            document.getElementById('suggestions').style.display = 'none';
        }
    });
</script>




</x-layout>    
