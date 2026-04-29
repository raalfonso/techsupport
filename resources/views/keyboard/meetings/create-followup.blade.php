<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Follow-up Meeting - Key Board</title>
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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create Follow-up Meeting</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Follow-up from: <span class="font-semibold">{{ $meetingDetail->title }}</span>
                </p>
            </div>

            @if($incompleteTasks->isEmpty() && $incompleteAgendas->isEmpty())
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8 text-center">
                    <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">All Items Completed!</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">There are no incomplete tasks or agendas to follow up on.</p>
                    <a href="{{ route('keyboard.index') }}" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Back to Board
                    </a>
                </div>
            @else
                <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">
                    <form action="{{ route('meetings.store') }}" method="POST" x-data="followUpForm()">
                        @csrf

                        <!-- Meeting Details -->
                        <div class="mb-8">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Meeting Details</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Title *</label>
                                    <input type="text" name="title" value="{{ old('title', 'Follow-up: ' . $meetingDetail->title) }}" required 
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('title') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date *</label>
                                    <input type="date" name="date" value="{{ old('date') }}" required 
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('date') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Time * (e.g., 10:00AM-11:30AM)</label>
                                    <input type="text" name="time" value="{{ old('time') }}" placeholder="10:00AM-11:30AM" required 
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
                                            <option value="{{ $type->id }}" {{ old('type_id', $meetingDetail->type_id) == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Visibility</label>
                                    <div class="flex items-center gap-3 mt-3">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_public" value="1" class="sr-only peer" {{ old('is_public', $meetingDetail->is_public) ? 'checked' : '' }}>
                                            <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                            <span class="ms-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                                <span class="peer-checked:hidden">Private Meeting</span>
                                                <span class="hidden peer-checked:inline">Public Meeting</span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Attendees Section (Copied from original meeting) -->
                            <div class="mb-6" x-data="attendeeManager()">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                    Meeting Attendees
                                    <span class="text-xs font-normal text-blue-600 dark:text-blue-400">(Copied from original meeting)</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="attendeeSearch" autocomplete="off"
                                        @input="searchAttendees($event.target.value)"
                                        @focus="showAttendeeResults = true"
                                        class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="Search attendees by name or email...">
                                    <div x-show="showAttendeeResults && attendeeSearchResults.length > 0" 
                                        @click.away="showAttendeeResults = false"
                                        class="absolute z-10 w-full mt-1 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                        <template x-for="user in attendeeSearchResults" :key="user.id">
                                            <div @click="addAttendee(user)" 
                                                class="p-3 hover:bg-gray-100 dark:hover:bg-slate-600 cursor-pointer border-b border-gray-200 dark:border-slate-600 last:border-b-0">
                                                <div class="font-medium text-sm text-gray-900 dark:text-white" x-text="user.name"></div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400" x-text="user.email + (user.team ? ' • ' + user.team : '')"></div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2">
                                    <template x-for="(attendeeId, index) in attendees" :key="attendeeId">
                                        <div class="inline-flex items-center gap-2 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-3 py-2 rounded-lg text-sm">
                                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold"
                                                x-text="getAttendeeName(attendeeId).charAt(0).toUpperCase()">
                                            </div>
                                            <div>
                                                <div class="font-medium" x-text="getAttendeeName(attendeeId)"></div>
                                                <div class="text-xs opacity-75" x-text="getAttendeeEmail(attendeeId)"></div>
                                            </div>
                                            <button type="button" @click="removeAttendee(index)" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 ml-2">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="attendees[]" :value="attendeeId">
                                        </div>
                                    </template>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Attendees from the original meeting are pre-selected. You can add or remove attendees.
                                </p>
                            </div>
                        </div>

                        <!-- Incomplete Items as Agendas -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                    Agendas (from incomplete items)
                                </h2>
                                <button type="button" @click="addAgenda()" 
                                    class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                    <i class="fas fa-plus mr-2"></i> Add More
                                </button>
                            </div>

                            <div class="space-y-4">
                                <!-- Pre-populated from incomplete agendas -->
                                @foreach($incompleteAgendas as $index => $agenda)
                                    <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                                <i class="fas fa-list-check text-blue-600"></i>
                                                Agenda {{ $index + 1 }} (from previous meeting)
                                            </h3>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <input type="text" name="agendas[{{ $index }}][title]" value="{{ $agenda->title }}" required 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <textarea name="agendas[{{ $index }}][details]" placeholder="Details (optional)" rows="2" 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $agenda->details }}</textarea>
                                            </div>
                                            <div>
                                                <input type="text" name="agendas[{{ $index }}][assigned_personnel]" value="{{ $agenda->assigned_personnel }}" placeholder="Assigned personnel (optional)" 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pre-populated from incomplete tasks -->
                                @foreach($incompleteTasks as $index => $task)
                                    @php $agendaIndex = $incompleteAgendas->count() + $index; @endphp
                                    <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                                <i class="fas fa-tasks text-green-600"></i>
                                                Agenda {{ $agendaIndex + 1 }} (from task)
                                            </h3>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <input type="text" name="agendas[{{ $agendaIndex }}][title]" value="{{ $task->title }}" required 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <textarea name="agendas[{{ $agendaIndex }}][details]" placeholder="Details (optional)" rows="2" 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $task->details }}</textarea>
                                            </div>
                                            <div>
                                                <input type="text" name="agendas[{{ $agendaIndex }}][assigned_personnel]" value="{{ $task->assigned_personnel }}" placeholder="Assigned personnel (optional)" 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Dynamic agendas -->
                                <template x-for="(agenda, index) in agendas" :key="index">
                                    <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                                        <div class="flex justify-between items-start mb-3">
                                            <h3 class="font-semibold text-gray-900 dark:text-white" x-text="'Agenda ' + ({{ $incompleteAgendas->count() + $incompleteTasks->count() }} + index + 1)"></h3>
                                            <button type="button" @click="removeAgenda(index)" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        <div class="space-y-3">
                                            <div>
                                                <input type="text" :name="'agendas[' + ({{ $incompleteAgendas->count() + $incompleteTasks->count() }} + index) + '][title]'" x-model="agenda.title" placeholder="Agenda title" required 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                            <div>
                                                <textarea :name="'agendas[' + ({{ $incompleteAgendas->count() + $incompleteTasks->count() }} + index) + '][details]'" x-model="agenda.details" placeholder="Details (optional)" rows="2" 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                            </div>
                                            <div>
                                                <input type="text" :name="'agendas[' + ({{ $incompleteAgendas->count() + $incompleteTasks->count() }} + index) + '][assigned_personnel]'" x-model="agenda.assigned_personnel" placeholder="Assigned personnel (optional)" 
                                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-save mr-2"></i> Create Follow-up Meeting
                            </button>
                            <a href="{{ route('keyboard.index') }}" class="bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-500 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </main>

    <script>
        function attendeeManager() {
            return {
                attendees: @json($meetingDetail->attendees->pluck('attendee_id')->toArray()),
                attendeeSearchResults: [],
                showAttendeeResults: false,
                userCache: @json($meetingDetail->attendees->pluck('attendee')->keyBy('id')->toArray()),
                attendeeSearchTimeout: null,
                
                init() {
                    console.log('Initialized with attendees from original meeting:', this.attendees);
                },
                
                searchAttendees(query) {
                    clearTimeout(this.attendeeSearchTimeout);
                    
                    if (query.length < 2) {
                        this.attendeeSearchResults = [];
                        this.showAttendeeResults = false;
                        return;
                    }

                    this.attendeeSearchTimeout = setTimeout(() => {
                        fetch(`/users-search?q=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(response => response.json())
                        .then(users => {
                            // Cache users
                            users.forEach(user => {
                                this.userCache[user.id] = user;
                            });
                            
                            // Filter out already selected attendees
                            this.attendeeSearchResults = users.filter(user => !this.attendees.includes(user.id));
                            this.showAttendeeResults = true;
                        })
                        .catch(error => {
                            console.error('Error searching attendees:', error);
                        });
                    }, 300);
                },
                
                addAttendee(user) {
                    if (!this.attendees.includes(user.id)) {
                        this.attendees.push(user.id);
                        this.userCache[user.id] = user;
                    }
                    
                    // Clear search
                    document.getElementById('attendeeSearch').value = '';
                    this.attendeeSearchResults = [];
                    this.showAttendeeResults = false;
                },
                
                removeAttendee(index) {
                    this.attendees.splice(index, 1);
                },
                
                getAttendeeName(userId) {
                    return this.userCache[userId]?.name || 'Unknown User';
                },
                
                getAttendeeEmail(userId) {
                    return this.userCache[userId]?.email || '';
                }
            }
        }

        function followUpForm() {
            return {
                agendas: [],
                addAgenda() {
                    this.agendas.push({ title: '', details: '', assigned_personnel: '' });
                },
                removeAgenda(index) {
                    this.agendas.splice(index, 1);
                }
            }
        }
    </script>
</body>
</html>
