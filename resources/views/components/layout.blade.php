<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-gray-100 dark:bg-slate-950 overflow-hidden">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
 
    @auth
    <div class="flex h-screen">
        <!-- Left Sidebar -->
        <div x-data="{ 
            sidebarOpen: localStorage.getItem('sidebarOpen') === 'true' || localStorage.getItem('sidebarOpen') === null,
            toggle() {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
            }
        }" class="flex">
            <!-- Sidebar -->
            <div :class="sidebarOpen ? 'w-64' : 'w-16'" class="bg-white dark:bg-slate-800 shadow-lg transition-all duration-300 flex flex-col">
                <!-- Logo Section -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-8 w-12 rounded">
                        <div x-show="sidebarOpen" class="flex flex-col">
                            <span class="text-lg font-bold text-gray-800 dark:text-white">SolveIT</span>
                            
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="px-3 pt-1">
                    <div class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">dashboard</i>
                            <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Dashboard
                            </div>
                        </a>
                        <a href="{{ route('report.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">article</i>
                            <span x-show="sidebarOpen" class="font-medium">Report</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Report
                            </div>
                        </a>
                        <a href="{{ route('issues.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">report</i>
                            <span x-show="sidebarOpen" class="font-medium">Issues</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Issues
                            </div>
                        </a>
                        <a href="{{ route('category.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">category</i>
                            <span x-show="sidebarOpen" class="font-medium">Category</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Category
                            </div>
                        </a>
                        <a href="{{ route('department.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">account_tree</i>
                            <span x-show="sidebarOpen" class="font-medium">Department</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Department
                            </div>
                        </a>
                        <a href="{{ route('devwatch.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">code</i>
                            <span x-show="sidebarOpen" class="font-medium">DevWatch</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                DevWatch
                            </div>
                        </a>
                        <a href="{{ route('main.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">description</i>
                            <span x-show="sidebarOpen" class="font-medium">Main CMS</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Main CMS
                            </div>
                        </a>
                        <a href="{{ route('attendance-logs.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">schedule</i>
                            <span x-show="sidebarOpen" class="font-medium">Attendance</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Attendance
                            </div>
                        </a>
                        <a href="{{ route('employee-masterlist.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">group</i>
                            <span x-show="sidebarOpen" class="font-medium">Master list</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Master List
                            </div>
                        </a>
                        <a href="{{ route('signatory.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">draw</i>
                            <span x-show="sidebarOpen" class="font-medium">Signatories</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Signatories
                            </div>
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">settings</i>
                            <span x-show="sidebarOpen" class="font-medium">User Management</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                User Management
                            </div>
                        </a>
                        <a href="{{ route('profile') }}" class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 hover:text-blue-600 px-3 py-2 rounded-lg transition-all duration-200 relative group">
                            <i class="material-icons text-xl">account_circle</i>
                            <span x-show="sidebarOpen" class="font-medium">Profile</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Profile
                            </div>
                        </a>
                    </div>
                </nav>

                <!-- Bottom Section -->
                <div class="mt-auto p-4 border-t border-gray-200 dark:border-slate-700 space-y-2">
                    <!-- User Info -->
                    <div x-show="sidebarOpen" class="flex items-center space-x-3 px-3 py-2">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    
                    <!-- Logout -->
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button class="flex items-center space-x-3 text-gray-700 dark:text-gray-300 hover:bg-red-50 dark:hover:bg-slate-700 hover:text-red-600 px-3 py-2 rounded-lg transition-all duration-200 w-full relative group">
                            <i class="material-icons text-xl">logout</i>
                            <span x-show="sidebarOpen" class="font-medium">Logout</span>
                            <div x-show="!sidebarOpen" class="absolute left-full ml-2 px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap z-50">
                                Logout
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Toggle Button -->
            <button @click="toggle()" class="absolute top-4 right-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-full p-1.5 shadow-md hover:shadow-lg transition-all duration-200 z-10">
                <i class="material-icons text-gray-600 dark:text-gray-400 text-sm" x-text="sidebarOpen ? 'chevron_left' : 'chevron_right'"></i>
            </button>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white dark:bg-slate-800 shadow-sm border-b border-gray-200 dark:border-slate-700 px-6 py-6 h-16">
                <div class="flex items-center justify-between h-full">
                       <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ env('APP_NAME') }}</h1>  
                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle -->
                        <button class="theme-toggle p-2 mr-4 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <i class="sun-icon fa-solid fa-sun text-gray-600 dark:text-gray-400"></i>
                            <i class="moon-icon fa-solid fa-moon text-gray-600 dark:text-gray-400 hidden"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-6 overflow-auto">
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
