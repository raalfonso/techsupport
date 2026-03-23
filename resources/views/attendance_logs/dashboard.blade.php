
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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    
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
        
        .autocomplete-item {
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .autocomplete-item:hover {
            background-color: #f3f4f6;
        }
        
        .autocomplete-container {
            position: relative;
        }
    </style>
</head>

<body style="background-color: #e6edfc" class="flex flex-col min-h-screen pt-16">
    @php
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
    @endphp
    
    <nav class="bg-white p-4 shadow-md top-0 z-50 min-w-full fixed max-h-16">
       <div class="flex items-center justify-between container mx-auto w-full">
            <div class="text-lg font-bold text-gray-800 flex items-center">
               <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-24 w-auto p-0 rounded">
                BCDA ClockWize
            </div>

            <div class="hidden md:flex items-center space-x-1">
                @if($isAdmin)
                <a href="{{ route('attendance.dashboard') }}" class="flex items-center space-x-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                    <i class="material-icons text-lg">dashboard</i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('attendance.present-today') }}" class="flex items-center space-x-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                    <i class="material-icons text-lg">people</i>
                    <span>On Duty</span>
                </a>
                <a href="{{ route('attendance.reports') }}" class="flex items-center space-x-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                    <i class="material-icons text-lg">assessment</i>
                    <span>Reports</span>
                </a>
                @endif
                <p class="text-gray-600 px-3 py-2 text-sm font-medium">{{ auth()->user()->name }}</p>
            </div>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white pt-2 pb-3 space-y-1 px-4 border-t border-gray-100">
            <p class="text-gray-600 px-3 py-2 text-sm font-medium">{{ auth()->user()->name }}</p>
            @if($isAdmin)
            <a href="{{ route('attendance.dashboard') }}" class="flex items-center space-x-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                <i class="material-icons text-lg">dashboard</i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('attendance.present-today') }}" class="flex items-center space-x-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                <i class="material-icons text-lg">people</i>
                <span>On Duty</span>
            </a>
            <a href="{{ route('attendance.reports') }}" class="flex items-center space-x-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 px-3 py-2 rounded-lg transition font-medium">
                <i class="material-icons text-lg">assessment</i>
                <span>Reports</span>
            </a>
            @endif
        </div>
    </nav>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>

    <main class="flex-grow bg-gray-50">
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
                    <h1 class="text-3xl font-bold text-gray-900">Hello, {{ auth()->user()->name }}!</h1>
                    <p class="text-gray-600 mt-1">Your workday overview is ready.</p>
                </div>
                <div class="flex items-center space-x-2 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-200">
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm text-gray-700">System Online • v1.1</span>
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

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-clock text-green-600 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Clock In</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">
                        @if($todayAttend)
                            Recorded today at {{ $todayAttend->time }}. You are currently active on the floor.
                        @else
                            Record your arrival time to start your shift.
                        @endif
                    </p>
                    <form action="{{ route('attendance.clock-in') }}" method="POST" class="inline-block w-full">
                        @csrf
                        <button type="submit" {{ $todayAttend ? 'disabled' : '' }} class="w-full py-2 px-4 rounded-lg font-semibold text-sm transition {{ $todayAttend ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700' }}">
                            {{ $todayAttend ? 'Already Clocked In' : 'Clock In Now' }}
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-sign-out-alt text-red-600 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Clock Out</span>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">
                        End your work session. Ensure all logs and reports are updated before leaving.
                    </p>
                    @if($todayAttend && !$todayLeave)
                        <button type="button" onclick="openWFHModal()" class="w-full py-2 px-4 rounded-lg font-semibold text-sm bg-blue-600 text-white hover:bg-blue-700 transition">
                            Clock Out Now
                        </button>
                    @else
                        <button disabled class="w-full py-2 px-4 rounded-lg font-semibold text-sm bg-gray-100 text-gray-400 cursor-not-allowed">
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

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Recent Attendance History</h2>
                    <div class="flex gap-3">
                        @php
                            $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
                        @endphp
                        @if($isAdmin)
                        <button onclick="exportToCSV()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                            <i class="fas fa-download"></i> Export CSV
                        </button>
                        <a href="{{ route('attendance.dashboard') }}" class="text-blue-600 text-sm font-semibold hover:text-blue-700 py-2">View Full History →</a>
                        @endif
                    </div>
                </div>
                 @if($isAdmin)
                
                <form id="searchForm" action="{{ route('attendance.search') }}" method="GET" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                @csrf
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div class="autocomplete-container">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Search by Name</label>
                            <input type="text" name="name" id="filterName" placeholder="Type name..." value="{{ $filters['name'] ?? '' }}" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="nameAutocomplete" class="autocomplete-list hidden"></div>
                        </div>
                        <div class="autocomplete-container">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Department</label>
                            <input type="text" name="department" id="filterDepartment" placeholder="Type department..." value="{{ $filters['department'] ?? '' }}" autocomplete="off" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="departmentAutocomplete" class="autocomplete-list hidden"></div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Employment Type</label>
                            <select name="employment_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">All Types</option>
                                @foreach(\App\Models\EmployeeMasterlist::distinct()->orderBy('employment_type')->pluck('employment_type') as $type)
                                    <option value="{{ $type }}" {{ ($filters['employment_type'] ?? '') === $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date Range</label>
                            <input type="text" id="dateRange" placeholder="Select date range..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
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
                @endif
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Time Logged</th>
                                @if($isAdmin)
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee Name</th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Mode/Type</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Terminal Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                if ($isAdmin) {
                                    $logsQuery = isset($logs) ? $logs : \App\Models\AttendanceLog::with('user.masterlist.department')->latest()->limit(50)->get();
                                } else {
                                    $logsQuery = isset($logs) ? $logs : \App\Models\AttendanceLog::where('user_id', auth()->id())->with('user.masterlist.department')->latest()->limit(50)->get();
                                }
                            @endphp
                            @forelse($logsQuery as $log)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $log->date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-mono text-gray-700">{{ date('g:i A', strtotime($log->time)) }}</td>
                                    @if($isAdmin)
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $log->user->name ?? 'N/A' }}</td>
                                    @endif
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $log->user->masterlist->employee_number ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $log->mode === 'Attend' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $log->mode }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <span class="text-sm text-gray-700">Online</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $isAdmin ? 6 : 5 }}" class="px-6 py-8 text-center text-gray-500 text-sm">No attendance records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- WFH Accomplishment History -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">My WFH Accomplishment History</h2>
                @php
                    $myAccomplishments = \App\Models\WFHAccomplishment::where('employee_id', auth()->id())
                        ->orderBy('date', 'desc')
                        ->orderBy('created_at', 'desc')
                        ->limit(30)
                        ->get()
                        ->groupBy(fn($a) => $a->date->format('Y-m-d'));
                @endphp
                @forelse($myAccomplishments as $date => $items)
                    <div class="mb-4 border border-gray-100 rounded-xl overflow-hidden">
                        <div class="bg-gray-50 px-4 py-2 flex items-center gap-2">
                            <i class="material-icons text-blue-500 text-sm">event</i>
                            <span class="text-sm font-semibold text-gray-700">{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</span>
                            <span class="ml-auto text-xs text-gray-400">{{ $items->count() }} {{ Str::plural('entry', $items->count()) }}</span>
                        </div>
                        <ul class="divide-y divide-gray-50">
                            @foreach($items as $item)
                                <li class="px-4 py-3 text-sm text-gray-700 flex items-start gap-2">
                                    <span class="mt-1 w-2 h-2 rounded-full bg-blue-400 flex-shrink-0"></span>
                                    {{ $item->accomplishment }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @empty
                    <p class="text-center text-gray-500 text-sm py-8">No accomplishments recorded yet.</p>
                @endforelse
            </div>

        </div>
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-600">
                © 2026 ClockWize • Powered by the ICT Department – Bases Conversion and Development Authority
            </p>
        </div>
    </footer>

    <script>
        setInterval(() => {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', { hour12: true });
        }, 1000);

        flatpickr("#dateRange", {
            mode: "range",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates) {
                if (selectedDates.length === 2) {
                    document.getElementById('start_date').value = selectedDates[0].toISOString().split('T')[0];
                    document.getElementById('end_date').value = selectedDates[1].toISOString().split('T')[0];
                } else if (selectedDates.length === 1) {
                    document.getElementById('start_date').value = selectedDates[0].toISOString().split('T')[0];
                    document.getElementById('end_date').value = '';
                }
            }
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
            let logsData;
            
            if (isAdmin) {
                logsData = @json(\App\Models\AttendanceLog::with('user.masterlist')->latest()->get());
            } else {
                logsData = @json(isset($logs) ? $logs : \App\Models\AttendanceLog::where('user_id', auth()->id())->with('user.masterlist')->latest()->get());
            }
            
            const user = @json(auth()->user());
            
            let csv = isAdmin 
                ? 'Date,Time,Employee Name,Employee ID,Class,Mode,Type,Card Serial,Result,Property,External Device,Coordinate\n'
                : 'Date,Time,User ID,Name,Employee ID,Class,Mode,Type,Card Serial,Result,Property,External Device,Coordinate\n';
            
            logsData.forEach(log => {
                const date = log.date.split('T')[0];
                const time = log.time;
                const employeeId = (log.user && log.user.masterlist) ? log.user.masterlist.employee_number : '';
                const className = 'User';
                const mode = log.mode;
                const type = log.mode;
                const cardSerial = '';
                const result = 'success';
                const property = '1000';
                const externalDevice = 'ClockWize';
                const coordinate = '0/0';
                
                if (isAdmin) {
                    const employeeName = log.user ? log.user.name : 'N/A';
                    csv += `"${date}","${time}","${employeeName}","${employeeId}","${className}","${mode}","${type}","${cardSerial}","${result}","${property}","${externalDevice}","${coordinate}"\n`;
                } else {
                    const userId = user.id;
                    const name = user.name;
                    csv += `"${date}","${time}","${userId}","${name}","${employeeId}","${className}","${mode}","${type}","${cardSerial}","${result}","${property}","${externalDevice}","${coordinate}"\n`;
                }
            });
            
            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `attendance_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    </script>
</body>
</html>

    <!-- WFH Accomplishment Modal (Clock Out) -->
    <div id="wfhModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Work From Home Accomplishment</h2>
                <button onclick="closeWFHModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="wfhForm" action="{{ route('attendance.clock-out') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Accomplishment</label>
                        <textarea name="accomplishment" id="accomplishment" rows="6" placeholder="Describe your work accomplishments for today..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>
                        <p class="text-xs text-gray-500 mt-1">Please provide details of what you accomplished today.</p>
                    </div>

                    <!-- Add Accomplishment Button -->
                    <button type="button" onclick="addAccomplishmentRow()" class="w-full px-4 py-2 rounded-lg font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 transition flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Add Another Accomplishment
                    </button>

                    <!-- Additional Accomplishments Container -->
                    <div id="accomplishmentsContainer"></div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeWFHModal()" class="flex-1 px-4 py-2 rounded-lg font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
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
    <div id="accomplishmentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Add Accomplishment</h2>
                <button onclick="closeAccomplishmentModal()" class="text-gray-500 hover:text-gray-700 text-2xl">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="accomplishmentForm" action="{{ route('accomplishment.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Accomplishment</label>
                        <textarea name="accomplishment" id="accomplishmentText" rows="6" placeholder="Describe what you accomplished today..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" required></textarea>
                        <p class="text-xs text-gray-500 mt-1">Please provide details of your work accomplishment.</p>
                    </div>

                    <!-- Add Accomplishment Button -->
                    <button type="button" onclick="addAccomplishmentRowStandalone()" class="w-full px-4 py-2 rounded-lg font-semibold text-green-600 bg-green-50 hover:bg-green-100 transition flex items-center justify-center gap-2">
                        <i class="fas fa-plus"></i> Add Another Accomplishment
                    </button>

                    <!-- Additional Accomplishments Container -->
                    <div id="accomplishmentsContainerStandalone"></div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeAccomplishmentModal()" class="flex-1 px-4 py-2 rounded-lg font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">
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
            accomplishmentCount++;
            const container = document.getElementById('accomplishmentsContainer');
            const newRow = document.createElement('div');
            newRow.className = 'p-4 bg-gray-50 rounded-lg border border-gray-200';
            newRow.id = `accomplishment-${accomplishmentCount}`;
            newRow.innerHTML = `
                <div class="flex items-start justify-between mb-2">
                    <label class="block text-sm font-semibold text-gray-700">Accomplishment ${accomplishmentCount + 1}</label>
                    <button type="button" onclick="removeAccomplishmentRow(${accomplishmentCount})" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <textarea name="accomplishments[]" rows="4" placeholder="Describe another accomplishment..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none" required></textarea>
            `;
            container.appendChild(newRow);
        }

        function removeAccomplishmentRow(id) {
            const row = document.getElementById(`accomplishment-${id}`);
            if (row) {
                row.remove();
            }
        }

        function addAccomplishmentRowStandalone() {
            accomplishmentCountStandalone++;
            const container = document.getElementById('accomplishmentsContainerStandalone');
            const newRow = document.createElement('div');
            newRow.className = 'p-4 bg-gray-50 rounded-lg border border-gray-200';
            newRow.id = `accomplishment-standalone-${accomplishmentCountStandalone}`;
            newRow.innerHTML = `
                <div class="flex items-start justify-between mb-2">
                    <label class="block text-sm font-semibold text-gray-700">Accomplishment ${accomplishmentCountStandalone + 1}</label>
                    <button type="button" onclick="removeAccomplishmentRowStandalone(${accomplishmentCountStandalone})" class="text-red-600 hover:text-red-700 text-sm font-semibold">
                        <i class="fas fa-trash"></i> Remove
                    </button>
                </div>
                <textarea name="accomplishments[]" rows="4" placeholder="Describe another accomplishment..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 resize-none" required></textarea>
            `;
            container.appendChild(newRow);
        }

        function removeAccomplishmentRowStandalone(id) {
            const row = document.getElementById(`accomplishment-standalone-${id}`);
            if (row) {
                row.remove();
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
