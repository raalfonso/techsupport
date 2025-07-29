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
<body> 
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
            <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
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
                        <a href="#contact">Request Support  <i class="fa-regular fa-comments"></i></a>
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
      <div class="max-w-6xl mx-auto px-6 text-center transition-all duration-700 opacity-0 translate-y-4" data-scroll>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to the IT Division</h1>
        <p class="text-lg md:text-xl mb-6">Empowering innovation, security, and digital transformation across the organization.</p>
        <a href="#services" class="inline-block bg-white text-blue-700 px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-100">Explore Services</a>
      </div>
    </section>

    <section id="about" class="py-16 bg-white mb-5">
      <div class="max-w-5xl mx-auto px-6 text-center transition-all duration-700 opacity-0 translate-y-4 mt-5" data-scroll>
        <h2 class="text-3xl font-bold mb-6">About the IT Division</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          The BCDA IT Department provides strategic IT leadership, technical expertise, and operational services to ensure secure, reliable, and efficient technology systems throughout the organization. We support innovation, system modernization, and collaborative digital solutions.
        </p>
      </div>
    </section>

    <section id="services" class="py-16 bg-gray-50">
      <div class="max-w-6xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
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
      <div class="max-w-6xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4 mt-5" data-scroll>
        <h2 class="text-3xl font-bold text-center mb-12">Key Projects</h2>
        <div class="grid gap-8 md:grid-cols-3">
          @foreach([
            ['title' => 'BCDA Website', 'desc' => 'Showcasing infrastructure projects, economic zone development, and public-private partnerships in the Philippines.', 'url' => 'https://www.bcda.gov.ph'],
            ['title' => 'Human Resource Information System', 'desc' => 'A system that manages employee data, payroll, recruitment, and HR processes in one digital platform.', 'url' => 'https://hris.bcda.gov.ph'],
            ['title' => 'Acumatica ERP', 'desc' => 'Cloud-based ERP platform for managing finance, inventory, sales, and operations in one integrated system.', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f'],
            ['title' => 'Property Asset Management System', 'desc' => 'Tracking and managing IT assets, including hardware, software licenses, and inventory.', 'url' => 'https://pams.bcda.gov.ph'],
            ['title' => 'BCDA Careers Portal', 'desc' => 'Job posting site that integrates HRIS and applicant tracking.', 'url' => '#careers'],
            ['title' => 'Records Digitization', 'desc' => 'Scanning, indexing, and management of agency records in digital format.', 'url' => '#digitization']
          ] as $project)
            <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" class="block bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 transform hover:scale-105">
              <h3 class="text-lg font-semibold text-blue-800 mb-2">{{ $project['title'] }}</h3>
              <p class="text-gray-700 text-sm text-justify">{{ $project['desc'] }}</p>
            </a>
          @endforeach
        </div>
      </div>
    </section>

    <section id="contact" class="py-10 bg-gray-50">
      <div class="max-w-6xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4 mt-5" data-scroll>
        <h2 class="text-3xl font-bold text-left mb-5">How can we help you today?</h2>
        <h3 class="text-xl font-normal text-left mb-12">Pick one from the topics below and we’ll find the best solution for you.</h3>
        <div class="grid gap-8 md:grid-cols-3">
          @foreach([
            ['title' => 'Issue Tracker', 'desc' => 'Check the status of your request or repair ticket.', 'url' => 'https://www.bcda.gov.ph','icon' => 'fa-solid fa-location-dot'],
            ['title' => 'Video conferencing / Support', 'desc' => 'Technical and configurational support from IT Support', 'url' => 'https://hris.bcda.gov.ph','icon' => 'fa-solid fa-video'],
            ['title' => 'Acumatica ERP and HRIS', 'desc' => 'Support for Acumatica or HRIS-related issues.', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-users'],
            ['title' => 'Hardware Issue', 'desc' => 'Support for system malfunction, connectivity issues, and printer errors', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-desktop'],
            ['title' => 'Cybersecurity Issue', 'desc' => 'Support for malware, phishing, and other cybersecurity issues', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-shield-halved'],
            ['title' => 'Network Problem', 'desc' => 'Assistance with slow connectivity, VPN failures, and disconnections.', 'url' => 'https://pams.bcda.gov.ph' ,'icon' => 'fa-solid fa-globe'],
            ['title' => 'AOdocs Issues', 'desc' => 'Support for document access, workflow malfunction, and permissions errors.', 'url' => '#careers' ,'icon' => 'fa-solid fa-file-alt'],
            ['title' => 'Software Issues', 'desc' => 'Support for software crashes, installation errors, and performance issues.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-location-dot'],
            ['title' => 'Google Workspace Issues', 'desc' => 'Support for email, drive, docs, sheets, meet, and document sharing issues.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-envelope'],
            ['title' => 'Other Issues', 'desc' => 'For any other IT-related issues not covered above.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-question']
          ] as $project)
            <a href="#" class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
              <div class="flex justify-left items-center text-center mb-3">
                <i class="{{ $project['icon'] }} text-blue-700 text-2xl"></i>
                <h2 class="text-lg font-semibold text-blue-800 ml-2">
                  {{ $project['title'] }}
                </h2>
               </div>
                <p class="text-sm text-justify">
                  {{ $project['desc'] }}
                </p>
             
            </a>
          @endforeach
        </div>
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

        document.addEventListener("DOMContentLoaded", () => {
        const elements = document.querySelectorAll('[data-scroll]');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.remove('opacity-0', 'translate-y-4');
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