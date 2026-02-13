
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
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl mt-8 p-8 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
          <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome, {{ $client->name }}</h1>
            <p class="text-gray-600">Fill out the form below to request assistance from our IT support team.</p>
          </div>
          <meta name="csrf-token" content="{{ csrf_token() }}">
            <form action="{{ route('home.data') }}" method="post" class="space" x-data="{ loading: false }" @submit="loading = true">
                    @csrf
                    <div class="grid grid-cols-1 gap-6">
                        <div class="space-y-2">
                            <label for="requestor_name" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                <i class="fas fa-user text-blue-600"></i>
                                <span>Name</span>
                            </label>
                            <input type="text" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-gray-50" value="{{ $client->name }}" disabled>
                            <input type="hidden" name="survey_employees_id" value="{{ $client->id }}">
                        </div>

                        <input type="hidden" id="department_id" name="department_id" value="{{$client->department->id }}">
                        
                        <div class="space-y-2">
                            <label for="location" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                <i class="fas fa-map-marker-alt text-blue-600"></i>
                                <span>Location <span class="text-red-500 text-xs">*</span></span>
                            </label>
                            <select name="location" id="location" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 @error('location') border-red-500 @enderror"> 
                                <option value="">Select Location</option>
                                <option value="BTC">BTC</option>
                                <option value="One west">One west</option>
                                <option value="PMO">PMO</option>
                                <option value="NCC">NCC</option>
                                <option value="BTP">BTP</option>
                            </select>
                            @error('location')
                                <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </p>
                            @enderror
                        </div>
    
                        <div class="space-y-2">
                            <label for="issues_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                <i class="fas fa-exclamation-triangle text-blue-600"></i>
                                <span>Issue <span class="text-red-500 text-xs">*</span></span>
                            </label>
                            <div class="relative" id="home-issue-search-container">
                                <div class="relative" id="home-issue-input-container">
                                    <input type="text" id="home_issue_search" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 text-sm" placeholder="Search for issue..." autocomplete="off">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                                        <i class="fas fa-search text-gray-400"></i>
                                    </div>
                                </div>
                                <div class="hidden">
                                    <input type="text" name="issues_id" id="home_issues_id_data" class="w-full" autocomplete="off">
                                </div>
                                <div id="home-issue-suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
                                <div id="home-selected-issue" class="hidden mt-2 p-3 bg-blue-50 border-2 border-blue-200 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center space-x-2">
                                            <i class="fas fa-check-circle text-blue-600"></i>
                                            <span id="home-selected-issue-name" class="font-semibold text-blue-800"></span>
                                        </div>
                                        <button type="button" id="home-clear-issue-selection" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-times"></i> Clear
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @error('issues_id')
                                <p class="error text-red-500 text-sm mt-1">{{ $message }}</p>
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
    
                    <div class="space-y-2 mt-5">
                        <label for="remarks" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fas fa-comment text-blue-600"></i>
                            <span>Remarks <span class="text-gray-500 text-xs">(Optional)</span></span>
                        </label>
                        <textarea name="remarks" rows="4" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none" placeholder="Provide additional details about your request..."></textarea>
                    </div>
    
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 disabled:opacity-50 flex items-center justify-center" :disabled="loading">
                        <span x-show="!loading" class="flex items-center space-x-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Submit Request</span>
                        </span>
                        <span x-show="loading" class="flex items-center space-x-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Processing...</span>
                        </span>
                    </button>
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
    //  document.getElementById('auto-department').addEventListener('input', function () {
    //     const query = this.value;
    //         // console.log(query);
    //     if (query.length >= 3) {
            
    //         fetch(`/search-department?q=${encodeURIComponent(query)}`)
    //             .then(response => response.json())
    //             .then(data => {
    //                 const suggestionsBox = document.getElementById('suggestions');
    //                 suggestionsBox.innerHTML = '';

    //                 if (data.length) {
    //                     suggestionsBox.style.display = 'block';
    //                     data.forEach(item => {
    //                         const suggestion = document.createElement('div');
    //                         $('.suggestions-box').show();
    //                         suggestion.textContent = item.title; // Adjust based on your data structure
    //                         suggestion.className = "border border-slate-500 p-2 mb-0 rounded-md bg-white hover:bg-slate-400 cursor-pointer transition duration-200";
    //                         suggestion.addEventListener('click', () => {
    //                             // console.log('hi');
    //                             document.getElementById('auto-department').value = item.title;
    //                             document.getElementById('department_id').value = item.id;
    //                             suggestionsBox.style.display = 'none';
                               
    //                         });
    //                         suggestionsBox.appendChild(suggestion);
    //                     });
    //                 } else {
    //                     suggestionsBox.style.display = 'none';
    //                 }
    //             });
    //     } else {
    //         document.getElementById('suggestions').style.display = 'none';
    //     }
    // });

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
      
    // Home Issue search functionality
    const homeIssues = @json($issues);
    const homeIssueSearchInput = document.getElementById('home_issue_search');
    const homeIssueSuggestionsContainer = document.getElementById('home-issue-suggestions-container');
    const homeSelectedIssue = document.getElementById('home-selected-issue');
    const homeSelectedIssueName = document.getElementById('home-selected-issue-name');
    const homeIssueId = document.getElementById('home_issues_id_data');
    const homeClearIssueButton = document.getElementById('home-clear-issue-selection');
    const homeIssueInputContainer = document.getElementById('home-issue-input-container');
    
    function fetchHomeIssues(query) {
        return new Promise(resolve => {
            setTimeout(() => {
                const results = homeIssues.filter(issue => 
                    issue.title.toLowerCase().includes(query.toLowerCase())
                );
                resolve(results);
            }, 200);
        });
    }
    
    function debounceHome(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    homeIssueSearchInput.addEventListener('input', debounceHome(async function(e) {
        const query = e.target.value.trim();
        const results = await fetchHomeIssues(query);
        displayHomeIssueSuggestions(results);
    }, 300));
    
    homeIssueSearchInput.addEventListener('focus', async function() {
        const results = await fetchHomeIssues('');
        displayHomeIssueSuggestions(results);
    });
    
    function displayHomeIssueSuggestions(issues) {
        if (issues.length === 0) {
            homeIssueSuggestionsContainer.innerHTML = '<div class="p-4 text-gray-500 text-sm">No issues found</div>';
            homeIssueSuggestionsContainer.classList.remove('hidden');
            return;
        }
        
        homeIssueSuggestionsContainer.innerHTML = '';
        issues.forEach(issue => {
            const div = document.createElement('div');
            div.className = 'p-3 border-b border-gray-100 hover:bg-teal-50 cursor-pointer transition';
            div.innerHTML = `<div class="font-medium text-gray-800 text-sm">${issue.title}</div>`;
            div.addEventListener('click', () => {
                selectHomeIssue(issue);
            });
            homeIssueSuggestionsContainer.appendChild(div);
        });
        
        homeIssueSuggestionsContainer.classList.remove('hidden');
    }
    
    function selectHomeIssue(issue) {
        homeSelectedIssueName.textContent = issue.title;
        homeIssueId.value = issue.id;
        homeSelectedIssue.classList.remove('hidden');
        homeIssueSearchInput.value = '';
        homeIssueSuggestionsContainer.classList.add('hidden');
        homeIssueInputContainer.classList.add('hidden');
    }
    
    homeClearIssueButton.addEventListener('click', function(e) {
        e.preventDefault();
        homeSelectedIssue.classList.add('hidden');
        homeIssueInputContainer.classList.remove('hidden');
        homeIssueId.value = '';
        homeIssueSearchInput.value = '';
        homeIssueSearchInput.focus();
    });
    
    document.addEventListener('click', function(e) {
        if (!homeIssueSearchInput.contains(e.target) && !homeIssueSuggestionsContainer.contains(e.target)) {
            homeIssueSuggestionsContainer.classList.add('hidden');
        }
    });
    </script>
</body>
</html>