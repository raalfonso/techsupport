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
            <div class="hidden md:flex space-x-4 float-right items-center">
                    {{-- Navigation links --}}
                    <a href="{{ route('survey.dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">dashboard</i>
                        {{-- Added icon for Dashboard --}}
                        Dashboard</a>

                    <a href="#about" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">assignment</i>
                        Survey Result
                    </a>

                    <a href="{{ route('qrcode', ['departmentCode' => auth()->user()->department_id]) }}"
                    class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium" target="_blank">
                        <i class="material-icons align-middle">qr_code</i>
                        QR Code
                    </a>

                    <a href="#contact" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">people</i>
                        Employee Registration
                    </a>

                    @if (auth()->user()->role === 'superadmin')
                        <a href="{{ route('survey.management') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="material-icons align-middle">settings</i>
                            User Management
                        </a>
                    @endif

                    {{-- User dropdown --}}
                    <div x-data="{ open: false }" class="relative">
                        <!-- Username button -->
                        <button @click="open = !open"
                            class="flex items-center text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            {{ auth()->user()->name }}
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">

                            <!-- Change Password -->
                            <a href="{{ route('survey.account') }}"
                            class="flex items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                <i class="material-icons mr-2 text-gray-500">lock</i> Account
                            </a>

                            <!-- Logout -->
                            <form method="POST" action="{{ route('userSurvey.logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex w-full items-center px-4 py-2 text-sm text-gray-600 hover:bg-gray-100">
                                    <i class="material-icons mr-2 text-gray-500">logout</i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
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
        <div id="mobile-menu" class="mt-20hidden md:hidden bg-white pt-2 pb-3 space-y-1 sm:px-3">
            {{-- Container for mobile menu links --}}
            <br><br><br>
            <br><br><br><br><br>
            <div class="container mx-auto mt-10"> 
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Home</a>
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">About</a>
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Project</a>
                <a href="{{ route('survey.dashboard') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Report</a>
                <a href="{{ route('survey.account') }}" class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">Account</a>
              <!-- Logout -->
                <form method="POST" action="{{ route('userSurvey.logout') }}">
                    @csrf
                    <button type="submit"
                            class="block text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-base font-medium">
                            Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section id="user" class="pb-5 mt-5" style="background-color: #e6edfc">
    <div class="container mx-auto px-6 py-16 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">User Management</h1>
        <p class="text-lg text-gray-600 mb-8">Manage survey users and their roles</p>

        <div class="bg-white rounded-lg shadow-lg p-6">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Department</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ ucfirst($user->name) }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ $user->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ $user->department->title }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ ucfirst($user->status) }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ ucfirst($user->role) }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">
                            <!-- Edit Button -->
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2" onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')">Edit</button>
                            <!-- Delete Button -->
                            <form action="{{ route('survey.management', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                <div class="mt-4">
                    {{ $users->links('pagination::tailwind') }}
                </div>

    </div>


    </section>  

    {{-- section for adding survey employee --}}
    <section class="pb-5 bg-white" id="add-user">
        <div class="container mx-auto px-6 py-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">List of Survey Employees</h2>
            <p class="text-lg text-gray-600 mb-8">Create a new survey user account</p>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <form action="{{ route('survey.uploadEmployees') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input type="file" name="file" class="border border-gray-300 p-2 rounded w-full" required>
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Import</button>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6 text-left">
                <p class="mt-5 text-lg text-gray-600 mb-8 font-bold"> List of Employees</p>

                <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Department</th>
                        <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ ucfirst($employee->name) }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ $employee->email }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">{{ $employee->department->title }}</td>
                        <td class="py-2 px-4 border-b border-gray-200 text-left">
                            <!-- Edit Button -->
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2" onclick="editUser({{ $employee->id }}, '{{ $employee->name }}', '{{ $employee->email }}', '{{ $employee->role }}')">Edit</button>
                            <!-- Edit Button -->
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
                <div class="mt-4">
                    {{ $employees->links('pagination::tailwind') }}
                </div>
            </div>

            
            
        </div>
    
    
    {{-- this is for data import --}}
    <section class="pb-5 bg-white" id="import">
        <div class="container mx-auto px-6 py-16 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Data Importation</h2>
            <p class="text-lg text-gray-600 mb-8">Import data from other office</p>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <form action="{{ route('survey.management') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <input type="file" name="file" class="border border-gray-300 p-2 rounded w-full" required>
                    </div>
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Import</button>
                </form>
                 <div class="mt-4 text-sm text-gray-500">
                <p>Note: Only CSV files are supported.</p>

            </div>




            {{-- list of uploaded files --}}
            <div class="mt-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4">Uploaded Files</h3>
                <table class="min-w-full bg-white">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">File Name</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Uploaded At</th>
                            <th class="py-2 px-4 border-b border-gray-200 bg-gray-100 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($files as $file)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200 text-left">{{ $file->filename }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-left">{{ $file->created_at->format('Y-m-d H:i') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200 text-left">
                                <a href="{{ route('files.download', $file->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded mr-2">Download</a>
                                <form action="{{ route('files.delete', $file->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded" onclick="return confirm('Are you sure you want to delete this file?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
          
           
        </div>

    </section>
    {{-- Footer --}}
       

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