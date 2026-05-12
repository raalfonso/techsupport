<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} - Employee Details</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-gray-100 dark:bg-slate-950">
    @include('attendance_logs._nav')
    <div class="container mx-auto p-4 mt-20">
    <div class="mx-auto max-w-screen-lg mt-5">
        <!-- Header Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <i class="material-icons text-blue-600 text-4xl">person</i>
                        Employee Details
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">View employee information</p>
                </div>
                <a href="{{ route('employee-list.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold hover:bg-gray-500 transition flex items-center gap-2">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Details Card -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <!-- Employee Avatar and Basic Info -->
            <div class="flex items-center gap-6 mb-8 pb-6 border-b border-gray-200 dark:border-slate-700">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-3xl font-bold">
                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}{{ strtoupper(substr($employee->last_name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $employee->full_name }}</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-400">{{ $employee->position }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Employee #{{ $employee->employee_number }}</p>
                </div>
            </div>

            <!-- Employee Information Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">First Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->first_name }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Middle Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->middle_name ?? 'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Last Name</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->last_name }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Employee Number</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white font-mono">{{ $employee->employee_number }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Position</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->position }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Department</p>
                    @if($employee->department)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                            {{ $employee->department->title }}
                        </span>
                    @else
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">N/A</p>
                    @endif
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Place of Assignment</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->place_of_assignment ?? 'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Date Hired</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->date_hired ? $employee->date_hired->format('F d, Y') : 'N/A' }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Employment Status</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                        {{ $employee->employment_status === 'Active' ? 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300' : '' }}
                        {{ $employee->employment_status === 'Inactive' ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-300' : '' }}
                        {{ $employee->employment_status === 'On Leave' ? 'bg-orange-100 text-orange-700 dark:bg-orange-900 dark:text-orange-300' : '' }}">
                        <i class="fas fa-circle text-xs mr-1"></i>
                        {{ $employee->employment_status }}
                    </span>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Employment Type</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $employee->employment_type }}</p>
                </div>

                <div class="p-4 bg-gray-50 dark:bg-slate-700 rounded-lg md:col-span-2">
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Email</p>
                    <a href="mailto:{{ $employee->email }}" class="text-lg font-semibold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ $employee->email }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
