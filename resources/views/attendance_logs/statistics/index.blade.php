<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} - Attendance Statistics</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-gray-100 dark:bg-slate-950">
    @include('attendance_logs._nav')
    <div class="container mx-auto px-4 py-8 mt-16">
    <div class="max-w-screen-2xl mx-auto">
        <!-- Header -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <i class="material-icons text-blue-600 text-4xl">bar_chart</i>
                Attendance Statistics
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Comprehensive attendance analytics and insights</p>
        </div>

        <!-- Date Range Filter -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <form action="{{ route('attendance.statistics') }}" method="GET" class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-1"></i> Start Date
                    </label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-calendar mr-1"></i> End Date
                    </label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-filter"></i> Apply Filter
                </button>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold uppercase">Total Employees</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($totalEmployees) }}</p>
                    </div>
                    <i class="fas fa-users text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold uppercase">Total Attendance</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($totalAttendance) }}</p>
                        <p class="text-green-100 text-xs mt-1">{{ $daysInRange }} days</p>
                    </div>
                    <i class="fas fa-check-circle text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold uppercase">Avg Per Day</p>
                        <p class="text-3xl font-bold mt-2">{{ $avgAttendancePerDay }}</p>
                        <p class="text-purple-100 text-xs mt-1">employees</p>
                    </div>
                    <i class="fas fa-chart-line text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-semibold uppercase">Late Arrivals</p>
                        <p class="text-3xl font-bold mt-2">{{ number_format($lateArrivals) }}</p>
                        <p class="text-orange-100 text-xs mt-1">after 9:00 AM</p>
                    </div>
                    <i class="fas fa-clock text-4xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Attendance by Department -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-building text-blue-600"></i>
                    Attendance by Department
                </h2>
                <div class="space-y-3">
                    @forelse($attendanceByDept as $dept => $count)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $dept ?? 'Unassigned' }}</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $totalAttendance > 0 ? ($count / $totalAttendance * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                    @endforelse
                </div>
            </div>

            <!-- Attendance by Employment Type -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <i class="fas fa-briefcase text-green-600"></i>
                    Attendance by Employment Type
                </h2>
                <div class="space-y-3">
                    @forelse($attendanceByType as $type => $count)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $type ?? 'Unknown' }}</span>
                                <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $count }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $totalAttendance > 0 ? ($count / $totalAttendance * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No data available</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Daily Attendance Trend -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-chart-area text-purple-600"></i>
                Daily Attendance Trend
            </h2>
            <div id="dailyTrendChart" style="height: 300px;"></div>
        </div>

        <!-- Top Punctual Employees -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <i class="fas fa-trophy text-yellow-500"></i>
                Top 10 Most Punctual Employees
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Rank</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Employee Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase">Avg Clock-In Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($punctualEmployees as $index => $employee)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                        {{ $index === 0 ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $index === 1 ? 'bg-gray-100 text-gray-700' : '' }}
                                        {{ $index === 2 ? 'bg-orange-100 text-orange-700' : '' }}
                                        {{ $index > 2 ? 'bg-blue-100 text-blue-700' : '' }} font-bold">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $employee['name'] }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ date('g:i A', strtotime($employee['avg_time'])) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    // Daily Attendance Trend Chart
    document.addEventListener('DOMContentLoaded', function () {
        const dailyData = @json($dailyAttendance);
        const categories = Object.keys(dailyData);
        const data = Object.values(dailyData);

        Highcharts.chart('dailyTrendChart', {
            chart: {
                type: 'area',
                backgroundColor: 'transparent'
            },
            title: {
                text: null
            },
            xAxis: {
                categories: categories,
                labels: {
                    rotation: -45,
                    style: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Number of Employees',
                    style: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563'
                    }
                },
                labels: {
                    style: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563'
                    }
                }
            },
            series: [{
                name: 'Attendance',
                data: data,
                color: '#3b82f6',
                fillColor: {
                    linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                    stops: [
                        [0, 'rgba(59, 130, 246, 0.5)'],
                        [1, 'rgba(59, 130, 246, 0.1)']
                    ]
                }
            }],
            credits: {
                enabled: false
            },
            legend: {
                enabled: false
            }
        });
    });
</script>
</body>
</html>
