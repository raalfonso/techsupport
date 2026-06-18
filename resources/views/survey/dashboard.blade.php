<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ 'ICT PORTAL' }}</title>
    
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
                BCDA ICT PORTAL {{-- Changed from MyBrand to match context --}}
            </div>
            {{-- Desktop Navigation --}}
                <div class="hidden md:flex space-x-4 float-right items-center">
                    {{-- Navigation links --}}
                    <a href="#home-section" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">dashboard</i>
                        Dashboard
                    </a>
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
        <div id="mobile-menu" class="mt-20 hidden md:hidden bg-white pt-2 pb-3 space-y-1 sm:px-3">
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
    <section id="home-section" class="pb-2" style="background-color: #e6edfc">
        <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-6 pt-24 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Survey Dashboard Overview</h2>
            <!-- Add this date range filter form after the Survey Dashboard Overview heading -->
        <div class="mb-8">
            <div class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" 
                            id="start_date" 
                            name="start_date" 
                            value="{{ request('start_date') }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="flex-1 min-w-[200px]">
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" 
                            id="end_date" 
                            name="end_date"
                            value="{{ request('end_date') }}" 
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex gap-3">
                    <button 
                       onclick="filterResults()"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>

                    <a href="{{ route('survey.dashboard') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset
                    </a>

                    <button id="export-result-btn"
                        class="export-result-btn inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>                        
                        Export
                    </button>
            </div>
        </div>


            {{-- this is for range filter --}}
        
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 mt-5">
                <!-- Total Surveys Card -->
                <div class="bg-white shadow-lg rounded-xl p-6 transform transition duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg text-gray-600 font-semibold mb-2">Total Surveys</p>
                            <p class="text-4xl font-bold text-blue-600 total-survey">{{$total}}</p>
                        </div>
                        <div class="bg-blue-100 p-4 rounded-full">
                            <i class="material-icons text-blue-600 text-[40px]">assignment</i>
                        </div>
                    </div>
                </div>

                <!-- Super Like Card -->
                <div class="bg-white shadow-lg rounded-xl p-6 transform transition duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg text-gray-600 font-semibold mb-2">Super Like</p>
                            <p class="text-4xl font-bold text-emerald-600 super-survey">{{$percentageSuperLike}}%</p>
                        </div>
                        <div class="bg-emerald-100 p-4 rounded-full">
                            <i class="material-icons text-emerald-600 text-[40px]">sentiment_very_satisfied</i>
                        </div>
                    </div>
                </div>

                <!-- Like Card -->
                <div class="bg-white shadow-lg rounded-xl p-6 transform transition duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg text-gray-600 font-semibold mb-2">Like</p>
                            <p class="text-4xl font-bold text-indigo-600 like-survey">{{$percentageLike}}%</p>
                        </div>
                        <div class="bg-indigo-100 p-4 rounded-full">
                            <i class="material-icons text-indigo-600 text-[40px]">sentiment_satisfied</i>
                        </div>
                    </div>
                </div>

                <!-- Dislike Card -->
                <div class="bg-white shadow-lg rounded-xl p-6 transform transition duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-lg text-gray-600 font-semibold mb-2">Dislike</p>
                            <p class="text-4xl font-bold text-rose-600 dislike-survey">{{$percentageDislike}}%</p>
                        </div>
                        <div class="bg-rose-100 p-4 rounded-full">
                            <i class="material-icons text-rose-600 text-[40px]">sentiment_neutral</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="top" class="pb-8" style="background-color: #e6edfc">
      <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-6 pt-8 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
            {{-- Charts Section --}}
          <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Survey Accuracy Chart -->
            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition duration-300">
                 <figure class="highcharts-figure">
                  <div id="container" class="min-h-[400px]"></div>
                </figure>
            </div>
             <!-- Survey Response Time Chart -->
            <div class="bg-white shadow-lg rounded-xl p-6 hover:shadow-xl transition duration-300">
                 <figure class="highcharts-figure">
                  <div id="container2" class="min-h-[400px]"></div>
                </figure>
            </div>
          </div>

        </div>

    </section>
    
    <section id="about" class="py-16" style="background-color: #e6edfc">
      <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
        <h1 class="text-4xl font-bold mb-8 text-gray-800">Survey Results</h1>
        
        <div class="flex justify-end mb-4">
            <button id="export-result-survey"
                class="export-result-survey inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>                        
                Export
            </button>
        </div>



        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <div class="overflow-x-auto survey-table">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                  <tr class="bg-gray-50">
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Date Submitted</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Employee's Name</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Competence & Accuracy</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Responsiveness</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Comment</th>
                    <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider">Client Name</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 survey-table-body">
                  @foreach($surveys as $survey)
                      <tr class="hover:bg-gray-50 transition duration-150">
                          <td class="py-4 px-6 text-sm text-gray-600">{{ $survey->created_at->format('F j, Y') }}</td>
                          <td class="py-4 px-6 text-sm text-gray-600 font-medium">{{ $survey->surveyEmployee->name }}</td>
                          <td class="py-4 px-6">
                              @if ($survey->accuracy_of_service == 2)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Super Like
                                  </span>
                              @elseif ($survey->accuracy_of_service == 1)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                                    </svg>
                                    Like
                                  </span>
                              @else
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    Dislike
                                  </span>
                              @endif
                          </td>
                          <td class="py-4 px-6">
                              @if ($survey->response_time == 2)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/>
                                    </svg>
                                    Super Like
                                  </span>
                              @elseif ($survey->response_time == 1)
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z"/>
                                    </svg>
                                    Like
                                  </span>
                              @else
                                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                      <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/>
                                    </svg>
                                    Dislike
                                  </span>
                              @endif
                          </td>
                          <td class="py-4 px-6 text-sm text-gray-600">{{ $survey->comments }}</td>
                          <td class="py-4 px-6 text-sm text-gray-600">{{ $survey->client_name }}</td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <div class="mt-6 pagination-links">
            {{ $surveys->links('pagination::tailwind') }}
        </div>
      </div>
    </section>

    <section id="contact" class="py-16" style="background-color: #e6edfc">
      <div class="container mx-auto lg:max-w-screen-xl md:max-w-screen-md px-4 transition-all duration-700 opacity-0 translate-y-4" data-scroll>
        <div class="flex justify-between items-center mb-8">
          <div>
            <h2 class="text-3xl font-bold text-gray-800">Employee Management</h2>
            <p class="mt-2 text-gray-600">Add and manage employee information</p>
          </div>
          <a href="#" 
             data-modal-target="crud-modal" 
             data-modal-toggle="crud-modal" 
             class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-150 ease-in-out">
             <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
             </svg>
             Add Employee
          </a>
        </div>
        
          <div class="overflow-x-auto">
            <!-- Search form above table -->
            <div class="mb-6">
  <form method="GET" action="{{ route('survey.dashboard') }}" class="flex flex-col sm:flex-row gap-4 items-end">
    <div class="flex-1">
      <div class="relative">
        <input type="text" 
               name="search"
               id="table-search" 
               class="block w-full p-3 pl-12 text-sm border border-gray-300 rounded-lg bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out shadow-sm" 
               placeholder="Search for employees..."
               value="{{ request('search') }}">
        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
          <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </div>
      </div>
    </div>
    <div class="flex gap-3 shrink-0">
      <button type="submit" class="inline-flex items-center px-5 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Search
      </button>
      <a href="{{ route('survey.dashboard') }}" class="inline-flex items-center px-5 py-3 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition duration-150 ease-in-out">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
        Clear
      </a>
    </div>          
  </form>
