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
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    {{-- Hero Section --}}
    <main class="flex-grow">
    {{-- Your page content here --}}
      <section id="home-section" class="p-5" >
        <div class="mx-auto bg-white rounded-lg shadow mt-5 p-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
          <h1 class="text-2xl font-bold mb-4">Welcome, {{ $client->name }}</h1>
          <p class="text-gray-600 mb-2">Here are your reported issues:</p>
          <div class="flex items-start justify-between px-6 py-4 border-b hover:bg-gray-50">
          
            {{-- Column Header --}}
              <div class="flex w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Issue Encounter {{-- column header --}}
                  </span>
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Ticket Number {{-- column header --}}
                  </span>
                
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Responsed {{-- column header --}}
                  </span>
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Resolved {{-- column header --}}
                  </span>
              </div>

              <div class="flex flex-col w-2/6">
                  <span class=" text-sm font-semibold px-4 py-2 flex items-center">
                      Status {{-- column header --}}
                  </span>
              </div>

          </div>

          {{-- Display a message if no reports are found --}}
          @foreach ($reports as $report)
          <div class="flex items-start justify-between px-6 py-4 border-b hover:bg-gray-50">
          
            {{-- Left: PDF Button --}}
              <div class="flex flex-col w-2/6">
                  <span class="text-sm font-semibold px-4 py-2 text-gray-700 flex items-start">
                      {{ $report->issues->title }} {{-- Display the issue title --}}
                  </span>
              </div>

              {{-- Middle Info --}}
              <div class="flex flex-col w-2/6 px-4">
                  <span class="text-sm text-gray-700 font-medium">{{ $report->ticket_number }}</span>
                  <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y') }}</span>
                  <span class="text-sm font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($report->request_datetime)->format('h:i A') }}</span>
              </div>

              {{-- response Info --}}
             @if (in_array($report->status, ['Ongoing', 'Done']))
                <div class="flex flex-col w-2/6">
                    <span class="text-sm text-gray-700 font-medium">{{ $report->response->name }}</span>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->response_datetime)->format('M d, Y') }}</span>
                    <span class="text-sm font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($report->response_datetime)->format('h:i A') }}</span>
                </div>
                
              @else
                <div class="flex flex-col w-2/6">
                    <span class="text-sm text-gray-700 font-medium ml-8"><i class="fa-solid fa-clock"></i></span>
                  
                </div>
              @endif
              

              {{-- resolve Info --}}
              @if ($report->status == 'Done')
                <div class="flex flex-col w-2/6">
                    <span class="text-gray-700 font-medium">{{ $report->resolve->user->name }}</span>
                    <span class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($report->resolve_datetime)->format('M d, Y') }}</span>
                    <span class="text-sm font-semibold text-gray-800 mt-1">{{ \Carbon\Carbon::parse($report->resolve_datetime)->format('h:i A') }}</span>
                </div>
              @else
               <div class="flex flex-col w-2/6">
                    <span class="text-sm text-gray-700 font-medium ml-8"><i class="fa-solid fa-clock"></i></span>
                </div>
              @endif
             

              {{-- Right: Status --}}
              <div class="flex flex-col w-2/6">
                  <span class="text-sm font-semibold px-4 py-2 flex items-center">
                    @if ($report->status == 'Ongoing')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                          {{ $report->status }} {{-- Display the status --}}
                      </span>
                    @elseif ($report->status == 'Done')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          {{ $report->status }} {{-- Display the status --}}    
                      </span>
                    @else
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                          {{ $report->status }} {{-- Display the status --}}
                      </span> 
                    @endif
                     
                  </span>
                  
          </div>
        </div>
          @endforeach

      </section>

  
    </main>

    <footer class="bg-blue-800 text-white py-8 floating-bottom">
    
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} IT Department - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">
          {{-- <a href="#about" class="hover:underline">About</a>
          <a href="#services" class="hover:underline">Services</a>
          <a href="#projects" class="hover:underline">Projects</a>
          <a href="#contact" class="hover:underline">Contact</a> --}}
        </div>
      </div>
    </footer>

    <script>
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