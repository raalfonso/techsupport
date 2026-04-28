<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Meeting - Key Board</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-slate-900">

    @include('keyboard._nav')
    
    <main class="flex-grow pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Meeting</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Update meeting details, agendas, and tasks</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">
                <form action="{{ route('meetings.update', $meetingDetail) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Meeting Details -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Meeting Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Title *</label>
                                <input type="text" name="title" value="{{ old('title', $meetingDetail->title) }}" required 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                                <input type="date" name="date" value="{{ old('date', $meetingDetail->date->format('Y-m-d')) }}" required 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Time * (e.g., 10:00AM-11:30AM)</label>
                                <input type="text" name="time" value="{{ old('time', $meetingDetail->time) }}" placeholder="10:00AM-11:30AM" required 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('time') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Venue</label>
                                <input type="text" name="venue" value="{{ old('venue', $meetingDetail->venue) }}" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Type</label>
                                <select name="type_id" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Type</option>
                                    @foreach($meetingTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('type_id', $meetingDetail->type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Existing Agendas -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Agendas</h2>
                        </div>

                        @if($meetingDetail->agendas->count() > 0)
                            <div class="space-y-4 mb-4">
                                @foreach($meetingDetail->agendas as $agenda)
                                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg border-l-4 border-blue-500">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $agenda->title }}</p>
                                                @if($agenda->details)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $agenda->details }}</p>
                                                @endif
                                                @if($agenda->assigned_personnel)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        <i class="fas fa-user"></i> {{ $agenda->assigned_personnel }}
                                                    </p>
                                                @endif
                                            </div>
                                            <span class="px-3 py-1 rounded-lg text-xs font-medium {{ $agenda->status === 'Done' ? 'bg-green-100 text-green-800' : ($agenda->status === 'In Process' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $agenda->status }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">No agendas yet</p>
                        @endif
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                            <i class="fas fa-info-circle"></i> To add or edit agendas, use the main board view
                        </p>
                    </div>

                    <!-- Existing Tasks -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tasks</h2>
                        </div>

                        @if($meetingDetail->tasks->count() > 0)
                            <div class="space-y-4 mb-4">
                                @foreach($meetingDetail->tasks as $task)
                                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg border-l-4 border-green-500">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-900 dark:text-white">{{ $task->title }}</p>
                                                @if($task->details)
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $task->details }}</p>
                                                @endif
                                                @if($task->assigned_personnel)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        <i class="fas fa-user"></i> {{ $task->assigned_personnel }}
                                                    </p>
                                                @endif
                                                @if($task->taskAssigns->count() > 0)
                                                    <div class="mt-2 flex flex-wrap gap-2">
                                                        @foreach($task->taskAssigns as $assignment)
                                                            <span class="inline-flex items-center gap-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded text-xs">
                                                                <i class="fas fa-user-check"></i>
                                                                {{ $assignment->assignedPersonnel->name }}
                                                                <span class="text-xs opacity-75">({{ $assignment->status }})</span>
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <button type="button" onclick="openAssignPersonnelModal({{ $task->id }}, '{{ addslashes($task->title) }}')" 
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium transition">
                                                    <i class="fas fa-user-plus"></i> Assign
                                                </button>
                                                <span class="px-3 py-1 rounded-lg text-xs font-medium {{ $task->status === 'Done' ? 'bg-green-100 text-green-800' : ($task->status === 'In Process' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $task->status }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">No tasks yet</p>
                        @endif
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">
                            <i class="fas fa-info-circle"></i> To add or edit tasks, use the main board view or presentation mode
                        </p>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Update Meeting
                        </button>
                        <a href="{{ route('keyboard.index') }}" class="bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-500 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Assign Personnel Modal -->
    <div id="assignPersonnelModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl max-w-lg w-full transform transition-all max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Assign Personnel</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400" id="modalTaskTitle"></p>
                    </div>
                    <button type="button" onclick="closeAssignPersonnelModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
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
                    <button type="button" onclick="closeAssignPersonnelModal()" 
                        class="flex-1 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition">
                        Cancel
                    </button>
                    <button type="button" onclick="submitAssignPersonnel()" 
                        class="flex-1 px-4 py-2 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 transition">
                        <i class="fas fa-user-plus mr-2"></i>Assign Personnel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTaskId = null;
        let selectedUserIds = [];
        let searchTimeout = null;

        function openAssignPersonnelModal(taskId, taskTitle) {
            currentTaskId = taskId;
            selectedUserIds = [];
            document.getElementById('assignPersonnelModal').classList.remove('hidden');
            document.getElementById('modalTaskTitle').textContent = taskTitle;
            document.getElementById('modalUserSearchInput').value = '';
            document.getElementById('modalSelectedUsers').innerHTML = '';
            document.getElementById('modalUserSearchResults').classList.add('hidden');
            document.getElementById('modalUserSearchInput').focus();
        }

        function closeAssignPersonnelModal() {
            document.getElementById('assignPersonnelModal').classList.add('hidden');
            currentTaskId = null;
            selectedUserIds = [];
        }

        // User search functionality
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('modalUserSearchInput');
            const searchResults = document.getElementById('modalUserSearchResults');

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
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

                        // Filter out already selected users
                        const filteredUsers = users.filter(user => !selectedUserIds.includes(user.id));

                        if (filteredUsers.length === 0) {
                            searchResults.innerHTML = '<div class="p-3 text-sm text-gray-500 dark:text-gray-400">All matching users already selected</div>';
                            searchResults.classList.remove('hidden');
                            return;
                        }

                        searchResults.innerHTML = filteredUsers.map(user => `
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

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('assignPersonnelModal').classList.contains('hidden')) {
                    closeAssignPersonnelModal();
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
            
            document.getElementById('modalSelectedUsers').appendChild(badge);
        }

        function removeSelectedUser(userId, buttonElement) {
            selectedUserIds = selectedUserIds.filter(id => id !== userId);
            buttonElement.closest('.inline-flex').remove();
        }

        function submitAssignPersonnel() {
            if (!currentTaskId || selectedUserIds.length === 0) {
                alert('Please select at least one user to assign');
                return;
            }

            // Create task assignments via AJAX
            const promises = selectedUserIds.map(userId => {
                return fetch('/task-assigns', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        meeting_task_id: currentTaskId,
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
                    closeAssignPersonnelModal();
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