</div>
<table class="min-w-full divide-y divide-gray-200">
    <thead>
      <tr class="bg-gray-50">
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Email</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Department</th>
        <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
        <th class="py-4 px-6 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200" id="employee-table-body">
      @foreach($employees as $employee)
          <tr class="hover:bg-gray-50 transition duration-150">
              <td class="py-4 px-6">
                <div class="flex items-center">
                  <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-full flex items-center justify-center">
                    <span class="text-xl font-medium text-gray-600">{{ substr($employee->name, 0, 1) }}</span>
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">{{ $employee->name }}</div>
                  </div>
                </div>
              </td>
              <td class="py-4 px-6 text-sm text-gray-600">{{ $employee->email }}</td>
              <td class="py-4 px-6 text-sm text-gray-600">{{ $employee->department->title }}</td>
              <td class="py-4 px-6">
                  @if ($employee->status === 'active')
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        Active
                      </span>
                  @else
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                        <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        Inactive
                      </span>
                  @endif
              </td>
              <td class="py-4 px-6 text-center">
                  <a href="#" 
                    data-modal-target="edit-modal" 
                    data-modal-toggle="edit-modal"
                    data-employee-id="{{ $employee->id }}"
                    data-employee-name="{{ $employee->name }}"
                    data-employee-email="{{ $employee->email }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
              </td>
          </tr>
      @endforeach
    </tbody>
