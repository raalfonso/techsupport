<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} - Employee List</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/modules/exporting.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/modules/export-data.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link class="favicon" rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-gray-100 dark:bg-slate-950">
    @include('attendance_logs._nav')
    <div class="container mx-auto p-4 mt-20">
    <div class="mx-auto max-w-screen-2xl mt-5">
        <!-- Header Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <i class="material-icons text-blue-600 text-4xl">group</i>
                        Employee List
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">View all employee records</p>
                </div>
                @php
                    $isHRAdmin = auth()->user()->authAssignments()->where('item_name', 'HR_admin')->exists();
                @endphp
                <div class="flex gap-3">
                    <a href="{{ route('employee-list.export', request()->query()) }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center gap-2 shadow-sm hover:shadow-md">
                        <i class="fas fa-file-excel"></i> Export Active to Excel
                    </a>
                    @if($isHRAdmin)
                    <a href="{{ route('employee-list.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-sm hover:shadow-md">
                        <i class="fas fa-plus"></i> Add Employee
                    </a>
                    @endif
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-400 rounded-lg flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <form action="{{ route('employee-list.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    <!-- Search Input -->
                    <div class="lg:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-search mr-1"></i> Search
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Employee #, Position, Email..." class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <!-- Department Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-building mr-1"></i> Department
                        </label>
                        <select name="department" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-toggle-on mr-1"></i> Status
                        </label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">All Status</option>
                            <option value="Active" {{ request('status') === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ request('status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="On Leave" {{ request('status') === 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-briefcase mr-1"></i> Type
                        </label>
                        <select name="type" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">All Types</option>
                            <option value="Permanent" {{ request('type') === 'Permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="Contractual" {{ request('type') === 'Contractual' ? 'selected' : '' }}>Contractual</option>
                            <option value="COS" {{ request('type') === 'COS' ? 'selected' : '' }}>COS</option>
                            <option value="COS(DBP)" {{ request('type') === 'COS(DBP)' ? 'selected' : '' }}>COS(DBP)</option>
                            <option value="COS(OMNI)" {{ request('type') === 'COS(OMNI)' ? 'selected' : '' }}>COS(OMNI)</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-sm hover:shadow-md">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="{{ route('employee-list.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-500 transition flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold uppercase">Total Employees</p>
                        <p class="text-3xl font-bold mt-2">{{ $employees->total() }}</p>
                    </div>
                    <i class="fas fa-users text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold uppercase">Active</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\EmployeeMasterlist::where('employment_status', 'Active')->count() }}</p>
                    </div>
                    <i class="fas fa-user-check text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-semibold uppercase">On Leave</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\EmployeeMasterlist::where('employment_status', 'On Leave')->count() }}</p>
                    </div>
                    <i class="fas fa-user-clock text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-semibold uppercase">Inactive</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\EmployeeMasterlist::where('employment_status', 'Inactive')->count() }}</p>
                    </div>
                    <i class="fas fa-user-times text-4xl opacity-20"></i>
                </div>
            </div>
        </div>
        
        <!-- Chart Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Employees per Department</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Count of active employees per department by employment type</p>
                </div>
                <!-- Employment Type selector button group & export button -->
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex flex-wrap bg-gray-100 dark:bg-slate-700 p-1 rounded-xl shadow-inner border border-gray-200 dark:border-slate-600 gap-1 sm:gap-0">
                        @foreach(['All', 'Permanent', 'Contractual', 'COS', 'COS(DBP)', 'COS(OMNI)'] as $typeOption)
                            @php
                                $defaultType = request('type') ?: 'All';
                                $isActive = ($defaultType === $typeOption);
                            @endphp
                            <button type="button" 
                                    class="chart-type-btn px-3 py-1.5 text-xs font-semibold rounded-lg transition-all 
                                    {{ $isActive ? 'bg-blue-600 text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white' }}" 
                                    data-type="{{ $typeOption }}">
                                {{ $typeOption }}
                            </button>
                        @endforeach
                    </div>
                    <button type="button" id="export-chart-btn" class="bg-emerald-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center gap-2 shadow-sm hover:shadow-md text-xs">
                        <i class="fas fa-file-excel"></i> Export Chart
                    </button>
                </div>
            </div>
            <div id="employee-dept-chart" class="w-full" style="height: 380px;"></div>
        </div>

        <!-- Table Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Employee #</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Position</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($employees as $employee)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 text-sm font-mono font-semibold text-gray-900 dark:text-white">
                                    {{ $employee->employee_number }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">{{ $employee->full_name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $employee->position }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($employee->department)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                                            {{ $employee->department->acronym }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold 
                                        {{ $employee->employment_status === 'Active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                                        {{ $employee->employment_status === 'Inactive' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}
                                        {{ $employee->employment_status === 'On Leave' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300' : '' }}">
                                        <i class="fas fa-circle text-xs mr-1"></i>
                                        {{ $employee->employment_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    {{ $employee->employment_type }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                                    <a href="mailto:{{ $employee->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        {{ $employee->email }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('employee-list.show', $employee) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @php
                                            $isHRAdmin = auth()->user()->authAssignments()->where('item_name', 'HR_admin')->exists();
                                        @endphp
                                        @if($isHRAdmin)
                                        <a href="{{ route('employee-list.edit', $employee) }}" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 p-2 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 rounded-lg transition" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('employee-list.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-users text-6xl mb-4 opacity-20"></i>
                                        <p class="text-lg font-semibold">No employees found</p>
                                        <p class="text-sm mt-1">Try adjusting your search or filters</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($employees->hasPages())
        <div class="mt-6">
            {{ $employees->links() }}
        </div>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const isDark = document.documentElement.classList.contains('dark') || document.body.classList.contains('dark');
        const chartData = @json($chartData);
        const defaultType = '{{ request('type') ?: 'All' }}';
        
        const chart = Highcharts.chart('employee-dept-chart', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent',
                style: {
                    fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif'
                }
            },
            title: {
                text: null
            },
            subtitle: {
                text: null
            },
            xAxis: {
                type: 'category',
                labels: {
                    style: {
                        color: isDark ? '#94a3b8' : '#64748b',
                        fontWeight: '600'
                    }
                },
                lineColor: isDark ? '#334155' : '#e2e8f0',
                tickColor: isDark ? '#334155' : '#e2e8f0'
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Number of Employees',
                    style: {
                        color: isDark ? '#94a3b8' : '#64748b',
                        fontWeight: '600'
                    }
                },
                labels: {
                    style: {
                        color: isDark ? '#94a3b8' : '#64748b'
                    }
                },
                gridLineColor: isDark ? '#334155' : '#e2e8f0'
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: '<b>{point.y}</b> employees'
            },
            credits: {
                enabled: false
            },
            plotOptions: {
                column: {
                    borderRadius: 8,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}',
                        style: {
                            color: isDark ? '#f8fafc' : '#0f172a',
                            textOutline: 'none',
                            fontWeight: 'bold'
                        }
                    },
                    colorByPoint: true,
                    colors: [
                        '#3b82f6', '#10b981', '#f59e0b', '#ef4444', 
                        '#8b5cf6', '#ec4899', '#14b8a6', '#6366f1',
                        '#06b6d4', '#f43f5e'
                    ]
                }
            },
            series: [{
                name: 'Employees',
                data: chartData[defaultType] || chartData['All']
            }],
            exporting: {
                filename: 'employee_department_chart_' + new Date().toISOString().slice(0, 10),
                buttons: {
                    contextButton: {
                        enabled: false // Hide default hamburger context menu
                    }
                }
            }
        });

        // Add interactive event listeners for export chart button
        const exportChartBtn = document.getElementById('export-chart-btn');
        if (exportChartBtn) {
            exportChartBtn.addEventListener('click', function() {
                chart.downloadXLS();
            });
        }

        // Add interactive event listeners for type buttons
        const typeButtons = document.querySelectorAll('.chart-type-btn');
        typeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const type = this.getAttribute('data-type');
                
                // Clear active classes from all buttons and add default hover/text classes
                typeButtons.forEach(btn => {
                    btn.className = 'chart-type-btn px-3 py-1.5 text-xs font-semibold rounded-lg transition-all text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white';
                });
                
                // Set active classes on the clicked button
                this.className = 'chart-type-btn px-3 py-1.5 text-xs font-semibold rounded-lg transition-all bg-blue-600 text-white shadow-sm';
                
                // Dynamically update data
                if (chartData[type]) {
                    chart.series[0].setData(chartData[type]);
                }
            });
        });
    });
</script>
</body>
</html>
