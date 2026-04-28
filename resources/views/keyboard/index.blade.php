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
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Key-Board</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-2 text-lg">Meeting Notes & Task Management</p>
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
                                </div>
                            </div>
                        </div>

                        <!-- Agendas Section -->
                        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <div class="bg-blue-100 dark:bg-blue-900 p-2 rounded-lg">
                                    <i class="fas fa-list-check text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span>Agendas</span>
                                <span class="ml-auto text-xs bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 px-2 py-1 rounded-full">{{ $meeting->agendas->count() }}</span>
                            </h4>
                            <div class="space-y-3">
                                @forelse($meeting->agendas as $agenda)
                                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 dark:from-slate-700 dark:to-slate-600 p-4 rounded-xl border-l-4 border-blue-500 hover:shadow-md transition-all duration-200 transform hover:-translate-y-1">
                                        <div class="flex justify-between items-start mb-2">
                                            <p class="font-semibold text-sm text-gray-900 dark:text-white flex-1">{{ $agenda->title }}</p>
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
                                        @if($agenda->remarks)
                                            <div class="bg-amber-50 dark:bg-amber-900/20 border-l-2 border-amber-400 px-3 py-2 rounded mb-2">
                                                <p class="text-xs text-amber-800 dark:text-amber-300"><span class="font-semibold">Remarks:</span> {{ $agenda->remarks }}</p>
                                                @if($agenda->updatedByUser)
                                                    <p class="text-xs text-amber-700 dark:text-amber-400 mt-1">
                                                        <i class="fas fa-user-edit"></i> Updated by: <span class="font-medium">{{ $agenda->updatedByUser->name }}</span>
                                                    </p>
                                                @endif
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
                                        <div class="flex justify-between items-start mb-2">
                                            <p class="font-semibold text-sm text-gray-900 dark:text-white flex-1">{{ $task->title }}</p>
                                            <select onchange="promptRemarksForTask({{ $task->id }}, this.value, '{{ $task->status }}')" 
                                                data-original-status="{{ $task->status }}"
                                                class="text-xs px-3 py-1.5 rounded-lg border-0 font-medium transition-all duration-200 cursor-pointer {{ $task->status === 'Done' ? 'bg-green-100 text-green-800 hover:bg-green-200' : ($task->status === 'In Process' ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200') }}">
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
                                            <div class="flex items-center gap-2 text-xs bg-white dark:bg-slate-800 text-gray-700 dark:text-gray-300 px-3 py-1.5 rounded-lg w-fit">
                                                <i class="fas fa-user text-green-500"></i>
                                                <span class="font-medium">{{ $task->assigned_personnel }}</span>
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
                    closeRemarksModal();
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
    </script>
</body>
</html>
