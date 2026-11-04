<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ env('APP_NAME', 'IT Department') }} - Yuletide Edition 🎄</title>
    
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
        /* Custom Yuletide themed scrollbar */
        html {
            scrollbar-width: thin;
            scrollbar-color: #dc2626 #071126;
        }
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #071126;
        }
        ::-webkit-scrollbar-thumb {
            background: #dc2626;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #ef4444;
        }

        /* Subtle Yuletide glowing animation */
        @keyframes yuletide-glow {
            0%, 100% {
                box-shadow: 0 0 15px rgba(220, 38, 38, 0.5), 0 0 30px rgba(251, 191, 36, 0.25);
            }
            50% {
                box-shadow: 0 0 25px rgba(239, 68, 68, 0.8), 0 0 45px rgba(251, 191, 36, 0.45);
            }
        }
        .animate-yuletide-glow {
            animation: yuletide-glow 3s ease-in-out infinite;
        }

        /* Twinkling Christmas string lights for the navbar */
        @keyframes twinkle-a {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.45; transform: scale(0.85); }
        }
        @keyframes twinkle-b {
            0%, 100% { opacity: 0.5; transform: scale(0.85); }
            50% { opacity: 1; transform: scale(1.05); }
        }
        .light-bulb-a {
            animation: twinkle-a 2.4s ease-in-out infinite;
        }
        .light-bulb-b {
            animation: twinkle-b 2.4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#071126] text-gray-100 antialiased selection:bg-red-600 selection:text-white"> 
    {{-- Yuletide Festive Navbar --}}
    <nav class="bg-gradient-to-r from-[#07152e]/95 via-[#3b0a14]/90 to-[#06241c]/95 backdrop-blur-md border-b-2 border-amber-400/40 px-4 py-3 shadow-[0_8px_30px_rgba(0,0,0,0.6)] top-0 z-50 min-w-full fixed transition-all duration-300">
        {{-- Festive Candy-Cane / Gold Shimmer Top Accent Bar --}}
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-600 via-amber-400 to-emerald-500 opacity-90"></div>

        <div class="flex items-center justify-between container mx-auto w-full max-w-7xl">
            {{-- Logo / Brand Name + Holiday Badge --}}
            <a href="#home-section" class="flex items-center gap-3 group py-0.5">
                <div class="relative flex items-center">
                    <img src="{{ asset('images/bcda-digitalhub-clean.png') }}"
                         alt="Digitalhub Logo"
                         class="h-6 sm:h-8 md:h-10 w-auto filter brightness-0 invert drop-shadow-[0_0_12px_rgba(251,191,36,0.5)] transition-transform duration-300 group-hover:scale-105">
                </div>
                <span class="hidden sm:inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold tracking-wide bg-gradient-to-r from-red-600/30 to-emerald-600/30 text-amber-300 border border-amber-400/40 shadow-[0_0_12px_rgba(251,191,36,0.2)]">
                    <i class="fa-solid fa-snowflake text-[11px] text-sky-300 animate-spin" style="animation-duration: 10s;"></i>
                    <span>Yuletide</span>
                </span>
            </a>
            
            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-1.5 lg:space-x-3 items-center">
                <a href="#home-section" class="inline-flex items-center gap-1.5 bg-gradient-to-r from-red-600/85 to-red-700/85 text-amber-200 border border-amber-400/50 font-semibold px-3.5 py-1.5 rounded-full text-sm shadow-md shadow-red-900/40 transition-all hover:from-red-500 hover:to-red-600 hover:text-white">
                    <i class="fa-solid fa-tree text-xs text-emerald-300"></i>
                    <span>Home</span>
                </a>
                <a href="#about" class="text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-1.5 rounded-full text-sm font-medium transition-all">About</a>
                <a href="#projects" class="text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-1.5 rounded-full text-sm font-medium transition-all">Project</a>
                <a href="#contact" class="text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-1.5 rounded-full text-sm font-medium transition-all">Report</a>
                
                @auth
                    <a href="{{ route('attendance.dashboard') }}" class="text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-1.5 rounded-full text-sm font-medium transition-all">Attendance</a>
                    <span class="inline-flex items-center gap-1.5 text-amber-200 bg-white/5 border border-amber-400/25 px-3 py-1 rounded-full text-sm font-semibold tracking-wide">
                        <i class="fa-solid fa-gifts text-xs text-red-400"></i>
                        {{ auth()->user()->name }}
                    </span>
                    @if (auth()->user()->authAssignments->whereIn('item_name', ['Administrator', 'IT_User'])->isNotEmpty())
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-md shadow-emerald-900/50 border border-amber-300/50 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-star text-amber-300 text-xs mr-1"></i>SolveIT
                        </a>
                    @endif
                @endauth
            </div>

            {{-- Mobile Menu Button (Hamburger) --}}
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" aria-label="Toggle navigation menu" class="text-amber-200 hover:text-white bg-white/5 hover:bg-red-600/30 border border-amber-400/30 focus:outline-none p-1.5 rounded-lg transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Twinkling Holiday String Lights along bottom of Navbar --}}
        <div class="pointer-events-none absolute -bottom-1.5 left-0 right-0 flex justify-around items-center px-4 overflow-hidden">
            @for ($i = 0; $i < 18; $i++)
                @php
                    $colors = [
                        'bg-red-500 shadow-[0_0_10px_#ef4444]',
                        'bg-amber-300 shadow-[0_0_10px_#fcd34d]',
                        'bg-emerald-400 shadow-[0_0_10px_#34d399]',
                        'bg-sky-300 shadow-[0_0_10px_#7dd3fc]',
                    ];
                    $colorClass = $colors[$i % 4];
                    $animClass = $i % 2 === 0 ? 'light-bulb-a' : 'light-bulb-b';
                @endphp
                <span class="w-2 h-2 rounded-full {{ $colorClass }} {{ $animClass }} {{ $i >= 8 ? 'hidden sm:inline-block' : '' }} {{ $i >= 12 ? 'hidden lg:inline-block' : '' }}"></span>
            @endfor
        </div>

        {{-- Mobile Navigation Dropdown --}}
        <div id="mobile-menu" class="hidden md:hidden bg-gradient-to-b from-[#0b1c3d]/98 to-[#2a0810]/98 border border-amber-400/30 backdrop-blur-xl px-4 pt-4 pb-6 space-y-2 mt-3 rounded-2xl shadow-2xl">
            <a href="#home-section" class="flex items-center gap-2 text-amber-300 bg-red-600/25 border border-amber-400/30 px-3.5 py-2.5 rounded-xl text-base font-semibold">
                <i class="fa-solid fa-tree text-sm text-emerald-400"></i>
                <span>Home</span>
            </a>
            <a href="#about" class="block text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-2.5 rounded-xl text-base font-medium transition-colors">About</a>
            <a href="#projects" class="block text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-2.5 rounded-xl text-base font-medium transition-colors">Project</a>
            <a href="#contact" class="block text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-2.5 rounded-xl text-base font-medium transition-colors">Report</a>
            
            @auth
                <a href="{{ route('attendance.dashboard') }}" class="block text-gray-100 hover:text-amber-300 hover:bg-white/10 px-3.5 py-2.5 rounded-xl text-base font-medium transition-colors">Attendance</a>
                <div class="pt-3 border-t border-amber-400/25 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 text-amber-200 text-sm font-semibold px-3">
                        <i class="fa-solid fa-gifts text-xs text-red-400"></i>
                        {{ auth()->user()->name }}
                    </span>
                    @if (auth()->user()->authAssignments->whereIn('item_name', ['Administrator', 'IT_User'])->isNotEmpty())
                        <a href="{{ route('dashboard') }}" class="inline-block bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-500 hover:to-emerald-600 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-md shadow-emerald-900/40 border border-amber-300/40">
                            <i class="fa-solid fa-star text-amber-300 text-xs mr-1"></i>SolveIT
                        </a>
                    @endif
                </div>
            @endauth                                  
        </div>
    </nav>

    {{-- Yuletide Master Wrapper: Covers Hero & BCDA IT Mission with yuletide.png --}}
    <div class="relative w-full bg-cover bg-center sm:bg-top bg-no-repeat overflow-hidden" 
         style="background-image: url('{{ asset('images/yuletide.png') }}'); background-size: cover; background-position: center top;">
        
        {{-- Section 1: Hero Section (Upper half of the Yuletide illustration) --}}
        <section id="home-section" class="pt-28 pb-12 sm:pt-36 sm:pb-16 lg:pt-40 lg:pb-24">
            <div class="container mx-auto max-w-7xl px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-8">
                    {{-- Left column: Welcome text & festive glowing pill button --}}
                    <div class="lg:col-span-6 xl:col-span-7 flex flex-col gap-6 text-left">
                        <h1 class="text-white text-4xl sm:text-5xl lg:text-5xl font-extrabold tracking-tight leading-tight drop-shadow-[0_4px_12px_rgba(7,17,38,0.95)]">
                            @auth
                                Welcome back, <span class="text-amber-300 drop-shadow-[0_0_18px_rgba(251,191,36,0.75)]">{{ auth()->user()->name }}!</span>
                            @else
                                The IT Solution <span class="text-amber-300 drop-shadow-[0_0_18px_rgba(251,191,36,0.75)]">Starts Here.</span>
                            @endauth
                        </h1>

                        <p class="text-white text-base sm:text-lg lg:text-xl font-medium max-w-xl leading-relaxed drop-shadow-[0_2px_10px_rgba(7,17,38,0.95)]">
                            Report problems, track requests, and get expert support from your IT Division, all in one place.
                        </p>

                        <div class="pt-2">
                            <a href="#contact" 
                               class="animate-yuletide-glow inline-flex items-center justify-center gap-3 px-8 py-3.5 rounded-full text-base font-semibold text-amber-100 bg-[#881313]/90 hover:bg-[#a31616] border-2 border-amber-400 shadow-[0_0_20px_rgba(220,38,38,0.6)] hover:shadow-[0_0_30px_rgba(251,191,36,0.85)] hover:text-white transition duration-300 transform hover:-translate-y-0.5">
                                <span>Request Support</span>
                                <i class="fa-regular fa-comments text-lg text-amber-300"></i>
                            </a>
                        </div>
                    </div>

                    {{-- Right column spacer: leaves the Santa-hat IT desk, reindeer & cabin artwork fully visible --}}
                    <div class="hidden lg:block lg:col-span-6 xl:col-span-5 min-h-[300px] xl:min-h-[360px]">
                        {{-- Open space on desktop showcasing the festive IT specialist, glowing monitor, reindeer and cabin --}}
                    </div>
                </div>
            </div>
        </section>

        {{-- Section 2: BCDA IT MISSION (Lower snowy portion between the holiday lanterns and gifts) --}}
        <section id="top" class="pt-8 pb-32 sm:pb-40 lg:pt-12 lg:pb-52 text-white text-center">
            <div class="max-w-4xl mx-auto px-6 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black tracking-wider uppercase mb-4 text-white drop-shadow-[0_4px_16px_rgba(7,17,38,0.95)]">
                    BCDA IT MISSION
                </h2>
                <p class="text-base sm:text-lg md:text-xl text-white mb-8 max-w-3xl mx-auto font-medium leading-relaxed drop-shadow-[0_3px_12px_rgba(7,17,38,0.95)]">
                    To empower BCDA by responding to its enterprise-wide IS requirements by using appropriate technologies.
                </p>
                <div>
                    <a href="#services" 
                       class="inline-block bg-white hover:bg-amber-50 text-[#071126] font-bold px-8 py-3 rounded-full border-2 border-amber-300/80 shadow-[0_0_20px_rgba(255,255,255,0.65)] hover:shadow-[0_0_25px_rgba(251,191,36,0.8)] transition duration-300 transform hover:-translate-y-0.5 text-sm sm:text-base">
                        Explore Services
                    </a>
                </div>
            </div>
        </section>
    </div>

    {{-- About Section --}}
    <section id="about" class="py-24 bg-gradient-to-b from-[#07152e] via-[#0b2239] to-[#081c24] border-t-2 border-amber-400/30 relative overflow-hidden">
        {{-- Ambient Yuletide Glows & Decorative Snowflakes --}}
        <div class="pointer-events-none absolute -top-24 -left-24 w-96 h-96 bg-red-600/15 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl"></div>
        <i class="fa-regular fa-snowflake pointer-events-none absolute top-10 left-10 text-white/5 text-7xl"></i>
        <i class="fa-regular fa-snowflake pointer-events-none absolute bottom-10 right-12 text-amber-300/5 text-8xl"></i>

        <div class="max-w-5xl mx-auto px-6 text-center relative z-10 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-red-600/30 to-emerald-600/30 border border-amber-400/50 text-amber-300 text-xs sm:text-sm font-bold tracking-wide shadow-[0_0_15px_rgba(251,191,36,0.2)] mb-5">
                <i class="fa-solid fa-snowflake text-sky-300"></i>
                <span>Empowering Innovation</span>
                <i class="fa-solid fa-holly-berry text-red-400"></i>
            </div>

            <h2 class="text-3xl sm:text-5xl font-extrabold mb-4 text-white tracking-tight">
                About the <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-amber-400 to-red-400">IT Division</span>
            </h2>

            {{-- Festive Gold & Holly Divider --}}
            <div class="flex items-center justify-center gap-3 mb-10">
                <span class="h-0.5 w-16 bg-gradient-to-r from-transparent to-amber-400/70 rounded-full"></span>
                <i class="fa-solid fa-star text-amber-300 text-sm drop-shadow-[0_0_8px_rgba(251,191,36,0.8)]"></i>
                <span class="h-0.5 w-16 bg-gradient-to-l from-transparent to-amber-400/70 rounded-full"></span>
            </div>

            <div class="relative bg-gradient-to-br from-[#0f2547]/90 via-[#290b17]/80 to-[#092922]/90 border-2 border-amber-400/35 backdrop-blur-md rounded-3xl p-8 sm:p-12 shadow-[0_20px_50px_rgba(0,0,0,0.6)] overflow-hidden">
                {{-- Top Festive Ribbon Strip --}}
                <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-red-600 via-amber-400 to-emerald-500"></div>
                <i class="fa-solid fa-sleigh pointer-events-none absolute -bottom-4 -right-4 text-amber-300/5 text-9xl"></i>

                <p class="text-gray-100 text-base sm:text-xl leading-relaxed text-justify sm:text-center font-normal relative z-10">
                    The BCDA IT Division provides strategic IT leadership, technical expertise, and operational services to ensure secure, reliable, and efficient technology systems throughout the organization. We support innovation, system modernization, and collaborative digital solutions.
                </p>

                {{-- Festive Pillars Row --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 pt-8 border-t border-amber-400/20 relative z-10">
                    <div class="flex items-center justify-center gap-2.5 bg-white/5 border border-amber-400/25 rounded-2xl py-3 px-4 text-sm font-semibold text-amber-200">
                        <i class="fa-solid fa-shield-halved text-red-400"></i>
                        <span>Secure &amp; Reliable</span>
                    </div>
                    <div class="flex items-center justify-center gap-2.5 bg-white/5 border border-amber-400/25 rounded-2xl py-3 px-4 text-sm font-semibold text-amber-200">
                        <i class="fa-solid fa-wand-magic-sparkles text-amber-300"></i>
                        <span>System Modernization</span>
                    </div>
                    <div class="flex items-center justify-center gap-2.5 bg-white/5 border border-amber-400/25 rounded-2xl py-3 px-4 text-sm font-semibold text-amber-200">
                        <i class="fa-solid fa-users-gear text-emerald-400"></i>
                        <span>Collaborative Solutions</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Services Section --}}
    <section id="services" class="py-24 bg-gradient-to-b from-[#081c24] via-[#260913] to-[#07152e] border-t border-amber-400/25 relative overflow-hidden">
        {{-- Ambient Yuletide Lights --}}
        <div class="pointer-events-none absolute top-1/3 left-1/4 w-80 h-80 bg-red-600/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-10 right-1/4 w-80 h-80 bg-amber-400/10 rounded-full blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-red-600/30 to-amber-500/25 border border-amber-400/50 text-amber-300 text-xs sm:text-sm font-bold tracking-wide shadow-[0_0_15px_rgba(220,38,38,0.25)] mb-4">
                    <i class="fa-solid fa-gift text-red-400"></i>
                    <span>What We Provide</span>
                    <i class="fa-solid fa-star text-amber-300 text-xs"></i>
                </div>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Our Core <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-amber-400 to-emerald-300">Services</span>
                </h2>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <span class="h-0.5 w-16 bg-gradient-to-r from-transparent to-amber-400/70 rounded-full"></span>
                    <i class="fa-solid fa-tree text-emerald-400 text-sm"></i>
                    <span class="h-0.5 w-16 bg-gradient-to-l from-transparent to-amber-400/70 rounded-full"></span>
                </div>
            </div>
            
            <div class="grid gap-8 md:grid-cols-3">
                @foreach([
                    [
                        'title' => 'IT Support',
                        'desc' => 'Helpdesk, troubleshooting, and technical assistance for all departments.',
                        'icon' => 'fa-solid fa-headset',
                        'badge' => 'from-red-600 to-red-800 shadow-red-600/40',
                        'ribbon' => 'from-red-500 via-amber-400 to-red-600',
                        'cardBg' => 'from-[#1a1027]/95 via-[#2e0c18]/90 to-[#0e1d38]/95',
                        'tag' => 'Rapid Assistance'
                    ],
                    [
                        'title' => 'Infrastructure',
                        'desc' => 'Managing servers, networks, and ensuring system uptime and reliability.',
                        'icon' => 'fa-solid fa-server',
                        'badge' => 'from-emerald-600 to-emerald-800 shadow-emerald-600/40',
                        'ribbon' => 'from-emerald-500 via-amber-400 to-emerald-600',
                        'cardBg' => 'from-[#0b2622]/95 via-[#0f293a]/90 to-[#0d1c38]/95',
                        'tag' => '24/7 Uptime & Security'
                    ],
                    [
                        'title' => 'Software Development',
                        'desc' => 'Custom applications, websites, and automations tailored to agency needs.',
                        'icon' => 'fa-solid fa-code',
                        'badge' => 'from-amber-500 to-red-600 shadow-amber-500/40',
                        'ribbon' => 'from-amber-400 via-red-500 to-emerald-500',
                        'cardBg' => 'from-[#122244]/95 via-[#1e193b]/90 to-[#290f1c]/95',
                        'tag' => 'Digital Innovation'
                    ]
                ] as $service)
                <div class="group relative bg-gradient-to-br {{ $service['cardBg'] }} border border-amber-400/30 hover:border-amber-300 p-8 rounded-3xl shadow-2xl shadow-black/50 hover:shadow-[0_15px_35px_rgba(220,38,38,0.25)] transition-all duration-300 transform hover:-translate-y-2 overflow-hidden flex flex-col justify-between">
                    {{-- Top Festive Ribbon --}}
                    <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r {{ $service['ribbon'] }}"></div>
                    {{-- Corner Snowflake Watermark --}}
                    <i class="fa-regular fa-snowflake pointer-events-none absolute -right-4 -top-4 text-white/5 text-7xl group-hover:text-amber-300/10 group-hover:rotate-45 transition-all duration-500"></i>

                    <div>
                        <div class="flex items-center justify-between mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br {{ $service['badge'] }} border-2 border-amber-300/60 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $service['icon'] }} text-white text-2xl"></i>
                            </div>
                            <span class="text-xs font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-white/5 border border-amber-400/30 text-amber-300">
                                {{ $service['tag'] }}
                            </span>
                        </div>
                        <h3 class="text-2xl font-bold mb-3 text-white group-hover:text-amber-300 transition-colors duration-300">{{ $service['title'] }}</h3>
                        <p class="text-gray-200 text-sm sm:text-base leading-relaxed">{{ $service['desc'] }}</p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-amber-400/15 flex items-center justify-between text-xs text-amber-300/80 font-semibold">
                        <span><i class="fa-solid fa-snowflake mr-1.5 text-sky-300"></i>BCDA IT Division</span>
                        <i class="fa-solid fa-sparkles text-amber-300"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Key Projects Section --}}
    <section id="projects" class="py-24 bg-gradient-to-b from-[#07152e] via-[#072327] to-[#0b1733] border-t border-amber-400/25 relative overflow-hidden">
        {{-- Ambient Holiday Glows --}}
        <div class="pointer-events-none absolute top-20 right-10 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-20 left-10 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>

        <div class="max-w-6xl mx-auto px-6 relative z-10 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-emerald-600/30 to-red-600/30 border border-amber-400/50 text-amber-300 text-xs sm:text-sm font-bold tracking-wide shadow-[0_0_15px_rgba(16,185,129,0.2)] mb-4">
                    <i class="fa-solid fa-sleigh text-amber-300"></i>
                    <span>Digital Systems</span>
                    <i class="fa-solid fa-tree text-emerald-400"></i>
                </div>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Key <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-amber-400 to-red-400">Projects</span>
                </h2>
                <div class="flex items-center justify-center gap-3 mt-4">
                    <span class="h-0.5 w-16 bg-gradient-to-r from-transparent to-amber-400/70 rounded-full"></span>
                    <i class="fa-solid fa-gift text-red-400 text-sm"></i>
                    <span class="h-0.5 w-16 bg-gradient-to-l from-transparent to-amber-400/70 rounded-full"></span>
                </div>
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
                ] as $index => $project)
                @php
                    $isEven = $index % 2 === 0;
                    $iconGradient = $isEven
                        ? 'from-red-600 to-red-800 border-amber-300/60 text-amber-200 shadow-red-900/40'
                        : 'from-emerald-600 to-emerald-800 border-amber-300/60 text-amber-200 shadow-emerald-900/40';
                @endphp
                <a href="{{ $project['url'] }}" target="_blank" rel="noopener noreferrer" 
                   class="group relative bg-gradient-to-br from-[#0e2245]/95 via-[#151b38]/95 to-[#1f0d1d]/90 border border-amber-400/25 hover:border-amber-300 p-6 rounded-2xl shadow-xl shadow-black/40 hover:shadow-[0_12px_30px_rgba(251,191,36,0.2)] transition-all duration-300 transform hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    {{-- Top Festive Trim --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-500 via-amber-400 to-emerald-500 opacity-80 group-hover:opacity-100"></div>
                    <i class="fa-regular fa-snowflake pointer-events-none absolute -bottom-3 -right-3 text-white/5 text-6xl group-hover:text-amber-300/10 transition-colors"></i>

                    <div>
                        <div class="flex items-center justify-between mb-5">
                            <span class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $iconGradient }} border flex items-center justify-center text-lg shadow-md group-hover:scale-110 transition-transform duration-300">
                                <i class="{{ $project['icon'] }}"></i>
                            </span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-amber-300/80 group-hover:text-amber-200 bg-white/5 px-3 py-1 rounded-full border border-amber-400/20 group-hover:border-amber-300/50 transition-colors">
                                <span>Open</span>
                                <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-white group-hover:text-amber-300 mb-2.5 transition-colors duration-300">{{ $project['title'] }}</h3>
                        <p class="text-gray-200/90 text-sm leading-relaxed">{{ $project['desc'] }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Contact / Support Topics Section --}}
    <section id="contact" class="py-24 bg-gradient-to-b from-[#0b1733] via-[#2c0914] to-[#061224] border-t-2 border-amber-400/30 relative overflow-hidden">
        {{-- Festive Ambient Glows --}}
        <div class="pointer-events-none absolute top-16 left-1/3 w-96 h-96 bg-red-600/15 rounded-full blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-16 right-1/4 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl"></div>
        <i class="fa-regular fa-snowflake pointer-events-none absolute top-12 right-12 text-white/5 text-8xl"></i>

        <div class="max-w-6xl mx-auto px-6 relative z-10 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <div class="mb-16 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gradient-to-r from-red-600/35 to-amber-500/25 border border-amber-400/50 text-amber-300 text-xs sm:text-sm font-bold tracking-wide shadow-[0_0_15px_rgba(220,38,38,0.3)] mb-4">
                    <i class="fa-solid fa-headset text-amber-300"></i>
                    <span>IT Helpdesk &amp; Holiday Support</span>
                    <i class="fa-solid fa-snowflake text-sky-300"></i>
                </div>
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white mb-4 tracking-tight">
                    How can we <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-200 via-amber-400 to-red-400">help you today?</span>
                </h2>
                <h3 class="text-base sm:text-lg text-gray-200 font-normal max-w-2xl mx-auto">
                    Pick one from the topics below and we’ll find the best solution for you.
                </h3>
                <div class="flex items-center justify-center gap-3 mt-5">
                    <span class="h-0.5 w-16 bg-gradient-to-r from-transparent to-amber-400/70 rounded-full"></span>
                    <i class="fa-solid fa-bell text-amber-300 text-sm"></i>
                    <span class="h-0.5 w-16 bg-gradient-to-l from-transparent to-amber-400/70 rounded-full"></span>
                </div>
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
                ] as $index => $project)
                @php
                    $badgePalette = match($index % 3) {
                        0 => 'from-red-600 to-red-800 shadow-red-600/35',
                        1 => 'from-emerald-600 to-emerald-800 shadow-emerald-600/35',
                        default => 'from-amber-500 to-red-600 shadow-amber-500/35',
                    };
                @endphp
                {{-- Use data attributes for modal functionality --}}
                <a href="#"
                   @guest onclick="event.preventDefault(); window.location.href='{{ route('google.login') }}';" @endguest
                   @auth data-modal-target="crud-modal" data-modal-toggle="crud-modal" @endauth
                   data-project-title="{{ $project['title'] }}"
                   data-project-button="{{ $project['button'] }}"
                   data-project-main="{{ $project['main'] }}"
                   class="group relative bg-gradient-to-br from-[#0f2244]/95 via-[#181734]/95 to-[#240b16]/90 p-6 rounded-2xl shadow-xl shadow-black/50 hover:shadow-[0_14px_32px_rgba(220,38,38,0.28)] transition-all duration-300 border border-amber-400/25 hover:border-amber-300 hover:-translate-y-1.5 flex flex-col justify-between overflow-hidden">
                    {{-- Festive Top Strip --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-red-600 via-amber-400 to-emerald-500 opacity-75 group-hover:opacity-100"></div>

                    <div class="flex items-start space-x-4 mb-5">
                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br {{ $badgePalette }} border border-amber-300/60 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                            <i class="{{ $project['icon'] }} text-white text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-white group-hover:text-amber-300 transition-colors duration-300 mb-1.5">
                                {{ $project['title'] }}
                            </h3>
                            <p class="text-sm text-gray-200/90 leading-relaxed">
                                {{ $project['desc'] }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-amber-400/15">
                        <span class="text-xs text-amber-200/60 font-medium">
                            <i class="fa-solid fa-snowflake text-[10px] text-sky-300 mr-1"></i>IT Support
                        </span>
                        <span class="inline-flex items-center text-amber-300 group-hover:text-white bg-white/5 group-hover:bg-gradient-to-r group-hover:from-red-600 group-hover:to-amber-600 px-3.5 py-1.5 rounded-full font-semibold text-xs border border-amber-400/30 transition-all duration-300">
                            <span>{{ $project['button'] }}</span>
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-300"></i>
                        </span>
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
            <div class="relative bg-[#0d1e40] border border-amber-400/40 rounded-2xl shadow-2xl shadow-black">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b border-amber-400/20 rounded-t">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-headset text-amber-400"></i>
                        <span id="modal-project-title" class="text-amber-300 font-bold"></span>
                    </h3>
                    <button type="button" class="text-gray-400 hover:text-white bg-transparent hover:bg-red-500/20 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center transition-colors" data-modal-toggle="crud-modal">
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
                                   class="bg-[#071126] border border-amber-400/30 text-white text-sm rounded-xl focus:ring-amber-400 focus:border-amber-400 block w-full p-3 transition" 
                                   placeholder="Enter your email address" 
                                   value="{{ auth()->check() ? auth()->user()->email : '' }}" required>
                        </div>
                        <input type="text" name="main" id='modal-project-main' class="hidden">

                        <button type="submit" id="modal-action-button" 
                                class="w-full bg-gradient-to-r from-red-600 to-amber-500 hover:from-red-700 hover:to-amber-600 text-white px-6 py-3 rounded-full font-bold shadow-lg shadow-red-600/30 hover:shadow-red-600/50 transition-all duration-300">
                            <span id="modal-project-button" class="text-white font-bold">Submit</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    {{-- Yuletide Festive Footer --}}
    <footer class="bg-[#040a17] border-t border-amber-400/20 text-gray-400 py-10 relative">
        <div class="max-w-6xl mx-auto px-6 text-center space-y-2">
            <p class="text-sm font-medium">&copy; {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
            <p class="text-xs text-amber-300/85">Developed by ICTD-ITD {{ date('Y') }} 🎄 Happy Holidays &amp; Merry Christmas</p>
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
