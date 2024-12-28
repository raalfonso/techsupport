<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME')}}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-slate-100 text-slate-900">
    
    {{-- <header class="bg-slate-800 shadow-lg"> --}}
    <header class="bg-gradient-to-l from-yellow-950 to-yellow-900 shadow-lg">
    <nav>
       {{-- <div class="p-0 m-0"> --}}
        <a href="{{ route('home')}}" class=" nav-link">ICT Help Center</a>
           {{-- <a href="{{ route('home')}}" class=" nav-link m-0 p-0">
            <img 
            src="{{ asset('images/bcda-removebg-preview.png') }}" 
            alt="Home" 
            class="max-h-12 object-contain">
           </a> --}}
       {{-- </div> --}}
    
          
        @auth
            <div class="relative grid place-items-center" x-data= "{ open:false}"">
                {{-- drop down menu button  --}}
                <button @click="open = !open" class="round-btn">
                    <img src="https://picsum.photos/200" alt="">
                </button>

                {{-- dropdown menu  --}}
                <div x-show="open" @click.outside ="open=false" class="bg-white shadow-lg absolute top-10 right-0  rounded-lg overflow-hidden font-light">
                    <p class="username">{{ auth()->user()->name }}</p>
                    <a href="{{ route('dashboard')}}" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Dashboard</a>
                    <a href="{{ route('report.index')}}" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Report</a>
                    <a href="{{ route('issues.index')}}" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Issues</a>
                    <a href="{{ route('category.index')}}" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Category</a>
                    <a href="{{ route('department.index')}}" class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Department</a>
                    <form action="{{ route('logout')}}" method="post">
                        @csrf
                        <button class="block hover:bg-slate-100 pl-4 pr-8 py-2 mb-1">Logout</button>
                    </form>


                </div>
            </div>
        @endauth
       
        @guest
        <a href="{{ route('track')}}" class="block text-white pl-4 pr-8 py-2 mb-1">Track your report</a>
        @endguest
        
    </nav>
   </header>

   <main class="py-8 px-4 mx-auto max-w-screen-lg">
     {{ $slot }}
   </main>


</body>
</html>