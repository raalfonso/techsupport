<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reports - {{ env('APP_NAME', 'IT Department') }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
</head>

<body style="background-color: #e6edfc" class="flex flex-col min-h-screen pt-16">
    @php
        $isAdmin = auth()->user()->authAssignments()->where('item_name', 'Administrator')->exists();
        $canViewNav = $isAdmin || auth()->user()->authAssignments()->whereIn('item_name', ['HR_admin', 'depthead'])->exists();
    @endphp
    
    <nav class="bg-white p-4 shadow-md top-0 z-50 min-w-full fixed max-h-16">
       <div class="flex items-center justify-between container mx-auto w-full">
            <div class="text-lg font-bold text-gray-800 flex items-center">
               <img src="{{ asset('img/itd_logo.png') }}" alt="ITD Logo" class="h-24 w-auto p-0 rounded">
                BCDA ClockWize
            </div>

            <div class="hidden md:flex items-center space-x-1">
                @if($canViewNav)
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
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white pt-2 pb-3 space-y-1 px-4 border-t border-gray-100">
            <p class="text-gray-600 px-3 py-2 text-sm font-medium">{{ auth()->user()->name }}</p>
            @if($canViewNav)
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

    <main class="flex-grow bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Attendance Reports</h1>
                <p class="text-gray-600 mt-1">Today's attendance summary - {{ now()->format('M d, Y') }}</p>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Total Employees</span>
                    </div>
                    <p class="text-4xl font-bold text-gray-900">{{ $totalEmployees }}</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Present Today</span>
                    </div>
                    <p class="text-4xl font-bold text-green-600">{{ $presentToday }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ round(($presentToday / $totalEmployees) * 100, 1) }}% attendance rate</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 uppercase">Absent Today</span>
                    </div>
                    <p class="text-4xl font-bold text-red-600">{{ $absentToday }}</p>
                    <p class="text-sm text-gray-600 mt-2">{{ round(($absentToday / $totalEmployees) * 100, 1) }}% absence rate</p>
                </div>
            </div>

            <!-- Department Breakdown -->
            @if(!isset($deptHeadDeptTitle) || !$deptHeadDeptTitle)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Attendance by Department</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Present</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendanceByDepartment as $department => $count)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $department ?? 'Unassigned' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $count }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($count / $presentToday) * 100 }}%"></div>
                                            </div>
                                            <span>{{ round(($count / $presentToday) * 100, 1) }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">No attendance data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- WFH Accomplishment -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">WFH Accomplishments</h2>
                    <a href="{{ route('attendance.reports.export-pdf', ['wfh_date' => $wfhDate, 'wfh_department' => $wfhDepartment]) }}" target="_blank" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>

                <!-- Date & Department Filter -->
                <form method="GET" action="{{ route('attendance.reports') }}" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex flex-wrap items-end gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Date</label>
                            <input type="date" name="wfh_date" value="{{ $wfhDate }}" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        @if(!isset($deptHeadDeptTitle) || !$deptHeadDeptTitle)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Department</label>
                            <select name="wfh_department" class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ $wfhDepartment === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition">Filter</button>
                            <a href="{{ route('attendance.reports') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-gray-500 transition">Reset</a>
                        </div>
                    </div>
                </form>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Accomplishments</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wfhAccomplishments as $key => $accomplishment)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $accomplishment['employee_name'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $accomplishment['employee_id'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $accomplishment['department'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($accomplishment['accomplishments'] as $acc)
                                                <li class="text-gray-700">{{ $acc }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $accomplishment['date'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 text-sm">No accomplishments recorded today</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            if (mobileMenu && !mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
