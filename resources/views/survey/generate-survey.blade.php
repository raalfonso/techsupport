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
<body class="bg-slate-950 text-slate-100">
    <style>
        * {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;
        }

        .management-shell {
            background:
                radial-gradient(circle at top left, rgba(56, 189, 248, 0.18), transparent 30%),
                radial-gradient(circle at top right, rgba(99, 102, 241, 0.22), transparent 28%),
                linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
        }

        .glass-panel {
            backdrop-filter: blur(18px);
            background: rgba(255, 255, 255, 0.82);
        }
    </style>

    {{-- Include Tailwind CSS --}}
    {{-- Main Navbar --}}
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

                    <a href="{{ route('survey.dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">assignment</i>
                        Survey Result
                    </a>

                     <a href="{{ route('survey.generateSurvey')}}"
                    class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="material-icons align-middle">qr_code</i>
                        QR Generator
                    </a>

                    <a href="{{ route('survey.dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
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

            <button id="mobile-menu-button" class="rounded-full border border-slate-200 bg-white p-2 text-slate-700 shadow-sm md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white md:hidden">
            <div class="mx-auto flex max-w-7xl flex-col gap-1 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('survey.dashboard') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Dashboard</a>
                @if (auth()->user()->role === 'superadmin')
                    <a href="{{ route('survey.management') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">User Management</a>
                @endif
                <a href="{{ route('survey.account') }}" class="rounded-xl px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">Account</a>
                <form method="POST" action="{{ route('userSurvey.logout') }}">
                    @csrf
                    <button type="submit" class="w-full rounded-xl px-3 py-2 text-left text-sm font-medium text-slate-700 hover:bg-slate-100">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @php
        $userDeptId = auth()->user()->department_id;
        $initialDept = $departments->firstWhere('id', $userDeptId);
        $isSuperAdminOrAdmin = auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin';
    @endphp

    <main class="management-shell min-h-screen pt-24">
        <section class="mx-auto max-w-7xl px-4 pb-10 sm:px-6 lg:px-8">
            <div class="glass-panel relative overflow-hidden rounded-3xl border border-white/70 p-6 shadow-[0_20px_60px_rgba(15,23,42,0.08)] sm:p-8">
                <div class="absolute inset-y-0 right-0 hidden w-1/3 bg-gradient-to-l from-sky-200/40 to-transparent lg:block"></div>
                <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                    <div class="max-w-2xl">
                        <p class="mb-3 inline-flex items-center rounded-full border border-sky-200 bg-sky-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-sky-700">Survey Utilities</p>
                        <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Generate Survey Link & QR Code for the Service Provided.</h1>
                        <p class="mt-3 max-w-xl text-sm leading-6 text-slate-600 sm:text-base">Generate shareable feedback URLs and high-quality QR codes for each services.</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('survey.dashboard') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:bg-slate-50">
                            <i class="material-icons text-base">dashboard</i>
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
            <!-- Instructions Card -->
                    <div x-data="{ showInstructions: false }" class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.04)] sm:p-8">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <i class="material-icons text-amber-500">info</i>
                                How to use
                            </h3>
                            <button @click="showInstructions = !showInstructions" class="inline-flex items-center gap-1 text-sm font-semibold text-sky-600 hover:text-sky-700 transition focus:outline-none">
                                <span x-text="showInstructions ? 'See Less' : 'See More'">See More</span>
                                <i class="material-icons text-lg" x-text="showInstructions ? 'expand_less' : 'expand_more'">expand_more</i>
                            </button>
                        </div>
                        <ul x-show="showInstructions" x-transition class="mt-4 space-y-4 text-sm text-slate-600" style="display: none;">
                            <li class="flex items-start gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-700 mt-0.5">1</span>
                                <div>
                                    <strong class="text-slate-800 font-semibold block mb-0.5">Enter Service Provided</strong>
                                    Input the <span class="italic font-medium">Service Provided</span> in the form field.
                                </div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-700 mt-0.5">2</span>
                                <div>
                                    <strong class="text-slate-800 font-semibold block mb-0.5">Generate & Save Code</strong>
                                    Click <span class="font-semibold text-sky-600">Generate & Save New Code</span> to create a tracked survey link and high-quality QR code.
                                </div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-700 mt-0.5">3</span>
                                <div>
                                    <strong class="text-slate-800 font-semibold block mb-0.5">Share or Print QR Code</strong>
                                    Copy the generated URL to share directly via chat/email, or click <span class="font-semibold text-slate-900">Download QR Code (PNG)</span> to print.
                                </div>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-slate-100 text-xs font-bold text-slate-700 mt-0.5">4</span>
                                <div>
                                    <strong class="text-slate-800 font-semibold block mb-0.5">Manage Existing Links</strong>
                                    Use the table at the bottom to monitor counts, toggle statuses (Enable/Disable), or delete links. Click <span class="font-semibold text-slate-700">Showcase</span> on any table row to load its URL and QR Code back into the active preview panel.
                                </div>
                            </li>
                        </ul>
                    </div>
            </div>

            <div class="mt-8 grid gap-8 lg:grid-cols-12">
                <!-- Left panel: Form controls -->
                <div class="lg:col-span-7 flex flex-col gap-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.04)] sm:p-8">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                            <i class="material-icons text-sky-500">settings</i>
                            Generator Settings
                        </h2>
                        
                        <form action="{{ route('survey.generateSurvey.store') }}" method="POST" class="flex flex-col gap-5 mb-6 pb-6 border-b border-slate-100">
                            @csrf
                            <div>
                                <label for="department-select" class="block text-sm font-semibold text-slate-700 mb-2">
                                    @if($isSuperAdminOrAdmin)

                                    Select Department
                                    @else
                                    My Department
                                    @endif
                                </label>
                                @if($isSuperAdminOrAdmin)
                                <select id="department-select" name="department_id" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-slate-800 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 transition-colors">
                                    @foreach($departments as $dept)
                                        @if($isSuperAdminOrAdmin || $dept->id == $userDeptId)
                                            <option value="{{ $dept->id }}" data-acronym="{{ $dept->acronym }}" data-title="{{ $dept->title }}" {{ ($initialDeptId ?? $userDeptId) == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->title }} ({{ $dept->acronym }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @else
                                 <label for="department-select" class="block text-lg font-semibold text-slate-700 mb-2 ml-5">
                                    {{ $initialDept->title }}
                                 </label>
                                 <select id="department-select" name="department_id" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-slate-800 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 transition-colors" style = "display:none;">
                                    @foreach($departments as $dept)
                                        @if($isSuperAdminOrAdmin || $dept->id == $userDeptId)
                                            <option value="{{ $dept->id }}" data-acronym="{{ $dept->acronym }}" data-title="{{ $dept->title }}" {{ ($initialDeptId ?? $userDeptId) == $dept->id ? 'selected' : '' }}>
                                                {{ $dept->title }} ({{ $dept->acronym }})
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @endif
                            </div>
                            
                            <div style="display:none;">
                                <label for="usage-limit-input" class="block text-sm font-semibold text-slate-700 mb-2">Usage Limit (Optional)</label>
                                <input type="number" id="usage-limit-input" name="usage_limit" min="1" placeholder="Leave empty for 1 use" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-slate-800 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 transition-colors" value="1">
                            </div>
                            <div>
                                <label for="client" class="block text-sm font-semibold text-slate-700 mb-2">Service Provided</label>
                                <input type="text" id="client" name="client" placeholder="Enter Service Provided" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3.5 text-slate-800 shadow-sm focus:border-sky-500 focus:outline-none focus:ring-1 focus:ring-sky-500 transition-colors" required autocomplete="off">
                            </div>
                            
                            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-sky-500 hover:bg-sky-600 text-white px-5 py-4 font-semibold transition hover:-translate-y-0.5 shadow-md shadow-sky-500/10">
                                <i class="material-icons">add_link</i>
                                Generate & Save New Code
                            </button>
                        </form>

                        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="material-icons text-indigo-500">link</i>
                            Active Link Details
                        </h2>
                        
                        <div class="flex flex-col gap-5">
                            <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 text-xs flex gap-2" id="untracked-warning" style="display: none;">
                                <i class="material-icons text-base">warning</i>
                                <span>This is a temporary untracked direct link. Generate a saved code to enable count tracking and link management.</span>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Shareable Survey URL</label>
                                <div class="flex gap-2">
                                    <div class="relative flex-1">
                                        <i class="material-icons absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg">link</i>
                                        <input type="text" id="survey-url-input" readonly placeholder="No survey link generated yet" class="block w-full rounded-2xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3.5 text-sm text-slate-600 outline-none focus:border-slate-200" value="">
                                    </div>
                                    <button onclick="copyToClipboard()" class="inline-flex items-center justify-center rounded-2xl bg-sky-500 hover:bg-sky-600 text-white px-5 py-3.5 font-semibold transition hover:-translate-y-0.5 shadow-md shadow-sky-500/10 gap-2 min-w-[120px]" id="copy-btn">
                                        <i class="material-icons text-base" id="copy-btn-icon">content_copy</i>
                                        <span id="copy-btn-text">Copy</span>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-2 flex gap-4">
                                <a id="test-link-btn" href="#" target="_blank" onclick="return checkTestLink(event)" class="inline-flex items-center gap-2 text-sm font-semibold text-sky-600 hover:text-sky-700 transition">
                                    <i class="material-icons text-base">open_in_new</i>
                                    Test Link in New Tab
                                </a>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <!-- Right panel: QR Code Preview -->
                <div class="lg:col-span-5 flex flex-col gap-6">
                    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-[0_20px_60px_rgba(15,23,42,0.04)] sm:p-8 flex flex-col items-center text-center">
                        <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2 self-start">
                            <i class="material-icons text-indigo-500">qr_code_2</i>
                            QR Code Preview
                        </h2>
                        
                        <div class="relative group p-6 bg-slate-50 rounded-2xl border border-slate-100 mb-6 flex flex-col justify-center items-center shadow-inner w-full max-w-[340px] min-h-[280px]" id="qr-container">
                            <div id="qr-preview-overlay" class="absolute inset-0 bg-white/20 opacity-0 group-hover:opacity-100 transition duration-300 rounded-2xl flex items-center justify-center backdrop-blur-[2px]" style="display: none;">
                                <span class="bg-slate-900/80 text-white px-4 py-2 rounded-full text-xs font-medium tracking-wider flex items-center gap-1 shadow-md">
                                    <i class="material-icons text-sm">zoom_in</i> PREVIEW
                                </span>
                            </div>
                            <canvas id="qrcode-canvas" class="rounded-lg bg-white p-3 shadow-sm transition-transform duration-300 group-hover:scale-[1.02]" style="display: none;"></canvas>
                            <div id="qr-placeholder" class="flex flex-col items-center justify-center p-6 text-slate-400 text-center">
                                <i class="material-icons text-5xl mb-2 text-slate-300">qr_code_2</i>
                                <p class="text-xs font-medium text-slate-500">No active QR code generated</p>
                                <p class="text-[11px] text-slate-400 mt-1">Generate a new code or click "Showcase" below to preview.</p>
                            </div>
                        </div> 
                        
                        <h3 id="preview-dept-title" class="text-lg font-bold text-slate-900 mb-1">Select Department</h3>
                        <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold mb-6" id="preview-dept-acronym">DEPT</p>
                        
                        <button onclick="downloadQR()" id="download-qr-btn" class="w-full inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-4 font-semibold text-white shadow-lg shadow-slate-900/25 transition hover:-translate-y-0.5 hover:bg-slate-800 disabled:opacity-50 disabled:cursor-not-allowed">
                            <i class="material-icons">download</i>
                            Download QR Code (PNG)
                        </button>
                    </div>
                </div>
            </div>

            <!-- List of Generated Survey Codes -->
            <div class="mt-8 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_20px_60px_rgba(15,23,42,0.08)]">
                <div class="flex flex-col gap-4 border-b border-slate-200 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Generated Survey Codes & QR Resources</h2>
                        <p class="mt-1 text-sm text-slate-500">Track clicks, toggle link status, and manage department resources.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Department</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Survey Code</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Scan/Click Count</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Date Created</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($generatedSurveys as $survey)
                                <tr class="transition hover:bg-slate-50/80">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-100 text-sky-700 font-bold text-xs uppercase">
                                                {{ $survey->userSurvey->department->acronym ?? 'N/A' }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-slate-900">{{ $survey->userSurvey->department->title ?? 'N/A' }}</p>
                                                <p class="text-xs text-slate-500">Acronym: {{ $survey->userSurvey->department->acronym ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $survey->generated_code }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-1.5">
                                            <span class="inline-flex h-2 w-2 rounded-full {{ $survey->usage_limit !== null && $survey->count >= $survey->usage_limit ? 'bg-rose-500' : 'bg-emerald-500' }}"></span>
                                            <span class="text-sm font-bold text-slate-800">
                                                {{ $survey->count }} / {{ $survey->usage_limit ?? '∞' }} uses
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($survey->usage_limit !== null && $survey->count >= $survey->usage_limit)
                                            <span class="inline-flex items-center rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 ring-1 ring-rose-200">
                                                Limit Reached
                                            </span>
                                        @elseif ($survey->status)
                                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200">
                                                Active
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 ring-1 ring-slate-200">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $survey->created_at ? $survey->created_at->format('M d, Y g:i A') : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <!-- Preview / Showcase Button -->
                                            <button class="inline-flex items-center gap-1 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50" onclick="showcaseSurvey('{{ $survey->generated_code }}', '{{ $survey->userSurvey->department_id ?? '' }}', '{{ $survey->userSurvey->department->title ?? '' }}', '{{ $survey->userSurvey->department->acronym ?? '' }}')">
                                                <i class="material-icons text-sm">visibility</i>
                                                Showcase
                                            </button>

                                            <!-- Toggle Status Form -->
                                            <form action="{{ route('survey.generateSurvey.toggle', $survey->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-full px-3 py-2 text-xs font-semibold text-white shadow-sm transition {{ $survey->status ? 'bg-amber-500 hover:bg-amber-600' : 'bg-emerald-600 hover:bg-emerald-700' }}">
                                                    <i class="material-icons text-sm">{{ $survey->status ? 'block' : 'check_circle' }}</i>
                                                    {{ $survey->status ? 'Disable' : 'Enable' }}
                                                </button>
                                            </form>

                                            <!-- Delete Form -->
                                            @if(auth()->user()->role === 'superadmin')
                                                <form action="{{ route('survey.generateSurvey.destroy', $survey->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center gap-1 rounded-full bg-rose-600 px-3 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-rose-700" onclick="return confirm('Are you sure you want to delete this survey link? This action cannot be undone.')">
                                                        <i class="material-icons text-sm">delete</i>
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center text-sm text-slate-500">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="material-icons text-slate-300 text-4xl">link_off</i>
                                            <span>No tracked survey links generated yet. Select a department above to generate your first link!</span>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($generatedSurveys->total() > 0)
                    <div class="flex flex-col gap-3 border-t border-slate-200 px-6 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-slate-500">Showing {{ $generatedSurveys->firstItem() ?? 0 }} to {{ $generatedSurveys->lastItem() ?? 0 }} of {{ $generatedSurveys->total() }} links</p>
                        @if ($generatedSurveys->hasPages())
                            <div>
                                {{ $generatedSurveys->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>
    </main>

    @if (session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0ea5e9'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0ea5e9'
                });
            });
        </script>
    @endif

    <!-- <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script>
        const baseUrl = "{{ url('survey/form') }}";
        
        @php
            $initialCode = session('generated_code');
            $initialDeptId = session('generated_dept_id');
        @endphp

        // Active code is only set if newly generated in session or showcased
        let activeCode = "{{ $initialCode ?? '' }}";
        let activeDeptId = "{{ $initialDeptId ?? '' }}";

        function generateQRCode() {
            const select = document.getElementById('department-select');
            if (!select || select.selectedIndex === -1) return;
            
            const selectedOption = select.options[select.selectedIndex];
            const deptId = select.value;
            const deptTitle = selectedOption.getAttribute('data-title');
            const deptAcronym = selectedOption.getAttribute('data-acronym');
            
            // Clear active code if user switches department dropdown away from active choice
            if (activeDeptId && activeDeptId != deptId) {
                activeCode = null;
                activeDeptId = null;
            }
            
            const canvas = document.getElementById('qrcode-canvas');
            const placeholder = document.getElementById('qr-placeholder');
            const overlay = document.getElementById('qr-preview-overlay');
            const urlInput = document.getElementById('survey-url-input');
            const testBtn = document.getElementById('test-link-btn');
            const downloadBtn = document.getElementById('download-qr-btn');
            const warningEl = document.getElementById('untracked-warning');
            
            if (warningEl) warningEl.style.display = 'none';
            
            if (activeCode) {
                const surveyUrl = `${baseUrl}?code=${activeCode}`;
                urlInput.value = surveyUrl;
                testBtn.href = surveyUrl;
                testBtn.classList.remove('opacity-50', 'pointer-events-none');
                
                document.getElementById('preview-dept-title').textContent = deptTitle || 'Department';
                document.getElementById('preview-dept-acronym').textContent = deptAcronym || 'DEPT';
                
                canvas.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
                if (overlay) overlay.style.display = 'flex';
                if (downloadBtn) downloadBtn.disabled = false;
                
                QRCode.toCanvas(canvas, surveyUrl, {
                    width: 280,
                    margin: 2,
                    color: {
                        dark: '#0f172a',
                        light: '#ffffff'
                    },
                    errorCorrectionLevel: 'H'
                }, function (error) {
                    if (error) console.error('QR code generation error:', error);
                });
            } else {
                urlInput.value = '';
                testBtn.href = '#';
                testBtn.classList.add('opacity-50', 'pointer-events-none');
                
                document.getElementById('preview-dept-title').textContent = deptTitle || 'Select Department';
                document.getElementById('preview-dept-acronym').textContent = deptAcronym || 'DEPT';
                
                canvas.style.display = 'none';
                if (placeholder) placeholder.style.display = 'flex';
                if (overlay) overlay.style.display = 'none';
                if (downloadBtn) downloadBtn.disabled = true;
            }
        }

        function showcaseSurvey(code, deptId, deptTitle, deptAcronym) {
            activeCode = code;
            activeDeptId = deptId;
            
            const select = document.getElementById('department-select');
            if (select) {
                select.value = deptId;
            }
            
            generateQRCode();
            
            document.getElementById('department-select').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        function checkTestLink(e) {
            if (!activeCode) {
                e.preventDefault();
                Swal.fire({
                    icon: 'info',
                    title: 'No Link Active',
                    text: 'Please generate a new survey code or click "Showcase" on a saved link first.',
                    confirmButtonColor: '#0ea5e9'
                });
                return false;
            }
        }

        document.getElementById('department-select').addEventListener('change', generateQRCode);

        window.addEventListener('DOMContentLoaded', () => {
            generateQRCode();
        });

        function copyToClipboard() {
            const urlInput = document.getElementById('survey-url-input');
            if (!urlInput.value) {
                Swal.fire({
                    icon: 'info',
                    title: 'No Link to Copy',
                    text: 'Please generate a new survey code or click "Showcase" on a saved link first.',
                    confirmButtonColor: '#0ea5e9'
                });
                return;
            }
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(urlInput.value).then(() => {
                const copyBtnText = document.getElementById('copy-btn-text');
                const copyBtnIcon = document.getElementById('copy-btn-icon');
                const copyBtn = document.getElementById('copy-btn');
                
                const originalText = copyBtnText.textContent;
                
                copyBtnText.textContent = 'Copied!';
                copyBtnIcon.textContent = 'done';
                copyBtn.classList.remove('bg-sky-500', 'hover:bg-sky-600');
                copyBtn.classList.add('bg-emerald-500', 'hover:bg-emerald-600');
                
                setTimeout(() => {
                    copyBtnText.textContent = originalText;
                    copyBtnIcon.textContent = 'content_copy';
                    copyBtn.classList.remove('bg-emerald-500', 'hover:bg-emerald-600');
                    copyBtn.classList.add('bg-sky-500', 'hover:bg-sky-600');
                }, 2000);
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }

        function downloadQR() {
            if (!activeCode) {
                Swal.fire({
                    icon: 'info',
                    title: 'No QR Code',
                    text: 'Please generate a new survey code or click "Showcase" on a saved link first.',
                    confirmButtonColor: '#0ea5e9'
                });
                return;
            }
            const select = document.getElementById('department-select');
            const acronym = select.options[select.selectedIndex].getAttribute('data-acronym') || 'dept';
            const canvas = document.getElementById('qrcode-canvas');
            
            const link = document.createElement('a');
            link.download = `${acronym.toLowerCase()}-survey-qr.png`;
            link.href = canvas.toDataURL('image/png');
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>
</html>