<x-layout>
  
    <style>
        .suggestions-box {
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        display: none;
        background: white;
    }
    .suggestions-box div {
        padding: 8px;
        cursor: pointer;
    }
    .suggestions-box div:hover {
        background-color: #f0f0f0;
    }
    </style>

    <div class="mx-auto max-w-screen-sm card p-5">
        <center><img src="{{asset('images/SolveIT-removebg-preview.png')}}" alt="" class="max-w-60">
            {{-- <p class="text-blue-900 text-lg font-bold">Sign in to the SolveIT</p> --}}
        </center> 
       
        <form action="{{ route('client.login.submit')}}" method="post">
            @csrf
            <div class="mb-2">
                <label for="email" class="text-lg">Email Address</label>
                <input type="text" id="auto-suggest" name="email_address" class="input @error('email_address') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off">
                <div id="suggestions" class="suggestions-box"></div>
                @error('email_address')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
            <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300">
                Login
              </button>
        </form>
    </div>


    <script>
        document.getElementById('auto-suggest').addEventListener('input', function () {
        const query = this.value;
            console.log(query);
        if (query.length >= 3) {
            fetch(`/search-suggestions?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const suggestionsBox = document.getElementById('suggestions');
                    suggestionsBox.innerHTML = '';

                    if (data.length) {
                        suggestionsBox.style.display = 'block';
                        data.forEach(item => {
                            const suggestion = document.createElement('div');
                            suggestion.textContent = item.email_address; // Adjust based on your data structure
                            suggestion.addEventListener('click', () => {
                                document.getElementById('auto-suggest').value = item.email_address;
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

