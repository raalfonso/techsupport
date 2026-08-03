<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issues Reported - {{ env('APP_NAME', 'IT Department') }}</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
                font-family: 'Inter', sans-serif;
            }
        @keyframes blinkRed {
            0%, 100% { border-color: #ef4444; box-shadow: 0 0 10px rgba(239, 68, 68, 0.5); }
            50% { border-color: #dc2626; box-shadow: 0 0 20px rgba(239, 68, 68, 0.8); }
        }
         @keyframes blinkYellow {
            0%, 100% { border-color: #f7f45e; box-shadow: 0 0 10px rgba(244, 235, 62, 0.5); }
            50% { border-color: #d2e832ea; box-shadow: 0 0 20px rgba(233, 222, 15, 0.84); }
        }
        .blink-red {
            animation: blinkRed 1s infinite;
        }
        .blink-yellow {
            animation: blinkYellow 1s infinite;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const notificationSound = new Audio('{{ asset('sounds/387533__soundwarf__alert-short.wav') }}');
        const alertSound = new Audio('{{ asset('sounds/spiderman.mp3') }}');
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
                        playAlert(3);
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
                btn.className = "flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow transition-all duration-300 border bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950/30 dark:text-emerald-400 dark:border-emerald-900/50 cursor-pointer";
                icon.textContent = 'volume_up';
                text.textContent = 'Sound Active';
            } else {
                btn.className = "flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow transition-all duration-300 border bg-red-50 text-red-700 border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50 animate-pulse cursor-pointer";
                icon.textContent = 'volume_off';
                text.textContent = 'Enable Sound';
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
<body class="bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 font-display transition-colors duration-300">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
        <!-- Top Navigation Bar -->

            <main class="flex flex-1 justify-center py-8">
            
                    <div class="layout-content-container- flex flex-col max-w-auto flex-1 px-4 sm:px-10">
                    <!-- Page Title and Actions -->
                        <div class="flex flex-wrap justify-between items-end gap-4 mb-8">
                            <div class="flex flex-col gap-1">
                                <h1 class="text-slate-900 dark:text-slate-100 font-bold text-4xl font-black leading-tight tracking-[-0.033em]">Active Issues Reported</h1>
                                <p class="text-slate-500 dark:text-slate-400 text-base font-normal leading-normal" id="current-datetime"></p>
                            </div>
                            
                            <div class="flex gap-3">
                                <button id="theme-toggle" onclick="toggleTheme()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow transition-all duration-300 border bg-slate-100 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-200 dark:border-slate-700 cursor-pointer">
                                    <span class="material-symbols-outlined text-[20px]" id="theme-icon">dark_mode</span>
                                    <span class="text-sm hidden sm:inline">Theme</span>
                                </button>
                                <button id="sound-toggle" onclick="toggleSound()" class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold shadow-sm hover:shadow transition-all duration-300 border bg-red-50 text-red-700 border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50 animate-pulse cursor-pointer">
                                    <span class="material-symbols-outlined text-[20px]" id="sound-icon">volume_off</span>
                                    <span id="sound-text" class="text-sm">Enable Sound</span>
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
                                    $cardBorderClass = 'border-t-4 border-t-red-500';
                                    $badgeClass = 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-950/30 dark:text-red-400 dark:border-red-900/50';
                                } else {
                                    $cardBorderClass = 'border-t-4 border-t-slate-400 dark:border-t-slate-600';
                                    $badgeClass = 'bg-yellow-100 text-yellow-700 border border-slate-200 dark:bg-slate-800/50 dark:text-slate-300 dark:border-slate-700/50';
                                }
                            @endphp
            
                            <div class="flex flex-col bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 {{ $cardBorderClass }} hover:shadow-md transition-shadow report-card {{ $report->status == 'Done' ? 'opacity-75 grayscale-[0.5]' : '' }}" data-report-id="{{ $report->id }}" data-report-time="{{ $report->request_datetime }}" data-report-status="{{ $report->status }}">
                                <div class="p-5 flex flex-col gap-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex flex-col gap-1">
                                            <p class="text-blue-700 text-xs font-bold uppercase tracking-wider">Ticket Number</p>
                                            <p class="text-slate-900 dark:text-slate-100 text-lg font-extrabold tracking-tight">{{ $report->ticket_number }}</p>
                                        </div>
                                        @if($report->status == 'Pending')
                                            <span class="bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                                <span class="size-2 bg-yellow-500 rounded-full"></span> Pending
                                            </span>
                                        @elseif($report->status == 'Ongoing')
                                            <span class="bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                                <span class="size-2 bg-amber-500 rounded-full"></span> Ongoing
                                            </span>
                                        @elseif($report->status == 'For Validation')
                                            <span class="bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                                <span class="size-2 bg-purple-500 rounded-full"></span> For Validation
                                            </span>
                                        @elseif($report->status == 'Done')
                                            <span class="bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                                <span class="material-symbols-outlined text-[14px]">check</span> Resolved
                                            </span>
                                        @else
                                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
                                                <span class="size-2 bg-slate-500 rounded-full"></span> {{ $report->status }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <!-- Badges Section -->
                                    <div class="flex flex-wrap gap-2 items-center">
                                        <!-- Priority Badge -->
                                        @if($report->issues->category->title == 'High')
                                            <span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                                <span class="size-2 bg-red-500 rounded-full"></span> Priority : High
                                            </span>
                                        @elseif($report->issues->category->title == 'Medium')
                                            <span class="bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                                <span class="size-2 bg-orange-500 rounded-full"></span> Priority : Medium
                                            </span>
                                        @elseif($report->issues->category->title == 'Low')
                                            <span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                                <span class="size-2 bg-green-500 rounded-full"></span> Priority : Low
                                            </span>
                                        @endif

                                        <!-- Location Badge -->
                                        <span class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1 {{ $badgeClass }}">
                                            <span class="material-symbols-outlined text-[14px]">location_on</span> Location : {{ !empty(trim($report->location ?? '')) ? $report->location : 'BTC' }}
                                        </span>
                                    </div>

                                    <div class="flex flex-col gap-1">
                                        <p class="text-slate-900 dark:text-slate-100 text-md font-semibold line-clamp-1">{{ $report->issues->title ?? 'N/A' }}</p>
                                        <div class="flex flex-col gap-0.5 mt-2">
                                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                                <span class="material-symbols-outlined text-[16px]">person</span>
                                                <p class="text-sm font-medium">{{ $report->client->name  ?? 'N/A' }}</p>
                                            </div>
                                            <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400">
                                                <span class="material-symbols-outlined text-[16px]">corporate_fare</span>
                                                <p class="text-xs">{{ $report->department->title ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                            @if($report->status != 'Pending')
                                                <div class="flex flex-col gap-0.5 mt-2">
                                                <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                                    
                                                    <p class="text-sm font-medium upper">Responsed by : {{ $report->response->name  ?? 'N/A' }}</p>
                                                </div>
                                                </div>
                                            @endif

                                            @if($report->remarks)
                                                <div class="flex flex-col gap-0.5 mt-2 pt-2 border-t border-slate-100 dark:border-slate-800">
                                                    <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-wider">Remarks</p>
                                                    <div class="flex items-start gap-2 text-slate-600 dark:text-slate-300">
                                                        <span class="material-symbols-outlined text-[16px] mt-0.5">comment</span>
                                                        <p class="text-xs font-medium italic leading-relaxed">{{ $report->remarks }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                    </div>
                                    
                                    <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800 mt-2">
                                        <div class="flex items-center gap-1 text-slate-500 dark:text-slate-400 text-xs">
                                        <span class="material-symbols-outlined text-[16px]">schedule</span>
                                            <span>{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
@empty
<div class="col-span-full">
<div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-lg p-12 text-center">
<span class="material-symbols-outlined text-gray-300 dark:text-slate-700 text-6xl mb-4">description</span>
<p class="text-xl font-semibold text-slate-900 dark:text-slate-100 mb-2">No reports found</p>
<p class="text-slate-500 dark:text-slate-400">There are currently no issues reported</p>
</div>
</div>
@endforelse
</div>

</div>
</div>
</body></html>