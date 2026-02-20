<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issues Reported - {{ env('APP_NAME', 'IT Department') }}</title>
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
    <script>
        function checkOldReports() {
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
                    }
                }
            });
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            checkOldReports();
            setInterval(checkOldReports, 5000);
        });
    </script>
</head>
<body class="bg-background-light font-display">
<div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
<div class="layout-container flex h-full grow flex-col">
<!-- Top Navigation Bar -->

<main class="flex flex-1 justify-center py-8">
<div class="layout-content-container flex flex-col max-w-[1200px] flex-1 px-4 sm:px-10">
<!-- Page Title and Actions -->
<div class="flex flex-wrap justify-between items-end gap-4 mb-8">
<div class="flex flex-col gap-1">
<h1 class="text-slate-900 dark:text-slate-100 font-bold text-4xl font-black leading-tight tracking-[-0.033em]">Active Issues Reported</h1>
{{-- <p class="text-slate-500 dark:text-slate-400 text-base font-normal leading-normal">Manage and track resolution of system issues.</p> --}}
</div>
<div class="flex gap-3">


</div>
</div>

<!-- Issues Grid -->
<div class="grid grid-cols-1 lg:grid-cols-4 xl:grid-cols-4 gap-6">
@forelse($reports as $report)
<div class="flex flex-col bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-800 hover:shadow-md transition-shadow report-card {{ $report->status == 'Done' ? 'opacity-75 grayscale-[0.5]' : '' }}" data-report-time="{{ $report->request_datetime }}" data-report-status="{{ $report->status }}">
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
<!-- Priority Badge -->

@if($report->issues->category->title == 'High')
<span class="bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
<span class="size-2 bg-red-500 rounded-full"></span> Priority : High
</span>
@elseif($report->issues->category->title == 'Medium')
<span class="bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
<span class="size-2 bg-orange-500 rounded-full"></span> Priority : Medium
</span>
@elseif($report->issues->category->title == 'Low')
<span class="bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1">
<span class="size-2 bg-green-500 rounded-full"></span> Priority : Low
</span>
@endif
<div class="flex flex-col gap-1">
<p class="text-slate-900 dark:text-slate-100 text-md font-semibold line-clamp-1">{{ $report->issues->title ?? 'N/A' }}</p>
<div class="flex flex-col gap-0.5 mt-2">
<div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
<span class="material-symbols-outlined text-[16px]">person</span>
<p class="text-sm font-medium">{{ $report->client->name  ?? 'N/A' }}</p>
</div>
<div class="flex items-center gap-2 text-slate-500 dark:text-slate-500">
<span class="material-symbols-outlined text-[16px]">corporate_fare</span>
<p class="text-xs">{{ $report->department->title ?? 'N/A' }}</p>
</div>
</div>
</div>
<div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800 mt-2">
<div class="flex items-center gap-1 text-slate-500 text-xs">
<span class="material-symbols-outlined text-[16px]">schedule</span>
<span>{{ \Carbon\Carbon::parse($report->request_datetime)->format('M d, Y h:i A') }}</span>
</div>
</div>
</div>
</div>
@empty
<div class="col-span-full">
<div class="bg-white rounded-xl shadow-lg p-12 text-center">
<span class="material-symbols-outlined text-gray-300 text-6xl mb-4">description</span>
<p class="text-xl font-semibold text-slate-900 mb-2">No reports found</p>
<p class="text-slate-500">There are currently no issues reported</p>
</div>
</div>
@endforelse
</div>

</div>
</div>
</body></html>