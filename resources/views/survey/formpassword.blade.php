<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>BCDA Survey Hub</title>
    
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
<body>
    @if (session('success'))
        <div class="flex items-center justify-between mb-4 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800 text-sm">
            <span>{{ session('success') }}</span>
            <button type="button" class="text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                &times;
            </button>
        </div>
    @endif
    <div class="min-h-screen flex bg-white items-center justify-center p-6">

        <div class="rounded-lg shadow w-full max-w-md mt-[0%] sm:mt-[-1/2]">
            <center>

                <img src="{{asset('img/itd_logo.png')}}" alt="" class="max-w-48 h-48 mx-auto mt-[-10%] mb-[-10%]">
            </center>

            <div class="mt-[-15%] p-6">
                <h1 class="text-2xl font-bold text-center mb-5 text-gray-800">BCDA Survey Hub Login</h1>
    
                <form action="{{ route('survey.changePasswordFirstLogin')}}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="block font-semibold text-gray-700">New Password</label>
                        <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block font-semibold text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="w-full p-3 border border-gray-300 rounded-md focus:ring focus:ring-blue-300">
                        @error('password_confirmation')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
        
                    <button type="submit" class="w-full bg-blue-600 text-white p-3 rounded-md hover:bg-blue-700 transition duration-200">Change Password</button>
            </div>
            
        </div>
    
    </div>

    {{-- Include any additional scripts or components --}}
    @stack('scripts')
</body>
</html>