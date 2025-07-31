<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    {{-- <link rel="icon" href="{{ asset('favicon.ico') }}">
     --}}
     <link rel="icon" type="image/png" href="{{ asset('images/SolveIT-removebg-preview.png') }}">

     
</head>
<body class="bg-gray-300 dark:bg-slate-950">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Header -->
    <header class="bg-gradient-to-l from-teal-900 to-teal-950 shadow-lg">
        
        @auth
        <nav class="flex items-center justify-between px-2 py-2 max-h-20 mr-5 ml-5 max-w-full">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center text-white text-xl font-bold p-0">
                <img src="{{ asset('images/logo.png') }}" alt="SolveIT Logo" class="w-28">
            </a>
            <!-- Navigation Links -->
            @auth
            <div class="hidden md:flex space-x-4">
                
                <a href="{{ route('dashboard') }}" class="text-white hover:text-yellow-300">Dashboard</a>
                <a href="{{ route('report.index') }}" class="text-white hover:text-yellow-300">Report</a>
                <a href="{{ route('issues.index') }}" class="text-white hover:text-yellow-300">Issues</a>
                <a href="{{ route('category.index') }}" class="text-white hover:text-yellow-300">Category </a>
                <a href="{{ route('department.index') }}" class="text-white hover:text-yellow-300">Department</a>
                <a href="{{ route('profile') }}" class="text-white hover:text-yellow-300">Profile</a>
                <form action="{{ route('logout') }}" method="post" class="inline">
                    @csrf
                    <button class="text-white hover:text-yellow-300">Logout</button>
                </form>
                <a href="#" class="theme-toggle text-white rounded">
                    <!-- Sun Icon (Light Mode) -->
                    <i class="sun-icon fa-solid fa-sun text-xl"></i>
                    <!-- Moon Icon (Dark Mode) -->
                    <i class="moon-icon fa-solid fa-moon text-xl hidden"></i>
                  </a>
            </div>

            <!-- Mobile Menu -->
            <div x-data="{ open: false }" class="md:hidden m-nav">
                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="text-white focus:outline-none btn-nav">
                    <span class="material-icons">menu</span>
                </button>
            
                <!-- Mobile Menu Links -->
                <div x-show="open" x-cloak 
                     class="absolute bg-teal-900 text-white p-4"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95">
                    <a href="{{ route('dashboard') }}" class="block py-2 hover:text-yellow-300">Dashboard</a>
                    <a href="{{ route('report.index') }}" class="block py-2 hover:text-yellow-300">Report</a>
                    <a href="{{ route('issues.index') }}" class="block py-2 hover:text-yellow-300">Issues</a>
                    <a href="{{ route('category.index') }}" class="block py-2 hover:text-yellow-300">Category</a>
                    <a href="{{ route('department.index') }}" class="block py-2 hover:text-yellow-300">Department</a>
                    <form action="{{ route('logout') }}" method="post" class="block py-2">
                        @csrf
                        <button class="hover:text-yellow-300">Logout</button>
                    </form>
                    <a href="#" class="theme-toggle text-white rounded">
                        <!-- Sun Icon (Light Mode) -->
                        <i class="sun-icon fa-solid fa-sun text-xl"></i>
                        <!-- Moon Icon (Dark Mode) -->
                        <i class="moon-icon fa-solid fa-moon text-xl hidden"></i>
                      </a>
                    
                </div>
            </div>
            @endauth
            
        </nav>
        @endauth
    </header>


    <!-- Main Content -->
    <main class="mx-auto">
        {{ $slot }}
    </main>

    <script>
        var run = false;
        $('.btn-nav').click(function(){
            
            if (run == false) {
                $('.m-nav').animate({ marginRight: '20%' }, 300);
                run = true;
            }
            else{
                $('.m-nav').animate({ marginRight: '0%' }, 300);
                run = false;
            }
            
        });

    // Select all theme toggle elements
    const themeToggles = document.querySelectorAll('.theme-toggle');
  // Select all sun and moon icons
  const sunIcons = document.querySelectorAll('.sun-icon');
  const moonIcons = document.querySelectorAll('.moon-icon');

  // Function to update icons based on current theme
  function updateThemeIcons() {
    if (document.documentElement.classList.contains('dark')) {
      sunIcons.forEach(icon => icon.classList.add('hidden'));
      moonIcons.forEach(icon => icon.classList.remove('hidden'));
    } else {
      sunIcons.forEach(icon => icon.classList.remove('hidden'));
      moonIcons.forEach(icon => icon.classList.add('hidden'));
    }
  }

  // Add event listeners to all theme toggles
  themeToggles.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
      e.preventDefault();
      // Toggle dark mode on the root element
      document.documentElement.classList.toggle('dark');
      // Save preference to localStorage
      localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
      // Update icons
      updateThemeIcons();
    });

    
  });

  // On page load, check localStorage for theme preference
  if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark');
  }
  updateThemeIcons();
  
    </script>

</body>
</html>
