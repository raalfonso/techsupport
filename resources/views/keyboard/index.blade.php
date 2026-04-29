<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Board - Meeting Notes</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-slate-900 transition-colors duration-200">

    @include('keyboard._nav')
    
    <main class="flex-grow pt-16">
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <!-- Enhanced Logo with Icon -->
                    <div class="flex items-center gap-3">
                        <!-- Keyboard Key Icon with Checklist -->
                        <div class="relative">
                            <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <!-- Rounded Square Keyboard Key Background -->
                                <rect x="2" y="2" width="52" height="52" rx="12" fill="#0D9488" stroke="#115E59" stroke-width="2"/>
                                <rect x="4" y="4" width="48" height="48" rx="10" fill="url(#keyGradient)"/>
                                
                                <!-- Checklist Lines and Checkboxes -->
                                <!-- Line 1 with checkbox -->
                                <circle cx="14" cy="16" r="2.5" fill="white" opacity="0.9"/>
                                <line x1="20" y1="16" x2="42" y2="16" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.9"/>
                                
                                <!-- Line 2 with checkbox -->
                                <circle cx="14" cy="24" r="2.5" fill="white" opacity="0.9"/>
                                <line x1="20" y1="24" x2="42" y2="24" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.9"/>
                                
                                <!-- Line 3 with checkbox and clock icon (agenda item) -->
                                <circle cx="14" cy="32" r="2.5" fill="white" opacity="0.9"/>
                                <line x1="20" y1="32" x2="38" y2="32" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.9"/>
                                <!-- Small clock icon -->
                                <circle cx="42" cy="32" r="3" fill="white" opacity="0.9"/>
                                <line x1="42" y1="32" x2="42" y2="30" stroke="#0D9488" stroke-width="1" stroke-linecap="round"/>
                                <line x1="42" y1="32" x2="43.5" y2="32" stroke="#0D9488" stroke-width="1" stroke-linecap="round"/>
                                
                                <!-- Line 4 with checkbox -->
                                <circle cx="14" cy="40" r="2.5" fill="white" opacity="0.9"/>
                                <line x1="20" y1="40" x2="42" y2="40" stroke="white" stroke-width="2" stroke-linecap="round" opacity="0.9"/>
                                
                                <!-- Gradient Definition -->
                                <defs>
                                    <linearGradient id="keyGradient" x1="4" y1="4" x2="52" y2="52" gradientUnits="userSpaceOnUse">
                                        <stop offset="0%" stop-color="#14B8A6"/>
                                        <stop offset="100%" stop-color="#0D9488"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        
                        <!-- Logo Text -->
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">
                                <span class="font-normal text-teal-600 dark:text-teal-400">Key-</span><span class="font-bold text-blue-900 dark:text-blue-300">Board</span>
                            </h1>
                            <p class="text-gray-600 dark:text-gray-400 mt-1 text-sm">Meeting Notes & Task Management</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('meetings.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-8 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-300 flex items-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-plus"></i> New Meeting
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Stats Overview -->
            @php
                $totalAgendas = $meetings->sum(function($meeting) { return $meeting->agendas->count(); });
                $totalTasks = $meetings->sum(function($meeting) { return $meeting->tasks->count(); });
                $completedAgendas = $meetings->sum(function($meeting) { return $meeting->agendas->where('status', 'Done')->count(); });
                $completedTasks = $meetings->sum(function($meeting) { return $meeting->tasks->where('status', 'Done')->count(); });
                $totalItems = $totalAgendas + $totalTasks;
                $completedItems = $completedAgendas + $completedTasks;
                $completionRate = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Active Meetings Card -->
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Active Meetings</p>
                            <h3 class="text-4xl font-bold">{{ $meetings->count() }}</h3>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-calendar-check text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Agendas Card -->
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium mb-1">Total Agendas</p>
                            <h3 class="text-4xl font-bold">{{ $totalAgendas }}</h3>
                            <p class="text-purple-100 text-xs mt-1">{{ $completedAgendas }} completed</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-list-check text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Tasks Card -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium mb-1">Total Tasks</p>
                            <h3 class="text-4xl font-bold">{{ $totalTasks }}</h3>
                            <p class="text-green-100 text-xs mt-1">{{ $completedTasks }} completed</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-tasks text-3xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Completion Rate Card -->
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-6 text-white transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium mb-1">Completion Rate</p>
                            <h3 class="text-4xl font-bold">{{ $completionRate }}%</h3>
                            <p class="text-orange-100 text-xs mt-1">{{ $completedItems }}/{{ $totalItems }} items</p>
                        </div>
                        <div class="bg-white/20 p-4 rounded-xl">
                            <i class="fas fa-chart-pie text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kanban Board -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                @foreach($meetings as $meeting)
                    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden transform hover:scale-105 hover:shadow-2xl transition-all duration-300">
                        <!-- Meeting Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-6 text-white relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                            
                            <div class="relative z-10">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold">{{ $meeting->title }}</h3>
                                    <div class="flex gap-2">
                                        <a href="{{ route('meetings.present', $meeting) }}" class="text-white hover:text-green-200 transform hover:scale-110 transition-transform" title="Present Meeting">
                                            <i class="fas fa-presentation-screen"></i>
                                        </a>
                                        <a href="{{ route('meetings.follow-up', $meeting) }}" class="text-white hover:text-blue-200 transform hover:scale-110 transition-transform" title="Create Follow-up Meeting">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                        <a href="{{ route('meetings.edit', $meeting) }}" class="text-white hover:text-blue-200 transform hover:scale-110 transition-transform">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('meetings.destroy', $meeting) }}" method="POST" class="inline" onsubmit="return confirm('Delete this meeting?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white hover:text-red-200 transform hover:scale-110 transition-transform">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="space-y-2 text-sm">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-calendar"></i>
                                        <span>{{ $meeting->date->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-clock"></i>
                                        <span>{{ $meeting->time }}</span>
                                    </div>
                                    @if($meeting->venue)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <span>{{ $meeting->venue }}</span>
                                        </div>
                                    @endif
                                    @if($meeting->type)
                                        <div class="inline-block bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs mt-2">
                                            {{ $meeting->type->title }}
                                        </div>
                                    @endif
                                    <div class="flex items-center gap-2 mt-2">
                                        @if($meeting->is_public)
                                            <span class="inline-flex items-center gap-1 bg-green-500/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs">
                                                <i class="fas fa-globe"></i> Public
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-orange-500/20 backdrop-blur-sm px-3 py-1 rounded-full text-xs">
                                                <i class="fas fa-lock"></i> Private
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Highlights Section (Agendas with remarks from previous meetings) -->
                        @php
                            $highlightedAgendas = $meeting->agendas->filter(function($agenda) {
                                return !empty($agenda->remarks) && !$agenda->updated_by;
                            });
                        @endphp
                        @if($highlightedAgendas->count() > 0)
                            <div class="p-6 border-b border-gray-200 dark:border-slate-700 bg-amber-50/30 dark:bg-amber-900/10">
                                <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <div class="bg-amber-100 dark:bg-amber-900 p-2 rounded-lg">
                                        <i class="fas fa-star text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    <span>Highlights</span>
                                    <span class="ml-auto text-xs bg-amber-100 dark:bg-amber-900 text-amber-600 dark:text-amber-400 px-2 py-1 rounded-full">{{ $highlightedAgendas->count() }}</span>
                                </h4>
                                <div class="space-y-3">
                                    @foreach($highlightedAgendas as $agenda)
                                        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 dark:from-amber-900/20 dark:to-yellow-900/20 p-4 rounded-xl border-l-4 border-amber-500 hover:shadow-md transition-all duration-200">
                                            <div class="flex justify-between items-start mb-2 gap-2">
                                                <div class="flex items-start gap-3 flex-1">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <i class="fas fa-star text-amber-500"></i>
                                                    </div>
                                                    <p class="font-semibold text-sm text-gray-900 dark:text-white flex-1">{{ $agenda->title }}</p>
                                                </div>
                                                <button onclick="openCreateTaskFromAgenda({{ $meeting->id }}, '{{ addslashes($agenda->title) }}', '{{ addslashes($agenda->details ?? '') }}')" 
                                                    class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors flex-shrink-0" 
                                                    title="Create Task from Agenda">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                                <select onchange="promptRemarksForAgenda({{ $agenda->id }}, this.value, '{{ $agenda->status }}')" 
                                                    data-original-status="{{ $agenda->status }}"
                                                    class="text-xs px-3 py-1.5 rounded-lg border-0 font-medium transition-all duration-200 cursor-pointer flex-shrink-0 {{ $agenda->status === 'Done' ? 'bg-green-100 text-green-800 hover:bg-green-200' : ($agenda->status === 'In Process' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200') }}">
                                                    <option value="Pending" {{ $agenda->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In Process" {{ $agenda->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                                    <option value="Done" {{ $agenda->status === 'Done' ? 'selected' : '' }}>Done</option>
                                                </select>
                                            </div>
                                            <div class="ml-8">
                                                <p class="text-xs text-amber-800 dark:text-amber-300 leading-relaxed">{{ $agenda->remarks }}</p>
                                                @if($agenda->details)
                                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-2 leading-relaxed">{{ $agenda->details }}</p>
                                                @endif
                                                @if($agenda->assigned_personnel)
                                                    <div class="flex items-center gap-2 text-xs bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 px-3 py-1.5 rounded-lg w-fit mt-2">
                                                        <i class="fas fa-user text-amber-500"></i>
                                                        <span class="font-medium">{{ $agenda->assigned_personnel }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Agendas Section -->
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            @php
                                $regularAgendas = $meeting->agendas->filter(function($agenda) {
                                    return empty($agenda->remarks) || $agenda->updated_by;
                                });
                            @endphp
                            <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                                    <i class="fas fa-list-check text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span>Agendas</span>
                                <span class="ml-auto text-xs bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 px-2 py-1 rounded-full">{{ $regularAgendas->count() }}</span>
                            </h4>
                            <div class="space-y-3">
                                @forelse($regularAgendas as $agenda)
                                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-xl border-l-4 border-blue-500 hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                                        <div class="flex justify-between items-start mb-2 gap-2">
                                            <p class="font-semibold text-sm text-gray-900 dark:text-white flex-1">{{ $agenda->title }}</p>
                                            <button onclick="openCreateTaskFromAgenda({{ $meeting->id }}, '{{ addslashes($agenda->title) }}', '{{ addslashes($agenda->details ?? '') }}')" 
                                                class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors" 
                                                title="Create Task from Agenda">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                            <select onchange="promptRemarksForAgenda({{ $agenda->id }}, this.value, '{{ $agenda->status }}')" 
                                                data-original-status="{{ $agenda->status }}"
                                                class="text-xs px-3 py-1.5 rounded-lg border-0 font-medium transition-all duration-200 cursor-pointer {{ $agenda->status === 'Done' ? 'bg-green-100 text-green-800 hover:bg-green-200' : ($agenda->status === 'In Process' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200') }}">
                                                <option value="Pending" {{ $agenda->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Process" {{ $agenda->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                                <option value="Done" {{ $agenda->status === 'Done' ? 'selected' : '' }}>Done</option>
                                            </select>
                                        </div>
                                        @if($agenda->details)
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 leading-relaxed">{{ $agenda->details }}</p>
                                        @endif
                                        @if($agenda->remarks && $agenda->updatedByUser)
                                            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-2 border-amber-400 px-3 py-2 rounded mb-2">
                                                <p class="text-xs text-amber-800 dark:text-amber-300"><span class="font-semibold">Remarks:</span> {{ $agenda->remarks }}</p>
                                                <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                    <i class="fas fa-user-edit"></i> Updated by: <span class="font-medium">{{ $agenda->updatedByUser->name }}</span>
                                                </p>
                                            </div>
                                        @endif
                                        @if($agenda->assigned_personnel)
                                            <div class="flex items-center gap-2 text-xs bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 px-3 py-1.5 rounded-lg w-fit">
                                                <i class="fas fa-user text-blue-500"></i>
                                                <span class="font-medium">{{ $agenda->assigned_personnel }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <i class="fas fa-inbox text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">No agendas</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Tasks Section -->
                        <div class="p-6">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <div class="bg-green-100 dark:bg-green-900 p-2 rounded-lg">
                                    <i class="fas fa-tasks text-green-600 dark:text-green-400"></i>
                                </div>
                                <span>Tasks</span>
                                <span class="ml-auto text-xs bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-400 px-2 py-1 rounded-full">{{ $meeting->tasks->count() }}</span>
                            </h4>
                            <div class="space-y-3">
                                @forelse($meeting->tasks as $task)
                                    <div class="bg-gradient-to-r from-gray-50 to-green-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-xl border-l-4 border-green-500 hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                                        <div class="flex justify-between items-start mb-2 gap-2">
                                            <p class="font-semibold text-sm text-gray-900 dark:text-white flex-1">{{ $task->title }}</p>
                                            <button type="button" onclick="openAssignPersonnelModal({{ $task->id }}, '{{ addslashes($task->title) }}')" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-medium transition flex items-center gap-1 flex-shrink-0"
                                                title="Assign Personnel">
                                                <i class="fas fa-user-plus"></i>
                                            </button>
                                            <select onchange="promptRemarksForTask({{ $task->id }}, this.value, '{{ $task->status }}')" 
                                                data-original-status="{{ $task->status }}"
                                                class="text-xs px-3 py-1.5 rounded-lg border-0 font-medium transition-all duration-200 cursor-pointer flex-shrink-0 {{ $task->status === 'Done' ? 'bg-green-100 text-green-800 hover:bg-green-200' : ($task->status === 'In Process' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200') }}">
                                                <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Process" {{ $task->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                                <option value="Done" {{ $task->status === 'Done' ? 'selected' : '' }}>Done</option>
                                            </select>
                                        </div>
                                        @if($task->details)
                                            <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 leading-relaxed">{{ $task->details }}</p>
                                        @endif
                                        @if($task->remarks)
                                            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-2 border-amber-400 px-3 py-2 rounded mb-2">
                                                <p class="text-xs text-amber-800 dark:text-amber-300"><span class="font-semibold">Remarks:</span> {{ $task->remarks }}</p>
                                                @if($task->updatedByUser)
                                                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                        <i class="fas fa-user-edit"></i> Updated by: <span class="font-medium">{{ $task->updatedByUser->name }}</span>
                                                    </p>
                                                @endif
                                            </div>
                                        @endif
                                        @if($task->assigned_personnel)
                                            <div class="flex items-center gap-2 text-xs bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 px-3 py-1.5 rounded-lg w-fit mb-2">
                                                <i class="fas fa-user text-green-500"></i>
                                                <span class="font-medium">{{ $task->assigned_personnel }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($task->taskAssigns->count() > 0)
                                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-slate-600">
                                                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300 mb-2 flex items-center gap-1">
                                                    <i class="fas fa-users text-green-500"></i>
                                                    Assigned Personnel ({{ $task->taskAssigns->count() }})
                                                </p>
                                                <div class="space-y-2">
                                                    @foreach($task->taskAssigns as $assignment)
                                                        <div class="bg-white dark:bg-slate-800 px-3 py-2 rounded-lg">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <div class="flex items-center gap-2 flex-1">
                                                                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                                                        {{ strtoupper(substr($assignment->assignedPersonnel->name, 0, 1)) }}
                                                                    </div>
                                                                    <div>
                                                                        <p class="text-xs font-medium text-gray-900 dark:text-white">
                                                                            {{ $assignment->assignedPersonnel->name }}
                                                                            @if(auth()->id() === $assignment->assigned_personnel_id)
                                                                                <span class="text-green-600 dark:text-green-400">(You)</span>
                                                                            @endif
                                                                        </p>
                                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $assignment->assignedPersonnel->email }}</p>
                                                                    </div>
                                                                </div>
                                                                @if(auth()->id() === $assignment->assigned_personnel_id)
                                                                    <select onchange="promptRemarksForAssignment({{ $assignment->id }}, this.value, '{{ $assignment->status }}')" 
                                                                        data-original-status="{{ $assignment->status }}"
                                                                        class="text-xs px-2 py-1 rounded border-0 font-medium cursor-pointer {{ $assignment->status === 'Done' ? 'bg-green-100 text-green-800' : ($assignment->status === 'In Process' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                                        <option value="Pending" {{ $assignment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                        <option value="In Process" {{ $assignment->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                                                        <option value="Done" {{ $assignment->status === 'Done' ? 'selected' : '' }}>Done</option>
                                                                    </select>
                                                                @else
                                                                    <span class="text-xs px-2 py-1 rounded font-medium {{ $assignment->status === 'Done' ? 'bg-green-100 text-green-800' : ($assignment->status === 'In Process' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                                        {{ $assignment->status }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            @if($assignment->remarks)
                                                                <div class="bg-blue-50 dark:bg-blue-900/20 border-l-2 border-blue-400 px-2 py-1.5 rounded mt-2">
                                                                    <p class="text-xs text-blue-800 dark:text-blue-300"><span class="font-semibold">Remarks:</span> {{ $assignment->remarks }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center py-8">
                                        <i class="fas fa-inbox text-3xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">No tasks</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($meetings->isEmpty())
                <div class="text-center py-20 bg-white dark:bg-slate-800 rounded-2xl shadow-lg">
                    <div class="mb-6">
                        <div class="inline-block p-6 bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900 dark:to-purple-900 rounded-full">
                            <i class="fas fa-clipboard-list text-6xl text-blue-600 dark:text-blue-400"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No meetings yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-8 text-lg">Create your first meeting to get started with task management</p>
                    <a href="{{ route('meetings.create') }}" class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-8 py-4 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i> Create Your First Meeting
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- Remarks Modal -->
    <div id="remarksModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add Remarks</h3>
                    <button onclick="closeRemarksModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Please provide remarks for this status change:</p>
                <textarea id="remarksInput" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white resize-none"
                    placeholder="Enter your remarks here..."></textarea>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeRemarksModal()" 
                        class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                    <button onclick="submitRemarks()" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg hover:from-blue-700 hover:to-purple-700 transition">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Remarks Modal -->
    <div id="assignmentRemarksModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">Add Remarks (Optional)</h3>
                    <button onclick="closeAssignmentRemarksModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">You can optionally add remarks for this status change:</p>
                <textarea id="assignmentRemarksInput" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white resize-none"
                    placeholder="Enter your remarks here (optional)..."></textarea>
                <div class="flex gap-3 mt-6">
                    <button onclick="submitAssignmentRemarksSkip()" 
                        class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition">
                        Skip
                    </button>
                    <button onclick="submitAssignmentRemarks()" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assign Personnel Modal -->
    <div id="assignPersonnelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Assign Personnel</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400" id="modalTaskTitle"></p>
                    </div>
                    <button type="button" onclick="closeAssignPersonnelModalIndex()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search Users</label>
                        <div class="relative">
                            <input type="text" id="modalUserSearchInput" autocomplete="off"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                placeholder="Search users by name or email...">
                            <div id="modalUserSearchResults" class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg shadow-lg max-h-48 overflow-y-auto"></div>
                        </div>
                    </div>
                    <div id="modalSelectedUsers" class="flex flex-wrap gap-2"></div>
                </div>

                <div class="flex gap-3 mt-6">
                    <button type="button" onclick="closeAssignPersonnelModalIndex()" 
                        class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                    <button type="button" onclick="submitAssignPersonnelIndex()" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition">
                        <i class="fas fa-user-plus mr-2"></i>Assign Personnel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Task from Agenda Modal -->
    <div id="createTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all max-h-[90vh] overflow-y-auto">
            <form id="createTaskForm" method="POST">
                @csrf
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Create Task from Agenda</h3>
                        <button type="button" onclick="closeCreateTaskModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Task Title</label>
                            <input type="text" id="taskTitle" name="title" required
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                placeholder="Enter task title">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Task Details</label>
                            <textarea id="taskDetails" name="details" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white resize-none"
                                placeholder="Enter task details (optional)"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assign to Users</label>
                            <div class="relative">
                                <input type="text" id="userSearchInput" autocomplete="off"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                    placeholder="Search users by name or email...">
                                <div id="userSearchResults" class="hidden absolute z-10 w-full mt-1 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg shadow-lg max-h-48 overflow-y-auto"></div>
                            </div>
                            <div id="selectedUsers" class="mt-3 flex flex-wrap gap-2"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assigned Personnel (Text)</label>
                            <input type="text" name="assigned_personnel"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white"
                                placeholder="Enter assigned personnel text (optional)">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">This is a text field for display purposes</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status"
                                class="w-full px-4 py-3 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                                <option value="Pending">Pending</option>
                                <option value="In Process">In Process</option>
                                <option value="Done">Done</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="closeCreateTaskModal()" 
                            class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition">
                            <i class="fas fa-plus mr-2"></i>Create Task
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-white dark:bg-slate-800 border-t border-gray-200 dark:border-slate-700 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-center space-y-2">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Powered by</span>
                    <img src="{{ asset('images/ICTD_Logo.png') }}" alt="ICTD Logo" class="h-8 w-auto" />
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    © 2026 Key-Board • Bases Conversion and Development Authority (BCDA). All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let currentAction = null; // Store current action details

        function promptRemarksForAgenda(agendaId, newStatus, oldStatus) {
            const selectElement = event.target;
            
            // If status hasn't changed, do nothing
            if (newStatus === oldStatus) {
                return;
            }

            // Store action details
            currentAction = {
                type: 'agenda',
                id: agendaId,
                status: newStatus,
                oldStatus: oldStatus,
                selectElement: selectElement
            };

            // Show modal
            document.getElementById('remarksModal').classList.remove('hidden');
            document.getElementById('remarksInput').value = '';
            document.getElementById('remarksInput').focus();
        }

        function promptRemarksForTask(taskId, newStatus, oldStatus) {
            const selectElement = event.target;
            
            // If status hasn't changed, do nothing
            if (newStatus === oldStatus) {
                return;
            }

            // Store action details
            currentAction = {
                type: 'task',
                id: taskId,
                status: newStatus,
                oldStatus: oldStatus,
                selectElement: selectElement
            };

            // Show modal
            document.getElementById('remarksModal').classList.remove('hidden');
            document.getElementById('remarksInput').value = '';
            document.getElementById('remarksInput').focus();
        }

        function closeRemarksModal() {
            // Reset select to original value
            if (currentAction && currentAction.selectElement) {
                currentAction.selectElement.value = currentAction.oldStatus;
            }
            
            document.getElementById('remarksModal').classList.add('hidden');
            document.getElementById('remarksInput').value = '';
            currentAction = null;
        }

        function submitRemarks() {
            const remarks = document.getElementById('remarksInput').value.trim();
            
            if (!remarks) {
                alert('Please enter remarks before submitting');
                return;
            }

            if (!currentAction) {
                return;
            }

            // Close modal
            document.getElementById('remarksModal').classList.add('hidden');

            // Update status with remarks
            if (currentAction.type === 'agenda') {
                updateAgendaStatus(currentAction.id, currentAction.status, remarks, currentAction.selectElement);
            } else if (currentAction.type === 'task') {
                updateTaskStatus(currentAction.id, currentAction.status, remarks, currentAction.selectElement);
            }

            currentAction = null;
        }

        // Allow Enter key to submit (with Shift+Enter for new line)
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('remarksInput').addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    submitRemarks();
                }
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!document.getElementById('remarksModal').classList.contains('hidden')) {
                        closeRemarksModal();
                    }
                    if (!document.getElementById('assignmentRemarksModal').classList.contains('hidden')) {
                        closeAssignmentRemarksModal();
                    }
                }
            });
        });

        function updateAgendaStatus(agendaId, status, remarks, selectElement) {
            const originalValue = selectElement.dataset.originalStatus || selectElement.value;
            
            // Add loading state
            selectElement.disabled = true;
            selectElement.style.opacity = '0.6';
            
            $.ajax({
                url: `/keyboard/agendas/${agendaId}/status`,
                method: 'POST',
                data: { 
                    status: status,
                    remarks: remarks
                },
                success: function(response) {
                    console.log('Agenda status updated');
                    selectElement.dataset.originalStatus = status;
                    
                    // Add success animation
                    selectElement.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        selectElement.style.transform = 'scale(1)';
                    }, 200);
                    
                    // Update colors based on status
                    selectElement.className = selectElement.className.replace(/bg-\w+-100 text-\w+-800 hover:bg-\w+-200/g, '');
                    if (status === 'Done') {
                        selectElement.className += ' bg-green-100 text-green-800 hover:bg-green-200';
                    } else if (status === 'In Process') {
                        selectElement.className += ' bg-yellow-100 text-yellow-800 hover:bg-yellow-200';
                    } else {
                        selectElement.className += ' bg-gray-100 text-gray-800 hover:bg-gray-200';
                    }

                    // Reload page to show updated remarks
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                },
                error: function(error) {
                    console.error('Error updating agenda status', error);
                    alert('Failed to update status');
                    selectElement.value = originalValue;
                },
                complete: function() {
                    selectElement.disabled = false;
                    selectElement.style.opacity = '1';
                }
            });
        }

        function updateTaskStatus(taskId, status, remarks, selectElement) {
            const originalValue = selectElement.dataset.originalStatus || selectElement.value;
            
            // Add loading state
            selectElement.disabled = true;
            selectElement.style.opacity = '0.6';
            
            $.ajax({
                url: `/keyboard/tasks/${taskId}/status`,
                method: 'POST',
                data: { 
                    status: status,
                    remarks: remarks
                },
                success: function(response) {
                    console.log('Task status updated');
                    selectElement.dataset.originalStatus = status;
                    
                    // Add success animation
                    selectElement.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        selectElement.style.transform = 'scale(1)';
                    }, 200);
                    
                    // Update colors based on status
                    selectElement.className = selectElement.className.replace(/bg-\w+-100 text-\w+-800 hover:bg-\w+-200/g, '');
                    if (status === 'Done') {
                        selectElement.className += ' bg-green-100 text-green-800 hover:bg-green-200';
                    } else if (status === 'In Process') {
                        selectElement.className += ' bg-yellow-100 text-yellow-800 hover:bg-yellow-200';
                    } else {
                        selectElement.className += ' bg-gray-100 text-gray-800 hover:bg-gray-200';
                    }

                    // Reload page to show updated remarks
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                },
                error: function(error) {
                    console.error('Error updating task status', error);
                    alert('Failed to update status');
                    selectElement.value = originalValue;
                },
                complete: function() {
                    selectElement.disabled = false;
                    selectElement.style.opacity = '1';
                }
            });
        }

        // Add fade-in animation on page load
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.grid > div');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Create Task from Agenda functions
        let selectedUserIds = [];

        function openCreateTaskFromAgenda(meetingId, agendaTitle, agendaDetails) {
            document.getElementById('createTaskModal').classList.remove('hidden');
            document.getElementById('taskTitle').value = agendaTitle;
            document.getElementById('taskDetails').value = agendaDetails;
            
            // Reset selected users
            selectedUserIds = [];
            document.getElementById('selectedUsers').innerHTML = '';
            document.getElementById('userSearchInput').value = '';
            
            // Set form action
            document.getElementById('createTaskForm').action = `/meetings/${meetingId}/tasks`;
            
            document.getElementById('taskTitle').focus();
        }

        function closeCreateTaskModal() {
            document.getElementById('createTaskModal').classList.add('hidden');
            document.getElementById('createTaskForm').reset();
            selectedUserIds = [];
            document.getElementById('selectedUsers').innerHTML = '';
            document.getElementById('userSearchResults').classList.add('hidden');
        }

        // User search functionality
        let searchTimeout;
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('userSearchInput');
            const searchResults = document.getElementById('userSearchResults');

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`/users-search?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(users => {
                            if (users.length === 0) {
                                searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500 dark:text-gray-400">No users found</div>';
                                searchResults.classList.remove('hidden');
                                return;
                            }

                            searchResults.innerHTML = users.map(user => `
                                <div class="p-3 hover:bg-gray-100 dark:hover:bg-slate-600 cursor-pointer border-b border-gray-200 dark:border-slate-600 last:border-b-0 user-result" 
                                    data-user-id="${user.id}" 
                                    data-user-name="${user.name}"
                                    data-user-email="${user.email}">
                                    <div class="font-medium text-sm text-gray-900 dark:text-white">${user.name}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">${user.email}${user.team ? ' • ' + user.team : ''}</div>
                                </div>
                            `).join('');
                            searchResults.classList.remove('hidden');

                            // Add click handlers
                            document.querySelectorAll('.user-result').forEach(el => {
                                el.addEventListener('click', function() {
                                    const userId = parseInt(this.dataset.userId);
                                    const userName = this.dataset.userName;
                                    const userEmail = this.dataset.userEmail;
                                    
                                    if (!selectedUserIds.includes(userId)) {
                                        addSelectedUser(userId, userName, userEmail);
                                    }
                                    
                                    searchInput.value = '';
                                    searchResults.classList.add('hidden');
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error searching users:', error);
                        });
                }, 300);
            });

            // Close search results when clicking outside
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.classList.add('hidden');
                }
            });
        });

        function addSelectedUser(userId, userName, userEmail) {
            selectedUserIds.push(userId);
            
            const badge = document.createElement('div');
            badge.className = 'inline-flex items-center gap-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1.5 rounded-lg text-sm';
            badge.innerHTML = `
                <div>
                    <div class="font-medium">${userName}</div>
                    <div class="text-xs opacity-75">${userEmail}</div>
                </div>
                <button type="button" onclick="removeSelectedUser(${userId}, this)" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.getElementById('selectedUsers').appendChild(badge);
        }

        function removeSelectedUser(userId, buttonElement) {
            selectedUserIds = selectedUserIds.filter(id => id !== userId);
            buttonElement.closest('.inline-flex').remove();
        }

        // Assignment remarks modal functions
        let currentAssignmentAction = null;

        function promptRemarksForAssignment(assignmentId, newStatus, oldStatus) {
            const selectElement = event.target;
            
            // If status hasn't changed, do nothing
            if (newStatus === oldStatus) {
                return;
            }

            // Store action details
            currentAssignmentAction = {
                id: assignmentId,
                status: newStatus,
                oldStatus: oldStatus,
                selectElement: selectElement
            };

            // Show modal
            document.getElementById('assignmentRemarksModal').classList.remove('hidden');
            document.getElementById('assignmentRemarksInput').value = '';
            document.getElementById('assignmentRemarksInput').focus();
        }

        function closeAssignmentRemarksModal() {
            // Reset select to original value
            if (currentAssignmentAction && currentAssignmentAction.selectElement) {
                currentAssignmentAction.selectElement.value = currentAssignmentAction.oldStatus;
            }
            
            document.getElementById('assignmentRemarksModal').classList.add('hidden');
            document.getElementById('assignmentRemarksInput').value = '';
            currentAssignmentAction = null;
        }

        function submitAssignmentRemarks() {
            const remarks = document.getElementById('assignmentRemarksInput').value.trim();
            
            if (!currentAssignmentAction) {
                return;
            }

            // Close modal
            document.getElementById('assignmentRemarksModal').classList.add('hidden');

            // Update status with remarks
            updateAssignmentStatus(currentAssignmentAction.id, currentAssignmentAction.status, remarks, currentAssignmentAction.selectElement);

            currentAssignmentAction = null;
        }

        function submitAssignmentRemarksSkip() {
            if (!currentAssignmentAction) {
                return;
            }

            // Close modal
            document.getElementById('assignmentRemarksModal').classList.add('hidden');

            // Update status without remarks
            updateAssignmentStatus(currentAssignmentAction.id, currentAssignmentAction.status, '', currentAssignmentAction.selectElement);

            currentAssignmentAction = null;
        }

        // Update assignment status
        function updateAssignmentStatus(assignmentId, status, remarks, selectElement) {
            const originalValue = selectElement ? (selectElement.dataset.originalStatus || selectElement.value) : null;
            
            // Add loading state
            if (selectElement) {
                selectElement.disabled = true;
                selectElement.style.opacity = '0.6';
            }
            
            fetch(`/task-assigns/${assignmentId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ 
                    status: status,
                    remarks: remarks || null
                })
            })
            .then(response => {
                if (response.status === 403) {
                    return response.json().then(data => {
                        throw new Error(data.message || 'You are not authorized to update this assignment status.');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    console.log('Assignment status updated successfully');
                    if (selectElement) {
                        selectElement.dataset.originalStatus = status;
                        
                        // Update colors based on status
                        selectElement.className = selectElement.className.replace(/bg-\w+-100 text-\w+-800/g, '');
                        if (status === 'Done') {
                            selectElement.className += ' bg-green-100 text-green-800';
                        } else if (status === 'In Process') {
                            selectElement.className += ' bg-yellow-100 text-yellow-800';
                        } else {
                            selectElement.className += ' bg-gray-100 text-gray-800';
                        }
                    }
                    
                    // Reload to show remarks
                    setTimeout(() => {
                        location.reload();
                    }, 500);
                } else {
                    alert('Failed to update assignment status');
                    if (selectElement && originalValue) {
                        selectElement.value = originalValue;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'Failed to update assignment status');
                if (selectElement && originalValue) {
                    selectElement.value = originalValue;
                }
            })
            .finally(() => {
                if (selectElement) {
                    selectElement.disabled = false;
                    selectElement.style.opacity = '1';
                }
            });
        }

        // Handle form submission
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('createTaskForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                // Add selected user IDs to form data
                selectedUserIds.forEach(userId => {
                    formData.append('assigned_users[]', userId);
                });
                
                const actionUrl = this.action;
                
                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeCreateTaskModal();
                        location.reload();
                    } else {
                        alert('Failed to create task');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to create task');
                });
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (!document.getElementById('createTaskModal').classList.contains('hidden')) {
                        closeCreateTaskModal();
                    }
                }
            });
        });

        // Assign Personnel Modal Functions for Index Page
        let currentTaskIdIndex = null;
        let selectedUserIdsIndex = [];
        let searchTimeoutIndex = null;

        function openAssignPersonnelModal(taskId, taskTitle) {
            currentTaskIdIndex = taskId;
            selectedUserIdsIndex = [];
            document.getElementById('assignPersonnelModal').classList.remove('hidden');
            document.getElementById('modalTaskTitle').textContent = taskTitle;
            document.getElementById('modalUserSearchInput').value = '';
            document.getElementById('modalSelectedUsers').innerHTML = '';
            document.getElementById('modalUserSearchResults').classList.add('hidden');
            document.getElementById('modalUserSearchInput').focus();
        }

        function closeAssignPersonnelModalIndex() {
            document.getElementById('assignPersonnelModal').classList.add('hidden');
            currentTaskIdIndex = null;
            selectedUserIdsIndex = [];
        }

        // User search for assign modal
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('modalUserSearchInput');
            const searchResults = document.getElementById('modalUserSearchResults');

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeoutIndex);
                    const query = this.value.trim();

                    if (query.length < 2) {
                        searchResults.classList.add('hidden');
                        return;
                    }

                    searchTimeoutIndex = setTimeout(() => {
                        fetch(`/users-search?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(users => {
                            if (users.length === 0) {
                                searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500 dark:text-gray-400">No users found</div>';
                                searchResults.classList.remove('hidden');
                                return;
                            }

                            const filteredUsers = users.filter(user => !selectedUserIdsIndex.includes(user.id));

                            if (filteredUsers.length === 0) {
                                searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500 dark:text-gray-400">All matching users already selected</div>';
                                searchResults.classList.remove('hidden');
                                return;
                            }

                            searchResults.innerHTML = filteredUsers.map(user => `
                                <div class="p-3 hover:bg-gray-100 dark:hover:bg-slate-600 cursor-pointer border-b border-gray-200 dark:border-slate-600 last:border-b-0 user-result-modal" 
                                    data-user-id="${user.id}" 
                                    data-user-name="${user.name}"
                                    data-user-email="${user.email}">
                                    <div class="font-medium text-sm text-gray-900 dark:text-white">${user.name}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">${user.email}${user.team ? ' • ' + user.team : ''}</div>
                                </div>
                            `).join('');
                            searchResults.classList.remove('hidden');

                            document.querySelectorAll('.user-result-modal').forEach(el => {
                                el.addEventListener('click', function() {
                                    const userId = parseInt(this.dataset.userId);
                                    const userName = this.dataset.userName;
                                    const userEmail = this.dataset.userEmail;
                                    
                                    if (!selectedUserIdsIndex.includes(userId)) {
                                        addSelectedUserModal(userId, userName, userEmail);
                                    }
                                    
                                    searchInput.value = '';
                                    searchResults.classList.add('hidden');
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error searching users:', error);
                        });
                    }, 300);
                });
            }
        });

        function addSelectedUserModal(userId, userName, userEmail) {
            selectedUserIdsIndex.push(userId);
            
            const badge = document.createElement('div');
            badge.className = 'inline-flex items-center gap-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-3 py-1.5 rounded-lg text-sm';
            badge.innerHTML = `
                <div>
                    <div class="font-medium">${userName}</div>
                    <div class="text-xs opacity-75">${userEmail}</div>
                </div>
                <button type="button" onclick="removeSelectedUserModal(${userId}, this)" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            document.getElementById('modalSelectedUsers').appendChild(badge);
        }

        function removeSelectedUserModal(userId, buttonElement) {
            selectedUserIdsIndex = selectedUserIdsIndex.filter(id => id !== userId);
            buttonElement.closest('.inline-flex').remove();
        }

        function submitAssignPersonnelIndex() {
            if (!currentTaskIdIndex || selectedUserIdsIndex.length === 0) {
                alert('Please select at least one user to assign');
                return;
            }

            const promises = selectedUserIdsIndex.map(userId => {
                return fetch('/task-assigns', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        meeting_task_id: currentTaskIdIndex,
                        assigned_personnel_id: userId,
                        status: 'Pending'
                    })
                }).then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Failed to assign user');
                        });
                    }
                    return response.json();
                });
            });

            Promise.all(promises)
                .then(results => {
                    closeAssignPersonnelModalIndex();
                    location.reload();
                })
                .catch(error => {
                    console.error('Error assigning personnel:', error);
                    alert(error.message || 'Failed to assign personnel');
                });
        }
    </script>
</body>
</html>
