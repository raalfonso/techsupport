<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ env('APP_NAME', 'IT Department') }} - Request Support 🎃</title>
    
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
        /* Custom Halloween themed scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: #090c1a;
        }
        ::-webkit-scrollbar-thumb {
            background: #ea580c;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #f97316;
        }

        /* Subtle glowing border */
        @keyframes subtle-glow {
            0%, 100% {
                box-shadow: 0 0 25px rgba(249, 115, 22, 0.2), 0 20px 40px rgba(0, 0, 0, 0.6);
            }
            50% {
                box-shadow: 0 0 40px rgba(249, 115, 22, 0.35), 0 20px 50px rgba(0, 0, 0, 0.7);
            }
        }
        .form-glow-card {
            animation: subtle-glow 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#080b18] text-gray-100 min-h-screen flex flex-col antialiased selection:bg-orange-600 selection:text-white relative"> 
    {{-- Atmospheric Spooky Ambient Background Glows --}}
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-orange-600/10 blur-[130px] rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-purple-900/15 blur-[140px] rounded-full"></div>
        <div class="absolute top-1/3 -left-40 w-[400px] h-[400px] bg-amber-600/10 blur-[120px] rounded-full"></div>
    </div>

    {{-- Halloween Dark Navbar --}}
    <nav class="bg-[#080b18]/90 backdrop-blur-md border-b border-orange-500/20 px-4 py-3 shadow-xl top-0 z-50 min-w-full fixed transition-all duration-300">
        <div class="flex items-center justify-between container mx-auto w-full max-w-7xl">
            {{-- Logo / Brand Name --}}
            <a href="{{ route('home') }}" class="flex items-center group py-0.5" title="Return to Home">
                <img src="{{ asset('images/bcda-digitalhub-clean.png') }}"
                     alt="Digitalhub Logo"
                     class="h-6 sm:h-8 md:h-10 w-auto filter brightness-0 invert drop-shadow-[0_0_10px_rgba(255,255,255,0.45)] transition-transform duration-300 group-hover:scale-105">
            </a>
            
            {{-- Desktop Navigation --}}
            <div class="hidden md:flex space-x-3 items-center">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-amber-400 px-3 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-arrow-left text-xs text-orange-400"></i>
                    <span>Back to Home</span>
                </a>

                <div class="h-5 w-px bg-orange-500/20 mx-1"></div>

                {{-- Client User Badge --}}
                <div class="flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/30 text-amber-400 text-sm font-semibold shadow-inner">
                    <i class="fa-solid fa-user-astronaut text-orange-400 text-xs"></i>
                    <span>{{ $client->name }}</span>
                </div>

                {{-- Exit / Logout --}}
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-red-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    <span>Exit</span>
                </a>
            </div>

            {{-- Mobile Menu Button (Hamburger) --}}
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" aria-label="Toggle navigation menu" class="text-gray-300 hover:text-amber-400 focus:outline-none p-1 rounded-md transition-colors">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Navigation Dropdown --}}
        <div id="mobile-menu" class="hidden md:hidden bg-[#0c0f22]/98 border-t border-orange-500/20 backdrop-blur-xl px-4 pt-4 pb-6 space-y-3 mt-3 rounded-b-2xl shadow-2xl">
            <div class="flex items-center gap-2 px-3 py-2 rounded-lg bg-orange-500/10 border border-orange-500/20 text-amber-400 text-sm font-semibold">
                <i class="fa-solid fa-user-astronaut text-orange-400"></i>
                <span>{{ $client->name }}</span>
            </div>
            <a href="{{ route('home') }}" class="block text-gray-200 hover:text-amber-400 hover:bg-orange-500/10 px-3 py-2.5 rounded-lg text-base font-medium">
                <i class="fa-solid fa-arrow-left mr-2 text-orange-400"></i> Back to Home
            </a>
            <a href="{{ route('home') }}" class="block text-red-400 hover:bg-red-500/10 px-3 py-2 rounded-lg text-sm font-medium">
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Exit Form
            </a>
        </div>
    </nav> 

    {{-- Main Form Container --}}
    <main class="flex-grow pt-24 pb-16 px-4 sm:px-6 lg:px-8 relative z-10 flex items-center justify-center">
        <div class="w-full max-w-3xl">
            
            {{-- Breadcrumb Navigation --}}
            <div class="mb-5 flex items-center gap-2 text-xs sm:text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-house text-orange-500/80"></i> Home
                </a>
                <span class="text-gray-600">/</span>
                <span class="text-orange-400 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-ticket text-xs"></i> New IT Ticket
                </span>
            </div>

            {{-- Upgraded Card --}}
            <div class="form-glow-card bg-[#12162d]/95 backdrop-blur-xl border border-orange-500/30 rounded-3xl overflow-hidden transition-all duration-300">
                
                {{-- Decorative Gradient Header Line --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-orange-500 via-amber-400 to-orange-600"></div>

                <div class="p-6 sm:p-10 lg:p-12">
                    {{-- Card Header --}}
                    <div class="mb-8">
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-orange-500/10 border border-orange-500/30 text-orange-400 text-xs sm:text-sm font-semibold mb-3">
                            <i class="fa-solid fa-headset"></i> IT Service Helpdesk
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-2">
                            Welcome, <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-amber-300 to-orange-500">{{ $client->name }}</span>
                        </h1>
                        <p class="text-gray-300 text-sm sm:text-base leading-relaxed">
                            Fill out the details below so our IT support team can quickly diagnose and resolve your concern.
                        </p>

                        {{-- Department Tag --}}
                        @if(isset($client->department) && $client->department)
                        <div class="mt-4 inline-flex items-center gap-2 text-xs text-gray-400 bg-[#0a0d1b] border border-gray-800 px-3 py-1.5 rounded-lg">
                            <i class="fa-solid fa-building text-orange-400"></i>
                            <span>Department: <strong class="text-gray-200">{{ $client->department->title }}</strong></span>
                        </div>
                        @endif
                    </div>

                    {{-- Form --}}
                    <form action="{{ route('home.data') }}" method="post" enctype="multipart/form-data" class="space-y-6" x-data="{ loading: false }" @submit="loading = true">
                        @csrf
                        
                        {{-- Hidden inputs --}}
                        <input type="hidden" name="survey_employees_id" value="{{ $client->id }}">
                        <input type="hidden" id="department_id" name="department_id" value="{{ $client->department->id ?? 1 }}">

                        {{-- Section: Requestor & Location (2 Columns) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Requestor Name (Read-only) --}}
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-200 flex items-center justify-between">
                                    <span class="flex items-center gap-2">
                                        <i class="fa-solid fa-user text-orange-400"></i>
                                        <span>Requestor Name</span>
                                    </span>
                                    <span class="text-xs text-emerald-400 font-normal flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i> Verified
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           class="w-full px-4 py-3 bg-[#0a0d1b] border border-gray-700/80 rounded-xl text-gray-300 text-sm font-medium cursor-not-allowed shadow-inner focus:outline-none" 
                                           value="{{ $client->name }}" 
                                           readonly>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-500">
                                        <i class="fa-solid fa-lock text-xs"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Location Selector --}}
                            <div class="space-y-2">
                                <label for="location" class="block text-sm font-semibold text-gray-200 flex items-center gap-2">
                                    <i class="fa-solid fa-location-dot text-orange-400"></i>
                                    <span>Location <span class="text-orange-400">*</span></span>
                                </label>
                                <div class="relative">
                                    <select name="location" id="location" 
                                            class="w-full appearance-none px-4 py-3 bg-[#0a0d1b] border border-gray-700 text-white rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/40 transition-all duration-200 text-sm pr-10 @error('location') border-red-500 ring-1 ring-red-500 @enderror" 
                                            required> 
                                        <option value="" disabled class="bg-[#0d1022] text-gray-400">Select your work location</option>
                                        <option value="BTC" selected class="bg-[#0d1022] text-white">BTC (Bonifacio Technology Center)</option>
                                        <option value="One west" class="bg-[#0d1022] text-white">One West</option>
                                        <option value="PMO" class="bg-[#0d1022] text-white">PMO</option>
                                        <option value="NCC" class="bg-[#0d1022] text-white">NCC (New Clark City)</option>
                                        <option value="BTP" class="bg-[#0d1022] text-white">BTP</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-orange-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                @error('location')
                                    <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-exclamation"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Section: Issue Autocomplete Search --}}
                        <div class="space-y-2 pt-2">
                            <label for="home_issue_search" class="block text-sm font-semibold text-gray-200 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-triangle-exclamation text-orange-400"></i>
                                    <span>Specific Issue <span class="text-orange-400">*</span></span>
                                </span>
                                <span class="text-xs text-gray-400 font-normal">Type to filter list</span>
                            </label>
                            
                            <div class="relative" id="home-issue-search-container">
                                <div class="relative" id="home-issue-input-container">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-orange-400">
                                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                                    </div>
                                    <input type="text" 
                                           id="home_issue_search" 
                                           class="w-full pl-11 pr-4 py-3 bg-[#0a0d1b] border border-gray-700 text-white rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/40 transition-all duration-200 text-sm placeholder-gray-500" 
                                           placeholder="Search or select the issue you're facing..." 
                                           autocomplete="off">
                                </div>

                                {{-- Hidden Actual Value --}}
                                <input type="hidden" name="issues_id" id="home_issues_id_data" required>

                                {{-- Live Suggestions Panel --}}
                                <div id="home-issue-suggestions-container" 
                                     class="hidden absolute z-30 w-full mt-2 bg-[#0e1226] border border-orange-500/30 rounded-xl shadow-2xl shadow-black/80 max-h-60 overflow-y-auto divide-y divide-gray-800">
                                </div>

                                {{-- Selected Issue Pill Display --}}
                                <div id="home-selected-issue" class="hidden mt-3 p-4 bg-gradient-to-r from-orange-500/15 to-amber-500/10 border border-orange-500/40 rounded-2xl shadow-inner">
                                    <div class="flex items-center justify-between gap-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-orange-500/20 border border-orange-500/40 flex items-center justify-center text-orange-400 shrink-0">
                                                <i class="fa-solid fa-check text-sm"></i>
                                            </div>
                                            <div>
                                                <span class="text-xs text-orange-400/80 block uppercase tracking-wider font-semibold">Selected Issue</span>
                                                <span id="home-selected-issue-name" class="font-bold text-white text-sm sm:text-base"></span>
                                            </div>
                                        </div>
                                        <button type="button" id="home-clear-issue-selection" 
                                                class="px-3 py-1.5 rounded-lg bg-orange-500/20 hover:bg-orange-500/30 text-orange-300 hover:text-white text-xs font-semibold transition-colors flex items-center gap-1.5 shrink-0">
                                            <i class="fa-solid fa-arrow-rotate-left text-xs"></i>
                                            <span>Change</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            @error('issues_id')
                                <p class="text-red-400 text-xs mt-1.5 flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    <span>{{ $message }}</span>
                                </p>
                                <script>
                                    Swal.fire({
                                        icon: "error",
                                        title: "Issue Required",
                                        text: "{{ $message }}",
                                        background: "#131830",
                                        color: "#fff",
                                        confirmButtonColor: "#f97316"
                                    });
                                </script>
                            @enderror
                        </div>

                        {{-- Section: Screenshot Drag & Drop Uploader --}}
                        <div class="space-y-2 pt-2">
                            <label class="block text-sm font-semibold text-gray-200 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-camera text-orange-400"></i>
                                    <span>Attach Screenshot</span>
                                </span>
                                <span class="text-xs text-gray-400 font-normal">Optional (Max 2MB)</span>
                            </label>

                            <div id="dropzone" 
                                 class="relative rounded-2xl border-2 border-dashed border-orange-500/30 hover:border-orange-500/70 bg-[#0a0d1b]/70 hover:bg-orange-500/5 p-6 transition-all duration-300 cursor-pointer group">
                                <input id="screenshot" type="file" name="screenshot" accept="image/png, image/jpeg, image/jpg, image/webp" class="sr-only">
                                
                                <div id="dropzone-empty-state" class="flex flex-col items-center justify-center text-center space-y-3">
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500/20 to-amber-500/10 border border-orange-500/30 flex items-center justify-center text-orange-400 text-2xl group-hover:scale-110 transition-transform duration-300 shadow-md shadow-orange-500/10">
                                        <i class="fa-solid fa-cloud-arrow-up"></i>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-sm font-bold text-white">
                                            <span class="text-orange-400 underline underline-offset-2">Click to upload</span> or drag and drop image
                                        </p>
                                        <p class="text-xs text-gray-400">Supports PNG, JPG, JPEG, or WEBP up to 2MB</p>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-orange-500/15 border border-orange-500/30 text-orange-300 text-xs font-semibold group-hover:bg-orange-500/25 transition">
                                        <i class="fa-solid fa-file-image"></i> Browse File
                                    </span>
                                </div>

                                {{-- Preview State --}}
                                <div id="screenshot-preview-wrap" class="hidden space-y-3">
                                    <div class="relative rounded-xl overflow-hidden border border-orange-500/30 bg-[#0e1226] p-2 flex items-center justify-center">
                                        <img id="screenshot-preview" alt="Screenshot preview" class="max-h-72 w-auto max-w-full rounded-lg object-contain">
                                    </div>
                                    <div class="flex items-center justify-between text-xs text-gray-300 bg-[#0e1226] border border-gray-800 p-3 rounded-xl">
                                        <div class="flex items-center gap-2 truncate pr-2">
                                            <i class="fa-solid fa-image text-orange-400"></i>
                                            <span id="screenshot-file-name" class="font-medium truncate text-white"></span>
                                        </div>
                                        <button type="button" id="remove-screenshot-btn" 
                                                class="px-2.5 py-1 rounded-lg bg-red-500/15 hover:bg-red-500/25 text-red-400 hover:text-red-300 text-xs font-semibold transition flex items-center gap-1 shrink-0">
                                            <i class="fa-solid fa-trash-can"></i> Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section: Remarks --}}
                        <div class="space-y-2 pt-2">
                            <label for="remarks" class="block text-sm font-semibold text-gray-200 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i class="fa-solid fa-comment-dots text-orange-400"></i>
                                    <span>Detailed Remarks</span>
                                    @if($mains_id == 99)
                                        <span class="text-red-400 text-xs">* Required</span>
                                    @else
                                        <span class="text-gray-400 text-xs font-normal">(Optional)</span>
                                    @endif
                                </span>
                            </label>
                            <textarea name="remarks" id="remarks" rows="4" 
                                      class="w-full px-4 py-3 bg-[#0a0d1b] border border-gray-700 text-white rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-500/40 transition-all duration-200 resize-none text-sm placeholder-gray-500" 
                                      placeholder="Please describe any symptoms, error messages, or steps that will help our engineers reproduce and resolve the issue..."
                                      {{ $mains_id == 99 ? 'required' : '' }}></textarea>
                        </div>

                        {{-- Section: Actions --}}
                        <div class="pt-4 space-y-3">
                            <button type="submit" 
                                    class="w-full bg-gradient-to-r from-orange-500 via-amber-500 to-orange-600 hover:from-orange-600 hover:via-amber-600 hover:to-orange-700 text-white py-4 px-6 rounded-2xl font-bold text-base shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 flex items-center justify-center gap-2 cursor-pointer" 
                                    :disabled="loading">
                                <span x-show="!loading" class="flex items-center gap-2">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    <span>Submit Request Ticket</span>
                                </span>
                                <span x-show="loading" class="flex items-center gap-2" style="display: none;">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    <span>Submitting your ticket...</span>
                                </span>
                            </button>

                            <div class="text-center">
                                <a href="{{ route('home') }}" class="text-xs sm:text-sm text-gray-400 hover:text-gray-200 transition-colors inline-flex items-center gap-1.5 py-1">
                                    <i class="fa-solid fa-xmark"></i> Cancel and return to home
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    {{-- Halloween Spooky Footer --}}
    <footer class="bg-[#05070e] border-t border-orange-500/20 text-gray-400 py-8 relative z-10">
        <div class="max-w-6xl mx-auto px-6 text-center space-y-2">
            <p class="text-sm font-medium">&copy; {{ date('Y') }} IT Division - Bases Conversion and Development Authority</p>
            <p class="text-xs text-orange-400/80">Developed by ICTD-ITD {{ date('Y') }} 🎃 Happy Halloween</p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Mobile Menu Toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Screenshot Drag & Drop and Preview Handler
            const dropzone = document.getElementById('dropzone');
            const screenshotInput = document.getElementById('screenshot');
            const dropzoneEmptyState = document.getElementById('dropzone-empty-state');
            const screenshotPreviewWrap = document.getElementById('screenshot-preview-wrap');
            const screenshotPreview = document.getElementById('screenshot-preview');
            const screenshotFileName = document.getElementById('screenshot-file-name');
            const removeScreenshotBtn = document.getElementById('remove-screenshot-btn');

            if (dropzone && screenshotInput) {
                // Click dropzone to open file dialog (unless clicking remove button)
                dropzone.addEventListener('click', function (e) {
                    if (e.target.closest('#remove-screenshot-btn')) return;
                    screenshotInput.click();
                });

                // Drag & drop highlights
                ['dragenter', 'dragover'].forEach(eventName => {
                    dropzone.addEventListener(eventName, function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.classList.add('border-orange-500', 'bg-orange-500/10');
                    });
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropzone.addEventListener(eventName, function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        dropzone.classList.remove('border-orange-500', 'bg-orange-500/10');
                    });
                });

                // Handle dropped files
                dropzone.addEventListener('drop', function (e) {
                    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                        screenshotInput.files = e.dataTransfer.files;
                        handleFileSelection(e.dataTransfer.files[0]);
                    }
                });

                // File input change
                screenshotInput.addEventListener('change', function () {
                    if (this.files && this.files[0]) {
                        handleFileSelection(this.files[0]);
                    }
                });

                function handleFileSelection(file) {
                    if (!file) return;

                    // Max size check 2MB
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'File Too Large',
                            text: 'Please select an image smaller than 2MB.',
                            background: '#131830',
                            color: '#fff',
                            confirmButtonColor: '#f97316'
                        });
                        resetScreenshot();
                        return;
                    }

                    screenshotFileName.textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
                    const objectUrl = URL.createObjectURL(file);
                    screenshotPreview.src = objectUrl;

                    dropzoneEmptyState.classList.add('hidden');
                    screenshotPreviewWrap.classList.remove('hidden');

                    screenshotPreview.onload = function () {
                        URL.revokeObjectURL(objectUrl);
                    };
                }

                function resetScreenshot() {
                    screenshotInput.value = '';
                    screenshotPreview.removeAttribute('src');
                    screenshotFileName.textContent = '';
                    screenshotPreviewWrap.classList.add('hidden');
                    dropzoneEmptyState.classList.remove('hidden');
                }

                if (removeScreenshotBtn) {
                    removeScreenshotBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        resetScreenshot();
                    });
                }
            }

            // Issue Search Autocomplete
            const homeIssues = @json($issues);
            const homeIssueSearchInput = document.getElementById('home_issue_search');
            const homeIssueSuggestionsContainer = document.getElementById('home-issue-suggestions-container');
            const homeSelectedIssue = document.getElementById('home-selected-issue');
            const homeSelectedIssueName = document.getElementById('home-selected-issue-name');
            const homeIssueId = document.getElementById('home_issues_id_data');
            const homeClearIssueButton = document.getElementById('home-clear-issue-selection');
            const homeIssueInputContainer = document.getElementById('home-issue-input-container');

            function fetchHomeIssues(query) {
                return new Promise(resolve => {
                    setTimeout(() => {
                        const q = query.toLowerCase();
                        const results = homeIssues.filter(issue => 
                            issue.title.toLowerCase().includes(q)
                        );
                        resolve(results);
                    }, 150);
                });
            }

            function debounceHome(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            if (homeIssueSearchInput) {
                homeIssueSearchInput.addEventListener('input', debounceHome(async function (e) {
                    const query = e.target.value.trim();
                    const results = await fetchHomeIssues(query);
                    displayHomeIssueSuggestions(results);
                }, 200));

                homeIssueSearchInput.addEventListener('focus', async function () {
                    const results = await fetchHomeIssues(homeIssueSearchInput.value.trim());
                    displayHomeIssueSuggestions(results);
                });
            }

            function displayHomeIssueSuggestions(issues) {
                if (!homeIssueSuggestionsContainer) return;

                if (issues.length === 0) {
                    homeIssueSuggestionsContainer.innerHTML = `
                        <div class="p-4 text-center text-gray-400 text-sm flex items-center justify-center gap-2">
                            <i class="fa-solid fa-circle-question text-orange-400"></i>
                            <span>No matching issues found</span>
                        </div>
                    `;
                    homeIssueSuggestionsContainer.classList.remove('hidden');
                    return;
                }

                homeIssueSuggestionsContainer.innerHTML = '';
                issues.forEach(issue => {
                    const item = document.createElement('div');
                    item.className = 'p-3.5 hover:bg-orange-500/15 cursor-pointer transition-colors flex items-center justify-between text-gray-200 group';
                    item.innerHTML = `
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-triangle-exclamation text-xs text-orange-400/80 group-hover:text-orange-400"></i>
                            <span class="font-medium text-sm text-gray-200 group-hover:text-white">${issue.title}</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-xs text-gray-600 group-hover:text-orange-400 group-hover:translate-x-0.5 transition-transform"></i>
                    `;
                    item.addEventListener('click', () => {
                        selectHomeIssue(issue);
                    });
                    homeIssueSuggestionsContainer.appendChild(item);
                });

                homeIssueSuggestionsContainer.classList.remove('hidden');
            }

            function selectHomeIssue(issue) {
                if (homeSelectedIssueName) homeSelectedIssueName.textContent = issue.title;
                if (homeIssueId) homeIssueId.value = issue.id;
                if (homeSelectedIssue) homeSelectedIssue.classList.remove('hidden');
                if (homeIssueSearchInput) homeIssueSearchInput.value = '';
                if (homeIssueSuggestionsContainer) homeIssueSuggestionsContainer.classList.add('hidden');
                if (homeIssueInputContainer) homeIssueInputContainer.classList.add('hidden');
            }

            if (homeClearIssueButton) {
                homeClearIssueButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (homeSelectedIssue) homeSelectedIssue.classList.add('hidden');
                    if (homeIssueInputContainer) homeIssueInputContainer.classList.remove('hidden');
                    if (homeIssueId) homeIssueId.value = '';
                    if (homeIssueSearchInput) {
                        homeIssueSearchInput.value = '';
                        homeIssueSearchInput.focus();
                    }
                });
            }

            // Click outside to close issue suggestions
            document.addEventListener('click', function (e) {
                if (homeIssueSearchInput && homeIssueSuggestionsContainer) {
                    if (!homeIssueSearchInput.contains(e.target) && !homeIssueSuggestionsContainer.contains(e.target)) {
                        homeIssueSuggestionsContainer.classList.add('hidden');
                    }
                }
            });
        });
    </script>
</body>
</html>