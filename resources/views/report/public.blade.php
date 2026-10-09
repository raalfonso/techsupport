<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🎃 Issues Reported - {{ env('APP_NAME', 'IT Department') }}</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Creepster&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: url('{{ asset('images/IqFEa1XlYDpZOiDqD3GsYBP1JjGCAD31Q7hDM7dzCvxm-VHfXNkX__SdEJH8vbt2hw-ZRLmAyujQy3JoxBedByV7rw64gv-Bkpa6PRgKweuzAa2ZafjX6kr33YYpidzE-TfK9n5_86bxP6_VChzDZx06bY1kqcYHGH9XgNf6BaV12YqByYlhbcgLh0oUGORt.jpg') }}') no-repeat center center fixed;
            background-size: cover;
        }
        .font-spooky {
            font-family: 'Creepster', cursive;
            letter-spacing: 0.05em;
        }
        @keyframes blinkRed {
            0%, 100% { 
                border-color: #ef4444; 
                box-shadow: 0 0 15px rgba(239, 68, 68, 0.75), inset 0 0 10px rgba(239, 68, 68, 0.35); 
            }
            50% { 
                border-color: #b91c1c; 
                box-shadow: 0 0 30px rgba(239, 68, 68, 1), inset 0 0 20px rgba(185, 28, 28, 0.6); 
            }
        }
        @keyframes blinkYellow {
            0%, 100% { 
                border-color: #f59e0b; 
                box-shadow: 0 0 15px rgba(245, 158, 11, 0.75), inset 0 0 10px rgba(245, 158, 11, 0.35); 
            }
            50% { 
                border-color: #d97706; 
                box-shadow: 0 0 30px rgba(245, 158, 11, 1), inset 0 0 20px rgba(217, 119, 6, 0.6); 
            }
        }
        .blink-red {
            animation: blinkRed 1s infinite !important;
        }
        .blink-yellow {
            animation: blinkYellow 1s infinite !important;
        }
        @keyframes floatBat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-7px) rotate(-4deg); }
        }
        .animate-float-bat {
            animation: floatBat 3.5s ease-in-out infinite;
        }
        .halloween-card-glow {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.7), 0 0 15px -2px rgba(249, 115, 22, 0.2);
        }
        .halloween-card-glow:hover {
            box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.8), 0 0 22px 2px rgba(249, 115, 22, 0.45);
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const notificationSound = new Audio('{{ asset('sounds/387533__soundwarf__alert-short.wav') }}');
        const alertSound = new Audio('{{ asset('sounds/WITCH_LAUGH.mp3') }}');
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
                btn.className = "flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-md transition-all duration-300 border bg-emerald-950/80 text-emerald-300 border-emerald-500/60 shadow-[0_0_15px_rgba(16,185,129,0.3)] cursor-pointer";
                icon.textContent = 'volume_up';
                text.textContent = 'Sound Active 🎃';
            } else {
                btn.className = "flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-md transition-all duration-300 border bg-orange-950/80 text-orange-300 border-orange-500/60 animate-pulse shadow-[0_0_15px_rgba(249,115,22,0.3)] cursor-pointer";
                icon.textContent = 'volume_off';
                text.textContent = 'Enable Sound 🎃';
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
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden bg-slate-950/40 backdrop-blur-[0.5px]">
        <div class="layout-container flex h-full grow flex-col">
            <main class="flex flex-1 justify-center py-8">
                <div class="layout-content-container flex flex-col max-w-auto flex-1 px-4 sm:px-10">
                    
                    <!-- Page Title and Actions Header Bar -->
                    <div class="flex flex-wrap justify-between items-center gap-4 mb-8 bg-slate-950/85 dark:bg-slate-950/90 backdrop-blur-md p-6 rounded-2xl border border-orange-500/40 shadow-[0_0_25px_rgba(249,115,22,0.25)] relative overflow-hidden">
                        <!-- Spooky accents in background -->
                        <div class="absolute -right-4 -bottom-4 text-7xl select-none opacity-20 pointer-events-none animate-float-bat">🦇</div>
                        <div class="absolute -left-3 -top-3 text-5xl select-none opacity-20 pointer-events-none">🕸️</div>

                        <div class="flex flex-col gap-1.5 z-10">
                            <div class="flex items-center gap-3">
                                <span class="text-3xl sm:text-4xl animate-bounce">🎃</span>
                                <h1 class="font-spooky text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-amber-300 to-orange-500 text-3xl sm:text-5xl font-bold tracking-wider drop-shadow-[0_2px_12px_rgba(249,115,22,0.8)]">Active Issues Reported</h1>
                                <span class="text-3xl animate-float-bat hidden sm:inline">🦇</span>
                            </div>
                            <div class="flex items-center gap-2 text-orange-200/90 text-sm font-medium">
                                <span>🕯️</span>
                                <span id="current-datetime"></span>
                                <span class="text-xs text-orange-400/90 bg-orange-950/80 border border-orange-500/40 px-2.5 py-0.5 rounded-full ml-1">Spooky Edition 👻</span>
                            </div>
                        </div>
                        
                        <div class="flex gap-3 z-10 items-center">
                            <button id="theme-toggle" onclick="toggleTheme()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 border bg-purple-950/70 text-purple-200 border-purple-500/40 hover:border-purple-400 hover:bg-purple-900/80 cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]" id="theme-icon">dark_mode</span>
                                <span class="text-sm hidden sm:inline">Theme</span>
                            </button>
                            <button id="sound-toggle" onclick="toggleSound()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-md hover:shadow-lg transition-all duration-300 border bg-orange-950/80 text-orange-300 border-orange-500/60 animate-pulse cursor-pointer">
                                <span class="material-symbols-outlined text-[20px]" id="sound-icon">volume_off</span>
                                <span id="sound-text" class="text-sm">Enable Sound 🎃</span>
                            </button>
                        </div>
                    </div>

                    <!-- Issues Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 gap-6">
                    @forelse($reports as $report)
                        @php
                            $loc = strtolower(trim($report->location ?? 'btc'));
                            if ($loc === '') {
                                $loc = 'btc';
                            }

                            if ($loc === 'btc') {
                                $cardBorderClass = 'border-t-4 border-t-orange-500';
                                $badgeClass = 'bg-orange-950/80 text-orange-300 border border-orange-500/50 shadow-sm';
                            } else {
                                $cardBorderClass = 'border-t-4 border-t-purple-500';
                                $badgeClass = 'bg-purple-950/80 text-purple-300 border border-purple-500/50 shadow-sm';
                            }
                        @endphp
        
                        <div class="flex flex-col bg-slate-950/85 dark:bg-slate-950/90 backdrop-blur-md rounded-2xl border border-orange-500/30 hover:border-orange-500/70 {{ $cardBorderClass }} halloween-card-glow transition-all duration-300 report-card {{ $report->status == 'Done' ? 'opacity-65 grayscale-[0.6]' : '' }}" data-report-id="{{ $report->id }}" data-report-time="{{ $report->request_datetime }}" data-report-status="{{ $report->status }}">
                            <div class="p-5 flex flex-col gap-4">
                                <div class="flex justify-between items-start">
                                    <div class="flex flex-col gap-0.5">
                                        <p class="text-orange-400/90 text-xs font-bold uppercase tracking-wider flex items-center gap-1">
                                            <span>📜</span> Ticket Number
                                        </p>
                                        <p class="text-orange-100 text-lg font-black tracking-tight drop-shadow-[0_1px_4px_rgba(0,0,0,0.8)]">{{ $report->ticket_number }}</p>
                                    </div>
                                    @if($report->status == 'Pending')
                                        <span class="bg-orange-950/90 text-orange-300 border border-orange-500/70 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 shadow-[0_0_10px_rgba(249,115,22,0.4)] animate-pulse">
                                            <span>🎃</span> Pending
                                        </span>
                                    @elseif($report->status == 'Ongoing')
                                        <span class="bg-purple-950/90 text-purple-300 border border-purple-500/70 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 shadow-[0_0_10px_rgba(168,85,247,0.4)]">
                                            <span>⚡</span> Ongoing
                                        </span>
                                    @elseif($report->status == 'For Validation')
                                        <span class="bg-indigo-950/90 text-indigo-300 border border-indigo-500/70 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 shadow-[0_0_10px_rgba(99,102,241,0.4)]">
                                            <span>🧪</span> For Validation
                                        </span>
                                    @elseif($report->status == 'Done')
                                        <span class="bg-emerald-950/90 text-emerald-300 border border-emerald-500/70 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 shadow-[0_0_10px_rgba(16,185,129,0.3)]">
                                            <span>👻</span> Resolved
                                        </span>
                                    @else
                                        <span class="bg-slate-900 text-slate-300 border border-slate-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                            <span class="size-2 bg-slate-500 rounded-full"></span> {{ $report->status }}
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Badges Section -->
                                <div class="flex flex-wrap gap-2 items-center">
                                    <!-- Priority Badge -->
                                    @if($report->issues->category->title == 'High')
                                        <span class="bg-red-950/80 text-red-300 border border-red-500/60 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-[0_0_8px_rgba(239,68,68,0.4)]">
                                            <span>🔥</span> Priority: High
                                        </span>
                                    @elseif($report->issues->category->title == 'Medium')
                                        <span class="bg-amber-950/80 text-amber-300 border border-amber-500/60 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-[0_0_8px_rgba(245,158,11,0.4)]">
                                            <span>🎃</span> Priority: Medium
                                        </span>
                                    @elseif($report->issues->category->title == 'Low')
                                        <span class="bg-lime-950/80 text-lime-300 border border-lime-500/60 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 shadow-[0_0_8px_rgba(132,204,22,0.4)]">
                                            <span>🦇</span> Priority: Low
                                        </span>
                                    @endif

                                    <!-- Location Badge -->
                                    <span class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1 {{ $badgeClass }}">
                                        <span class="material-symbols-outlined text-[14px]">location_on</span> Location: {{ !empty(trim($report->location ?? '')) ? $report->location : 'BTC' }}
                                    </span>
                                </div>

                                <div class="flex flex-col gap-1">
                                    <p class="text-orange-50 font-bold text-base line-clamp-1 hover:text-orange-300 transition-colors">{{ $report->issues->title ?? 'N/A' }}</p>
                                    <div class="flex flex-col gap-1 mt-2">
                                        <div class="flex items-center gap-2 text-slate-300">
                                            <span class="material-symbols-outlined text-[16px] text-orange-400">person</span>
                                            <p class="text-sm font-medium">{{ $report->client->name ?? 'N/A' }}</p>
                                        </div>
                                        <div class="flex items-center gap-2 text-slate-400">
                                            <span class="material-symbols-outlined text-[16px] text-purple-400">corporate_fare</span>
                                            <p class="text-xs">{{ $report->department->title ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($report->status != 'Pending')
                                        <div class="flex flex-col gap-0.5 mt-2">
                                            <div class="flex items-center gap-2 text-amber-300 bg-amber-950/40 px-2.5 py-1.5 rounded-lg border border-orange-500/20 text-xs font-semibold">
                                                <span>🧙 Responded by:</span>
                                                <span class="text-amber-100 font-medium">{{ $report->response->name ?? 'N/A' }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if($report->remarks)
                                        <div class="flex flex-col gap-1 mt-2 pt-2 border-t border-orange-500/20">
                                            <p class="text-orange-400/80 text-[10px] font-bold uppercase tracking-wider flex items-center gap-1">
                                                <span>🕸️</span> Remarks
                                            </p>
                                            <div class="bg-slate-900/70 p-2.5 rounded-lg border border-orange-500/20 text-orange-200/90 text-xs italic leading-relaxed">
                                                {{ $report->remarks }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex items-center justify-between pt-2 border-t border-orange-500/20 mt-2">
                                    <div class="flex items-center gap-1.5 text-orange-300/80 text-xs">
                                        <span class="material-symbols-outlined text-[16px] text-orange-400">schedule</span>
                                        <span>{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y h:i A') }}</span>
                                    </div>
                                    <span class="text-xs select-none opacity-40">🦇</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-slate-950/85 backdrop-blur-md border border-orange-500/40 rounded-2xl shadow-2xl p-14 text-center">
                                <span class="text-6xl mb-4 block animate-bounce">👻</span>
                                <p class="font-spooky text-3xl font-bold text-orange-400 tracking-wide mb-2">No Horrors Lurking</p>
                                <p class="text-orange-200/80 text-sm">The realm is currently peaceful — there are no active issues reported!</p>
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
