<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - {{ env('APP_NAME', 'IT Department') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen pt-16 bg-gray-50 dark:bg-slate-900 transition-colors duration-200">

    @include('attendance_logs._nav')

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Attendance Reports</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Today's attendance summary — {{ now()->format('M d, Y') }}</p>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Total Employees</span>
                    </div>
                    <p class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalEmployees }}</p>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 cursor-pointer hover:shadow-lg transition-shadow" onclick="openPresentModal()">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Present Today</span>
                    </div>
                    <p class="text-4xl font-bold text-green-600 dark:text-green-400">{{ $presentToday }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $totalEmployees ? round(($presentToday / $totalEmployees) * 100, 1) : 0 }}% attendance rate</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 font-semibold">Click to view list</p>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 cursor-pointer hover:shadow-lg transition-shadow" onclick="openAbsentModal()">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-xl flex items-center justify-center">
                            <i class="fas fa-times-circle text-red-600 dark:text-red-400 text-xl"></i>
                        </div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase">Absent Today</span>
                    </div>
                    <p class="text-4xl font-bold text-red-600 dark:text-red-400">{{ $absentToday }}</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $totalEmployees ? round(($absentToday / $totalEmployees) * 100, 1) : 0 }}% absence rate</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-2 font-semibold">Click to view list</p>
                </div>
            </div>

            {{-- Department Breakdown --}}
            @if(!isset($deptHeadDeptTitle) || !$deptHeadDeptTitle)
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Attendance by Department</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-slate-600">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Present</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Percentage</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendanceByDepartment as $department => $count)
                                <tr class="border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $department ?? 'Unassigned' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $count }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-gray-200 dark:bg-slate-600 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $presentToday ? ($count / $presentToday) * 100 : 0 }}%"></div>
                                            </div>
                                            <span>{{ $presentToday ? round(($count / $presentToday) * 100, 1) : 0 }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">No attendance data available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- WFH Accomplishments --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">WFH Accomplishments</h2>
                    <a href="{{ route('attendance.reports.export-pdf', ['wfh_date' => $wfhDate, 'wfh_department' => $wfhDepartment]) }}" target="_blank"
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('attendance.reports') }}" class="mb-6 p-4 bg-gray-50 dark:bg-slate-700 rounded-lg border border-gray-200 dark:border-slate-600">
                    <div class="flex flex-wrap items-end gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date</label>
                            <input type="date" name="wfh_date" value="{{ $wfhDate }}"
                                class="px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                        </div>
                        @if(!isset($deptHeadDeptTitle) || !$deptHeadDeptTitle)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Department</label>
                            <select name="wfh_department"
                                class="px-3 py-2 border border-gray-300 dark:border-slate-500 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                                <option value="">All Departments</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept }}" {{ $wfhDepartment === $dept ? 'selected' : '' }}>{{ $dept }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-blue-700 transition">Filter</button>
                        <a href="{{ route('attendance.reports') }}" class="bg-gray-400 dark:bg-slate-500 text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-gray-500 transition">Reset</a>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-slate-600">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Accomplishments</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($wfhAccomplishments as $accomplishment)
                                <tr class="border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $accomplishment['employee_name'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $accomplishment['employee_id'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $accomplishment['department'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        <ul class="list-disc list-inside space-y-1">
                                            @foreach($accomplishment['accomplishments'] as $acc)
                                                <li>{{ $acc }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $accomplishment['date'] }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">No accomplishments recorded today</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

    <!-- Present Employees Modal -->
    <div id="presentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-600"></i>
                    Present Today ({{ $presentToday }})
                </h2>
                <button onclick="closePresentModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee #</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Department</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Time In</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($presentEmployees as $employee)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $employee['name'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $employee['employee_number'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $employee['department'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ date('g:i A', strtotime($employee['time'])) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No employees present today</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Absent Employees Modal -->
    <div id="absentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <i class="fas fa-times-circle text-red-600"></i>
                    Absent Today ({{ $absentToday }})
                </h2>
                <button onclick="closeAbsentModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-700 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee #</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Department</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Position</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($absentEmployees as $employee)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $employee['name'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $employee['employee_number'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $employee['department'] }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-300">{{ $employee['position'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">All employees are present today</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openPresentModal() {
            document.getElementById('presentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closePresentModal() {
            document.getElementById('presentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function openAbsentModal() {
            document.getElementById('absentModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeAbsentModal() {
            document.getElementById('absentModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modals when clicking outside
        document.getElementById('presentModal')?.addEventListener('click', function(e) {
            if (e.target === this) closePresentModal();
        });

        document.getElementById('absentModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeAbsentModal();
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closePresentModal();
                closeAbsentModal();
            }
        });
    </script>
</body>
</html>
