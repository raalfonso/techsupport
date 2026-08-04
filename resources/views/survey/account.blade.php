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
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>

{{-- Added pt-16 to the body to account for the fixed navbar height --}}
<body> 


  <style>
  * {
    font-family:
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        Roboto,
        Helvetica,
        Arial,
        "Apple Color Emoji",
        "Segoe UI Emoji",
        "Segoe UI Symbol",
        sans-serif;
}

.highcharts-figure,
.highcharts-data-table table {
    min-width: 310px;
    max-width: 800px;
    margin: 1em auto;
}

#container {
    height: 400px;
}

.highcharts-data-table table {
    font-family: Verdana, sans-serif;
    border-collapse: collapse;
    border: 1px solid var(--highcharts-neutral-color-10, #e6e6e6);
    margin: 10px auto;
    text-align: center;
    width: 100%;
    max-width: 500px;
}

.highcharts-data-table caption {
    padding: 1em 0;
    font-size: 1.2em;
    color: var(--highcharts-neutral-color-60, #666);
}

.highcharts-data-table th {
    font-weight: 600;
    padding: 0.5em;
}

.highcharts-data-table td,
.highcharts-data-table th,
.highcharts-data-table caption {
    padding: 0.5em;
}

.highcharts-data-table thead tr,
.highcharts-data-table tbody tr:nth-child(even) {
    background: var(--highcharts-neutral-color-3, #f7f7f7);
}

.highcharts-description {
    margin: 0.3rem 10px;
}

  </style>

    {{-- Include Tailwind CSS --}}
    {{-- Main Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 w-full bg-white shadow-md">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            {{-- Logo or Brand Name --}}
            <div class="flex items-center text-lg font-bold text-gray-800">
                <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="mr-2 h-10 w-auto rounded">
                BCDA IT DIVISION
            </div>

            {{-- Desktop Navigation --}}
            <div class="hidden items-center space-x-4 md:flex">
                <a href="{{ route('survey.dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    <i class="material-icons align-middle">dashboard</i>
                    Dashboard
                </a>

                <a href="{{ route('survey.generateSurvey') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                    <i class="material-icons align-middle">qr_code</i>
                    QR Generator
                </a>

                @if (auth()->user()->role === 'superadmin')
                    <a href="{{ route('survey.management') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                        <i class="material-icons align-middle">settings</i>
                        User Management
                    </a>
                @endif

                {{-- User dropdown --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                        {{ auth()->user()->name }}
                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-50 mt-2 w-48 rounded-md border border-gray-200 bg-white shadow-lg">
                        <a href="{{ route('survey.account') }}" class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                            <i class="material-icons mr-2 text-gray-500">lock</i> Account
                        </a>
                        <form method="POST" action="{{ route('userSurvey.logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                <i class="material-icons mr-2 text-gray-500">logout</i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <button id="mobile-menu-button" class="rounded-lg border border-slate-200 bg-white p-2 text-slate-700 shadow-sm focus:outline-none md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white md:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('survey.dashboard') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"><i class="material-icons align-middle">dashboard</i> Dashboard</a>
                <a href="{{ route('survey.generateSurvey') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"><i class="material-icons align-middle">qr_code</i> QR Generator</a>
                @if (auth()->user()->role === 'superadmin')
                    <a href="{{ route('survey.management') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"><i class="material-icons align-middle">settings</i> User Management</a>
                @endif
                <a href="{{ route('survey.account') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100"><i class="material-icons align-middle">lock</i> Account</a>
                <form method="POST" action="{{ route('userSurvey.logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100"><i class="material-icons align-middle">logout</i> Logout</button>
                </form>
            </div>
        </div>
    </nav>

        {{-- Flash Message for Success --}}
       

    {{-- Account Section --}}
    <section id="user" class="pb-5 mt-5 mb-10" style="background-color: #e6edfc">
    <div class="container mx-auto px-6 py-16 text-center bg-white rounded-lg shadow-md">
        {{-- Section Title and Description --}}
         @if (session('success'))
            <div class="flex items-center justify-between mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 text-sm">
                <span>{{ session('success') }}</span>
                <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                    &times;
                </button>   
            </div>
        @endif
        <h1 class="text-4xl font-bold text-gray-800 mb-4">My Profile </h1>
        <p class="text-lg text-gray-600 mb-8">Account Details</p>

        {{-- User Information --}}
        {{-- <img src="{{ asset('img/close-up-white-cat-with-blue-eyes-121224.jpg') }}" alt="User Avatar" class="w-32 h-32 mx-auto mb-4 rounded-full border-4 border-blue-500">
        <button class="bg-blue btn mx-auto max-w-40"><i class="material-icons align-middle">upload</i> Change Image</button>
        <br> --}}

        <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ auth()->user()->name }}</h2>
        <p class="text-gray-600 mb-4"><strong>Email:</strong> {{ auth()->user()->email }}</p>
        <p class="text-gray-600 mb-4"><strong>Department:</strong> {{ auth()->user()->department->title ?? 'N/A' }}</p>
        <p class="text-gray-600 mb-4"><strong>Role:</strong> {{ ucfirst(auth()->user()->role) }}</p>
        {{-- <p class="text-gray-600 mb-4"><strong>Account Created:</strong> {{ auth()->user()->created_at->format('F j, Y, g:i a') }}</p> --}}

        {{-- Reset Password --}}
        <div class="mt-6 bg-gray-200 bordered p-6 rounded-lg shadow-md inline-block min-w-full max-w-md text-left">
            {{-- Password Reset Form --}}
            <form action="{{ route('survey.changePassword') }}" method="POST" class="space-y-4">
                @csrf
             
                
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Change Password</h3>
                
                <div>
                    <label for="current_password" class="block text-gray-700 mb-2">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" required>
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="new_password" class="block text-gray-700 mb-2">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" required>
                    @error('new_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="new_password_confirmation" class="block text-gray-700 mb-2">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="w-full p-2 border border-gray-300 rounded-md focus:ring focus:ring-blue-300" required>
                </div>
                
                <button type="submit" class="w-full px-4 py-2 bg-gradient-to-r from-slate-800 to-blue-950 text-white font-semibold rounded-md hover:from-blue-700 hover:to-blue-900 transition duration-200">
                    <i class="material-icons align-middle">lock</i> Update Password
                </button>   
            


        

    </div>


    </section>  

    
       

{{--     
    <footer class="bg-blue-800 text-white py-8">
      <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">
          <a href="#home-section" class="hover:underline">Home</a>
          <a href="#about" class="hover:underline">About</a>
          <a href="#services" class="hover:underline">Services</a>
          <a href="#projects" class="hover:underline">Projects</a>
          <a href="#contact" class="hover:underline">Report</a>
        </div>
      </div>
    </footer> --}}

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
            } else {
                menu.classList.add('hidden');
            }
        });
</script>


</body>
</html>