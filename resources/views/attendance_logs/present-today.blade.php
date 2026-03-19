<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Present for Today - {{ env('APP_NAME', 'IT Department') }}</title>
    
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
                <button id="mobile-menu-button" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

    <main class="flex-grow bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Present for Today</h1>
                <p class="text-gray-600 mt-1">Employees who clocked in today - {{ now()->format('M d, Y') }}</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-6">
                    <div class="inline-block bg-blue-100 text-blue-700 px-4 py-2 rounded-lg font-semibold">
                        Total Present: {{ $presentEmployees->count() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee Name</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Employee ID</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Department</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Clock In Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($presentEmployees as $log)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $log->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $log->user->masterlist->employee_number ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-700">{{ $log->user->masterlist->department->title ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm font-mono text-gray-700">{{ date('g:i A', strtotime($log->time)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-gray-500 text-sm">No employees present today</td>
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
