<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎄 Issues Reported - {{ env('APP_NAME', 'IT Department') }}</title>
    <script>
        // Run as early as possible to avoid screen flash
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@700;800&family=Luckiest+Guy&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        html {
            scrollbar-width: thin;
            scrollbar-color: #b91c1c #092218;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: url('{{ asset('images/Gemini_Generated_Image_wu23jowu23jowu23.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }

        /* 3D Gingerbread / Golden Holiday Title Font */
        .font-holiday-title {
            font-family: 'Luckiest Guy', 'Fredoka', cursive;
            letter-spacing: 0.04em;
            background: linear-gradient(180deg, #fff3b0 0%, #fbbf24 45%, #ea580c 90%, #b45309 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            filter: drop-shadow(0 3px 0 #451a03) drop-shadow(0 5px 10px rgba(0, 0, 0, 0.75));
        }

        /* Header Banner Dark Evergreen Frame */
        .yuletide-header-banner {
            background: linear-gradient(180deg, rgba(10, 38, 25, 0.92) 0%, rgba(7, 26, 18, 0.95) 100%);
            border: 2px solid rgba(180, 138, 68, 0.65);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.7), inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        /* Wooden Holiday Buttons (Theme / Enable Sound) */
        .wooden-holiday-btn {
            background: linear-gradient(180deg, #7c4a2b 0%, #5a3219 55%, #432310 100%);
            border: 2px solid #d49b54;
            color: #fef3c7;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.65), inset 0 1px 1px rgba(255, 235, 180, 0.35);
        }
        .wooden-holiday-btn:hover {
            background: linear-gradient(180deg, #8d5533 0%, #693b1e 55%, #4f2a13 100%);
            border-color: #fbbf24;
        }
        .wooden-holiday-btn-active {
            background: linear-gradient(180deg, #166534 0%, #14532d 60%, #052e16 100%);
            border: 2px solid #86efac;
            color: #ecfdf5;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.65), 0 0 15px rgba(34, 197, 94, 0.4);
        }

        /* Card Themes: Deep Forest Green & Deep Winter Navy */
        .yuletide-card-green {
            background: linear-gradient(180deg, rgba(11, 39, 26, 0.94) 0%, rgba(7, 25, 17, 0.96) 100%);
        }
        .yuletide-card-navy {
            background: linear-gradient(180deg, rgba(11, 24, 46, 0.94) 0%, rgba(7, 16, 34, 0.96) 100%);
        }

        /* Candy Cane Side Borders on Cards */
        .candy-cane-rail-left,
        .candy-cane-rail-right {
            position: absolute;
            top: 22px;
            bottom: 18px;
            width: 5px;
            z-index: 20;
            border-radius: 999px;
            background: repeating-linear-gradient(
                -45deg,
                #dc2626 0px,
                #dc2626 7px,
                #ffffff 7px,
                #ffffff 14px
            );
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.6);
        }
        .candy-cane-rail-left { left: 0; }
        .candy-cane-rail-right { right: 0; }

        /* Alert Blink Animations */
        @keyframes blinkRed {
            0%, 100% { 
                border-color: #ef4444; 
                box-shadow: 0 0 18px rgba(239, 68, 68, 0.8), inset 0 0 12px rgba(239, 68, 68, 0.35); 
            }
            50% { 
                border-color: #b91c1c; 
                box-shadow: 0 0 32px rgba(239, 68, 68, 1), inset 0 0 22px rgba(185, 28, 28, 0.65); 
            }
        }
        @keyframes blinkYellow {
            0%, 100% { 
                border-color: #f59e0b; 
                box-shadow: 0 0 18px rgba(245, 158, 11, 0.8), inset 0 0 12px rgba(245, 158, 11, 0.35); 
            }
            50% { 
                border-color: #d97706; 
                box-shadow: 0 0 32px rgba(245, 158, 11, 1), inset 0 0 22px rgba(217, 119, 6, 0.65); 
            }
        }
        .blink-red {
            animation: blinkRed 1s infinite !important;
        }
        .blink-yellow {
            animation: blinkYellow 1s infinite !important;
        }

        .yuletide-card-shadow {
            box-shadow: 0 16px 36px -6px rgba(0, 0, 0, 0.82), 0 0 18px -2px rgba(16, 185, 129, 0.18);
        }
        .yuletide-card-shadow:hover {
            box-shadow: 0 20px 42px -4px rgba(0, 0, 0, 0.9), 0 0 24px 2px rgba(251, 191, 36, 0.32);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const notificationSound = new Audio('{{ asset('sounds/387533__soundwarf__alert-short.wav') }}');
        const alertSound = new Audio('{{ asset('sounds/cartoon_music-cheerful-orchestra-christmas-transition-jingle-558676.mp3') }}');
        notificationSound.loop = true;
        let isPlaying = false;
        
        // Track reports in a Set of IDs to handle empty state and multiple reports correctly
        let existingTickets = new Set();
        let soundEnabled = false;

        async function playAlert(times = 1) {
            if (!soundEnabled) return;
            for (let i = 0; i < times; i++) {
                alertSound.currentTime = 0;

                try {
                    await alertSound.play();

                    await new Promise(resolve => {
                        alertSound.onended = resolve;
                    });

                } catch (e) {
                    console.error("Alert sound play failed:", e);
                    break;
                }
            }
        }

        function loadReports() {
            $.ajax({
                url: '{{ route('report.public') }}',
                type: 'GET',
                success: function(response) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');

                    // Check if there are any new tickets in the response
                    let hasNewTicket = false;
                    const newCards = doc.querySelectorAll('.report-card');
                    newCards.forEach(card => {
                        const reportId = card.dataset.reportId;
                        const status = card.dataset.reportStatus;
                        // It is a new ticket if it's not in the existing set AND its status is Pending
                        if (!existingTickets.has(reportId) && status === 'Pending') {
                            hasNewTicket = true;
                        }
                    });

                    // Rebuild the existingTickets set with the new IDs
                    existingTickets.clear();
                    newCards.forEach(card => {
                        existingTickets.add(card.dataset.reportId);
                    });

                    if (hasNewTicket) {
                        playAlert(1);
                    }

                    const newGrid = doc.querySelector('.grid');
                    if (newGrid) {
                        $('.grid').html(newGrid.innerHTML);
                    }

                    checkOldReports();
                }
            });
        }

        function checkOldReports() {
            let hasOldPending = false;
            
            document.querySelectorAll('.report-card').forEach(card => {
                const reportTime = new Date(card.dataset.reportTime);
                const reportStatus = card.dataset.reportStatus;
                const now = new Date();
                const diffMinutes = (now - reportTime) / 1000 / 60;

                card.classList.remove('blink-red', 'blink-yellow');

                if (reportStatus === 'Pending') {
                    if (diffMinutes > 3 && diffMinutes < 5) {
                        card.classList.add('blink-yellow');
                    } else if (diffMinutes > 5) {
                        card.classList.add('blink-red');
                        hasOldPending = true;
                    }
                }
            });
            
            if (hasOldPending && !isPlaying && soundEnabled) {
                notificationSound.play().catch(e => console.log('Audio play failed:', e));
                isPlaying = true;
            } else if ((!hasOldPending || !soundEnabled) && isPlaying) {
                notificationSound.pause();
                notificationSound.currentTime = 0;
                isPlaying = false;
            }
        }

        function updateSoundUI() {
            const btn = document.getElementById('sound-toggle');
            const icon = document.getElementById('sound-icon');
            const text = document.getElementById('sound-text');
            if (!btn || !icon || !text) return;
            
            if (soundEnabled) {
                btn.className = "wooden-holiday-btn-active relative flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold transition-all duration-300 cursor-pointer";
                icon.textContent = 'volume_up';
                text.textContent = 'Sound Active 🔔';
            } else {
                btn.className = "wooden-holiday-btn relative flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold transition-all duration-300 cursor-pointer";
                icon.textContent = 'volume_off';
                text.textContent = 'Enable Sound 🔔';
            }
        }

        function toggleSound() {
            if (!soundEnabled) {
                // Try playing and pausing sounds to unlock them
                alertSound.play().then(() => {
                    alertSound.pause();
                    alertSound.currentTime = 0;
                    soundEnabled = true;
                    updateSoundUI();
                    checkOldReports();
                }).catch(err => {
                    console.error("Failed to enable audio:", err);
                });
                
                notificationSound.play().then(() => {
                    notificationSound.pause();
                    notificationSound.currentTime = 0;
                }).catch(err => {});
            } else {
                soundEnabled = false;
                updateSoundUI();
                alertSound.pause();
                alertSound.currentTime = 0;
                notificationSound.pause();
                notificationSound.currentTime = 0;
                isPlaying = false;
            }
        }

        function checkAutoplay() {
            alertSound.play().then(() => {
                alertSound.pause();
                alertSound.currentTime = 0;
                soundEnabled = true;
                updateSoundUI();
                checkOldReports();
            }).catch(err => {
                console.log("Autoplay is blocked by browser. User interaction required to enable sound.");
                soundEnabled = false;
                updateSoundUI();
            });
        }
        
        function toggleTheme() {
            const html = document.documentElement;
            const themeToggleIcon = document.getElementById('theme-icon');
            
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.theme = 'light';
                if (themeToggleIcon) themeToggleIcon.textContent = 'dark_mode';
            } else {
                html.classList.add('dark');
                localStorage.theme = 'dark';
                if (themeToggleIcon) themeToggleIcon.textContent = 'light_mode';
            }
        }

        function updateThemeUI() {
            const themeToggleIcon = document.getElementById('theme-icon');
            if (!themeToggleIcon) return;
            if (document.documentElement.classList.contains('dark')) {
                themeToggleIcon.textContent = 'light_mode';
            } else {
                themeToggleIcon.textContent = 'dark_mode';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Populate initial set of reports
            document.querySelectorAll('.report-card').forEach(card => {
                existingTickets.add(card.dataset.reportId);
            });

            updateThemeUI();
            checkAutoplay();
            setInterval(loadReports, 5000);

            function updateDateTime() {
                const now = new Date();
                const options = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric', 
                    hour: '2-digit', 
                    minute: '2-digit', 
                    second: '2-digit' 
                };
                document.getElementById('current-datetime').textContent = now.toLocaleDateString('en-US', options);
            }
            
            updateDateTime();
            setInterval(updateDateTime, 1000);
        });
    </script>
</head>
<body class="text-slate-100 font-display transition-colors duration-300 min-h-screen">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden bg-black/15">
        <div class="layout-container flex h-full grow flex-col">
            <main class="flex flex-1 justify-center py-6 sm:py-8">
                <div class="layout-content-container flex flex-col max-w-auto flex-1 px-4 sm:px-8">
                    
                    <!-- Page Title and Actions Header Bar -->
                    <div class="yuletide-header-banner flex flex-wrap justify-between items-center gap-4 mb-9 px-6 py-5 rounded-2xl relative overflow-visible">
                        
                        <!-- Snow Cap & Icicles on Top-Left of Header -->
                        <svg class="pointer-events-none absolute -top-3.5 left-3 w-72 sm:w-96 h-10 z-20 drop-shadow-md" viewBox="0 0 400 45" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                            <path d="M5 18 C20 4, 65 2, 110 8 C160 2, 220 4, 280 9 C330 4, 375 6, 395 16 C398 20, 390 24, 375 23 L370 36 L364 22 L350 22 L346 40 L340 22 C310 25, 260 20, 220 23 L215 35 L210 22 C160 24, 110 20, 65 23 L60 39 L53 23 L42 33 L36 22 C20 23, 8 22, 5 18 Z" fill="url(#headerSnowGrad)"/>
                            <defs>
                                <linearGradient id="headerSnowGrad" x1="0" y1="0" x2="0" y2="1">
                                    <stop offset="0%" stop-color="#ffffff"/>
                                    <stop offset="70%" stop-color="#e2e8f0"/>
                                    <stop offset="100%" stop-color="#bae6fd"/>
                                </linearGradient>
                            </defs>
                        </svg>

                        <!-- Holly & Berries Corner Accents on Header -->
                        <div class="pointer-events-none absolute -top-2 -left-2 z-30 text-2xl select-none drop-shadow">🌿🍒</div>
                        <div class="pointer-events-none absolute -bottom-2 left-6 z-30 text-xl select-none opacity-80">❄️</div>

                        <div class="flex flex-col gap-1.5 z-10 pt-1">
                            <div class="flex items-center gap-2.5 sm:gap-3">
                                <span class="text-3xl sm:text-4xl drop-shadow-[0_3px_6px_rgba(0,0,0,0.7)]">🎁</span>
                                <h1 class="font-holiday-title text-2xl sm:text-4xl lg:text-[42px] font-extrabold uppercase tracking-wide leading-none pt-1">
                                    ACTIVE ISSUES REPORTED
                                </h1>
                                <span class="text-3xl sm:text-4xl drop-shadow-[0_3px_6px_rgba(0,0,0,0.7)] hidden sm:inline">🎅</span>
                            </div>
                            <div class="flex flex-wrap items-center gap-2.5 text-amber-50/95 text-xs sm:text-sm font-medium pl-1">
                                <span>🕯️</span>
                                <span id="current-datetime" class="drop-shadow"></span>
                                <span class="inline-flex items-center gap-1.5 text-xs sm:text-sm text-amber-300 bg-gradient-to-b from-red-700 via-red-800 to-red-950 border border-amber-400/80 px-3.5 py-0.5 rounded-full ml-1 font-bold shadow-[0_2px_10px_rgba(0,0,0,0.6)]">
                                    <span>🎄</span>
                                    <span>Yuletide Special</span>
                                    <span>🎄</span>
                                </span>
                            </div>
                        </div>
                        
                        <!-- Right Action Buttons with Snow Caps & Santa Hat -->
                        <div class="flex gap-4 z-10 items-center pt-2 sm:pt-0">
                            <!-- Theme Button -->
                            <div class="relative">
                                <!-- Snow cap on button -->
                                <span class="pointer-events-none absolute -top-2 left-2 right-2 h-2.5 bg-gradient-to-b from-white to-sky-100 rounded-full shadow-sm z-20"></span>
                                <span class="pointer-events-none absolute -top-3.5 -left-2 text-xl z-30 -rotate-12 select-none drop-shadow">🎅</span>
                                <button id="theme-toggle" onclick="toggleTheme()" class="wooden-holiday-btn relative flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold transition-all duration-300 cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px] text-amber-200" id="theme-icon">dark_mode</span>
                                    <span class="text-sm">Theme</span>
                                </button>
                            </div>

                            <!-- Enable Sound Button -->
                            <div class="relative">
                                <!-- Gift & Snow cap on button -->
                                <span class="pointer-events-none absolute -top-4 left-1/2 -translate-x-1/2 text-lg z-30 select-none drop-shadow">🎁</span>
                                <span class="pointer-events-none absolute -top-2 left-2 right-2 h-2.5 bg-gradient-to-b from-white to-sky-100 rounded-full shadow-sm z-20"></span>
                                <span class="pointer-events-none absolute -top-3.5 -right-2 text-xl z-30 rotate-12 select-none drop-shadow">🎅</span>
                                <button id="sound-toggle" onclick="toggleSound()" class="wooden-holiday-btn relative flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold transition-all duration-300 cursor-pointer">
                                    <span class="material-symbols-outlined text-[18px] text-amber-300" id="sound-icon">volume_off</span>
                                    <span id="sound-text" class="text-sm">Enable Sound 🔔</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Issues Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4 gap-6 pt-2">
                    @forelse($reports as $index => $report)
                        @php
                            $loc = strtolower(trim($report->location ?? 'btc'));
                            if ($loc === '') {
                                $loc = 'btc';
                            }

                            // Alternate card base between deep evergreen and deep winter navy like the reference image
                            $cardSurfaceClass = ($index % 4 < 2) ? 'yuletide-card-green' : 'yuletide-card-navy';
                        @endphp
        
                        <div class="relative flex flex-col {{ $cardSurfaceClass }} backdrop-blur-md rounded-2xl border border-amber-500/40 hover:border-amber-300/80 yuletide-card-shadow transition-all duration-300 report-card overflow-visible {{ $report->status == 'Done' ? 'opacity-65 grayscale-[0.6]' : '' }}" data-report-id="{{ $report->id }}" data-report-time="{{ $report->request_datetime }}" data-report-status="{{ $report->status }}">
                            
                            <!-- Top Snow Drift & Hanging Icicles SVG Overlay -->
                            <svg class="pointer-events-none absolute -top-3.5 left-0 right-0 w-full h-11 z-20 drop-shadow-[0_3px_4px_rgba(0,0,0,0.5)]" viewBox="0 0 360 44" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                                <path d="M4 16 C18 3, 55 2, 95 7 C140 2, 195 1, 245 7 C290 2, 335 3, 356 15 C359 19, 355 23, 346 22 L343 35 L338 22 L329 31 L325 21 C305 22, 285 20, 268 22 L264 38 L259 22 L251 32 L247 21 C215 22, 175 19, 145 21 L141 34 L136 21 C105 22, 72 20, 46 22 L42 37 L37 22 L28 31 L24 21 C12 22, 5 20, 4 16 Z" fill="url(#cardSnowGrad-{{ $report->id }})"/>
                                <defs>
                                    <linearGradient id="cardSnowGrad-{{ $report->id }}" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#ffffff"/>
                                        <stop offset="65%" stop-color="#e2e8f0"/>
                                        <stop offset="100%" stop-color="#bae6fd"/>
                                    </linearGradient>
                                </defs>
                            </svg>

                            <!-- Candy Cane Left & Right Side Stripes -->
                            <div class="candy-cane-rail-left"></div>
                            <div class="candy-cane-rail-right"></div>

                            <!-- Top & Bottom Corner Holly & Pine Accents -->
                            <div class="pointer-events-none absolute -top-2 -left-1.5 z-30 text-lg select-none drop-shadow">🌿🍒</div>
                            <div class="pointer-events-none absolute -top-2 -right-1.5 z-30 text-lg select-none drop-shadow">🍒🌿</div>
                            <div class="pointer-events-none absolute -bottom-2.5 -left-1.5 z-30 text-lg select-none drop-shadow">🌿🍒</div>
                            <div class="pointer-events-none absolute -bottom-2.5 -right-1.5 z-30 text-lg select-none drop-shadow">🍒🌿</div>

                            <div class="p-5 pt-6 flex flex-col gap-3.5 flex-1 justify-between z-10">
                                <div class="flex flex-col gap-3.5">
                                    <!-- Ticket Number & Snowy Status Pill -->
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex flex-col gap-0.5">
                                            <p class="text-amber-300/95 text-[11px] font-extrabold uppercase tracking-wider flex items-center gap-1.5">
                                                <span>🎁</span> TICKET NUMBER
                                            </p>
                                            <p class="text-white text-lg font-extrabold tracking-tight leading-snug drop-shadow-[0_2px_4px_rgba(0,0,0,0.8)]">
                                                {{ $report->ticket_number }}
                                            </p>
                                        </div>

                                        <!-- Cream / Snowy Parchment Status Pill with Icicles -->
                                        <div class="relative flex-shrink-0">
                                            @if($report->status == 'Pending')
                                                <span class="bg-gradient-to-b from-[#fffbeb] to-[#fde68a] text-red-900 border-2 border-amber-500 px-3.5 py-1 rounded-full text-xs font-extrabold flex items-center gap-1.5 shadow-[0_4px_10px_rgba(0,0,0,0.5)] animate-pulse">
                                                    <span class="size-2 bg-red-600 rounded-full"></span> Pending
                                                </span>
                                            @elseif($report->status == 'Ongoing')
                                                <span class="bg-gradient-to-b from-[#fffbeb] to-[#fde68a] text-amber-950 border-2 border-amber-500 px-3.5 py-1 rounded-full text-xs font-extrabold flex items-center gap-1.5 shadow-[0_4px_10px_rgba(0,0,0,0.5)]">
                                                    <span class="size-2 bg-amber-600 rounded-full"></span> Ongoing
                                                </span>
                                            @elseif($report->status == 'For Validation')
                                                <span class="bg-gradient-to-b from-[#fffef7] to-[#f5ead2] text-stone-800 border-2 border-amber-600/60 px-3.5 py-1 rounded-full text-xs font-extrabold flex items-center gap-1.5 shadow-[0_4px_10px_rgba(0,0,0,0.5)]">
                                                    <span class="size-1.5 bg-amber-700 rounded-full"></span> For validation
                                                </span>
                                            @elseif($report->status == 'Done')
                                                <span class="bg-gradient-to-b from-[#ecfdf5] to-[#a7f3d0] text-emerald-950 border-2 border-emerald-500 px-3.5 py-1 rounded-full text-xs font-extrabold flex items-center gap-1.5 shadow-[0_4px_10px_rgba(0,0,0,0.5)]">
                                                    <span class="size-2 bg-emerald-600 rounded-full"></span> Resolved
                                                </span>
                                            @else
                                                <span class="bg-gradient-to-b from-[#fffef7] to-[#f5ead2] text-stone-800 border-2 border-amber-600/60 px-3.5 py-1 rounded-full text-xs font-extrabold flex items-center gap-1.5 shadow-md">
                                                    <span class="size-1.5 bg-stone-600 rounded-full"></span> {{ $report->status }}
                                                </span>
                                            @endif
                                            <!-- Mini Icicles under Status Pill -->
                                            <svg class="pointer-events-none absolute -bottom-2.5 left-2 right-2 w-4/5 h-3 opacity-90" viewBox="0 0 100 14" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                                                <path d="M5 0 L9 11 L13 0 L24 0 L27 13 L31 0 L48 0 L52 10 L56 0 L72 0 L76 13 L80 0 L88 8 L92 0 Z" fill="#e0f2fe"/>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- Priority & Location Badges Row -->
                                    <div class="flex flex-wrap gap-2 items-center pt-1">
                                        <!-- Priority Badge (Green Holly Pill for Low, Gold for Medium, Crimson for High) -->
                                        @if($report->issues->category->title == 'High')
                                            <span class="bg-gradient-to-b from-red-600 to-red-800 text-white border border-red-300/60 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-md">
                                                <span>🍒</span> Priority: High
                                            </span>
                                        @elseif($report->issues->category->title == 'Medium')
                                            <span class="bg-gradient-to-b from-amber-600 to-amber-800 text-white border border-amber-300/60 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-md">
                                                <span>🔔</span> Priority: Medium
                                            </span>
                                        @elseif($report->issues->category->title == 'Low')
                                            <span class="bg-gradient-to-b from-[#1f6f3e] to-[#134626] text-white border border-emerald-300/50 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-md">
                                                <span>🍒</span> Priority: Low
                                            </span>
                                        @endif

                                        <!-- Location Badge (Crimson Stocking Pill) -->
                                        <span class="bg-gradient-to-b from-[#a82020] to-[#6e1212] text-white border border-red-300/50 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-md">
                                            <span>🧦</span> Location: {{ !empty(trim($report->location ?? '')) ? $report->location : 'BTC' }}
                                        </span>
                                    </div>

                                    <!-- Issue Title, Client, Department -->
                                    <div class="flex flex-col gap-1.5 pt-0.5">
                                        <p class="text-white font-bold text-base leading-snug line-clamp-2">{{ $report->issues->title ?? 'N/A' }}</p>
                                        <div class="flex flex-col gap-1.5 mt-1">
                                            <div class="flex items-center gap-2 text-amber-50">
                                                <span class="text-sm">🎄</span>
                                                <p class="text-sm font-semibold">{{ $report->client->name ?? 'N/A' }}</p>
                                            </div>
                                            <div class="flex items-center gap-2 text-slate-300/90">
                                                <span class="text-sm">🎁</span>
                                                <p class="text-xs font-medium">{{ $report->department->title ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        
                                        <!-- Responded By Warm Bronze Box -->
                                        @if($report->status != 'Pending')
                                            <div class="flex flex-col gap-0.5 mt-2">
                                                <div class="flex items-center gap-1.5 text-amber-200 bg-[#3d2516]/85 px-3 py-1.5 rounded-lg border border-amber-500/45 text-xs shadow-inner">
                                                    <span>📜 <span class="text-amber-300/95 font-medium">Responded by:</span></span>
                                                    <span class="text-white font-bold truncate">{{ $report->response->name ?? 'N/A' }}</span>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Remarks Section -->
                                        @if($report->remarks)
                                            <div class="flex flex-col gap-1.5 mt-2 pt-2.5 border-t border-white/15">
                                                <p class="text-amber-200/90 text-[10px] font-extrabold uppercase tracking-wider flex items-center gap-1">
                                                    <span>🌿</span> REMARKS
                                                </p>
                                                <div class="bg-[#23383e]/75 p-2.5 rounded-lg border border-white/20 text-slate-100 text-xs leading-relaxed shadow-inner">
                                                    {{ $report->remarks }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <!-- Footer Timestamp -->
                                <div class="flex items-center justify-between pt-2.5 border-t border-white/15 mt-1">
                                    <div class="flex items-center gap-1.5 text-amber-100/90 text-xs font-medium">
                                        <span class="material-symbols-outlined text-[16px] text-amber-200">schedule</span>
                                        <span>{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <span class="text-xs select-none opacity-80">🔔</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="yuletide-card-green backdrop-blur-md border-2 border-amber-400/50 rounded-2xl yuletide-card-shadow p-14 text-center relative overflow-hidden">
                                <span class="text-6xl mb-4 block animate-bounce">🎄</span>
                                <p class="font-holiday-title text-3xl sm:text-4xl font-bold tracking-wide mb-2 uppercase">Silent Night, All Systems Bright!</p>
                                <p class="text-amber-100/90 text-sm">All tickets are wrapped up — there are currently no active issues reported!</p>
                            </div>
                        </div>
                    @endforelse
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
</html>
