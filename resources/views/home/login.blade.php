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
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
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
                <a href="#"   data-modal-target="login-modal"
                  data-modal-toggle="login-modal"
                  class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Login</a>
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
        <div id="mobile-menu" class="mt-5 hidden md:hidden bg-white pt-2 pb-3 space-y-1 sm:px-3">
            {{-- Container for mobile menu links --}}
            <br><br><br>
            <br>
            <div class="container mx-auto mt-5"> 
                <a href="#home-section" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="#about" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="#projects" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Project</a>
                <a href="#contact" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Report</a>
                <a href="#"   data-modal-target="login-modal"
                  data-modal-toggle="login-modal"
                  class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Login</a>
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
                    
                    <a href="#contact" class="bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800 text-center">
                        Request Support  <i class="fa-regular fa-comments"></i>
                    </a>
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
        <h1 class="text-4xl md:text-5xl font-bold mb-4">BCDA IT MISSION</h1>
        <p class="text-lg md:text-xl mb-6">To empower BCDA by responding to its enterprise-wide IS requirements by using appropriate technologies.</p>
        <a href="#services" class="inline-block bg-white text-blue-700 px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-100">Explore Services</a>
      </div>
    </section>

    <section id="about" class="py-16 bg-white mb-5">
      <div class="max-w-5xl mx-auto px-6 text-center transition-all duration-700 opacity-0 translate-y-4 mt-5" data-scroll>
        <h2 class="text-3xl font-bold mb-6">About the IT Division</h2>
        <p class="text-gray-700 text-lg leading-relaxed">
          The BCDA IT Division provides strategic IT leadership, technical expertise, and operational services to ensure secure, reliable, and efficient technology systems throughout the organization. We support innovation, system modernization, and collaborative digital solutions.
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
            ['title' => 'BCDA QR Maker', 'desc' => 'BCDA’s smart way to share information—one scan away.', 'url' => route('vcard')],
            // ['title' => 'BCDA Careers Portal', 'desc' => 'Job posting site that integrates HRIS and applicant tracking.', 'url' => '#careers'],
            ['title' => 'BCDA Survey Hub', 'desc' => 'Your gateway to sharing insights, giving feedback, and shaping the future of BCDA through quick and secure surveys.', 'url' => route('survey.index')],
            ['title' => 'ITD Assets Maintenance', 'desc' => 'An IT asset management hub for tracking hardware, software licenses, and maintenance schedules to ensure timely updates and repairs', 'url' => 'https://www.appsheet.com/start/98c13452-6136-41b8-bd56-72559f573536'],
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
            ['title' => 'Issue Tracker', 'desc' => 'Check the status of your request or repair ticket.', 'url' => 'https://www.bcda.gov.ph','icon' => 'fa-solid fa-location-dot','button' => 'Track Issue', 'main' =>'0' ],
            ['title' => 'Video conferencing / Support', 'desc' => 'Technical and configurational support from IT Support', 'url' => 'https://hris.bcda.gov.ph','icon' => 'fa-solid fa-video','button' => 'Submit Request', 'main' =>'1'],
            ['title' => 'Acumatica ERP and HRIS', 'desc' => 'Support for Acumatica or HRIS-related issues.', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-users','button' => 'Report Issue', 'main' =>'2'],
            ['title' => 'Hardware Issue', 'desc' => 'Support for system malfunction, connectivity issues, and printer errors', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-desktop', 'button' => 'Report Issue', 'main' =>'4'],
            ['title' => 'Cybersecurity Issue', 'desc' => 'Support for malware, phishing, and other cybersecurity issues', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-shield-halved','button' => 'Report Issue', 'main' =>'3'],
            ['title' => 'Network Problem', 'desc' => 'Assistance with slow connectivity, VPN failures, and disconnections.', 'url' => 'https://pams.bcda.gov.ph' ,'icon' => 'fa-solid fa-globe','button' => 'Report Issue' , 'main' =>'4'],
            ['title' => 'AOdocs Issues', 'desc' => 'Support for document access, workflow malfunction, and permissions errors.', 'url' => '#careers' ,'icon' => 'fa-solid fa-file-alt','button' => 'Report Issue', 'main' =>'2'],
            ['title' => 'Software Issues', 'desc' => 'Support for software crashes, installation errors, and performance issues.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-location-dot','button' => 'Report Issue', 'main' =>'4'],
            ['title' => 'Google Workspace Issues', 'desc' => 'Support for email, drive, docs, sheets, meet, and document sharing issues.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-envelope','button' => 'Report Issue', 'main' =>'2'],
            ['title' => 'Other Issues', 'desc' => 'For any other IT-related issues not covered above.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-question','button' => 'Report Issue', 'main' =>'99']
          ] as $project)
            {{-- Use data attributes for modal functionality --}}
            <a href="#"
              data-modal-target="crud-modal"
              data-modal-toggle="crud-modal"
              data-project-title="{{ $project['title'] }}"
              data-project-button="{{ $project['button'] }}"
              data-project-main="{{ $project['main'] }}"
              class="bg-white p-4 rounded-lg shadow hover:shadow-lg transition">
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

    {{-- this is for modal request --}}
    <!-- Login modal -->
      <div id="login-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full ">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                         <span class="text-blue-700 font-semibold"></span>
                      </h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="login-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <div class="rounded-lg shadow w-full max-w-md mt-[0%] sm:mt-[-1/2]">
                    <center>
                        <img src="{{asset('img/itd_logo.png')}}" alt="" class="max-w-48 h-48 mx-auto mt-[-10%] mb-[-10%]">
                    </center>

                    <div class="mt-[-15%] p-6">
                        <h1 class="text-2xl font-bold text-center mb-5 text-gray-800">ICTD Login</h1>
            
                        <form action="{{ route('login')}}" method="post">
                            @csrf
                            <div class="mb-4">
                                <label for="email" class="block font-semibold text-gray-700">Email</label>
                                <input type="text" name="email" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300 @error('email') ring-red-500 @enderror" value="{{ old('email') }}">
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <div class="mb-4">
                                <label for="password" class="block font-semibold text-gray-700">Password</label>
                                <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                
                            <!-- Remember me checkbox -->
                            <div class="mb-4 flex items-center">
                                <input type="checkbox" name="remember" id="remember" class="mr-2">
                                <label for="remember" class="text-gray-700">Remember me</label>
                            </div>
                
                            @error('failed')
                                <p class="text-red-500 text-sm mb-4">{{ $message }}</p>
                            @enderror
                
                            <button class="w-full px-4 py-3  bg-gradient-to-r from-slate-800 to-blue-950 text-white font-semibold rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-200">
                                Login
                            </button>
                        </form>
                    </div>
                    
                </div>

              </div>
          </div>
      </div> 
     <!-- Main modal -->
      <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full ">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                         <span id="modal-project-title" class="text-blue-700 font-semibold"></span>
                      </h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <form action="{{ route('client.check-email') }}" method="post" id="login-form" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                      <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email address" required>

                      
                      </div>
                      <input type="text" name="main" id='modal-project-main' class="hidden">

                      <button type="submit" id="modal-action-button" class="col-span-2 bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800">
                        <span id="modal-project-button" class="text-blue-700 font-semibold">Submit</span>
                      </button>
                    </div>
                  </form>

              </div>
          </div>
      </div> 
    <footer class="bg-blue-800 text-white py-8">
      <div class="max-w-6xl mx-auto px-6 text-center">
        <p class="text-sm">&copy; {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
        <p class="text-xs mt-2 text-blue-200">Developed by ICTD-ITD 2025</p>
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

      // this is for modal request
      document.addEventListener('DOMContentLoaded', function () {
        const modalTitle = document.getElementById('modal-project-title');
        const actionButton = document.getElementById('modal-action-button');
        const main = document.getElementById('modal-project-main');

        document.querySelectorAll('[data-modal-toggle="crud-modal"]').forEach(el => {
          el.addEventListener('click', function () {
            const title = this.getAttribute('data-project-title');
            const mainData = this.getAttribute('data-project-main');
            const projectButton = this.getAttribute('data-project-button') || 'Submit';
            if (modalTitle) {
              modalTitle.textContent = title;
              actionButton.textContent = projectButton;
              main.value = mainData;
            }
          });
        });
      });

    </script>
</body>
</html>