
<x-layout>    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container-fluid flex justify-center items-center px-4 p-6" style="background: linear-gradient(to bottom left, #00cb6a, #4dc9fe); background-repeat: no-repeat;">
        <div class="w-full max-w-4xl bg-slate-900 rounded-lg p-8 shadow-lg mt-[3%]">
            <div class="relative p-2 rounded w-full mt-[-12%]">
                <h2 class="text-2xl font-bold text-center text-white">
                    <center>
                        
                        <img src="{{asset('images/logo.png')}}" alt="Logo" class="max-w-80 mx-auto">
                    </center>
                    <span class="text-blue-400">Request</span> <span class="text-green-400">Here</span>
                </h2>
    
                <form action="{{ route('home.data') }}" method="post" class="space">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                        <div>
                            <label for="requestor_name" class="text-white text-md">Name</label>
                            <input type="text" class="input @error('title') ring-red-500 @enderror" value="{{ $client->name }}" disabled>
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                        </div>
                        <div>
                            <label for="email" class="text-white">Email Address</label>
                            <input type="text" class="input" value="{{ $client->email_address }}" disabled>
                        </div>
    
                        @if ($user_department)
                            <div>
                                <label for="department_id" class="text-white">Department <span class="text-rose-500 text-xs">(Required)</span></label>
                                <input type="hidden" id="department_id" name="department_id" value="{{$user_department->department_id }}">
                                <input type="text" id="auto-department" class="input @error('department') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off" value="{{$user_department->department->title}}">
                                <div id="suggestions" class="suggestions-box input cursor-pointer" style="display: none;"></div>
                                @error('department')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div>
                                <label for="department_id" class="text-white">Department <span class="text-rose-500 text-xs">(Required)</span></label>
                                <input type="hidden" id="department_id" name="department_id">
                                <input type="text" id="auto-department" class="input @error('department') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off">
                                <div id="suggestions" class="suggestions-box input cursor-pointer" style="display: none;"></div>
                                @error('department')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
    
                        <div>
                            <label for="location" class="text-white">Location <span class="text-red-500 text-xs">(Required)</span></label>
                            <select name="location" id="location" class="input @error('location') ring-red-500 @enderror"> 
                                <option value="">Select Location</option>
                                <option value="BTC">BTC</option>
                                <option value="One west">One west</option>
                            </select>
                        </div>
    
                        <div>
                            <label for="issues_id" class="text-white">Issue <span class="text-rose-500 text-xs">(Required)</span></label>
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
                    </div>
    
                    <div>
                        <label for="remarks" class="text-white">Remarks <span class="text-green-600 text-xs">(Optional)</span></label>
                        <textarea rows="4" class="w-full p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
                    </div>
    
                    <button class="text-white bg-teal-500 rounded-md w-full h-12">Submit</button>
                </form>
            </div>
        </div>
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
                            suggestion.className = "border border-slate-500 p-2 mb-0 rounded-md bg-white hover:bg-slate-400 cursor-pointer transition duration-200";
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
