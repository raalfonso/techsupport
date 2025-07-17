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
    <link rel="icon" type="image/png" href="{{ asset('images/SolveIT-removebg-preview.png') }}">
</head>

{{-- Added pt-16 to the body to account for the fixed navbar height --}}
<body> 
    {{-- Main Navbar --}}
    <nav class="bg-white p-4 shadow-md top-0 z-50 min-w-full fixed">
        {{-- Outer container for full-width alignment --}}
        {{-- Inner container for content alignment --}}
       <div class="flex items-center justify-between container mx-auto w-full">
            {{-- Logo or Brand Name --}}
            <div class="text-lg font-bold text-gray-800">
                BCDA IT Department {{-- Changed from MyBrand to match context --}}
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-4 float-right">
                {{-- Navigation links --}}
                <a href="#home-section" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                <a href="#about" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">About</a>
                <a href="#projects" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Project</a>
                <a href="#contact" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Report</a> {{-- Assuming 'Report' links to 'Contact' or another relevant section --}}
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
    <section id="home-section" class="pb-5" style="background-color: #e6edfc">
        <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 pt-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-6">
                <div class="col-span-6 flex flex-col gap-8">
                    <div class="flex gap-2 mx-auto lg:mx-0 items-center">
                        
                    </div>

                    <h1 class="text-gray-900 text-4xl sm:text-5xl font-semibold pt-5 lg:pt-0">
                        The IT Solution Starts Here.
                    </h1>

                    <h3 class="text-black/70 text-lg pt-5 lg:pt-0">
                        Report problems, track requests, and get expert support from your IT Division, all in one place.
                    </h3>
                    
                    <button class="bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800">
                        <a href="{{ route('login') }}">Request Support  <i class="fa-regular fa-comments"></i></a>
                    </button>
                </div>

                <div class="col-span-6 flex justify-center">
                   <video width="1000" height="805" autoplay loop muted playsinline class="max-w-full h-auto rounded-lg ">
                    <source src="{{ asset('img/6999824_Motion_Graphics_Animation_1920x1080.mp4') }}" type="video/mp4">
                </video>
                </div>
            </div>
        </div>
    </section>

    <section id="top" class="bg-blue-700 text-white py-20">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to the IT Department</h1>
        <p class="text-lg md:text-xl mb-6">Empowering innovation, security, and digital transformation across the organization.</p>
        <a href="#services" class="inline-block bg-white text-blue-700 px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-100">Explore Services</a>
      </div>
    </section>

    <section id="about" class="py-16 bg-white">
      <div class="max-w-5xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">About the IT Department</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          The BCDA IT Department provides strategic IT leadership, technical expertise, and operational services to ensure secure, reliable, and efficient technology systems throughout the organization. We support innovation, system modernization, and collaborative digital solutions.
        </p>
      </div>
    </section>

    <section id="services" class="py-16 bg-gray-50">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Our Core Services</h2>
        <div class="grid gap-8 md:grid-cols-3">
          @foreach([
            ['title' => 'IT Support', 'desc' => 'Helpdesk, troubleshooting, and technical assistance for all departments.'],
            ['title' => 'Infrastructure', 'desc' => 'Managing servers, networks, and ensuring system uptime and reliability.'],
            ['title' => 'Software Development', 'desc' => 'Custom applications, websites, and automations tailored to agency needs.']
          ] as $service)
          <div class="bg-white p-6 rounded-xl shadow hover:shadow-md transition duration-300 transform hover:-translate-y-1">
            <h3 class="text-xl font-semibold mb-2 text-blue-700">{{ $service['title'] }}</h3>
            <p class="text-gray-600 text-sm">{{ $service['desc'] }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </section>

    <section id="projects" class="py-16 bg-white">
      <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-12">Key Projects</h2>
        <div class="grid gap-8 md:grid-cols-3">
          @foreach([
            ['title' => 'Ticketing System', 'desc' => 'An internal platform to streamline IT requests and track issue resolution.'],
            ['title' => 'BCDA Careers Portal', 'desc' => 'Job posting site that integrates HRIS and applicant tracking.'],
            ['title' => 'Records Digitization', 'desc' => 'Scanning, indexing, and management of agency records in digital format.']
          ] as $project)
          <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
            <h3 class="text-lg font-semibold text-blue-800 mb-2">{{ $project['title'] }}</h3>
            <p class="text-gray-700 text-sm">{{ $project['desc'] }}</p>
          </div>
          @endforeach
        </div>
      </div>
    </section>

    <section id="contact" class="py-16 bg-gray-50">
      <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold mb-6">Get in Touch</h2>
        <p class="text-lg">📍 BCDA IT Department, Taguig City</p>
        <p class="mt-2">📧 <a href="mailto:it-support@bcda.gov.ph" class="text-blue-600 underline hover:text-blue-800">it-support@bcda.gov.ph</a></p>
        <p class="mt-2">📞 Local: 1234</p>
        <a href="#top" class="mt-6 inline-block text-sm text-blue-700 hover:underline">Back to Top ↑</a>
      </div>
    </section>

    <footer class="bg-blue-800 text-white py-8">
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} IT Department - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">
          <a href="#about" class="hover:underline">About</a>
          <a href="#services" class="hover:underline">Services</a>
          <a href="#projects" class="hover:underline">Projects</a>
          <a href="#contact" class="hover:underline">Contact</a>
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
    </script>
</body>
</html>