
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME', 'IT Department') }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
        
        // Auto-refresh after 10 minutes of inactivity
        let inactivityTimer;
        const INACTIVITY_TIMEOUT = 10 * 60 * 1000; // 10 minutes in milliseconds

        function resetInactivityTimer() {
            clearTimeout(inactivityTimer);
            inactivityTimer = setTimeout(() => {
                console.log('Refreshing page due to inactivity...');
                window.location.reload();
            }, INACTIVITY_TIMEOUT);
        }

        // Reset timer on user activity
        document.addEventListener('DOMContentLoaded', function() {
            // Start the timer
            resetInactivityTimer();

            // Reset timer on any user interaction
            ['mousedown', 'mousemove', 'keypress', 'scroll', 'touchstart', 'click'].forEach(event => {
                document.addEventListener(event, resetInactivityTimer, true);
            });
        });
    </script>
    <style>
        .autocomplete-list {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 0.5rem 0.5rem;
            max-height: 200px;
            overflow-y: auto;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .dark .autocomplete-list {
            background: #1e293b;
            border-color: #475569;
        }
        .autocomplete-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
        }
        .dark .autocomplete-item {
            border-bottom-color: #334155;
            color: #e2e8f0;
        }
        .autocomplete-item:hover { background-color: #f3f4f6; }
        .dark .autocomplete-item:hover { background-color: #334155; }
        .autocomplete-container { position: relative; }
    </style>
</head>

<body class="flex flex-col min-h-screen pt-16 bg-gray-50 dark:bg-slate-900 transition-colors duration-200">
    @include('attendance_logs._nav')

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Hello, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Your workday overview is ready.</p>
                </div>
                <div class="flex items-center space-x-2 bg-white dark:bg-slate-800 px-4 py-2 rounded-full shadow-sm border border-gray-200 dark:border-slate-600">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-700 dark:text-gray-300">System Online • v1.3</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                @php
                    $todayAttend = \App\Models\AttendanceLog::where('user_id', auth()->id())
                        ->whereDate('date', today())
                        ->where('mode', 'Attend')
                        ->first();
                    $todayLeave = \App\Models\AttendanceLog::where('user_id', auth()->id())
                        ->whereDate('date', today())
                        ->where('mode', 'Leave')
                        ->first();
                @endphp

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Clock In</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        @if($todayAttend)
                            Recorded today at {{ $todayAttend->time }}. You are currently active on the floor.
                        @else
                            Record your arrival time to start your shift.
                        @endif
                    </p>
                    <form id="clockInForm" action="{{ route('attendance.clock-in') }}" method="POST" class="inline-block w-full">
                        @csrf
                        <button id="clockInBtn" type="submit" {{ $todayAttend ? 'disabled' : '' }} class="w-full py-2 px-4 rounded-lg font-semibold text-sm transition {{ $todayAttend ? 'bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-gray-500 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                            {{ $todayAttend ? 'Already Clocked In' : 'Clock In Now' }}
                        </button>
                    </form>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center">
                            <i class="fas fa-sign-out-alt text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Clock Out</span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                        End your work session. Ensure all logs and reports are updated before leaving.
                    </p>
                    @if($todayAttend && !$todayLeave)
                        <button type="button" onclick="openWFHModal()" class="w-full py-2 px-4 rounded-lg font-semibold text-sm bg-blue-600 text-white hover:bg-blue-700 transition mb-2">
                            Clock Out Now
                        </button>
                        <button type="button" onclick="openAccomplishmentModal()" class="w-full py-2 px-4 rounded-lg font-semibold text-sm bg-green-600 text-white hover:bg-green-700 transition">
                            Add Accomplishment
                        </button>
                    @else
                        <button disabled class="w-full py-2 px-4 rounded-lg font-semibold text-sm bg-gray-100 dark:bg-slate-700 text-gray-400 dark:text-gray-500 cursor-not-allowed">
                            {{ $todayLeave ? 'Already Clocked Out' : 'Clock In First' }}
                        </button>
                    @endif
                </div>

                @php
                    $clockInTime = \App\Models\AttendanceLog::where('user_id', auth()->id())
                        ->whereDate('date', today())
                        ->where('mode', 'Attend')
                        ->first();
                    
                    $clockOutTime = \App\Models\AttendanceLog::where('user_id', auth()->id())
                        ->whereDate('date', today())
                        ->where('mode', 'Leave')
                        ->first();
                    
                    $workHours = 0;
                    $progressPercent = 0;
                    $dutyStatus = 'Not clocked in';
                    $statusColor = 'text-white-400';
                    $statusDot = 'bg-gray-400';
                    
                    if ($clockInTime) {
                        $clockInDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $clockInTime->time);
                        $clockInDateTime->setDate(today()->year, today()->month, today()->day);
                        
                        if ($clockOutTime) {
                            $clockOutDateTime = \Carbon\Carbon::createFromFormat('H:i:s', $clockOutTime->time);
                            $clockOutDateTime->setDate(today()->year, today()->month, today()->day);
                            $workHours = $clockOutDateTime->diffInHours($clockInDateTime);
                            $dutyStatus = 'Off Duty';
                            $statusColor = 'text-white-400';
                            $statusDot = 'bg-red-400';
                        } else {
                            $workHours = now()->diffInHours($clockInDateTime);
                            $dutyStatus = 'On Duty';
                            $statusColor = 'text-white-400';
                            $statusDot = 'bg-green-400';
                        }
                        
                        $progressPercent = min(($workHours / 9) * 100, 100);
                    }
                @endphp
                <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl shadow-sm p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-xs font-semibold uppercase opacity-90">Shift Summary</span>
                        <i class="fas fa-briefcase text-2xl opacity-20"></i>
                    </div>
                    <p class="text-sm opacity-90 mb-3">{{ now()->format('M d, Y') }}</p>
                    <p class="text-4xl font-bold mb-4" id="current-time">{{ now()->format('H:i:s') }}</p>
                    <p class="text-sm opacity-90 mb-4">
                        <span class="flex items-center gap-2">
                            <span class="w-2 h-2 {{ $statusDot }} rounded-full"></span>
                            <span class="{{ $statusColor }}">{{ $dutyStatus }}</span>
                        </span>
                    </p>
                    <div class="w-full bg-blue-500 rounded-full h-2">
                        <div class="bg-blue-300 h-2 rounded-full transition-all duration-500" style="width: {{ $progressPercent }}%"></div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Recent Attendance History</h2>
                    <div class="flex gap-3">
                        @php
                            $canViewNav = $canViewAll ?? (auth()->user()->authAssignments()->whereIn('item_name', ['Administrator', 'HR_admin', 'depthead'])->exists());
                        @endphp
                        @if($canViewNav)
                        <button onclick="exportToCSV()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                        <a href="{{ route('attendance.print-pdf', request()->query()) }}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
                            <i class="fas fa-file-pdf"></i> Print PDF
                        </a>
                        <a href="{{ route('attendance.dashboard') }}" class="text-blue-600 text-sm font-semibold hover:text-blue-700 py-2">View Full History →</a>
                        @else
                        <a href="{{ route('attendance.print-pdf', request()->query()) }}" target="_blank" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
                            <i class="fas fa-file-pdf"></i> Print PDF
                        </a>
                        @endif
                    </div>
                </div>
                 @if($canViewNav)
                <!-- Admin/HR/Dept Head Search Form -->
                <form id="searchForm" action="{{ route('attendance.search') }}" method="GET" class="mb-6 p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                @csrf
                    <!-- Preserve accomplishment filters -->
                    <input type="hidden" name="acc_start_date" value="{{ request('acc_start_date') }}">
                    <input type="hidden" name="acc_end_date" value="{{ request('acc_end_date') }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="autocomplete-container">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Search by Name</label>
                            <input type="text" name="name" id="filterName" placeholder="Type name..." value="{{ $filters['name'] ?? '' }}" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="nameAutocomplete" class="autocomplete-list hidden"></div>
                        </div>
                        <div class="autocomplete-container">
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Department</label>
                            <input type="text" name="department" id="filterDepartment" placeholder="Type department..." value="{{ $filters['department'] ?? '' }}" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="departmentAutocomplete" class="autocomplete-list hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Employment Type</label>
                            <select name="employment_type" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Types</option>
                                @foreach(\App\Models\EmployeeMasterlist::distinct()->orderBy('employment_type')->pluck('employment_type') as $type)
                                    <option value="{{ $type }}" {{ ($filters['employment_type'] ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date Range</label>
                            <input type="text" id="dateRange" placeholder="Select date range..." class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="hidden" name="start_date" id="start_date" value="{{ $filters['start_date'] ?? '' }}">
                            <input type="hidden" name="end_date" id="end_date" value="{{ $filters['end_date'] ?? '' }}">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-search mr-2"></i>Search
                            </button>
                            <a href="{{ route('attendance.dashboard') }}" class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-500 transition text-center">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
                @else
                <!-- Regular User Date Range Filter -->
                <form id="userSearchForm" action="{{ route('attendance.search') }}" method="GET" class="mb-6 p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Start Date</label>
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">End Date</label>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="{{ route('attendance.dashboard') }}" class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-500 transition text-center">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-slate-600">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Time Logged</th>
                                @if($canViewNav)
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee Name</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Mode/Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Terminal Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $logsQuery = $logs; @endphp
                            @forelse($logsQuery as $log)
                                <tr class="border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-mono text-gray-700 dark:text-gray-300">{{ date('g:i A', strtotime($log->time)) }}</td>
                                    @if($canViewNav)
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $log->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $log->user->masterlist->employee_number ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $log->mode === 'Attend' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $log->mode }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <span class="text-sm text-gray-700 dark:text-gray-300">Online</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $canViewNav ? 6 : 5 }}" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">No attendance records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($logs->hasPages())
                <div class="mt-4">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mt-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">My WFH Accomplishment History</h2>
                    <button onclick="printAccomplishments()" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition flex items-center gap-2">
                        <i class="fas fa-print"></i> Print Accomplishments
                    </button>
                </div>

                <!-- Date Range Filter -->
                <form action="{{ route('attendance.dashboard') }}" method="GET" class="mb-6 p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                    <!-- Preserve attendance filters -->
                    <input type="hidden" name="name" value="{{ $filters['name'] ?? '' }}">
                    <input type="hidden" name="department" value="{{ $filters['department'] ?? '' }}">
                    <input type="hidden" name="employment_type" value="{{ $filters['employment_type'] ?? '' }}">
                    <input type="hidden" name="start_date" value="{{ $filters['start_date'] ?? '' }}">
                    <input type="hidden" name="end_date" value="{{ $filters['end_date'] ?? '' }}">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Accomplishment Date Range</label>
                            <input type="text" id="accomplishmentDateRange" placeholder="Select date range..." class="w-full px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="hidden" name="acc_start_date" id="acc_start_date" value="{{ request('acc_start_date') }}">
                            <input type="hidden" name="acc_end_date" id="acc_end_date" value="{{ request('acc_end_date') }}">
                        </div>
                        <div class="flex items-end gap-2">
                            <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-filter mr-2"></i>Filter
                            </button>
                            <a href="{{ route('attendance.dashboard') }}" class="flex-1 bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-500 transition text-center">
                                <i class="fas fa-redo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </form>

                @php
                    $grouped = $accomplishments->getCollection()->groupBy(fn($a) => $a->date->format('Y-m-d'));
                @endphp
                @forelse($grouped as $date => $items)
                    <div class="mb-4 border border-gray-100 dark:border-slate-700 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 dark:bg-slate-700 px-4 py-2 flex items-center gap-2">
                            <i class="material-icons text-blue-500 text-sm">event</i>
                            <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</span>
                            <span class="ml-auto text-xs text-gray-400 dark:text-gray-500">{{ $items->count() }} {{ Str::plural('entry', $items->count()) }}</span>
                        </div>
                        <ul class="divide-y divide-gray-50 dark:divide-slate-700">
                            @foreach($items as $item)
                                <li class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300 flex items-start gap-2">
                                    <span class="mt-1 w-2 h-2 rounded-full bg-blue-400 flex-shrink-0"></span>
                                    {{ $item->accomplishment }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p class="text-center text-gray-500 dark:text-gray-400 text-sm py-8">No accomplishments recorded yet.</p>
                @endforelse
                @if($accomplishments->hasPages())
                <div class="mt-4">
                    {{ $accomplishments->appends(request()->query())->links() }}
                </div>
                @endif
            </div>

        </div>
    </main>

    <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center space-y-2">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Powered by</span>
                    <img src="{{ asset('images/ICTD_Logo.png') }}" alt="ICTD Logo" class="h-8 w-auto" />
                    <!-- <span class="text-sm text-gray-600 dark:text-gray-400">ICT Department</span> -->
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © 2026 ClockWize • Bases Conversion and Development Authority (BCDA). All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Prevent double clock-in on slow network
        document.getElementById('clockInForm')?.addEventListener('submit', function () {
            const btn = document.getElementById('clockInBtn');
            btn.disabled = true;
            btn.textContent = 'Clocking In...';
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            btn.classList.add('bg-gray-100', 'dark:bg-slate-700', 'text-gray-400', 'cursor-not-allowed');
        });

        setInterval(() => {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', { hour12: true });
        }, 1000);

        // Initialize Flatpickr after DOM is ready
        document.addEventListener('DOMContentLoaded', function() {
            // Attendance date range picker
            const startDateValue = document.getElementById('start_date')?.value;
            const endDateValue = document.getElementById('end_date')?.value;
            const defaultDates = [];
            
            if (startDateValue) defaultDates.push(startDateValue);
            if (endDateValue) defaultDates.push(endDateValue);

            flatpickr("#dateRange", {
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: defaultDates,
                onChange: function(selectedDates) {
                    function formatDate(d) {
                        const y = d.getFullYear();
                        const m = String(d.getMonth() + 1).padStart(2, '0');
                        const day = String(d.getDate()).padStart(2, '0');
                        return `${y}-${m}-${day}`;
                    }
                    if (selectedDates.length === 2) {
                        document.getElementById('start_date').value = formatDate(selectedDates[0]);
                        document.getElementById('end_date').value = formatDate(selectedDates[1]);
                    } else if (selectedDates.length === 1) {
                        document.getElementById('start_date').value = formatDate(selectedDates[0]);
                        document.getElementById('end_date').value = '';
                    }
                }
            });

            // Accomplishment date range picker
            const accStartDateValue = document.getElementById('acc_start_date')?.value;
            const accEndDateValue = document.getElementById('acc_end_date')?.value;
            const accDefaultDates = [];
            
            if (accStartDateValue) accDefaultDates.push(accStartDateValue);
            if (accEndDateValue) accDefaultDates.push(accEndDateValue);

            flatpickr("#accomplishmentDateRange", {
                mode: "range",
                dateFormat: "Y-m-d",
                defaultDate: accDefaultDates,
                onChange: function(selectedDates) {
                    function formatDate(d) {
                        const y = d.getFullYear();
                        const m = String(d.getMonth() + 1).padStart(2, '0');
                        const day = String(d.getDate()).padStart(2, '0');
                        return `${y}-${m}-${day}`;
                    }
                    if (selectedDates.length === 2) {
                        document.getElementById('acc_start_date').value = formatDate(selectedDates[0]);
                        document.getElementById('acc_end_date').value = formatDate(selectedDates[1]);
                    } else if (selectedDates.length === 1) {
                        document.getElementById('acc_start_date').value = formatDate(selectedDates[0]);
                        document.getElementById('acc_end_date').value = '';
                    }
                }
            });
        });

        // Name autocomplete
        let nameTimeout;
        $('#filterName').on('input focus', function() {
            clearTimeout(nameTimeout);
            const search = $(this).val();
            
            nameTimeout = setTimeout(() => {
                $.ajax({
                    url: '{{ route("attendance.employees") }}',
                    method: 'GET',
                    data: { search: search },
                    success: function(data) {
                        const autocompleteDiv = $('#nameAutocomplete');
                        autocompleteDiv.empty();
                        
                        if (data.length === 0) {
                            autocompleteDiv.addClass('hidden');
                            return;
                        }
                        
                        data.forEach(employee => {
                            autocompleteDiv.append(
                                `<div class="autocomplete-item" data-name="${employee.name}">${employee.name} (${employee.employee_id})</div>`
                            );
                        });
                        
                        autocompleteDiv.removeClass('hidden');
                    }
                });
            }, 300);
        });

        $(document).on('click', '#nameAutocomplete .autocomplete-item', function() {
            const name = $(this).data('name');
            $('#filterName').val(name);
            $('#nameAutocomplete').addClass('hidden');
        });

        // Department autocomplete
        let deptTimeout;
        $('#filterDepartment').on('input focus', function() {
            clearTimeout(deptTimeout);
            const search = $(this).val();
            
            deptTimeout = setTimeout(() => {
                $.ajax({
                    url: '{{ route("attendance.departments") }}',
                    method: 'GET',
                    data: { search: search },
                    success: function(data) {
                        const autocompleteDiv = $('#departmentAutocomplete');
                        autocompleteDiv.empty();
                        
                        if (data.length === 0) {
                            autocompleteDiv.addClass('hidden');
                            return;
                        }
                        
                        data.forEach(dept => {
                            autocompleteDiv.append(
                                `<div class="autocomplete-item" data-name="${dept.name}">${dept.name}</div>`
                            );
                        });
                        
                        autocompleteDiv.removeClass('hidden');
                    }
                });
            }, 300);
        });

        $(document).on('click', '#departmentAutocomplete .autocomplete-item', function() {
            const name = $(this).data('name');
            $('#filterDepartment').val(name);
            $('#departmentAutocomplete').addClass('hidden');
        });

        // Close autocomplete when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.autocomplete-container').length) {
                $('.autocomplete-list').addClass('hidden');
            }
        });

        function exportToCSV() {
            const isAdmin = @json($isAdmin);
            const canViewNav = @json($canViewNav ?? false);
            
            // Build URL with current filters
            const params = new URLSearchParams();
            const name = document.getElementById('filterName')?.value;
            const department = document.getElementById('filterDepartment')?.value;
            const employmentType = document.querySelector('select[name="employment_type"]')?.value;
            const startDate = document.getElementById('start_date')?.value;
            const endDate = document.getElementById('end_date')?.value;
            
            if (name) params.append('name', name);
            if (department) params.append('department', department);
            if (employmentType) params.append('employment_type', employmentType);
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            params.append('export', 'csv');
            
            // Redirect to export endpoint
            window.location.href = '{{ route("attendance.export-csv") }}?' + params.toString();
        }

        function printAccomplishments() {
            // Build URL with current filters
            const params = new URLSearchParams();
            const accStartDate = document.getElementById('acc_start_date')?.value;
            const accEndDate = document.getElementById('acc_end_date')?.value;
            
            if (accStartDate) params.append('acc_start_date', accStartDate);
            if (accEndDate) params.append('acc_end_date', accEndDate);
            
            // Open print PDF in new window
            window.open('{{ route("attendance.print-accomplishments") }}?' + params.toString(), '_blank');
        }
    </script>

    <!-- WFH Accomplishment Modal (Clock Out) -->
    <div id="wfhModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-y-auto py-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 max-w-2xl w-full mx-4 my-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Work From Home Accomplishment</h2>
                <button onclick="closeWFHModal()" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>
             <!-- Warning Note -->
            <div class="mb-6 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg">
                <p class="text-orange-600 dark:text-orange-400 font-semibold text-sm flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    <span>Please check your accomplishment entry, as it will no longer be editable upon saving. Note that edit functionality will be available in an upcoming version.</span>
                </p>
            </div>
            <form id="wfhForm" action="{{ route('attendance.clock-out') }}" method="POST">
                @csrf
                <div id="wfhScrollContainer" class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Accomplishment</label>
                        <textarea name="accomplishment" id="accomplishment" rows="6" placeholder="Describe your work accomplishments for today..." class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Please provide details of what you accomplished today.</p>
                    </div>

                    <!-- Add Accomplishment Button -->
                    <button type="button" onclick="addAccomplishmentRow()" class="w-full px-4 py-2 rounded-lg font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 hover:bg-blue-100 dark:hover:bg-blue-900/50 transition flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Add Another Accomplishment
                    </button>

                    <!-- Additional Accomplishments Container -->
                    <div id="accomplishmentsContainer"></div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeWFHModal()" class="flex-1 px-4 py-2 rounded-lg font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg font-semibold text-white bg-blue-600 hover:bg-blue-700 transition">
                        Clock Out & Submit
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Accomplishment Modal (Anytime) -->
    <div id="accomplishmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center overflow-y-auto py-8">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 max-w-2xl w-full mx-4 my-auto">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add Accomplishment</h2>
                <button onclick="closeAccomplishmentModal()" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Warning Note -->
            <div class="mb-6 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg">
                <p class="text-orange-600 dark:text-orange-400 font-semibold text-sm flex items-start gap-2">
                    <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
                    <span>Please check your accomplishment entry, as it will no longer be editable upon saving. Note that edit functionality will be available in an upcoming version.</span>
                </p>
            </div>
            
            <form id="accomplishmentForm" action="{{ route('accomplishment.store') }}" method="POST">
                @csrf
                <div id="accomplishmentScrollContainer" class="space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Accomplishment</label>
                        <textarea name="accomplishment" id="accomplishmentText" rows="6" placeholder="Describe what you accomplished today..." class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 resize-none"></textarea>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Please provide details of your work accomplishment.</p>
                    </div>

                    <!-- Add Accomplishment Button -->
                    <button type="button" onclick="addAccomplishmentRowStandalone()" class="w-full px-4 py-2 rounded-lg font-semibold text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-900/30 hover:bg-green-100 dark:hover:bg-green-900/50 transition flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Add Another Accomplishment
                    </button>

                    <!-- Additional Accomplishments Container -->
                    <div id="accomplishmentsContainerStandalone"></div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeAccomplishmentModal()" class="flex-1 px-4 py-2 rounded-lg font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 rounded-lg font-semibold text-white bg-green-600 hover:bg-green-700 transition">
                        Save Accomplishment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let accomplishmentCount = 0;
        let accomplishmentCountStandalone = 0;

        function openWFHModal() {
            document.getElementById('wfhModal').classList.remove('hidden');
            accomplishmentCount = 0;
            document.getElementById('accomplishmentsContainer').innerHTML = '';
        }

        function closeWFHModal() {
            document.getElementById('wfhModal').classList.add('hidden');
            document.getElementById('accomplishment').value = '';
            document.getElementById('accomplishmentsContainer').innerHTML = '';
            accomplishmentCount = 0;
        }

        function openAccomplishmentModal() {
            document.getElementById('accomplishmentModal').classList.remove('hidden');
            accomplishmentCountStandalone = 0;
            document.getElementById('accomplishmentsContainerStandalone').innerHTML = '';
        }

        function closeAccomplishmentModal() {
            document.getElementById('accomplishmentModal').classList.add('hidden');
            document.getElementById('accomplishmentText').value = '';
            document.getElementById('accomplishmentsContainerStandalone').innerHTML = '';
            accomplishmentCountStandalone = 0;
        }

        function addAccomplishmentRow() {
            // Get the current value from the main accomplishment field
            const mainField = document.getElementById('accomplishment');
            const currentValue = mainField.value.trim();
            const scrollContainer = document.getElementById('wfhScrollContainer');
            
            // Only proceed if there's a value to move
            if (currentValue) {
                accomplishmentCount++;
                const container = document.getElementById('accomplishmentsContainer');
                const newRow = document.createElement('div');
                newRow.className = 'mb-3 opacity-0 transition-all duration-300';
                newRow.id = `accomplishment-${accomplishmentCount}`;
                newRow.innerHTML = `
                    <div class="relative group">
                        <div class="absolute -left-3 top-3 w-1 h-full bg-gradient-to-b from-blue-500 to-blue-300 rounded-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        <div class="bg-white dark:bg-slate-600 rounded-xl border-2 border-gray-200 dark:border-slate-500 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 dark:border-slate-500">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Additional Item</span>
                                <button type="button" onclick="removeAccomplishmentRow(${accomplishmentCount})" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-3">
                                <textarea name="accomplishments[]" rows="3" placeholder="Describe another accomplishment..." class="w-full px-3 py-2 border-0 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-600 resize-none transition-all" ></textarea>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                
                // Set the value of the new field to the current value
                const newTextarea = newRow.querySelector('textarea');
                newTextarea.value = currentValue;
                
                // Animate in and scroll back to top
                setTimeout(() => {
                    newRow.classList.remove('opacity-0');
                    newRow.classList.add('opacity-100');
                    // Scroll back to top to focus on main field
                    scrollContainer.scrollTop = 0;
                }, 10);
                
                // Clear the main field and focus it
                mainField.value = '';
                mainField.focus();
            } else {
                // If main field is empty, just add a new empty field
                accomplishmentCount++;
                const container = document.getElementById('accomplishmentsContainer');
                const newRow = document.createElement('div');
                newRow.className = 'mb-3 opacity-0 transition-all duration-300';
                newRow.id = `accomplishment-${accomplishmentCount}`;
                newRow.innerHTML = `
                    <div class="relative group">
                        <div class="absolute -left-3 top-3 w-1 h-full bg-gradient-to-b from-blue-500 to-blue-300 rounded-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        <div class="bg-white dark:bg-slate-600 rounded-xl border-2 border-gray-200 dark:border-slate-500 hover:border-blue-400 dark:hover:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 dark:border-slate-500">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Additional Item</span>
                                <button type="button" onclick="removeAccomplishmentRow(${accomplishmentCount})" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-3">
                                <textarea name="accomplishments[]" rows="3" placeholder="Describe another accomplishment..." class="w-full px-3 py-2 border-0 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-600 resize-none transition-all" ></textarea>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                
                // Animate in and scroll back to top
                setTimeout(() => {
                    newRow.classList.remove('opacity-0');
                    newRow.classList.add('opacity-100');
                    // Scroll back to top
                    scrollContainer.scrollTop = 0;
                }, 10);
            }
        }

        function removeAccomplishmentRow(id) {
            const row = document.getElementById(`accomplishment-${id}`);
            if (row) {
                row.classList.add('opacity-0', 'scale-95');
                setTimeout(() => row.remove(), 300);
            }
        }

        function addAccomplishmentRowStandalone() {
            // Get the current value from the main accomplishment field
            const mainField = document.getElementById('accomplishmentText');
            const currentValue = mainField.value.trim();
            const scrollContainer = document.getElementById('accomplishmentScrollContainer');
            
            // Only proceed if there's a value to move
            if (currentValue) {
                accomplishmentCountStandalone++;
                const container = document.getElementById('accomplishmentsContainerStandalone');
                const newRow = document.createElement('div');
                newRow.className = 'mb-3 opacity-0 transition-all duration-300';
                newRow.id = `accomplishment-standalone-${accomplishmentCountStandalone}`;
                newRow.innerHTML = `
                    <div class="relative group">
                        <div class="absolute -left-3 top-3 w-1 h-full bg-gradient-to-b from-green-500 to-green-300 rounded-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        <div class="bg-white dark:bg-slate-600 rounded-xl border-2 border-gray-200 dark:border-slate-500 hover:border-green-400 dark:hover:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 dark:border-slate-500">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Additional Item</span>
                                <button type="button" onclick="removeAccomplishmentRowStandalone(${accomplishmentCountStandalone})" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-3">
                                <textarea name="accomplishments[]" rows="3" placeholder="Describe another accomplishment..." class="w-full px-3 py-2 border-0 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white dark:focus:bg-slate-600 resize-none transition-all" ></textarea>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                
                // Set the value of the new field to the current value
                const newTextarea = newRow.querySelector('textarea');
                newTextarea.value = currentValue;
                
                // Animate in and scroll back to top
                setTimeout(() => {
                    newRow.classList.remove('opacity-0');
                    newRow.classList.add('opacity-100');
                    // Scroll back to top to focus on main field
                    scrollContainer.scrollTop = 0;
                }, 10);
                
                // Clear the main field and focus it
                mainField.value = '';
                mainField.focus();
            } else {
                // If main field is empty, just add a new empty field
                accomplishmentCountStandalone++;
                const container = document.getElementById('accomplishmentsContainerStandalone');
                const newRow = document.createElement('div');
                newRow.className = 'mb-3 opacity-0 transition-all duration-300';
                newRow.id = `accomplishment-standalone-${accomplishmentCountStandalone}`;
                newRow.innerHTML = `
                    <div class="relative group">
                        <div class="absolute -left-3 top-3 w-1 h-full bg-gradient-to-b from-green-500 to-green-300 rounded-full opacity-50 group-hover:opacity-100 transition-opacity"></div>
                        <div class="bg-white dark:bg-slate-600 rounded-xl border-2 border-gray-200 dark:border-slate-500 hover:border-green-400 dark:hover:border-green-500 transition-all duration-200 shadow-sm hover:shadow-md">
                            <div class="flex items-center justify-between px-4 py-2 border-b border-gray-100 dark:border-slate-500">
                                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Additional Item</span>
                                <button type="button" onclick="removeAccomplishmentRowStandalone(${accomplishmentCountStandalone})" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1 rounded hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="p-3">
                                <textarea name="accomplishments[]" rows="3" placeholder="Describe another accomplishment..." class="w-full px-3 py-2 border-0 bg-gray-50 dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:bg-white dark:focus:bg-slate-600 resize-none transition-all" ></textarea>
                            </div>
                        </div>
                    </div>
                `;
                container.appendChild(newRow);
                
                // Animate in and scroll back to top
                setTimeout(() => {
                    newRow.classList.remove('opacity-0');
                    newRow.classList.add('opacity-100');
                    // Scroll back to top
                    scrollContainer.scrollTop = 0;
                }, 10);
            }
        }

        function removeAccomplishmentRowStandalone(id) {
            const row = document.getElementById(`accomplishment-standalone-${id}`);
            if (row) {
                row.classList.add('opacity-0', 'scale-95');
                setTimeout(() => row.remove(), 300);
            }
        }

        // Close modals when clicking outside
        document.getElementById('wfhModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeWFHModal();
            }
        });

        document.getElementById('accomplishmentModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAccomplishmentModal();
            }
        });
    </script>
</body>
</html>


<!-- Accomplishment Modal -->
<div id="accomplishmentModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-slate-800">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Add Today's Accomplishment</h3>
            <button onclick="closeAccomplishmentModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <form action="{{ route('accomplishment.store') }}" method="POST" class="mt-4">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Describe your accomplishments for today <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="accomplishment" 
                    rows="6" 
                    
                    class="w-full border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white"
                    placeholder="List your tasks, achievements, and completed work..."
                ></textarea>
            </div>

            <div class="flex gap-3 justify-end">
                <button 
                    type="button" 
                    onclick="closeAccomplishmentModal()" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-6 rounded-lg transition"
                >
                    Cancel
                </button>
                <button 
                    type="submit" 
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg transition"
                >
                    Save Accomplishment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAccomplishmentModal() {
        document.getElementById('accomplishmentModal').classList.remove('hidden');
    }

    function closeAccomplishmentModal() {
        document.getElementById('accomplishmentModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('accomplishmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeAccomplishmentModal();
        }
    });
</script>
