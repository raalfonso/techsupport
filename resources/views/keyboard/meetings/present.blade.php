<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meetingDetail->title }} - Presentation</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-page-break { page-break-before: always; }
        }
    </style>
</head>

<body class="bg-white min-h-screen">
    
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 py-6 px-6 no-print sticky top-0 z-40 backdrop-blur-sm bg-white/95">
        <div class="max-w-5xl mx-auto gap-4 flex justify-between items-center">
            <a href="{{ route('keyboard.index') }}" class="text-gray-600 hover:text-gray-900 transition-all duration-300 flex items-center gap-2 text-sm font-medium">
                <i class="fas fa-arrow-left"></i>
                <span>Back</span>
            </a>
            <div class="flex gap-3">
                <button onclick="window.print()" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 text-sm font-medium">
                    <i class="fas fa-print"></i>
                    <span>Print</span>
                </button>
                <button onclick="toggleFullscreen()" class="bg-gray-100 hover:bg-gray-200 text-gray-900 px-5 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 text-sm font-medium">
                    <i class="fas fa-expand"></i>
                    <span>Fullscreen</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Presentation Content -->
    <div class="max-w-5xl mx-auto px-6 py-16">
        
        <!-- Meeting Header -->
        <div class="mb-24 border-b border-gray-200 pb-16">
            <div class="max-w-3xl mx-auto text-center">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-widest">Meeting Presentation</span>
                <h1 class="text-5xl md:text-6xl font-light text-gray-900 my-8 leading-tight">{{ $meetingDetail->title }}</h1>
                <div class="flex flex-wrap justify-center items-center gap-4 text-gray-500 text-sm">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-gray-400 text-xs"></i>
                        <span>{{ $meetingDetail->date->format('F d, Y') }}</span>
                    </div>
                    <span class="text-gray-300">•</span>
                    <div class="flex items-center gap-2">
                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                        <span>{{ $meetingDetail->time }}</span>
                    </div>
                    @if($meetingDetail->venue)
                        <span class="text-gray-300">•</span>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gray-400 text-xs"></i>
                            <span>{{ $meetingDetail->venue }}</span>
                        </div>
                    @endif
                </div>
                @if($meetingDetail->type)
                    <div class="mt-6">
                        <span class="inline-block bg-gray-100 px-4 py-1.5 rounded-full text-gray-600 text-xs font-medium">
                            {{ $meetingDetail->type->title }}
                        </span>
                    </div>
                @endif
            </div>
            <br>
        </div>

        <!-- Agendas Section -->
        @if($meetingDetail->agendas->count() > 0)
            <div class="mb-20 print-page-break py-4">
                <div class="flex items-baseline justify-between mb-12 border-b border-gray-200 pb-4 py-4">
                    <h2 class="text-3xl font-light text-gray-900">Agendas</h2>
                    <span class="text-sm text-gray-400">{{ $meetingDetail->agendas->count() }} items</span>
                </div>
                
                <div class="space-y-8">
                    @foreach($meetingDetail->agendas as $index => $agenda)
                        <div class="group">
                            <div class="flex gap-6">
                                <div class="flex-shrink-0 w-8 text-right">
                                    <span class="text-sm font-medium text-gray-400">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-1 pb-8 border-b border-gray-100">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="text-xl font-medium text-gray-900">{{ $agenda->title }}</h3>
                                        <select onchange="promptRemarksForAgenda({{ $agenda->id }}, this.value, '{{ $agenda->status }}')" 
                                            data-original-status="{{ $agenda->status }}"
                                            class="ml-4 flex-shrink-0 px-3 py-1 rounded-md text-xs font-medium cursor-pointer transition-all {{ $agenda->status === 'Done' ? 'bg-green-50 text-green-700 hover:bg-green-100' : ($agenda->status === 'In Process' ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 'bg-gray-50 text-gray-600 hover:bg-gray-100') }}">
                                            <option value="Pending" {{ $agenda->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="In Process" {{ $agenda->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                            <option value="Done" {{ $agenda->status === 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </div>
                                    @if($agenda->details)
                                        <p class="text-gray-600 leading-relaxed mb-4">{{ $agenda->details }}</p>
                                    @endif
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        @if($agenda->assigned_personnel)
                                            <div class="flex items-center gap-1.5">
                                                <i class="fas fa-user text-xs"></i>
                                                <span>{{ $agenda->assigned_personnel }}</span>
                                            </div>
                                        @endif
                                        @if($agenda->updatedByUser)
                                            <div class="flex items-center gap-1.5">
                                                <i class="fas fa-user-edit text-xs"></i>
                                                <span>{{ $agenda->updatedByUser->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if($agenda->remarks)
                                        <div class="mt-4 bg-amber-50 border-l-2 border-amber-400 rounded-r-lg p-4">
                                            <p class="text-sm text-gray-700"><span class="font-medium">Remarks:</span> {{ $agenda->remarks }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Tasks Section -->
        @if($meetingDetail->tasks->count() > 0 || true)
            <div class="mb-20 print-page-break">
                <div class="flex items-baseline justify-between mb-12 border-b border-gray-200 pb-4">
                    <div class="flex items-baseline gap-4">
                        <h2 class="text-3xl font-light text-gray-900">Tasks</h2>
                        <span class="text-sm text-gray-400">{{ $meetingDetail->tasks->count() }} items</span>
                    </div>
                    <button onclick="openAddTaskModal()" class="no-print bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-all duration-300 flex items-center gap-2 text-sm font-medium">
                        <i class="fas fa-plus"></i>
                        <span>Add Task</span>
                    </button>
                </div>
                
                @if($meetingDetail->tasks->count() === 0)
                    <div class="text-center py-12 text-gray-400">
                        <i class="fas fa-tasks text-4xl mb-3"></i>
                        <p>No tasks yet. Click "Add Task" to create one.</p>
                    </div>
                @endif
                
                <div class="space-y-8">
                    @foreach($meetingDetail->tasks as $index => $task)
                        <div class="group">
                            <div class="flex gap-6">
                                <div class="flex-shrink-0 w-8 text-right">
                                    <span class="text-sm font-medium text-gray-400">{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-1 pb-8 border-b border-gray-100">
                                    <div class="flex items-start justify-between mb-3">
                                        <h3 class="text-xl font-medium text-gray-900">{{ $task->title }}</h3>
                                        <select onchange="promptRemarksForTask({{ $task->id }}, this.value, '{{ $task->status }}')" 
                                            data-original-status="{{ $task->status }}"
                                            class="ml-4 flex-shrink-0 px-3 py-1 rounded-md text-xs font-medium cursor-pointer transition-all {{ $task->status === 'Done' ? 'bg-green-50 text-green-700 hover:bg-green-100' : ($task->status === 'In Process' ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 'bg-gray-50 text-gray-600 hover:bg-gray-100') }}">
                                            <option value="Pending" {{ $task->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="In Process" {{ $task->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                            <option value="Done" {{ $task->status === 'Done' ? 'selected' : '' }}>Done</option>
                                        </select>
                                    </div>
                                    @if($task->details)
                                        <p class="text-gray-600 leading-relaxed mb-4">{{ $task->details }}</p>
                                    @endif
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                        @if($task->assigned_personnel)
                                            <div class="flex items-center gap-1.5">
                                                <i class="fas fa-user text-xs"></i>
                                                <span>{{ $task->assigned_personnel }}</span>
                                            </div>
                                        @endif
                                        @if($task->updatedByUser)
                                            <div class="flex items-center gap-1.5">
                                                <i class="fas fa-user-edit text-xs"></i>
                                                <span>{{ $task->updatedByUser->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    @if($task->remarks)
                                        <div class="mt-4 bg-amber-50 border-l-2 border-amber-400 rounded-r-lg p-4">
                                            <p class="text-sm text-gray-700"><span class="font-medium">Remarks:</span> {{ $task->remarks }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($task->taskAssigns->count() > 0)
                                        <div class="mt-6 pt-6 border-t border-gray-200">
                                            <h4 class="text-sm font-medium text-gray-700 mb-4 flex items-center gap-2">
                                                <i class="fas fa-users text-gray-400"></i>
                                                Assigned Personnel ({{ $task->taskAssigns->count() }})
                                            </h4>
                                            <div class="space-y-3">
                                                @foreach($task->taskAssigns as $assignment)
                                                    <div class="bg-gray-50 rounded-lg p-4">
                                                        <div class="flex items-center justify-between mb-2">
                                                            <div class="flex items-center gap-3 flex-1">
                                                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                                                    {{ strtoupper(substr($assignment->assignedPersonnel->name, 0, 1)) }}
                                                                </div>
                                                                <div>
                                                                    <p class="text-sm font-medium text-gray-900">
                                                                        {{ $assignment->assignedPersonnel->name }}
                                                                        @if(auth()->id() === $assignment->assigned_personnel_id)
                                                                            <span class="text-green-600">(You)</span>
                                                                        @endif
                                                                    </p>
                                                                    <p class="text-xs text-gray-500">{{ $assignment->assignedPersonnel->email }}</p>
                                                                </div>
                                                            </div>
                                                            @if(auth()->id() === $assignment->assigned_personnel_id)
                                                                <select onchange="promptRemarksForAssignment({{ $assignment->id }}, this.value, '{{ $assignment->status }}')" 
                                                                    data-original-status="{{ $assignment->status }}"
                                                                    class="px-3 py-1 rounded-md text-xs font-medium cursor-pointer transition-all {{ $assignment->status === 'Done' ? 'bg-green-50 text-green-700 hover:bg-green-100' : ($assignment->status === 'In Process' ? 'bg-yellow-50 text-yellow-700 hover:bg-yellow-100' : 'bg-gray-50 text-gray-600 hover:bg-gray-100') }}">
                                                                    <option value="Pending" {{ $assignment->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="In Process" {{ $assignment->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                                                                    <option value="Done" {{ $assignment->status === 'Done' ? 'selected' : '' }}>Done</option>
                                                                </select>
                                                            @else
                                                                <span class="px-3 py-1 rounded-md text-xs font-medium {{ $assignment->status === 'Done' ? 'bg-green-50 text-green-700' : ($assignment->status === 'In Process' ? 'bg-yellow-50 text-yellow-700' : 'bg-gray-50 text-gray-600') }}">
                                                                    {{ $assignment->status }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        @if($assignment->remarks)
                                                            <div class="mt-3 bg-blue-50 border-l-2 border-blue-400 rounded-r-lg p-3">
                                                                <p class="text-xs text-gray-700"><span class="font-medium">Remarks:</span> {{ $assignment->remarks }}</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>

    <!-- Remarks Modal -->
    <div id="remarksModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 no-print">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-medium text-gray-900">Add Remarks</h3>
                    <button onclick="closeRemarksModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mb-4">Please provide remarks for this status change:</p>
                <textarea id="remarksInput" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-none"
                    placeholder="Enter your remarks here..."></textarea>
                <div class="flex gap-3 mt-6">
                    <button onclick="closeRemarksModal()" 
                        class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Cancel
                    </button>
                    <button onclick="submitRemarks()" 
                        class="flex-1 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Assignment Remarks Modal -->
    <div id="assignmentRemarksModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 no-print">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-medium text-gray-900">Add Remarks (Optional)</h3>
                    <button onclick="closeAssignmentRemarksModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <p class="text-sm text-gray-600 mb-4">You can optionally add remarks for this status change:</p>
                <textarea id="assignmentRemarksInput" rows="4" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-none"
                    placeholder="Enter your remarks here (optional)..."></textarea>
                <div class="flex gap-3 mt-6">
                    <button onclick="submitAssignmentRemarksSkip()" 
                        class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                        Skip
                    </button>
                    <button onclick="submitAssignmentRemarks()" 
                        class="flex-1 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Task Modal -->
    <div id="addTaskModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 no-print">
        <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-medium text-gray-900">Add New Task</h3>
                    <button onclick="closeAddTaskModal()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form id="addTaskForm" onsubmit="submitNewTask(event)">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Task Title *</label>
                            <input type="text" id="taskTitle" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                placeholder="Enter task title">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Details</label>
                            <textarea id="taskDetails" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent resize-none"
                                placeholder="Enter task details (optional)"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assigned Personnel</label>
                            <input type="text" id="taskAssignedPersonnel"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-gray-900 focus:border-transparent"
                                placeholder="Enter assigned personnel (optional)">
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" onclick="closeAddTaskModal()" 
                            class="flex-1 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition">
                            Add Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50 border-t border-gray-200 py-8 mt-16 no-print">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <p class="text-gray-500 text-sm">Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
            <p class="text-gray-400 text-xs mt-2">Key-Board Meeting Management System</p>
        </div>
    </footer>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let currentAction = null;

        function promptRemarksForAgenda(agendaId, newStatus, oldStatus) {
            const selectElement = event.target;
            
            if (newStatus === oldStatus) {
                return;
            }

            currentAction = {
                type: 'agenda',
                id: agendaId,
                status: newStatus,
                oldStatus: oldStatus,
                selectElement: selectElement
            };

            document.getElementById('remarksModal').classList.remove('hidden');
            document.getElementById('remarksInput').value = '';
            document.getElementById('remarksInput').focus();
        }

        function promptRemarksForTask(taskId, newStatus, oldStatus) {
            const selectElement = event.target;
            
            if (newStatus === oldStatus) {
                return;
            }

            currentAction = {
                type: 'task',
                id: taskId,
                status: newStatus,
                oldStatus: oldStatus,
                selectElement: selectElement
            };

            document.getElementById('remarksModal').classList.remove('hidden');
            document.getElementById('remarksInput').value = '';
            document.getElementById('remarksInput').focus();
        }

        function closeRemarksModal() {
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

            document.getElementById('remarksModal').classList.add('hidden');

            if (currentAction.type === 'agenda') {
                updateAgendaStatus(currentAction.id, currentAction.status, remarks, currentAction.selectElement);
            } else if (currentAction.type === 'task') {
                updateTaskStatus(currentAction.id, currentAction.status, remarks, currentAction.selectElement);
            }

            currentAction = null;
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('remarksInput').addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    submitRemarks();
                }
            });

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

        // Assignment remarks modal functions
        let currentAssignmentAction = null;

        function promptRemarksForAssignment(assignmentId, newStatus, oldStatus) {
            const selectElement = event.target;
            
            if (newStatus === oldStatus) {
                return;
            }

            currentAssignmentAction = {
                id: assignmentId,
                status: newStatus,
                oldStatus: oldStatus,
                selectElement: selectElement
            };

            document.getElementById('assignmentRemarksModal').classList.remove('hidden');
            document.getElementById('assignmentRemarksInput').value = '';
            document.getElementById('assignmentRemarksInput').focus();
        }

        function closeAssignmentRemarksModal() {
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

            document.getElementById('assignmentRemarksModal').classList.add('hidden');
            updateAssignmentStatus(currentAssignmentAction.id, currentAssignmentAction.status, remarks, currentAssignmentAction.selectElement);
            currentAssignmentAction = null;
        }

        function submitAssignmentRemarksSkip() {
            if (!currentAssignmentAction) {
                return;
            }

            document.getElementById('assignmentRemarksModal').classList.add('hidden');
            updateAssignmentStatus(currentAssignmentAction.id, currentAssignmentAction.status, '', currentAssignmentAction.selectElement);
            currentAssignmentAction = null;
        }

        function updateAssignmentStatus(assignmentId, status, remarks, selectElement) {
            const originalValue = selectElement ? (selectElement.dataset.originalStatus || selectElement.value) : null;
            
            if (selectElement) {
                selectElement.disabled = true;
                selectElement.style.opacity = '0.6';
            }
            
            $.ajax({
                url: `/task-assigns/${assignmentId}/status`,
                method: 'POST',
                data: { 
                    status: status,
                    remarks: remarks || null
                },
                success: function(response) {
                    if (response.success) {
                        if (selectElement) {
                            selectElement.dataset.originalStatus = status;
                            
                            // Update colors based on status
                            selectElement.className = selectElement.className.replace(/bg-\w+-50 text-\w+-\d+ hover:bg-\w+-\d+/g, '');
                            if (status === 'Done') {
                                selectElement.className += ' bg-green-50 text-green-700 hover:bg-green-100';
                            } else if (status === 'In Process') {
                                selectElement.className += ' bg-yellow-50 text-yellow-700 hover:bg-yellow-100';
                            } else {
                                selectElement.className += ' bg-gray-50 text-gray-600 hover:bg-gray-100';
                            }
                        }
                        
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    } else {
                        alert(response.message || 'Failed to update assignment status');
                        if (selectElement && originalValue) {
                            selectElement.value = originalValue;
                        }
                    }
                },
                error: function(xhr) {
                    console.error('Error updating assignment status', xhr);
                    const message = xhr.responseJSON?.message || 'Failed to update assignment status';
                    alert(message);
                    if (selectElement && originalValue) {
                        selectElement.value = originalValue;
                    }
                },
                complete: function() {
                    if (selectElement) {
                        selectElement.disabled = false;
                        selectElement.style.opacity = '1';
                    }
                }
            });
        }

        function updateAgendaStatus(agendaId, status, remarks, selectElement) {
            const originalValue = selectElement.dataset.originalStatus || selectElement.value;
            
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
                    selectElement.dataset.originalStatus = status;
                    
                    // Update colors based on status
                    selectElement.className = selectElement.className.replace(/bg-\w+-50 text-\w+-\d+ hover:bg-\w+-\d+/g, '');
                    if (status === 'Done') {
                        selectElement.className += ' bg-green-50 text-green-700 hover:bg-green-100';
                    } else if (status === 'In Process') {
                        selectElement.className += ' bg-yellow-50 text-yellow-700 hover:bg-yellow-100';
                    } else {
                        selectElement.className += ' bg-gray-50 text-gray-600 hover:bg-gray-100';
                    }

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
                    selectElement.dataset.originalStatus = status;
                    
                    // Update colors based on status
                    selectElement.className = selectElement.className.replace(/bg-\w+-50 text-\w+-\d+ hover:bg-\w+-\d+/g, '');
                    if (status === 'Done') {
                        selectElement.className += ' bg-green-50 text-green-700 hover:bg-green-100';
                    } else if (status === 'In Process') {
                        selectElement.className += ' bg-yellow-50 text-yellow-700 hover:bg-yellow-100';
                    } else {
                        selectElement.className += ' bg-gray-50 text-gray-600 hover:bg-gray-100';
                    }

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

        function openAddTaskModal() {
            document.getElementById('addTaskModal').classList.remove('hidden');
            document.getElementById('taskTitle').focus();
        }

        function closeAddTaskModal() {
            document.getElementById('addTaskModal').classList.add('hidden');
            document.getElementById('addTaskForm').reset();
        }

        function submitNewTask(event) {
            event.preventDefault();
            
            const title = document.getElementById('taskTitle').value.trim();
            const details = document.getElementById('taskDetails').value.trim();
            const assignedPersonnel = document.getElementById('taskAssignedPersonnel').value.trim();
            
            if (!title) {
                alert('Please enter a task title');
                return;
            }

            $.ajax({
                url: `/meetings/{{ $meetingDetail->id }}/tasks`,
                method: 'POST',
                data: {
                    title: title,
                    details: details,
                    assigned_personnel: assignedPersonnel
                },
                success: function(response) {
                    closeAddTaskModal();
                    location.reload();
                },
                error: function(error) {
                    console.error('Error adding task', error);
                    alert('Failed to add task');
                }
            });
        }

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    </script>
</body>
</html>
