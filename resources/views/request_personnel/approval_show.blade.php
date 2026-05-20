<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $requestPersonnel->event_title }} - Approval - {{ env('APP_NAME', 'IT Department') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen pt-16 bg-gray-50 dark:bg-slate-900 transition-colors duration-200">

    @include('request_personnel._nav')

    <main class="flex-grow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $requestPersonnel->event_title }}</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Request Approval Details</p>
                    </div>
                    <a href="{{ route('request-personnel.approval') }}" class="bg-gray-300 hover:bg-gray-400 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-900 dark:text-white px-6 py-3 rounded-lg font-semibold transition flex items-center gap-2 shadow-md hover:shadow-lg">
                        <i class="material-icons">arrow_back</i>
                        Back
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 px-6 py-4 rounded-lg flex items-center gap-3 shadow-sm mb-6">
                    <i class="material-icons text-green-500">check_circle</i>
                    <div>
                        <p class="font-semibold">Success!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Details Card -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Event Title</h3>
                                <p class="text-lg text-gray-900 dark:text-white font-medium">{{ $requestPersonnel->event_title }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Point Person</h3>
                                <p class="text-lg text-gray-900 dark:text-white font-medium">{{ $requestPersonnel->point_person ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Requestor</h3>
                                <p class="text-lg text-gray-900 dark:text-white font-medium">{{ $requestPersonnel->requestor->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $requestPersonnel->requestor->email }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $requestPersonnel->requestor->department->name ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Status</h3>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'cancelled' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400',
                                    ];
                                @endphp
                                <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$requestPersonnel->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($requestPersonnel->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Start Date/Time</h3>
                                <p class="text-lg text-gray-900 dark:text-white font-medium">{{ $requestPersonnel->start_date_time->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $requestPersonnel->start_date_time->format('H:i') }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">End Date/Time</h3>
                                <p class="text-lg text-gray-900 dark:text-white font-medium">{{ $requestPersonnel->end_date_time->format('M d, Y') }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $requestPersonnel->end_date_time->format('H:i') }}</p>
                            </div>
                        </div>

                        @if($requestPersonnel->meeting_link)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Meeting Link</h3>
                                <a href="{{ $requestPersonnel->meeting_link }}" target="_blank" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 underline flex items-center gap-1">
                                    {{ $requestPersonnel->meeting_link }}
                                    <i class="material-icons text-sm">open_in_new</i>
                                </a>
                            </div>
                        @endif

                        @if($requestPersonnel->resources->count() > 0)
                            <div>
                                <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wide mb-2">Resources Needed</h3>
                                <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-4">
                                    <ul class="space-y-2">
                                        @foreach($requestPersonnel->resources as $resource)
                                            <li class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                                <i class="material-icons text-blue-600 dark:text-blue-400 text-sm">check_circle</i>
                                                {{ $resource->item_name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Assigned Staff Section -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class="material-icons">group</i>
                            Assigned Staff
                        </h3>
                        <form action="{{ route('request-personnel.assign-staff', $requestPersonnel) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="bg-gray-50 dark:bg-slate-700/50 rounded-lg p-4 border border-gray-200 dark:border-slate-600 max-h-64 overflow-y-auto">
                                @if($users->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($users as $user)
                                            <label class="flex items-center gap-3 p-3 rounded-lg hover:bg-white dark:hover:bg-slate-700 cursor-pointer transition">
                                                <input type="checkbox" name="staff[]" value="{{ $user->id }}" class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500" {{ $requestPersonnel->assignedStaff->contains($user->id) ? 'checked' : '' }}>
                                                <span class="text-sm text-gray-900 dark:text-gray-100">{{ $user->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No users available</p>
                                @endif
                            </div>
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Update Assigned Staff
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Actions Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class="material-icons">approval</i>
                            Actions
                        </h3>
                        <div class="space-y-3">
                            @if($requestPersonnel->status === 'pending')
                                <form action="{{ route('request-personnel.update-status', $requestPersonnel) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                        <i class="material-icons">check_circle</i>
                                        Approve Request
                                    </button>
                                </form>
                                <form action="{{ route('request-personnel.update-status', $requestPersonnel) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="w-full text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                        <i class="material-icons">cancel</i>
                                        Reject Request
                                    </button>
                                </form>
                            @elseif($requestPersonnel->status === 'approved')
                                <form action="{{ route('request-personnel.update-status', $requestPersonnel) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition flex items-center justify-center gap-2">
                                        <i class="material-icons">done_all</i>
                                        Mark as Completed
                                    </button>
                                </form>
                            @else
                                <p class="text-sm text-gray-600 dark:text-gray-400 text-center py-4">No actions available for {{ $requestPersonnel->status }} requests</p>
                            @endif
                        </div>
                    </div>

                    <!-- Info Card -->
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <i class="material-icons">info</i>
                            Information
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">Created</p>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $requestPersonnel->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">Updated</p>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $requestPersonnel->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
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
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © 2026 Personnel Request System • Bases Conversion and Development Authority (BCDA). All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
