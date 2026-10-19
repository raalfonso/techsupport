<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', 'IT Department') }} - Ticket Tracking 🎃</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    {{-- Vite Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">

    <style>
        /* Custom Halloween Scrollbar */
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

        /* Ambient Glowing Pulse */
        @keyframes subtle-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(249, 115, 22, 0.15), 0 0 40px rgba(249, 115, 22, 0.05);
            }
            50% {
                box-shadow: 0 0 30px rgba(249, 115, 22, 0.3), 0 0 60px rgba(249, 115, 22, 0.12);
            }
        }
        .animate-subtle-glow {
            animation: subtle-glow 4s ease-in-out infinite;
        }

        /* Pulse Dot Animation for Active / Pending Status */
        @keyframes status-pulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.85); }
        }
        .animate-status-pulse {
            animation: status-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>

<body class="bg-[#080b18] text-gray-100 min-h-screen flex flex-col antialiased selection:bg-orange-600 selection:text-white relative"> 
    
    {{-- Atmospheric Spooky Ambient Background Glows --}}
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[700px] h-[500px] bg-orange-600/10 blur-[140px] rounded-full"></div>
        <div class="absolute bottom-10 right-0 w-[550px] h-[550px] bg-purple-900/15 blur-[150px] rounded-full"></div>
        <div class="absolute top-1/3 -left-40 w-[450px] h-[450px] bg-amber-600/10 blur-[130px] rounded-full"></div>
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
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-red-400 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors flex items-center gap-1.5" title="Exit Tracker">
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
                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Exit Tracker
            </a>
        </div>
    </nav> 

    {{-- Main Container --}}
    <main class="flex-grow pt-24 pb-20 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-6xl mx-auto">
            
            {{-- Breadcrumb Navigation --}}
            <div class="mb-6 flex items-center gap-2 text-xs sm:text-sm text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-orange-400 transition-colors flex items-center gap-1.5">
                    <i class="fa-solid fa-house text-orange-500/80"></i> Home
                </a>
                <span class="text-gray-600">/</span>
                <span class="text-orange-400 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-list-check text-xs"></i> Ticket Tracking
                </span>
            </div>

            {{-- Success Notification Banner --}}
            @if(session('success'))
            <div class="mb-6 p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-950/80 via-emerald-900/60 to-emerald-950/80 border border-emerald-500/40 text-emerald-200 shadow-xl backdrop-blur-md flex items-start sm:items-center justify-between gap-3 animate-fade-in" role="alert">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/20 border border-emerald-500/40 flex items-center justify-center text-emerald-400 shrink-0">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-white text-sm sm:text-base">Success!</h4>
                        <p class="text-xs sm:text-sm text-emerald-300/90">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-white p-1 rounded-lg transition-colors">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
            @endif

            {{-- Welcome & Summary Hero Section --}}
            <div class="bg-[#12162d]/90 backdrop-blur-xl border border-orange-500/30 rounded-3xl p-6 sm:p-8 mb-8 shadow-2xl relative overflow-hidden animate-subtle-glow">
                {{-- Decorative background gradient --}}
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-orange-600/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 relative z-10">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-orange-500/15 border border-orange-500/30 text-amber-400 text-xs font-semibold mb-3">
                            <i class="fa-solid fa-sparkles text-orange-400"></i>
                            <span>Live IT Helpdesk Status</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                            Welcome, <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-amber-300">{{ $client->name }}</span>
                        </h1>
                        <p class="text-sm sm:text-base text-gray-300 mt-2 max-w-2xl leading-relaxed">
                            Monitor real-time resolution progress, view activity history, and provide feedback on your reported IT requests.
                        </p>
                    </div>

                    {{-- Action Button: Submit Another Ticket --}}
                    <div class="shrink-0 flex items-center gap-3">
                        <a href="{{ route('home') }}#contact" 
                           class="inline-flex items-center justify-center gap-2.5 px-5 py-3 rounded-2xl bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold text-sm shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span>New Request</span>
                        </a>
                    </div>
                </div>

                {{-- Status Metric Badges --}}
                @php
                    $totalCount = $reports->count();
                    $ongoingCount = $reports->where('status', 'Ongoing')->count();
                    $pendingCount = $reports->where('status', 'Pending')->count();
                    $doneCount = $reports->where('status', 'Done')->count();
                @endphp
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 mt-8 pt-6 border-t border-orange-500/20">
                    {{-- Total --}}
                    <div class="bg-[#0b0e1e]/80 border border-gray-800 rounded-2xl p-4 flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-blue-500/15 border border-blue-500/30 flex items-center justify-center text-blue-400 shrink-0">
                            <i class="fa-solid fa-ticket text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Total Filed</p>
                            <p class="text-xl sm:text-2xl font-black text-white">{{ $totalCount }}</p>
                        </div>
                    </div>

                    {{-- Pending --}}
                    <div class="bg-[#0b0e1e]/80 border border-gray-800 rounded-2xl p-4 flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-amber-500/15 border border-amber-500/30 flex items-center justify-center text-amber-400 shrink-0">
                            <i class="fa-solid fa-hourglass-half text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Pending</p>
                            <p class="text-xl sm:text-2xl font-black text-amber-300">{{ $pendingCount }}</p>
                        </div>
                    </div>

                    {{-- Ongoing --}}
                    <div class="bg-[#0b0e1e]/80 border border-gray-800 rounded-2xl p-4 flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-orange-500/15 border border-orange-500/30 flex items-center justify-center text-orange-400 shrink-0">
                            <i class="fa-solid fa-gears text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">In Progress</p>
                            <p class="text-xl sm:text-2xl font-black text-orange-400">{{ $ongoingCount }}</p>
                        </div>
                    </div>

                    {{-- Resolved --}}
                    <div class="bg-[#0b0e1e]/80 border border-gray-800 rounded-2xl p-4 flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-emerald-500/15 border border-emerald-500/30 flex items-center justify-center text-emerald-400 shrink-0">
                            <i class="fa-solid fa-circle-check text-lg"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider">Resolved</p>
                            <p class="text-xl sm:text-2xl font-black text-emerald-400">{{ $doneCount }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Real-Time Interactive Filter & Search Controls --}}
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 mb-6">
                {{-- Status Filter Tabs --}}
                <div class="inline-flex p-1 bg-[#12162d]/90 border border-orange-500/20 rounded-2xl overflow-x-auto shadow-inner text-xs font-semibold">
                    <button type="button" class="filter-tab px-4 py-2 rounded-xl transition-all duration-200 text-white bg-orange-600 shadow-md shadow-orange-500/30" data-filter="all">
                        All ({{ $totalCount }})
                    </button>
                    <button type="button" class="filter-tab px-4 py-2 rounded-xl transition-all duration-200 text-gray-400 hover:text-white" data-filter="Ongoing">
                        Ongoing ({{ $ongoingCount }})
                    </button>
                    <button type="button" class="filter-tab px-4 py-2 rounded-xl transition-all duration-200 text-gray-400 hover:text-white" data-filter="Pending">
                        Pending ({{ $pendingCount }})
                    </button>
                    <button type="button" class="filter-tab px-4 py-2 rounded-xl transition-all duration-200 text-gray-400 hover:text-white" data-filter="Done">
                        Resolved ({{ $doneCount }})
                    </button>
                </div>

                {{-- Live Search Input --}}
                <div class="relative w-full sm:w-72">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-500 text-xs"></i>
                    <input type="text" 
                           id="ticket-search-input" 
                           placeholder="Search ticket # or issue title..." 
                           class="w-full bg-[#12162d]/90 border border-orange-500/20 rounded-2xl pl-9 pr-4 py-2 text-xs sm:text-sm text-gray-200 placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all shadow-inner">
                </div>
            </div>

            {{-- Ticket List Container --}}
            <div class="space-y-6" id="tickets-container">
            @forelse ($reports as $report)
                @php
                    $status = $report->status;
                    $isPending = ($status == 'Pending');
                    $isOngoing = ($status == 'Ongoing');
                    $isDone = ($status == 'Done');
                    $isForValidation = ($status == 'For validation');

                    // Stepper status logic
                    // Step 1: Filed (Always 100%)
                    // Step 2: In Progress
                    // Step 3: Resolved
                @endphp

                <div class="ticket-card bg-[#12162d]/90 backdrop-blur-xl border border-orange-500/20 hover:border-orange-500/50 rounded-3xl p-6 sm:p-7 shadow-xl hover:shadow-orange-500/10 transition-all duration-300 relative group overflow-hidden" 
                     id="report{{ $report->id }}"
                     data-ticket-id="{{ $report->id }}"
                     data-ticket-status="{{ $status }}"
                     data-ticket-search="{{ strtolower($report->ticket_number . ' ' . ($report->issues->title ?? '') . ' ' . $status) }}">
                    
                    {{-- Decorative Card Accent Glow --}}
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-orange-500/40 to-transparent"></div>

                    {{-- Top Row: Ticket Number, Timestamps, and Status Badge --}}
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-gray-800">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                            {{-- Ticket Number with Copy Button --}}
                            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl bg-slate-900/90 border border-orange-500/30 text-amber-400 font-mono text-xs sm:text-sm font-bold shadow-inner">
                                <i class="fa-solid fa-hashtag text-[10px] text-orange-400"></i>
                                <span>{{ $report->ticket_number }}</span>
                                <button type="button" 
                                        class="copy-btn text-gray-400 hover:text-white transition-colors ml-1 p-0.5" 
                                        data-copy="{{ $report->ticket_number }}" 
                                        title="Copy Ticket Number">
                                    <i class="fa-regular fa-copy text-xs"></i>
                                </button>
                            </div>

                            <span class="text-xs text-gray-500">•</span>

                            {{-- Request Datetime --}}
                            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                <i class="fa-regular fa-calendar-days text-orange-400/80"></i>
                                <span>{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y • h:i A') }}</span>
                            </div>

                            {{-- Department Tag if exists --}}
                            @if($report->department)
                                <span class="hidden sm:inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-slate-800 text-[11px] font-medium text-gray-300 border border-gray-700">
                                    <i class="fa-solid fa-building text-[10px] text-amber-400"></i>
                                    <span>{{ $report->department->acronym ?? $report->department->title }}</span>
                                </span>
                            @endif
                        </div>

                        {{-- Status Badge --}}
                        <div class="shrink-0">
                            @if ($isOngoing)
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-blue-500/15 text-blue-300 border border-blue-500/40 shadow-sm shadow-blue-500/20">
                                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-status-pulse"></span>
                                    <span>In Progress</span>
                                </span>
                            @elseif ($isDone)
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/40 shadow-sm shadow-emerald-500/20">
                                    <i class="fa-solid fa-circle-check text-xs text-emerald-400"></i>
                                    <span>Resolved</span>
                                </span>
                            @elseif ($isForValidation)
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-purple-500/15 text-purple-300 border border-purple-500/40 shadow-sm shadow-purple-500/20">
                                    <i class="fa-solid fa-clipboard-check text-xs text-purple-400"></i>
                                    <span>For Validation</span>
                                </span>
                            @else
                                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-bold bg-amber-500/15 text-amber-300 border border-amber-500/40 shadow-sm shadow-amber-500/20">
                                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-status-pulse"></span>
                                    <span>Pending Assignment</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Middle Row: Issue Title & Details --}}
                    <div class="py-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="space-y-2">
                                <h3 class="text-lg sm:text-xl font-bold text-white group-hover:text-amber-300 transition-colors flex items-center gap-2">
                                    <i class="fa-solid fa-wrench text-sm text-orange-400"></i>
                                    <span>{{ $report->issues->title ?? 'Technical Support Request' }}</span>
                                </h3>

                                {{-- Optional Location or Remarks --}}
                                @if($report->location)
                                    <p class="text-xs text-gray-400 flex items-center gap-1.5">
                                        <i class="fa-solid fa-location-dot text-amber-400"></i>
                                        <span>Location: {{ $report->location }}</span>
                                    </p>
                                @endif
                            </div>

                            {{-- Attachment / Screenshot Button if available --}}
                            @if ($report->screenshot)
                                <a href="{{ route('report.screenshot', $report->id) }}" 
                                   target="_blank" 
                                   class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-orange-500/10 hover:bg-orange-500/20 border border-orange-500/30 text-orange-300 text-xs font-semibold transition-colors shrink-0" 
                                   title="View Attachment">
                                    <i class="fa-solid fa-paperclip text-xs"></i>
                                    <span>Attachment</span>
                                </a>
                            @endif
                        </div>

                        {{-- User Remarks Callout if present --}}
                        @if($report->remarks)
                            <div class="mt-3.5 p-3 rounded-xl bg-slate-900/60 border border-slate-800 text-xs text-gray-300 leading-relaxed">
                                <span class="font-semibold text-gray-400 flex items-center gap-1.5 mb-1">
                                    <i class="fa-regular fa-comment text-orange-400"></i> Issue Details / Remarks:
                                </span>
                                <p class="text-gray-300 whitespace-pre-line">{{ $report->remarks }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Visual Progress Stepper --}}
                    <div class="py-4 my-2 px-4 sm:px-6 bg-[#0c0f20]/90 border border-gray-800/80 rounded-2xl">
                        <div class="grid grid-cols-3 gap-2 relative">
                            {{-- Step 1: Filed --}}
                            <div class="flex flex-col items-center text-center relative z-10">
                                <div class="w-8 h-8 rounded-full bg-orange-500 text-white flex items-center justify-center text-xs font-bold shadow-md shadow-orange-500/40 mb-1.5">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <span class="text-[11px] sm:text-xs font-semibold text-orange-300">Ticket Filed</span>
                                <span class="text-[10px] text-gray-500 hidden sm:block">{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, h:i A') }}</span>
                            </div>

                            {{-- Step 2: In Progress --}}
                            <div class="flex flex-col items-center text-center relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold mb-1.5 {{ ($isOngoing || $isDone || $isForValidation) ? 'bg-orange-500 text-white shadow-md shadow-orange-500/40' : 'bg-slate-800 text-gray-500 border border-gray-700' }}">
                                    @if($isOngoing)
                                        <i class="fa-solid fa-spinner fa-spin text-xs"></i>
                                    @elseif($isDone || $isForValidation)
                                        <i class="fa-solid fa-check"></i>
                                    @else
                                        2
                                    @endif
                                </div>
                                <span class="text-[11px] sm:text-xs font-semibold {{ ($isOngoing || $isDone || $isForValidation) ? 'text-orange-300' : 'text-gray-500' }}">
                                    {{ $isOngoing ? 'In Progress' : (($isDone || $isForValidation) ? 'Assigned' : 'Queued') }}
                                </span>
                                @if($report->response_datetime)
                                    <span class="text-[10px] text-gray-500 hidden sm:block">{{ \Carbon\Carbon::parse($report->response_datetime)->format('M d, h:i A') }}</span>
                                @endif
                            </div>

                            {{-- Step 3: Resolved --}}
                            <div class="flex flex-col items-center text-center relative z-10">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold mb-1.5 {{ $isDone ? 'bg-emerald-500 text-white shadow-md shadow-emerald-500/40' : 'bg-slate-800 text-gray-500 border border-gray-700' }}">
                                    @if($isDone)
                                        <i class="fa-solid fa-check-double text-xs"></i>
                                    @else
                                        3
                                    @endif
                                </div>
                                <span class="text-[11px] sm:text-xs font-semibold {{ $isDone ? 'text-emerald-300' : 'text-gray-500' }}">Resolved</span>
                                @if($report->resolve_datetime)
                                    <span class="text-[10px] text-gray-500 hidden sm:block">{{ \Carbon\Carbon::parse($report->resolve_datetime)->format('M d, h:i A') }}</span>
                                @endif
                            </div>

                            {{-- Connecting Track Lines behind Stepper --}}
                            <div class="absolute top-4 left-[16%] right-[16%] h-0.5 bg-gray-800 -z-0">
                                <div class="h-full bg-gradient-to-r from-orange-500 {{ $isDone ? 'to-emerald-500 w-full' : ($isOngoing ? 'to-orange-500 w-1/2' : 'w-0') }} transition-all duration-500"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Personnel Details Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                        {{-- Responded By Column --}}
                        <div class="p-4 rounded-2xl bg-[#0e1227]/80 border border-gray-800/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-user-gear text-orange-400 text-xs"></i>
                                    <span>Responded By</span>
                                </p>
                                @if (in_array($status, ['Ongoing', 'Done', 'For validation']))
                                    <span class="text-[11px] text-orange-400 font-medium">Assigned</span>
                                @endif
                            </div>

                            @if (in_array($status, ['Ongoing', 'Done', 'For validation']))
                                <div class="pt-1">
                                    <p class="text-sm font-bold text-white flex items-center gap-2">
                                        <span>{{ $report->response->name ?? 'IT Specialist' }}</span>
                                    </p>
                                    @if($report->response_datetime)
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ \Carbon\Carbon::parse($report->response_datetime)->format('M d, Y • h:i A') }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Notes Callout --}}
                                @if($report->notes)
                                    <div class="mt-3 p-3 bg-blue-950/40 border border-blue-500/30 rounded-xl text-xs">
                                        <p class="font-semibold text-blue-300 flex items-center gap-1.5 mb-1">
                                            <i class="fa-solid fa-comment-dots text-blue-400"></i>
                                            <span>Staff Response Notes:</span>
                                        </p>
                                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $report->notes }}</p>
                                    </div>
                                @endif
                            @else
                                <p class="text-xs sm:text-sm text-gray-500 pt-1 flex items-center gap-1.5">
                                    <i class="fa-regular fa-clock text-amber-500"></i>
                                    <span>Awaiting staff pickup & assignment</span>
                                </p>
                            @endif
                        </div>

                        {{-- Resolved By Column --}}
                        <div class="p-4 rounded-2xl bg-[#0e1227]/80 border border-gray-800/80 space-y-2">
                            <div class="flex items-center justify-between">
                                <p class="text-[11px] font-semibold text-gray-400 uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-check text-emerald-400 text-xs"></i>
                                    <span>Resolved By</span>
                                </p>
                                @if ($isDone)
                                    <span class="text-[11px] text-emerald-400 font-medium">Completed</span>
                                @endif
                            </div>

                            @if ($isDone)
                                <div class="pt-1">
                                    <p class="text-sm font-bold text-white flex items-center gap-2">
                                        <span>{{ $report->resolve->user->name ?? $report->response->name ?? 'IT Staff' }}</span>
                                    </p>
                                    @if($report->resolve_datetime)
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ \Carbon\Carbon::parse($report->resolve_datetime)->format('M d, Y • h:i A') }}
                                        </p>
                                    @endif
                                </div>

                                {{-- Completion Notes Callout --}}
                                @if($report->completion_notes)
                                    <div class="mt-3 p-3 bg-emerald-950/40 border border-emerald-500/30 rounded-xl text-xs">
                                        <p class="font-semibold text-emerald-300 flex items-center gap-1.5 mb-1">
                                            <i class="fa-solid fa-clipboard-check text-emerald-400"></i>
                                            <span>Resolution Summary:</span>
                                        </p>
                                        <p class="text-gray-300 leading-relaxed whitespace-pre-line">{{ $report->completion_notes }}</p>
                                    </div>
                                @endif
                            @else
                                <p class="text-xs sm:text-sm text-gray-500 pt-1 flex items-center gap-1.5">
                                    <i class="fa-regular fa-hourglass text-gray-500"></i>
                                    <span>Pending resolution</span>
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Bottom Action Bar: Toggle Log History & Service Feedback --}}
                    <div class="pt-4 mt-2 border-t border-gray-800/90 flex flex-wrap items-center justify-between gap-3">
                        {{-- Log History Toggle Button --}}
                        <button type="button" 
                                class="toggle-history-btn inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800/80 hover:bg-slate-700/80 text-gray-300 hover:text-white text-xs font-semibold border border-gray-700 transition-all duration-200" 
                                data-report-id="{{ $report->id }}">
                            <i class="fa-solid fa-timeline text-orange-400"></i>
                            <span>Activity History</span>
                            <i class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 arrow-icon"></i>
                        </button>

                        {{-- Service Rating Button / Feedback Status --}}
                        <div>
                            @if ($isDone && ($report->feedback != 'Yes'))
                                <button type="button" 
                                        data-modal-target="feedback-modal"
                                        data-modal-toggle="feedback-modal" 
                                        data-report-id="{{ $report->id }}"
                                        data-staff-name="{{ $report->resolve?->user?->name ?? $report->response?->name ?? 'IT Staff' }}"
                                        data-transacted-person-id="{{ $report->resolve?->user?->surveyEmployee?->id ?? $report->response?->surveyEmployee?->id ?? '' }}"
                                        data-generated-code="{{ $report->ticket_number }}"
                                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-400 hover:to-orange-500 text-white text-xs sm:text-sm font-bold rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 transform hover:-translate-y-0.5">
                                    <i class="fa-solid fa-star text-amber-200"></i>
                                    <span>Rate Our Service</span>
                                </button>
                            @elseif ($isDone && $report->feedback == 'Yes')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/15 border border-emerald-500/30 text-emerald-400">
                                    <i class="fa-solid fa-circle-check"></i>
                                    <span>Feedback Submitted</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Collapsible Activity Log History Container (Populated via AJAX) --}}
                    <div id="history-container-{{ $report->id }}" class="history-dropdown hidden mt-5 pt-4 border-t border-gray-800">
                        {{-- Timeline injected here dynamically --}}
                    </div>
                </div>
            @empty
                {{-- Empty State --}}
                <div class="bg-[#12162d]/90 backdrop-blur-xl border border-orange-500/30 rounded-3xl p-12 text-center shadow-2xl">
                    <div class="w-20 h-20 mx-auto rounded-3xl bg-orange-500/10 border border-orange-500/30 flex items-center justify-center text-orange-400 text-3xl mb-4 shadow-lg shadow-orange-500/10">
                        <i class="fa-solid fa-ghost"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">No Reported Issues Yet</h3>
                    <p class="text-gray-400 text-sm max-w-md mx-auto mb-6">
                        You have not submitted any technical support requests yet. If you need any IT assistance, please submit a ticket below.
                    </p>
                    <a href="{{ route('home') }}#contact" 
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-orange-600 to-amber-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold text-sm shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-paper-plane text-xs"></i>
                        <span>Submit an IT Request</span>
                    </a>
                </div>
            @endforelse
            </div>

            {{-- No Search Results State (hidden by default) --}}
            <div id="no-search-results" class="hidden bg-[#12162d]/90 backdrop-blur-xl border border-orange-500/30 rounded-3xl p-10 text-center shadow-xl mt-6">
                <i class="fa-solid fa-magnifying-glass text-3xl text-gray-500 mb-3"></i>
                <h4 class="text-lg font-bold text-white mb-1">No Matching Tickets</h4>
                <p class="text-sm text-gray-400">Try searching with a different ticket number or keyword.</p>
            </div>
        </div>
    </main>

    {{-- Halloween Dark Footer --}}
    <footer class="bg-[#050710] border-t border-orange-500/20 text-gray-400 py-8 relative z-10">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs sm:text-sm">
            <div class="flex items-center gap-2">
                <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-6 w-auto opacity-80">
                <span>&copy; {{ date('Y') }} Bases Conversion and Development Authority - IT Division</span>
            </div>
            <div class="flex items-center gap-4 text-gray-400">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Home</a>
                <span>•</span>
                <a href="{{ route('home') }}#contact" class="hover:text-amber-400 transition-colors">Helpdesk</a>
                <span>•</span>
                <span class="text-orange-500 font-mono text-xs">SolveIT Portal</span>
            </div>
        </div>
    </footer>

    {{-- Upgraded Feedback Modal (BCDA Internal Services Feedback Form) --}}
    <div id="feedback-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 justify-center items-center w-full h-full bg-black/75 backdrop-blur-md p-4 flex">
        <div class="relative w-full max-w-2xl mx-auto my-auto animate-fade-in">
            {{-- Modal Content Card --}}
            <div class="relative bg-[#0d1025] border border-orange-500/30 rounded-3xl shadow-2xl text-gray-100 overflow-hidden">
                
                {{-- Decorative Gradient Header Line --}}
                <div class="h-1.5 w-full bg-gradient-to-r from-orange-500 via-amber-400 to-orange-600"></div>

                {{-- Modal Header --}}
                <div class="flex items-center justify-between p-5 sm:p-6 border-b border-gray-800 bg-[#12162d]/70">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/itd_logo.png') }}" alt="BCDA Logo" class="h-10 w-auto rounded">
                        <div>
                            <p class="italic text-[10px] text-amber-400/80 font-mono">BCDA-ODMD2014-12 | May 2014</p>
                            <h3 class="text-base sm:text-lg font-bold text-white">BCDA Internal Services Feedback Form</h3>
                        </div>
                    </div>
                    <button type="button" 
                            class="text-gray-400 hover:text-white bg-slate-800/60 hover:bg-slate-700/80 rounded-xl p-2 transition-colors focus:outline-none" 
                            data-modal-toggle="feedback-modal"
                            aria-label="Close modal">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-6 sm:p-7 overflow-y-auto max-h-[calc(100vh-200px)]">
                    <form action="{{ route('feedback.store') }}" method="POST" id="feedback-form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="report_id" id="modal-report-id" value="">
                        <input type="hidden" name="transacted-person" id="modal-transacted-person-id" value="">
                        <input type="hidden" name="generated-code" id="modal-generated-code" value="">

                        {{-- Date & Person Transacted With --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-2xl bg-[#12162d]/60 border border-gray-800">
                            <div>
                                <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Date</label>
                                <div class="text-sm font-semibold text-white flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-orange-400 text-xs"></i>
                                    <span>{{ now()->format('F d, Y') }}</span>
                                </div>
                            </div>

                            <div>
                                <label for="modal-transacted-person-name" class="text-xs font-semibold text-gray-400 uppercase tracking-wider block mb-1">Person Transacted With</label>
                                <input type="text" 
                                       id="modal-transacted-person-name" 
                                       class="w-full px-3 py-1.5 rounded-xl border border-gray-700 bg-slate-900/90 text-amber-300 text-xs font-bold focus:outline-none cursor-default" 
                                       readonly 
                                       value="IT Staff">
                            </div>
                        </div>

                        {{-- Section Title --}}
                        <div class="pt-1">
                            <h4 class="text-sm font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                <span>How do you rate their service?</span>
                            </h4>
                            <p class="text-xs text-gray-400 mt-0.5">Please check your assessment for each criteria.</p>
                        </div>

                        {{-- Section 1: Degree of Competence & Accuracy --}}
                        <div class="space-y-2.5">
                            <label class="block text-xs font-bold text-gray-200 uppercase tracking-wider">
                                1. Degree of Competence & Accuracy of Service <span class="text-orange-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-2.5">
                                @foreach ([
                                    '2' => ['icon' => 'fa-solid fa-thumbs-up', 'text' => 'Super Like', 'color' => 'text-emerald-400', 'border' => 'peer-checked:border-emerald-500 peer-checked:bg-emerald-500/20 peer-checked:text-emerald-300'],
                                    '1' => ['icon' => 'fa-regular fa-thumbs-up', 'text' => 'Like', 'color' => 'text-blue-400', 'border' => 'peer-checked:border-blue-500 peer-checked:bg-blue-500/20 peer-checked:text-blue-300'],
                                    '0' => ['icon' => 'fa-regular fa-thumbs-down', 'text' => 'Dislike', 'color' => 'text-rose-400', 'border' => 'peer-checked:border-rose-500 peer-checked:bg-rose-500/20 peer-checked:text-rose-300']
                                ] as $value => $meta)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="accuracy_of_service" value="{{ $value }}" class="peer hidden" required>
                                        <div class="p-3 rounded-2xl border border-gray-700 bg-slate-900/70 hover:border-gray-500 {{ $meta['border'] }} transition-all duration-200 text-center flex flex-col items-center justify-center gap-1.5 h-full">
                                            <i class="{{ $meta['icon'] }} {{ $meta['color'] }} text-base"></i>
                                            <span class="text-xs font-bold">{{ $meta['text'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Section 2: Degree of Responsiveness / Timeliness --}}
                        <div class="space-y-2.5">
                            <label class="block text-xs font-bold text-gray-200 uppercase tracking-wider">
                                2. Degree of Responsiveness / Timeliness <span class="text-orange-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-2.5">
                                @foreach ([
                                    '2' => ['icon' => 'fa-solid fa-thumbs-up', 'text' => 'Super Like', 'color' => 'text-emerald-400', 'border' => 'peer-checked:border-emerald-500 peer-checked:bg-emerald-500/20 peer-checked:text-emerald-300'],
                                    '1' => ['icon' => 'fa-regular fa-thumbs-up', 'text' => 'Like', 'color' => 'text-blue-400', 'border' => 'peer-checked:border-blue-500 peer-checked:bg-blue-500/20 peer-checked:text-blue-300'],
                                    '0' => ['icon' => 'fa-regular fa-thumbs-down', 'text' => 'Dislike', 'color' => 'text-rose-400', 'border' => 'peer-checked:border-rose-500 peer-checked:bg-rose-500/20 peer-checked:text-rose-300']
                                ] as $value => $meta)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="response_time" value="{{ $value }}" class="peer hidden" required>
                                        <div class="p-3 rounded-2xl border border-gray-700 bg-slate-900/70 hover:border-gray-500 {{ $meta['border'] }} transition-all duration-200 text-center flex flex-col items-center justify-center gap-1.5 h-full">
                                            <i class="{{ $meta['icon'] }} {{ $meta['color'] }} text-base"></i>
                                            <span class="text-xs font-bold">{{ $meta['text'] }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Section 3: Brief Comment --}}
                        <div>
                            <label for="modal-comments" class="block text-xs font-bold text-gray-200 uppercase tracking-wider mb-2">
                                Brief Comment <span id="comments-required-star-modal" class="text-rose-500 hidden">* (Required for Dislike)</span>
                            </label>
                            <textarea name="comments" 
                                      id="modal-comments" 
                                      rows="3" 
                                      class="w-full bg-slate-900/90 border border-gray-700 rounded-2xl p-3 text-xs sm:text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all" 
                                      placeholder="Share your thoughts or recommendations to help us improve..."></textarea>
                        </div>

                        {{-- Section 4: Name (Optional) --}}
                        <div>
                            <label for="modal-client-name" class="block text-xs font-bold text-gray-200 uppercase tracking-wider mb-2">Name (Optional)</label>
                            <input type="text" 
                                   name="client_name" 
                                   id="modal-client-name"
                                   value="{{ $client->name ?? '' }}" 
                                   class="w-full bg-slate-900/90 border border-gray-700 rounded-2xl px-4 py-2.5 text-xs sm:text-sm text-gray-100 placeholder-gray-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all" 
                                   placeholder="Your name">
                        </div>

                        {{-- Submit Button --}}
                        <div class="pt-2">
                            <button type="submit" 
                                    id="modal-btn-submit" 
                                    class="w-full bg-gradient-to-r from-orange-600 via-amber-500 to-orange-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg shadow-orange-500/30 hover:shadow-orange-500/50 transition-all duration-300 transform hover:-translate-y-0.5 text-sm sm:text-base flex items-center justify-center gap-2">
                                <i class="fa-solid fa-paper-plane text-xs"></i>
                                <span>Submit Feedback</span>
                            </button>
                        </div>

                        <p class="text-center text-[11px] text-gray-500 italic">
                            Thank you. Your feedback is instrumental in improving BCDA IT services.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Application Logic & AJAX Timeline --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            // 1. Mobile navigation menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // 2. Click to copy ticket number
            document.querySelectorAll('.copy-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const text = this.getAttribute('data-copy');
                    if (navigator.clipboard) {
                        navigator.clipboard.writeText(text).then(() => {
                            const icon = this.querySelector('i');
                            if (icon) {
                                icon.className = 'fa-solid fa-check text-xs text-emerald-400';
                                setTimeout(() => {
                                    icon.className = 'fa-regular fa-copy text-xs';
                                }, 2000);
                            }
                        });
                    }
                });
            });

            // 3. Live search and filter functionality
            const searchInput = document.getElementById('ticket-search-input');
            const filterTabs = document.querySelectorAll('.filter-tab');
            const ticketCards = document.querySelectorAll('.ticket-card');
            const noResults = document.getElementById('no-search-results');
            let currentFilter = 'all';

            function filterTickets() {
                const query = (searchInput ? searchInput.value : '').toLowerCase().trim();
                let visibleCount = 0;

                ticketCards.forEach(card => {
                    const status = card.getAttribute('data-ticket-status');
                    const searchData = card.getAttribute('data-ticket-search');

                    const matchesFilter = (currentFilter === 'all' || status === currentFilter);
                    const matchesQuery = (!query || (searchData && searchData.includes(query)));

                    if (matchesFilter && matchesQuery) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                if (noResults) {
                    if (visibleCount === 0 && ticketCards.length > 0) {
                        noResults.classList.remove('hidden');
                    } else {
                        noResults.classList.add('hidden');
                    }
                }
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterTickets);
            }

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    filterTabs.forEach(t => {
                        t.className = 'filter-tab px-4 py-2 rounded-xl transition-all duration-200 text-gray-400 hover:text-white';
                    });
                    this.className = 'filter-tab px-4 py-2 rounded-xl transition-all duration-200 text-white bg-orange-600 shadow-md shadow-orange-500/30';
                    currentFilter = this.getAttribute('data-filter');
                    filterTickets();
                });
            });

            // 4. Modal Open & Data Populating
            const feedbackModal = document.getElementById('feedback-modal');
            const modalReportId = document.getElementById('modal-report-id');
            const modalTransactedPersonName = document.getElementById('modal-transacted-person-name');
            const modalTransactedPersonId = document.getElementById('modal-transacted-person-id');
            const modalGeneratedCode = document.getElementById('modal-generated-code');

            function openFeedbackModal(button) {
                const reportId = button.getAttribute('data-report-id');
                const staffName = button.getAttribute('data-staff-name');
                const transactedPersonId = button.getAttribute('data-transacted-person-id');
                const generatedCode = button.getAttribute('data-generated-code');

                if (modalReportId) modalReportId.value = reportId || '';
                if (modalTransactedPersonName) modalTransactedPersonName.value = staffName || 'IT Staff';
                if (modalTransactedPersonId) modalTransactedPersonId.value = transactedPersonId || '';
                if (modalGeneratedCode) modalGeneratedCode.value = generatedCode || '';

                if (feedbackModal) {
                    feedbackModal.classList.remove('hidden');
                }
            }

            function closeFeedbackModal() {
                if (feedbackModal) {
                    feedbackModal.classList.add('hidden');
                }
            }

            document.querySelectorAll('[data-modal-toggle="feedback-modal"]').forEach(el => {
                el.addEventListener('click', function (e) {
                    e.preventDefault();
                    if (this.getAttribute('data-report-id')) {
                        openFeedbackModal(this);
                    } else {
                        closeFeedbackModal();
                    }
                });
            });

            // Close modal when clicking backdrop
            if (feedbackModal) {
                feedbackModal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeFeedbackModal();
                    }
                });
            }

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && feedbackModal && !feedbackModal.classList.contains('hidden')) {
                    closeFeedbackModal();
                }
            });

            // 5. Dynamic requirement for comments based on Dislike rating ('0')
            const modalAccuracyRadios = document.querySelectorAll('input[name="accuracy_of_service"]');
            const modalResponseRadios = document.querySelectorAll('input[name="response_time"]');
            const modalCommentsTextarea = document.getElementById('modal-comments');
            const modalCommentsRequiredStar = document.getElementById('comments-required-star-modal');

            function updateModalCommentRequirement() {
                let hasDislike = false;
                modalAccuracyRadios.forEach(radio => {
                    if (radio.checked && radio.value === '0') hasDislike = true;
                });
                modalResponseRadios.forEach(radio => {
                    if (radio.checked && radio.value === '0') hasDislike = true;
                });

                if (hasDislike) {
                    if (modalCommentsTextarea) modalCommentsTextarea.setAttribute('required', 'required');
                    if (modalCommentsRequiredStar) modalCommentsRequiredStar.classList.remove('hidden');
                } else {
                    if (modalCommentsTextarea) modalCommentsTextarea.removeAttribute('required');
                    if (modalCommentsRequiredStar) modalCommentsRequiredStar.classList.add('hidden');
                }
            }

            modalAccuracyRadios.forEach(radio => radio.addEventListener('change', updateModalCommentRequirement));
            modalResponseRadios.forEach(radio => radio.addEventListener('change', updateModalCommentRequirement));

            // 6. Handle Feedback Form Submission with validation
            const feedbackForm = document.getElementById('feedback-form');
            if (feedbackForm) {
                feedbackForm.addEventListener('submit', function(e) {
                    let errors = [];

                    let accuracySelected = false;
                    let accuracyVal = '';
                    modalAccuracyRadios.forEach(radio => {
                        if (radio.checked) {
                            accuracySelected = true;
                            accuracyVal = radio.value;
                        }
                    });
                    if (!accuracySelected) {
                        errors.push("Degree of Competence & Accuracy rating is required.");
                    }

                    let timeSelected = false;
                    let timeVal = '';
                    modalResponseRadios.forEach(radio => {
                        if (radio.checked) {
                            timeSelected = true;
                            timeVal = radio.value;
                        }
                    });
                    if (!timeSelected) {
                        errors.push("Degree of Responsiveness/Timeliness rating is required.");
                    }

                    let hasDislike = (accuracyVal === '0' || timeVal === '0');
                    if (hasDislike && modalCommentsTextarea && !modalCommentsTextarea.value.trim()) {
                        errors.push("Please provide a comment explaining how we can improve our service.");
                    }

                    if (errors.length > 0) {
                        e.preventDefault();
                        let errorHtml = '<ul class="text-left list-disc list-inside space-y-1.5 text-sm text-rose-400">';
                        errors.forEach(err => {
                            errorHtml += `<li>${err}</li>`;
                        });
                        errorHtml += '</ul>';

                        Swal.fire({
                            title: 'Rating Required',
                            html: errorHtml,
                            icon: 'warning',
                            background: '#0d1025',
                            color: '#f8fafc',
                            confirmButtonText: 'Understood',
                            confirmButtonColor: '#ea580c'
                        });
                    }
                });
            }

            // 7. Toggle Activity Log History Accordion via AJAX
            document.querySelectorAll('.toggle-history-btn').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const reportId = this.getAttribute('data-report-id');
                    const container = document.getElementById(`history-container-${reportId}`);
                    const arrowIcon = this.querySelector('.arrow-icon');

                    if (!container) return;

                    // Toggle if already visible
                    if (!container.classList.contains('hidden')) {
                        container.classList.add('hidden');
                        if (arrowIcon) arrowIcon.classList.remove('rotate-180');
                        return;
                    }

                    // Open container & show loading state
                    container.classList.remove('hidden');
                    if (arrowIcon) arrowIcon.classList.add('rotate-180');
                    container.innerHTML = `
                        <div class="py-6 text-center text-orange-400">
                            <i class="fa-solid fa-circle-notch fa-spin text-xl mb-2"></i>
                            <p class="text-xs text-gray-400">Fetching activity history...</p>
                        </div>
                    `;

                    // Fetch JSON log history
                    const url = "{{ route('report.loghistory', ':id') }}".replace(':id', reportId);

                    fetch(url)
                        .then(response => {
                            if (!response.ok) throw new Error('Network error');
                            return response.json();
                        })
                        .then(data => {
                            if (!data || data.length === 0) {
                                container.innerHTML = `
                                    <div class="p-4 rounded-2xl bg-slate-900/60 border border-gray-800 text-center">
                                        <p class="text-xs text-gray-400">No activity logs recorded yet for this ticket.</p>
                                    </div>
                                `;
                                return;
                            }

                            let timelineItems = '';
                            data.forEach((item, index) => {
                                const action = (item.action || '').toLowerCase();
                                let actionBadge = 'bg-blue-500/20 text-blue-300 border-blue-500/40';
                                let dotColor = 'bg-blue-400 ring-blue-500/30';
                                let icon = 'fa-solid fa-clock-rotate-left';

                                if (action === 'responded') {
                                    actionBadge = 'bg-orange-500/20 text-orange-300 border-orange-500/40';
                                    dotColor = 'bg-orange-400 ring-orange-500/30';
                                    icon = 'fa-solid fa-headset';
                                } else if (action === 'resolved') {
                                    actionBadge = 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40';
                                    dotColor = 'bg-emerald-400 ring-emerald-500/30';
                                    icon = 'fa-solid fa-check';
                                }

                                timelineItems += `
                                    <div class="flex items-start gap-3.5 relative pb-5 last:pb-0 group">
                                        <div class="w-7 h-7 rounded-full ${dotColor} ring-4 flex items-center justify-center text-white text-[10px] shrink-0 z-10 shadow-md">
                                            <i class="${icon}"></i>
                                        </div>
                                        <div class="flex-1 min-w-0 bg-slate-900/70 border border-gray-800 rounded-xl p-3 hover:border-gray-700 transition-colors">
                                            <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border ${actionBadge}">
                                                    ${item.action}
                                                </span>
                                                <span class="text-[11px] text-gray-400 font-mono">${item.perform_at || ''}</span>
                                            </div>
                                            <p class="text-xs text-gray-300">
                                                Performed by <strong class="text-white">${item.perform_by || 'IT Staff'}</strong>
                                            </p>
                                        </div>
                                    </div>
                                `;
                            });

                            container.innerHTML = `
                                <div class="p-5 rounded-2xl bg-[#0c0f22]/90 border border-gray-800 space-y-4">
                                    <div class="flex items-center justify-between pb-3 border-b border-gray-800">
                                        <h4 class="text-xs font-bold text-white uppercase tracking-wider flex items-center gap-2">
                                            <i class="fa-solid fa-timeline text-orange-400"></i>
                                            <span>Ticket Resolution Audit Trail</span>
                                        </h4>
                                        <button type="button" class="close-history-btn text-xs text-gray-400 hover:text-white transition-colors" data-report-id="${reportId}">
                                            <i class="fa-solid fa-xmark"></i> Close
                                        </button>
                                    </div>
                                    <div class="space-y-1 relative pl-1">
                                        {{-- Vertical Connector Line --}}
                                        <div class="absolute left-4 top-3 bottom-3 w-0.5 bg-gray-800 -z-0"></div>
                                        ${timelineItems}
                                    </div>
                                </div>
                            `;

                            // Close button inside dropdown
                            container.querySelector('.close-history-btn').addEventListener('click', () => {
                                container.classList.add('hidden');
                                if (arrowIcon) arrowIcon.classList.remove('rotate-180');
                            });
                        })
                        .catch(err => {
                            console.error('Log history error:', err);
                            container.innerHTML = `
                                <div class="p-4 rounded-2xl bg-rose-950/40 border border-rose-500/30 text-rose-300 text-center text-xs">
                                    <i class="fa-solid fa-triangle-exclamation mr-1.5"></i> Unable to load activity history at this time.
                                </div>
                            `;
                        });
                });
            });

        });
    </script>
</body>
</html>