</table>

        </div>
<div class="mt-4 px-6">
    {{ $employees->links('pagination::tailwind') }}
</div>              
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>
    {{-- this is for modal  --}}
    <!-- Main modal -->
      <div id="crud-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full ">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                         <span class="text-blue-700 font-semibold">Registration Form</span>
                      </h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="crud-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <form action="{{ route('survey.employee.store') }}" method="post" id="registration-form" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                      <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email address" required>
                      </div>
                      <div class="col-span-2">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter your email address" required>
                      </div>
                      <div class="col-span-2">
                      @if (auth()->user()->role === 'superadmin')
                        <label for="department_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                        <select name="department_id" id="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                          <option value="" disabled selected>Select Department</option>
                          @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->title }}</option>
                          @endforeach
                        </select>
                        @else
                            <input type="text" name="department_id" class="" value="{{ auth()->user()->department_id }}" hidden>
                        @endif
                        </div>

                      <button type="submit" id="modal-action-button" class="col-span-2 bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800">
                        <span class="font-semibold">Submit</span>
                      </button>
                    </div>
                  </form>
              </div>
          </div>
      </div>
    {{-- end of modal Registration --}}


   {{-- -- this is for edit modal -- --}}
        <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full ">
          <div class="relative p-4 w-full max-w-md max-h-full">
              <!-- Modal content -->
              <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                  <!-- Modal header -->
                  <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                      <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                         <span class="text-blue-700 font-semibold">Edit Form</span>
                      </h3>
                      <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="edit-modal">
                          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                          </svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                  </div>
                  <!-- Modal body -->
                  <form action="{{ route('survey.employee.edit') }}" method="post" id="registration-form" class="p-4 md:p-5">
                    @csrf
                    <div class="grid gap-4 mb-4 grid-cols-2">
                      <input type="hidden" name="id" id="edit-id">
                      <div class="col-span-2">
                        <label for="edit-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" id="edit-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter name" required>
                      </div>
                      <div class="col-span-2">
                        <label for="edit-email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="text" name="email" id="edit-email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter email address" required>
                      </div>
                       <div class="col-span-2">
                      @if (auth()->user()->role === 'superadmin')
                        <label for="department_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                        <select name="department_id" id="department_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                          <option value="" disabled selected>Select Department</option>
                          @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->title }}</option>
                          @endforeach
                        </select>
                        @else
                            <input type="text" name="department_id" class="" value="{{ auth()->user()->department_id }}" hidden>
                        @endif
                        </div>
                      <button type="submit" id="modal-action-button" class="col-span-2 bg-blue-700 text-white px-6 py-3 rounded-full font-semibold shadow transition hover:bg-blue-800">
                        <span class="font-semibold">Submit</span>
                      </button>
                    </div>
                  </form>
              </div>
          </div>
      </div>
    


