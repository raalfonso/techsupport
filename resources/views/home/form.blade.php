
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ env('APP_NAME', 'IT Department') }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
</head>

{{-- Added pt-16 to the body to account for the fixed navbar height --}}
<body style="background-color: #e6edfc" class="flex flex-col min-h-screen pt-16"> 
    {{-- Main Navbar --}}
    <nav class="bg-white p-4 shadow-md top-0 z-50 min-w-full fixed max-h-16">
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
       <div class="flex items-center justify-between container mx-auto w-full">
            {{-- Logo or Brand Name --}}
            <div class="text-lg font-bold text-gray-800 flex items-center">
                {{-- Logo image --}}
               <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-24 w-auto p-0 rounded">
                BCDA IT DIVISION {{-- Changed from MyBrand to match context --}}
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-4 float-right">
                {{-- Navigation links --}}
                <p class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">{{$client->name}}</p>
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Logout</a> {{-- Assuming 'Report' links to 'Contact' or another relevant section --}}
            </div>

            {{-- Mobile Menu Button (Hamburger) --}}
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation (Hidden by default) --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white pt-2 pb-3 space-y-1 sm:px-3">
            {{-- Container for mobile menu links --}}
            <div class="container mx-auto"> 
                <a href="#home-section" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="#about" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="#projects" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Project</a>
                <a href="#contact" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Report</a>
            </div>
        </div>
    </nav> 
     {{-- Hero Section --}}
    <main class="flex-grow">
    {{-- Your page content here --}}
      <section id="home-section" class="" >
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow mt-5 p-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
          <h1 class="text-2xl font-bold mb-4">Welcome, {{ $client->name }}</h1>
          <p class="text-gray-600 mb-2"> Fill out the form below to request assistance.</p>
          <p class="text-gray-600 mb-2">Please ensure that you have selected the correct department and issue to expedite your request.</p>
          <meta name="csrf-token" content="{{ csrf_token() }}">
            <form action="{{ route('home.data') }}" method="post" class="space">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                        <div>
                            <label for="requestor_name" class="text-gray-800 text-md">Name</label>
                            <input type="text" class="input @error('title') ring-red-500 @enderror" value="{{ $client->name }}" disabled>
                            <input type="hidden" name="client_id" value="{{ $client->id }}">
                        </div>
                        <div>
                            <label for="email" class="text-gray-800">Email Address</label>
                            <input type="text" class="input" value="{{ $client->email_address }}" disabled>
                        </div>
    
                        @if ($user_department)
                            <div>
                                <label for="department_id" class="text-gray-800">Department <span class="text-rose-500 text-xs">(Required)</span></label>
                                <input type="hidden" id="department_id" name="department_id" value="{{$user_department->department_id }}">
                                <input type="text" id="auto-department" class="input @error('department') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off" value="{{$user_department->department->title}}">
                                <div id="suggestions" class="suggestions-box input cursor-pointer" style="display: none;"></div>
                                @error('department')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        @else
                            <div>
                                <label for="department_id" class="text-gray-800">Department <span class="text-rose-500 text-xs">(Required)</span></label>
                                <input type="hidden" id="department_id" name="department_id">
                                <input type="text" id="auto-department" class="input @error('department') ring-red-500 @enderror" placeholder="Type to search..." autocomplete="off">
                                <div id="suggestions" class="suggestions-box input cursor-pointer" style="display: none;"></div>
                                @error('department')
                                    <p class="error">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
    
                        <div>
                            <label for="location" class="text-gray-800">Location <span class="text-red-500 text-xs">(Required)</span></label>
                            <select name="location" id="location" class="input @error('location') ring-red-500 @enderror"> 
                                <option value="">Select Location</option>
                                <option value="BTC">BTC</option>
                                <option value="One west">One west</option>
                            </select>
                        </div>
    
                        <div>
                            <label for="issues_id" class="text-gray-800">Issue <span class="text-rose-500 text-xs">(Required)</span></label>
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
                        <label for="remarks" class="text-gray-800">Remarks <span class="text-green-600 text-xs">(Optional)</span></label>
                        <textarea rows="4" class="w-full p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
                    </div>
    
                    <button class="text-gray-800 bg-teal-500 rounded-md w-full h-12">Submit</button>
                </form>
        </div>

      </section>

  
    </main>
   

    {{-- Footer --}}





 <footer class="bg-blue-800 text-white py-8 floating-bottom">
    
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} IT Department - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">

        </div>
      </div>
    </footer>



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

       // JavaScript to toggle mobile menu
        document.addEventListener('DOMContentLoaded', function () {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll('[data-scroll]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', 'translate-y-5');
                    entry.target.classList.add('opacity-100', 'translate-y-0');
                    observer.unobserve(entry.target); // only animate once
                }
            });
        }, {
            threshold: 0.1
        });

        elements.forEach(el => observer.observe(el));
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });
    </script>
</body>
</html>