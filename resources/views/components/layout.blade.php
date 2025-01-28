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
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    {{-- <link rel="icon" href="{{ asset('favicon.ico') }}">
     --}}
     <link rel="icon" type="image/png" href="{{ asset('images/SolveIT-removebg-preview.png') }}">
</head>
<body class="bg-slate-100 text-slate-900">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <!-- Header -->
    <header class="bg-gradient-to-l from-yellow-950 to-yellow-900 shadow-lg">
        <nav class="flex items-center justify-between px-4 py-2">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center text-white text-xl font-bold">
                <span>SolveIT</span>
            </a>

            <!-- Navigation Links -->
            @auth
            <div class="hidden md:flex space-x-4">
                <a href="{{ route('dashboard') }}" class="text-white hover:text-yellow-300">Dashboard</a>
                <a href="{{ route('report.index') }}" class="text-white hover:text-yellow-300">Report</a>
                <a href="{{ route('issues.index') }}" class="text-white hover:text-yellow-300">Issues</a>
                <a href="{{ route('category.index') }}" class="text-white hover:text-yellow-300">Category</a>
                <a href="{{ route('department.index') }}" class="text-white hover:text-yellow-300">Department</a>
                <form action="{{ route('logout') }}" method="post" class="inline">
                    @csrf
                    <button class="text-white hover:text-yellow-300">Logout</button>
                </form>
            </div>

            <!-- Mobile Menu -->
            <div x-data="{ open: false }" class="md:hidden m-nav">
                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="text-white focus:outline-none btn-nav">
                    <span class="material-icons">menu</span>
                </button>
            
                <!-- Mobile Menu Links -->
                <div x-show="open" x-cloak 
                     class="absolute mr-10 bg-yellow-900 text-white p-4"
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
                </div>
            </div>
            @endauth
        </nav>
    </header>


    <!-- Main Content -->
    <main class="py-8 px-4 mx-auto max-w-screen-lg">
        {{ $slot }}
    </main>

    <script>
        var run = false;
        $('.btn-nav').click(function(){
            
            if (run == false) {
                $('.m-nav').animate({ marginRight: '10%' }, 300);
                run = true;
            }
            else{
                $('.m-nav').animate({ marginRight: '0%' }, 300);
                run = false;
            }
            
        });
    </script>

</body>
</html>
