<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ env('APP_NAME', 'IT Department') }} - Halloween Edition 🎃</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">

    <style>
        /* Custom Halloween themed scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #090c1a;
        }
        ::-webkit-scrollbar-thumb {
            background: #ea580c;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }

        /* Subtle glowing animations */
        @keyframes spooky-glow {
            0%, 100% {
                box-shadow: 0 0 15px rgba(249, 115, 22, 0.45), 0 0 30px rgba(249, 115, 22, 0.2);
            }
            50% {
                box-shadow: 0 0 25px rgba(249, 115, 22, 0.75), 0 0 45px rgba(249, 115, 22, 0.35);
            }
        }
        .animate-spooky-glow {
            animation: spooky-glow 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#080b18] text-gray-100 antialiased selection:bg-orange-600 selection:text-white"> 
    {{-- Halloween Dark Navbar --}}
    <nav class="bg-[#080b18]/90 backdrop-blur-md border-b border-orange-500/20 px-4 py-3 shadow-xl top-0 z-50 min-w-full fixed transition-all duration-300">
        <div class="flex items-center justify-between container mx-auto w-full max-w-7xl">
            {{-- Logo / Brand Name --}}
            <a href="#home-section" class="flex items-center group py-0.5">
                <img src="{{ asset('images/bcda-digitalhub-clean.png') }}"
                     alt="Digitalhub Logo"
                     class="h-6 sm:h-8 md:h-10 w-auto filter brightness-0 invert drop-shadow-[0_0_10px_rgba(255,255,255,0.45)] transition-transform duration-300 group-hover:scale-105">
            </a>
            
            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-2 lg:space-x-5 items-center">
                <a href="#home-section" class="text-amber-400 font-semibold px-3 py-2 rounded-md text-sm transition-colors hover:text-orange-300">Home</a>
                <a href="#about" class="text-gray-200 hover:text-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">About</a>
                <a href="#projects" class="text-gray-200 hover:text-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">Project</a>
                <a href="#contact" class="text-gray-200 hover:text-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">Report</a>
                
                @auth
                    <a href="{{ route('attendance.dashboard') }}" class="text-gray-200 hover:text-amber-400 px-3 py-2 rounded-md text-sm font-medium transition-colors">Attendance</a>
                    <span class="text-gray-100 px-2 py-1 text-sm font-semibold tracking-wide">{{ auth()->user()->name }}</span>
                    @if (auth()->user()->authAssignments->whereIn('item_name', ['Administrator', 'IT_User'])->isNotEmpty())
                        <a href="{{ route('dashboard') }}" class="bg-[#f97316] hover:bg-[#ea580c] text-white px-4 py-1.5 rounded-lg text-sm font-semibold shadow-md shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 transform hover:-translate-y-0.5">SolveIT</a>
                    @endif
                @endauth
            </div>

            {{-- Mobile Menu Button (Hamburger) --}}
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" aria-label="Toggle navigation menu" class="text-gray-300 hover:text-amber-400 focus:outline-none p-1 rounded-md transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation Dropdown --}}
        <div id="mobile-menu" class="hidden md:hidden bg-[#0c0f22]/98 border-t border-orange-500/20 backdrop-blur-xl px-4 pt-4 pb-6 space-y-2 mt-3 rounded-b-2xl shadow-2xl">
            <a href="#home-section" class="block text-amber-400 hover:bg-orange-500/10 px-3 py-2.5 rounded-lg text-base font-semibold">Home</a>
            <a href="#about" class="block text-gray-200 hover:text-amber-400 hover:bg-orange-500/10 px-3 py-2.5 rounded-lg text-base font-medium">About</a>
            <a href="#projects" class="block text-gray-200 hover:text-amber-400 hover:bg-orange-500/10 px-3 py-2.5 rounded-lg text-base font-medium">Project</a>
            <a href="#contact" class="block text-gray-200 hover:text-amber-400 hover:bg-orange-500/10 px-3 py-2.5 rounded-lg text-base font-medium">Report</a>
            
            @auth
                <a href="{{ route('attendance.dashboard') }}" class="block text-gray-200 hover:text-amber-400 hover:bg-orange-500/10 px-3 py-2.5 rounded-lg text-base font-medium">Attendance</a>
                <div class="pt-2 border-t border-orange-500/20 flex items-center justify-between">
                    <span class="text-gray-300 text-sm font-semibold px-3">{{ auth()->user()->name }}</span>
                    @if (auth()->user()->authAssignments->whereIn('item_name', ['Administrator', 'IT_User'])->isNotEmpty())
                        <a href="{{ route('dashboard') }}" class="inline-block bg-[#f97316] hover:bg-[#ea580c] text-white px-4 py-1.5 rounded-lg text-sm font-semibold shadow-md shadow-orange-500/30">SolveIT</a>
                    @endif
                </div>
            @endauth                                  
        </div>
    </nav>

    {{-- Halloween Master Wrapper: Covers Hero & BCDA IT Mission with halloween_bg.png --}}
    <div class="relative w-full bg-cover bg-center sm:bg-top bg-no-repeat overflow-hidden" 
         style="background-image: url('{{ asset('images/halloween_bg.png') }}'); background-size: cover; background-position: center top;">
        
        {{-- Section 1: Hero Section (Upper half of the Halloween illustration) --}}
        <section id="home-section" class="pt-28 pb-12 sm:pt-36 sm:pb-16 lg:pt-40 lg:pb-24">
            <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-8">
                    {{-- Left column: Welcome text & glowing pill button --}}
                    <div class="lg:col-span-6 xl:col-span-7 flex flex-col gap-6 text-left">
                        <h1 class="text-white text-4xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight leading-tight drop-shadow-[0_3px_10px_rgba(0,0,0,0.8)]">
                            @auth
                                Welcome back, <span class="text-[#f97316] drop-shadow-[0_0_15px_rgba(249,115,22,0.65)]">{{ auth()->user()->name }}!</span>
                            @else
                                The IT Solution <span class="text-[#f97316] drop-shadow-[0_0_15px_rgba(249,115,22,0.65)]">Starts Here.</span>
                            @endauth
                        </h1>

                        <p class="text-gray-200 text-base sm:text-lg lg:text-xl font-normal max-w-xl leading-relaxed drop-shadow-[0_2px_6px_rgba(0,0,0,0.85)]">
                            Report problems, track requests, and get expert support from your IT Division, all in one place.
                        </p>

                        <div class="pt-2">
                            <a href="#contact" 
                               class="animate-spooky-glow inline-flex items-center justify-center gap-3 px-8 py-3.5 rounded-full text-base font-semibold text-orange-200 bg-[#16122c]/85 hover:bg-[#201a3d] border-2 border-[#f97316] shadow-[0_0_20px_rgba(249,115,22,0.55)] hover:shadow-[0_0_30px_rgba(249,115,22,0.85)] hover:text-white transition duration-300 transform hover:-translate-y-0.5">
                                <span>Request Support</span>
                                <i class="fa-regular fa-comments text-lg text-orange-400"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Right column spacer: leaves the witch/vampire IT desk artwork fully visible --}}
                    <div class="hidden lg:block lg:col-span-6 xl:col-span-5 min-h-[300px] xl:min-h-[360px]">
                        {{-- Open space on desktop showcasing the wizard, glowing monitor, ghosts and jack-o-lantern --}}
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: BCDA IT MISSION (Lower misty portion above the carved glowing pumpkins) --}}
        <section id="top" class="pt-8 pb-32 sm:pb-40 lg:pt-12 lg:pb-52 text-white text-center">
            <div class="max-w-4xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-wider uppercase mb-4 text-white drop-shadow-[0_4px_14px_rgba(0,0,0,0.9)]">
                    BCDA IT MISSION
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-gray-200 mb-8 max-w-3xl mx-auto font-normal leading-relaxed drop-shadow-[0_2px_10px_rgba(0,0,0,0.9)]">
                    To empower BCDA by responding to its enterprise-wide IS requirements by using appropriate technologies.
                </p>
                <div>
                    <a href="#services" 
                       class="inline-block bg-white hover:bg-orange-50 text-gray-950 font-bold px-8 py-3 rounded-full shadow-[0_0_20px_rgba(255,255,255,0.45)] hover:shadow-[0_0_25px_rgba(249,115,22,0.65)] hover:border-orange-400 transition duration-300 transform hover:-translate-y-0.5 text-sm sm:text-base">
                        Explore Services
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- About Section --}}
    <section id="about" class="py-20 bg-[#090c1a] border-t border-orange-500/20 relative">
        <div class="max-w-5xl mx-auto px-6 text-center transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/30 text-orange-400 text-xs sm:text-sm font-semibold mb-6">
                <i class="fa-solid fa-wand-magic-sparkles"></i> Empowering Innovation
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold mb-6 text-white tracking-wide">About the IT Division</h2>
            <div class="bg-[#12162d]/80 border border-orange-500/20 backdrop-blur-md rounded-2xl p-8 sm:p-12 shadow-2xl shadow-black/50 text-gray-300 text-base sm:text-lg leading-relaxed text-justify sm:text-center">
                The BCDA IT Division provides strategic IT leadership, technical expertise, and operational services to ensure secure, reliable, and efficient technology systems throughout the organization. We support innovation, system modernization, and collaborative digital solutions.
            </div>
        </div>
    </section>

    {{-- Core Services Section --}}
    <section id="services" class="py-20 bg-[#0d1022] border-t border-orange-500/10 relative">
        <div class="max-w-6xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/30 text-orange-400 text-xs sm:text-sm font-semibold mb-4">
                    <i class="fa-solid fa-ghost"></i> What We Provide
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Our Core Services</h2>
            </div>
            
            <div class="grid gap-8 md:grid-cols-3">
                @foreach([
                    ['title' => 'IT Support', 'desc' => 'Helpdesk, troubleshooting, and technical assistance for all departments.', 'icon' => 'fa-solid fa-headset'],
                    ['title' => 'Infrastructure', 'desc' => 'Managing servers, networks, and ensuring system uptime and reliability.', 'icon' => 'fa-solid fa-server'],
                    ['title' => 'Software Development', 'desc' => 'Custom applications, websites, and automations tailored to agency needs.', 'icon' => 'fa-solid fa-code']
                ] as $service)
                <div class="group bg-[#151933]/90 border border-orange-500/20 hover:border-orange-500/60 p-8 rounded-2xl shadow-xl shadow-black/40 hover:shadow-orange-500/20 transition-all duration-300 transform hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center mb-6 shadow-md shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                        <i class="{{ $service['icon'] }} text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-white group-hover:text-orange-400 transition-colors duration-300">{{ $service['title'] }}</h3>
                    <p class="text-gray-300 text-sm leading-relaxed">{{ $service['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Key Projects Section --}}
    <section id="projects" class="py-20 bg-[#090c1a] border-t border-orange-500/10 relative">
        <div class="max-w-6xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="text-center mb-14">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/30 text-orange-400 text-xs sm:text-sm font-semibold mb-4">
                    <i class="fa-solid fa-layer-group"></i> Digital Systems
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Key Projects</h2>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['title' => 'BCDA Website', 'desc' => 'Showcasing infrastructure projects, economic zone development, and public-private partnerships in the Philippines.', 'url' => 'https://www.bcda.gov.ph', 'icon' => 'fa-solid fa-globe'],
                    ['title' => 'Human Resource Information System', 'desc' => 'A system that manages employee data, payroll, recruitment, and HR processes in one digital platform.', 'url' => 'https://hris.bcda.gov.ph', 'icon' => 'fa-solid fa-id-card-clip'],
                    ['title' => 'Acumatica ERP', 'desc' => 'Cloud-based ERP platform for managing finance, inventory, sales, and operations in one integrated system.', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f', 'icon' => 'fa-solid fa-chart-line'],
                    ['title' => 'BCDA QR Maker', 'desc' => 'BCDA’s smart way to share information—one scan away.', 'url' => route('vcard'), 'icon' => 'fa-solid fa-qrcode'],
                    ['title' => 'Key-Board', 'desc' => 'A centralized system for managing meeting notes, agendas, and tasks.', 'url' => route('keyboard.index'), 'icon' => 'fa-solid fa-clipboard-list'],
                    ['title' => 'BCDA Survey Hub', 'desc' => 'Your gateway to sharing insights, giving feedback, and shaping the future of BCDA through quick and secure surveys.', 'url' => route('survey.checkLogin'), 'icon' => 'fa-solid fa-square-poll-vertical'],
                    ['title' => 'ITD Assets Maintenance', 'desc' => 'An IT asset management hub for tracking hardware, software licenses, and maintenance schedules to ensure timely updates and repairs.', 'url' => 'https://www.appsheet.com/start/98c13452-6136-41b8-bd56-72559f573536', 'icon' => 'fa-solid fa-screwdriver-wrench'],
                    ['title' => 'IT Request Personnel', 'desc' => 'A web-based system for managing and tracking IT personnel and technical support requests within the organization.', 'url' => route('request-personnel.index'), 'icon' => 'fa-solid fa-users-gear'],
                ] as $project)
                <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" 
                   class="group bg-[#13172e] border border-orange-500/15 hover:border-orange-500/60 p-6 rounded-2xl shadow-lg shadow-black/40 hover:shadow-orange-500/20 transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="w-10 h-10 rounded-lg bg-orange-500/10 border border-orange-500/30 flex items-center justify-center text-orange-400 group-hover:scale-110 transition-transform">
                                <i class="{{ $project['icon'] }}"></i>
                            </span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs text-gray-500 group-hover:text-orange-400 transition-colors"></i>
                        </div>
                        <h3 class="text-lg font-bold text-white group-hover:text-orange-400 mb-2 transition-colors duration-300">{{ $project['title'] }}</h3>
                        <p class="text-gray-300 text-sm leading-relaxed">{{ $project['desc'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact / Support Topics Section --}}
    <section id="contact" class="py-20 bg-gradient-to-b from-[#090c1a] via-[#0d1022] to-[#060812] border-t border-orange-500/20 relative">
        <div class="max-w-6xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="mb-14 text-center md:text-left">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/30 text-orange-400 text-xs sm:text-sm font-semibold mb-4">
                    <i class="fa-solid fa-headset"></i> IT Helpdesk
                </div>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">How can we help you today?</h2>
                <h3 class="text-base sm:text-lg text-gray-300 font-normal">Pick one from the topics below and we’ll find the best solution for you.</h3>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach([
                    ['title' => 'Issue Tracker', 'desc' => 'Check the status of your request or repair ticket.', 'url' => 'https://www.bcda.gov.ph','icon' => 'fa-solid fa-location-dot','button' => 'Track Issue', 'main' =>'0' ],
                    ['title' => 'Video Conferencing / Support', 'desc' => 'Technical and configurational support from IT Support', 'url' => 'https://hris.bcda.gov.ph','icon' => 'fa-solid fa-video','button' => 'Submit Request', 'main' =>'1'],
                    ['title' => 'Video Conferencing Issues', 'desc' => 'Troubleshooting for connectivity, hardware, and software performance', 'url' => 'https://hris.bcda.gov.ph','icon' => 'fa-solid fa-triangle-exclamation','button' => 'Report Issue', 'main' =>'5'],
                    ['title' => 'Acumatica ERP and HRIS', 'desc' => 'Support for Acumatica or HRIS-related issues.', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-users','button' => 'Report Issue', 'main' =>'2'],
                    ['title' => 'Hardware Issue', 'desc' => 'Support for system malfunction, connectivity issues, and printer errors', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-desktop', 'button' => 'Report Issue', 'main' =>'4'],
                    ['title' => 'Cybersecurity Issue', 'desc' => 'Support for malware, phishing, and other cybersecurity issues', 'url' => 'https://bcda.cloudtwogo.com/Frames/Login.aspx?ReturnUrl=%2f','icon' => 'fa-solid fa-shield-halved','button' => 'Report Issue', 'main' =>'3'],
                    ['title' => 'Network Problem', 'desc' => 'Assistance with slow connectivity, VPN failures, and disconnections.', 'url' => 'https://pams.bcda.gov.ph' ,'icon' => 'fa-solid fa-globe','button' => 'Report Issue' , 'main' =>'4'],
                    ['title' => 'AOdocs Issues', 'desc' => 'Support for document access, workflow malfunction, and permissions errors.', 'url' => '#careers' ,'icon' => 'fa-solid fa-file-lines','button' => 'Report Issue', 'main' =>'2'],
                    ['title' => 'Software Issues', 'desc' => 'Support for software crashes, installation errors, and performance issues.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-bug','button' => 'Report Issue', 'main' =>'4'],
                    ['title' => 'Google Workspace Issues', 'desc' => 'Support for email, drive, docs, sheets, meet, and document sharing issues.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-envelope','button' => 'Report Issue', 'main' =>'2'],
                    ['title' => 'Print Toner/Supplies', 'desc' => 'Request for printer toner, ink cartridges, and other printing supplies.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-print','button' => 'Request Supplies', 'main' =>'6'],
                    ['title' => 'Other Issues', 'desc' => 'For any other IT-related issues not covered above.', 'url' => '#digitization' ,'icon' => 'fa-solid fa-circle-question','button' => 'Report Issue', 'main' =>'99']
                ] as $project)
                {{-- Use data attributes for modal functionality --}}
                <a href="#"
                   @guest onclick="event.preventDefault(); window.location.href='{{ route('google.login') }}';" @endguest
                   @auth data-modal-target="crud-modal" data-modal-toggle="crud-modal" @endauth
                   data-project-title="{{ $project['title'] }}"
                   data-project-button="{{ $project['button'] }}"
                   data-project-main="{{ $project['main'] }}"
                   class="group bg-[#13172e] p-6 rounded-2xl shadow-xl shadow-black/40 hover:shadow-orange-500/25 transition-all duration-300 border border-orange-500/20 hover:border-orange-500/60 hover:-translate-y-1.5 flex flex-col justify-between">
                    <div class="flex items-start space-x-4 mb-4">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-orange-500 to-amber-600 rounded-xl flex items-center justify-center shadow-md shadow-orange-500/30 group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $project['icon'] }} text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white group-hover:text-orange-400 transition-colors duration-300 mb-2">
                                {{ $project['title'] }}
                            </h3>
                            <p class="text-sm text-gray-300 leading-relaxed">
                                {{ $project['desc'] }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-end text-orange-400 font-semibold text-sm group-hover:text-orange-300 transition-colors pt-2 border-t border-white/5">
                        <span>{{ $project['button'] }}</span>
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1.5 transition-transform duration-300"></i>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Request Support Modal --}}
    <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/70 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-[#131830] border border-orange-500/40 rounded-2xl shadow-2xl shadow-black">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-orange-500/20 rounded-t">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-headset text-orange-400"></i>
                        <span id="modal-project-title" class="text-orange-400 font-bold"></span>
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-white bg-transparent hover:bg-orange-500/20 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors" data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('client.check-email') }}" method="post" id="login-form" class="p-5">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-200">Email Address</label>
                            <input type="text" name="email" id="email" 
                                   class="bg-[#0b0e1e] border border-gray-700 text-white text-sm rounded-xl focus:ring-orange-500 focus:border-orange-500 block w-full p-3 transition" 
                                   placeholder="Enter your email address" 
                                   value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                        </div>
                        <input type="text" name="main" id='modal-project-main' class="hidden">

                        <button type="submit" id="modal-action-button" 
                                class="w-full bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white px-6 py-3 rounded-full font-bold shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300">
                            <span id="modal-project-button" class="text-white font-bold">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    {{-- Halloween Spooky Footer --}}
    <footer class="bg-[#05070e] border-t border-orange-500/20 text-gray-400 py-10 relative">
        <div class="max-w-6xl mx-auto px-6 text-center space-y-2">
            <p class="text-sm font-medium">&copy; {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
            <p class="text-xs text-orange-400/80">Developed by ICTD-ITD {{ date('Y') }} 🎃 Happy Halloween</p>
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

        // Intersection Observer for scroll animations
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

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId && targetId !== '#') {
                    const target = document.querySelector(targetId);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                }
            });
        });

        // Modal Request handler
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('crud-modal');
            const modalTitle = document.getElementById('modal-project-title');
            const actionButton = document.getElementById('modal-action-button');
            const actionButtonText = document.getElementById('modal-project-button');
            const main = document.getElementById('modal-project-main');

            document.querySelectorAll('[data-modal-toggle="crud-modal"]').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (modal) {
                        modal.classList.toggle('hidden');
                        modal.classList.toggle('flex');
                    }
                    const title = this.getAttribute('data-project-title');
                    const mainData = this.getAttribute('data-project-main');
                    const projectButton = this.getAttribute('data-project-button') || 'Submit';
                    if (modalTitle && title) {
                        modalTitle.textContent = title;
                    }
                    if (actionButtonText && projectButton) {
                        actionButtonText.textContent = projectButton;
                    }
                    if (main && mainData) {
                        main.value = mainData;
                    }
                });
            });
        });
    </script>
</body>
</html>