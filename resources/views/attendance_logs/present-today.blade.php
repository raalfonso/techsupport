<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>On Duty - {{ env('APP_NAME', 'IT Department') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Present for Today</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Employees who clocked in today — {{ now()->format('M d, Y') }}</p>
                @php
                    $isDeptHead  = auth()->user()->authAssignments()->where('item_name', 'depthead')->exists();
                    $isAdminOrHR = auth()->user()->authAssignments()->whereIn('item_name', ['Administrator', 'HR_admin'])->exists();
                @endphp
                @if($isDeptHead && !$isAdminOrHR)
                    @php $myDept = auth()->user()->masterlist?->department?->title ?? 'Your Department'; @endphp
                    <span class="inline-block mt-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs font-semibold px-3 py-1 rounded-full">
                        <i class="material-icons text-xs align-middle">filter_list</i> Filtered: {{ $myDept }}
                    </span>
                @endif
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                <div class="mb-6">
                    <div class="inline-block bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-4 py-2 rounded-lg font-semibold">
                        Total Present: {{ $presentEmployees->count() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-slate-600">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Employee ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Clock In Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($presentEmployees as $log)
                                <tr class="border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-medium">{{ $log->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $log->user->masterlist->employee_number ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">{{ $log->user->masterlist->department->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm font-mono text-gray-700 dark:text-gray-300">{{ date('g:i A', strtotime($log->time)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 text-sm">No employees present today</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 py-6 mt-auto">
        <p class="text-center text-sm text-gray-600 dark:text-gray-400">
            © 2026 ClockWize • Powered by the ICT Department – Bases Conversion and Development Authority
        </p>
    </footer>
</body>
</html>
