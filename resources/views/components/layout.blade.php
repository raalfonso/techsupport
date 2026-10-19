<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME', 'SolveIT') }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* Slim elegant scrollbar for sidebar nav */
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(156, 163, 175, 0.4);
            border-radius: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(156, 163, 175, 0.7);
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-slate-950 text-gray-900 dark:text-gray-100 h-full overflow-hidden antialiased">
 
    @auth
    <div x-data="{ 
        // Desktop collapsed state (persisted in localStorage)
        sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || localStorage.getItem('sidebarOpen') === null,
        // Mobile off-canvas drawer open state
        mobileMenuOpen: false,
        
        toggleDesktop() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', this.sidebarOpen);
        },
        toggleMobile() {
            this.mobileMenuOpen = !this.mobileMenuOpen;
        },
        closeMobile() {
            this.mobileMenuOpen = false;
        }
    }" 
    @keydown.window.escape="closeMobile()"
    class="flex h-screen overflow-hidden bg-gray-100 dark:bg-slate-950 relative">

        <!-- Mobile Drawer Backdrop Overlay -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="closeMobile()" 
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
             x-cloak>
        </div>

        <!-- Sidebar Container (Responsive: Off-canvas on Mobile, Collapsible in flow on Desktop) -->
        <aside :class="{
                'translate-x-0 shadow-2xl': mobileMenuOpen,
                '-translate-x-full lg:translate-x-0': !mobileMenuOpen,
                'lg:w-64': sidebarOpen,
                'lg:w-20': !sidebarOpen
               }" 
               class="fixed lg:static inset-y-0 left-0 z-50 w-72 max-w-[85vw] shrink-0 overflow-hidden bg-white dark:bg-slate-900 border-r border-gray-200 dark:border-slate-800 shadow-xl lg:shadow-none transition-all duration-300 ease-in-out flex flex-col h-full select-none">
            
            <!-- Sidebar Header / Logo -->
            <div class="h-16 flex items-center border-b border-gray-200 dark:border-slate-800 shrink-0 transition-all duration-300"
                 :class="!sidebarOpen ? 'lg:justify-center px-3' : 'justify-between px-4'">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center overflow-hidden group"
                   :class="sidebarOpen || mobileMenuOpen ? 'space-x-3' : ''">
                    <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-8 w-auto object-contain rounded shrink-0 transition-transform group-hover:scale-105">
                    <div x-show="sidebarOpen || mobileMenuOpen" class="flex flex-col truncate">
                        <span class="text-lg font-bold text-gray-900 dark:text-white tracking-tight">SolveIT</span>
                        <span class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold">IT Helpdesk</span>
                    </div>
                </a>

                <!-- Mobile Close (X) Button -->
                <button @click="closeMobile()" 
                        class="lg:hidden p-1.5 rounded-lg text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none transition-colors"
                        aria-label="Close mobile menu">
                    <i class="material-icons text-xl">close</i>
                </button>
            </div>

            <!-- Sidebar Navigation Links (div role="navigation" to bypass global app.css nav { flex justify-between } collision) -->
            <div role="navigation" aria-label="Sidebar Navigation" class="flex-1 overflow-y-auto overflow-x-hidden px-3 py-3 flex flex-col space-y-1 sidebar-scroll min-h-0 w-full">
                @php
                    $navItems = [
                        ['route' => 'dashboard', 'active' => 'dashboard*', 'icon' => 'dashboard', 'label' => 'Dashboard'],
                        ['route' => 'report.index', 'active' => 'report*', 'icon' => 'article', 'label' => 'Report'],
                        ['route' => 'issues.index', 'active' => 'issues*', 'icon' => 'report', 'label' => 'Issues'],
                        ['route' => 'category.index', 'active' => 'category*', 'icon' => 'category', 'label' => 'Category'],
                        ['route' => 'department.index', 'active' => 'department*', 'icon' => 'account_tree', 'label' => 'Department'],
                        ['route' => 'devwatch.index', 'active' => 'devwatch*', 'icon' => 'code', 'label' => 'DevWatch'],
                        ['route' => 'main.index', 'active' => 'main*', 'icon' => 'description', 'label' => 'Main CMS'],
                        ['route' => 'attendance-logs.index', 'active' => 'attendance*', 'icon' => 'schedule', 'label' => 'Attendance'],
                        ['route' => 'employee-masterlist.index', 'active' => 'employee-masterlist*', 'icon' => 'group', 'label' => 'Master list'],
                        ['route' => 'signatory.index', 'active' => 'signatory*', 'icon' => 'draw', 'label' => 'Signatories'],
                        ['route' => 'users.index', 'active' => 'users*', 'icon' => 'settings', 'label' => 'User Management'],
                        ['route' => 'profile', 'active' => 'profile*', 'icon' => 'account_circle', 'label' => 'Profile'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    @php
                        $isActive = request()->routeIs($item['active']);
                    @endphp
                    <a href="{{ route($item['route']) }}" 
                       @click="if (window.innerWidth < 1024) closeMobile()"
                       class="w-full flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 relative group shrink-0 {{ $isActive ? 'bg-blue-600 text-white font-semibold shadow-sm shadow-blue-500/30' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400 font-medium' }}"
                       :class="!sidebarOpen ? 'lg:justify-center lg:px-0' : 'space-x-3'"
                       title="{{ $item['label'] }}">
                        <i class="material-icons text-xl shrink-0 {{ $isActive ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}">{{ $item['icon'] }}</i>
                        <span x-show="sidebarOpen || mobileMenuOpen" class="text-sm truncate" :class="sidebarOpen || mobileMenuOpen ? 'ml-3' : ''">{{ $item['label'] }}</span>

                        <!-- Collapsed Desktop Tooltip -->
                        <div x-show="!sidebarOpen" 
                             class="hidden lg:block absolute left-full ml-3 px-2.5 py-1.5 bg-gray-900 text-white text-xs font-medium rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 pointer-events-none">
                            {{ $item['label'] }}
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Sidebar Footer: User Info & Logout -->
            <div class="p-3 border-t border-gray-200 dark:border-slate-800 space-y-2 bg-gray-50/50 dark:bg-slate-900/50 shrink-0">
                <!-- User Profile Summary (Expanded) -->
                <div x-show="sidebarOpen || mobileMenuOpen" class="flex items-center space-x-3 px-2 py-1.5 rounded-lg">
                    <div class="w-9 h-9 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm shrink-0">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->role ?? 'Staff' }}</p>
                    </div>
                </div>

                <!-- User Avatar (Collapsed Desktop) -->
                <div x-show="!sidebarOpen" class="hidden lg:flex justify-center py-1">
                    <div class="w-9 h-9 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm shrink-0 cursor-default"
                         title="{{ auth()->user()->name }} ({{ auth()->user()->role ?? 'Staff' }})">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
                
                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" 
                            class="flex items-center text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 px-3 py-2 rounded-xl transition-all duration-200 w-full relative group font-medium text-sm"
                            :class="!sidebarOpen ? 'lg:justify-center lg:px-0' : 'space-x-3'">
                        <i class="material-icons text-xl shrink-0">logout</i>
                        <span x-show="sidebarOpen || mobileMenuOpen" class="truncate ml-3">Logout</span>
                        <div x-show="!sidebarOpen" 
                             class="hidden lg:block absolute left-full ml-3 px-2.5 py-1.5 bg-gray-900 text-white text-xs font-medium rounded-lg shadow-xl opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50 pointer-events-none">
                            Logout
                        </div>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white dark:bg-slate-900 shadow-sm border-b border-gray-200 dark:border-slate-800 px-4 sm:px-6 h-16 shrink-0 z-10">
                <div class="flex items-center justify-between h-full">
                    <!-- Left: Mobile Hamburger & Desktop Toggle & Title -->
                    <div class="flex items-center space-x-3 min-w-0">
                        <!-- Mobile Hamburger Button -->
                        <button @click="toggleMobile()" 
                                class="lg:hidden p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/40 transition-colors" 
                                aria-label="Open navigation menu">
                            <i class="material-icons text-2xl">menu</i>
                        </button>

                        <!-- Desktop Sidebar Toggle Button -->
                        <button @click="toggleDesktop()" 
                                class="hidden lg:flex p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/40 transition-colors" 
                                title="Toggle sidebar">
                            <i class="material-icons text-2xl" x-text="sidebarOpen ? 'menu_open' : 'menu'"></i>
                        </button>

                        <!-- App Title -->
                        <h1 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 dark:text-white truncate">
                            {{ env('APP_NAME', 'SolveIT') }}
                        </h1>  
                    </div>

                    <!-- Right Controls -->
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <!-- Portal / Home Link -->
                        <a href="{{ route('home') }}" 
                           class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 px-3 py-1.5 rounded-lg transition-colors">
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            <span>Public Portal</span>
                        </a>

                        <!-- Theme Toggle Button -->
                        <button class="theme-toggle p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors focus:outline-none" 
                                aria-label="Toggle dark mode"
                                title="Toggle Theme">
                            <i class="sun-icon fa-solid fa-sun text-base text-amber-500"></i>
                            <i class="moon-icon fa-solid fa-moon text-base text-blue-400 hidden"></i>
                        </button>

                        <!-- User Avatar (Small) -->
                        <div class="flex items-center pl-1 sm:pl-2">
                            <div class="w-8 h-8 rounded-full bg-blue-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Container (Responsive padding & smooth scroll) -->
            <main class="flex-1 p-3 sm:p-5 md:p-6 lg:p-8 overflow-y-auto overflow-x-hidden focus:outline-none">
                {{ $slot }}
            </main>
        </div>
    </div>
    @else
    <!-- Guest Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>
    @endauth

    <script>
        // Theme toggle functionality
        const themeToggles = document.querySelectorAll('.theme-toggle');
        const sunIcons = document.querySelectorAll('.sun-icon');
        const moonIcons = document.querySelectorAll('.moon-icon');

        function updateThemeIcons() {
            if (document.documentElement.classList.contains('dark')) {
                sunIcons.forEach(icon => icon.classList.add('hidden'));
                moonIcons.forEach(icon => icon.classList.remove('hidden'));
            } else {
                sunIcons.forEach(icon => icon.classList.remove('hidden'));
                moonIcons.forEach(icon => icon.classList.add('hidden'));
            }
        }

        themeToggles.forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.preventDefault();
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
                updateThemeIcons();
            });
        });

        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
        updateThemeIcons();
    </script>
</body>
</html>