{{-- Footer --}}
<footer class="bg-blue-800 text-white py-8 bottom-0 w-full">
    <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center text-sm">
        <p class="mb-4 md:mb-0">© {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
        <div class="flex gap-4">
            <a href="#home-section" class="hover:underline">Home</a>
            <a href="#about" class="hover:underline">About</a>
            <a href="#services" class="hover:underline">Services</a>
            <a href="#projects" class="hover:underline">Projects</a>
            <a href="#contact" class="hover:underline">Report</a>
        </div>
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
    
    // Populate Edit Modal fields when Edit button is clicked
    document.addEventListener('click', function (e) {
        const trigger = e.target.closest('[data-modal-toggle="edit-modal"]');
        if (!trigger) return;
        const id = trigger.getAttribute('data-employee-id') || '';
        const name = trigger.getAttribute('data-employee-name') || '';
        const email = trigger.getAttribute('data-employee-email') || '';

        const inputId = document.getElementById('edit-id');
        const inputName = document.getElementById('edit-name');
        const inputEmail = document.getElementById('edit-email');

        if (inputId) inputId.value = id;
        if (inputName) inputName.value = name;
        if (inputEmail) inputEmail.value = email;
    });
 
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

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
        target.scrollIntoView({ behavior: 'smooth' });
        }
    });
    });

    // this is for modal request
    document.addEventListener('DOMContentLoaded', function () {
    const modalTitle = document.getElementById('modal-project-title');
    const actionButton = document.getElementById('modal-action-button');
    const main = document.getElementById('modal-project-main');

    document.querySelectorAll('[data-modal-toggle="crud-modal"]').forEach(el => {
        el.addEventListener('click', function () {
        const title = this.getAttribute('data-project-title');
        const mainData = this.getAttribute('data-project-main');
        const projectButton = this.getAttribute('data-project-button') || 'Submit';
        if (modalTitle) {
            modalTitle.textContent = title;
            actionButton.textContent = projectButton;
            main.value = mainData;
        }
        });
    });
    });

    // this is for highchart
    Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Degree of Competence & Accuracy of Service'
        },
        xAxis: {
            //categories: @json(collect($superData)->pluck('employee_name')),
            //crosshair: true
            categories: @json(collect($superData)->pluck('employee_name')),
            crosshair: true,
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                },
                step: 1, // Show every label
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Responses'
            }
        },
        tooltip: {
            valueSuffix: ' responses'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Super Like',
                data: @json(collect($superData)->pluck('super_like')),
                color: 'rgb(34, 197, 94)' // Tailwind CSS green-500
            },
            {
                name: 'Like',
                data: @json(collect($superData)->pluck('like')),
                color: 'rgb(59, 130, 246)' // Tailwind CSS blue-500
            },
            {
                name: 'Dislike',
                data: @json(collect($superData)->pluck('dislike')),
                color: 'rgb(239, 68, 68)' // Tailwind CSS red-500
            }
        ]
    });



    Highcharts.chart('container2', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Degree of Responsiveness and Timeliness'
        },
        xAxis: {
            categories: @json(collect($superDataR)->pluck('employee_name')),
            crosshair: true,
            labels: {
                rotation: -75,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                },
                step: 1, // Show every label
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total Responses'
            }
        },
        tooltip: {
            valueSuffix: ' responses'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Super Like',
                data: @json(collect($superDataR)->pluck('super_like')),
                color: 'rgb(34, 197, 94)' // Tailwind CSS green-500
            },
            {
                name: 'Like',
                data: @json(collect($superDataR)->pluck('like')),
                color: 'rgb(59, 130, 246)' // Tailwind CSS blue-500
            },
            {
                name: 'Dislike',
                data: @json(collect($superDataR)->pluck('dislike')),
                color: 'rgb(239, 68, 68)' // Tailwind CSS red-500
            }
        ]
    });



    function filterResults() {

        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        // console.log(startDate, endDate);
        // Validate dates
        if (!startDate || !endDate) {
            Swal.fire({
                toast: true,
                position: 'top-end', 
                icon: 'warning',
                title: 'Please select both start and end dates',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }
       else if (startDate > endDate) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error', 
                title: 'Start date cannot be later than end date',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }

        else {

            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while data is being processed.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            $.ajax({
                url: '{{ route("survey.dashboard.filter") }}',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    // Handle successful response
                    // console.log(response.superDataR);
                    $('.total-survey').html(response.total);
                    $('.super-survey').html(response.percentageSuperLike);
                    $('.like-survey').html(response.percentageLike);
                    $('.dislike-survey').html(response.percentageDislike);


                    //console.log(response.superData);
                    // re-render the charts with new data

                    //////////////////////////////////////////////////////////////////////
                    // this is for highchart
                        Highcharts.chart('container', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Degree of Competence & Accuracy of Service'
                            },
                            xAxis: {
                                //categories: @json(collect($superData)->pluck('employee_name')),
                                //crosshair: true
                                categories: response.superData.map(item => item.employee_name),
                                crosshair: true,
                                labels: {
                                    rotation: -75,
                                    style: {
                                        fontSize: '13px',
                                        fontFamily: 'Verdana, sans-serif'
                                    },
                                    step: 1, // Show every label
                                }
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Total Responses'
                                }
                            },
                            tooltip: {
                                valueSuffix: ' responses'
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [
                                {
                                    name: 'Super Like',
                                    data: response.superData.map(item => item.super_like),
                                    color: 'rgb(34, 197, 94)' // Tailwind CSS green-500
                                },
                                {
                                    name: 'Like',
                                    data: response.superData.map(item => item.like),
                                    color: 'rgb(59, 130, 246)' // Tailwind CSS blue-500
                                },
                                {
                                    name: 'Dislike',
                                    data: response.superData.map(item => item.dislike),
                                    color: 'rgb(239, 68, 68)' // Tailwind CSS red-500
                                }
                            ]
                        });

                        Highcharts.chart('container2', {
                            chart: {
                                type: 'column'
                            },
                            title: {
                                text: 'Degree of Responsiveness and Timeliness'
                            },
                            xAxis: {
                                categories: response.superDataR.map(item => item.employee_name),
                                crosshair: true,
                                labels: {
                                    rotation: -75,
                                    style: {
                                        fontSize: '13px',
                                        fontFamily: 'Verdana, sans-serif'
                                    },
                                    step: 1, // Show every label
                                }
                            },
                            yAxis: {
                                min: 0,
                                title: {
                                    text: 'Total Responses'
                                }
                            },
                            tooltip: {
                                valueSuffix: ' responses'
                            },
                            plotOptions: {
                                column: {
                                    pointPadding: 0.2,
                                    borderWidth: 0
                                }
                            },
                            series: [
                                {
                                    name: 'Super Like',
                                    data: response.superDataR.map(item => item.super_like),
                                    color: 'rgb(34, 197, 94)' // Tailwind CSS green-500
                                },
                                {
                                    name: 'Like',
                                    data: response.superDataR.map(item => item.like),
                                    color: 'rgb(59, 130, 246)' // Tailwind CSS blue-500
                                },
                                {
                                    name: 'Dislike',
                                    data: response.superDataR.map(item => item.dislike),
                                    color: 'rgb(239, 68, 68)' // Tailwind CSS red-500
                                }
                            ]
                        });
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error fetching filtered data:', error);
                }
            });

            $.ajax({
                url: '{{ route("survey.searchResults") }}',
                method: 'GET',
                data: {
                    start_date: startDate,
                    end_date: endDate
                },
                success: function(response) {
                    // Handle successful response as table data
                    $('.survey-table-body').html(response.data);
                    $('.pagination-links').hide(); // Hide pagination links when filtering

                      // Close loading
                        Swal.close();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error('Error exporting results:', error);
                }
            });

            
        }



        
    }

    

    $('#export-result-btn').click(function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate > endDate) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error', 
                title: 'Start date cannot be later than end date',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }
        else{
            let url = '{{ route("survey.exportResults") }}';
            if (startDate && endDate) {
                url += `?start_date=${startDate}&end_date=${endDate}`;
            }
           window.open(url, "_blank");
        }
    });

    $('#export-result-survey').click(function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;

        if (startDate > endDate) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error', 
                title: 'Start date cannot be later than end date',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
            return;
        }
        else{
            let urlpdf = '{{ route("survey.exportResultsPDF") }}';
            if (startDate && endDate) {
                urlpdf += `?start_date=${startDate}&end_date=${endDate}`;
            }
           window.open(urlpdf, "_blank");
        
        }
    });

</script>

{{-- SweetAlert2 notification for success messages --}}
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: @json(session('success')),
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });
    });
</script>
@endif

</body>
</html>