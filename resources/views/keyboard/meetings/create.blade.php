<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Meeting - Key Board</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd.png') }}">
    <script>
        if (localStorage.getItem('cw-theme') === 'dark') document.documentElement.classList.add('dark');
    </script>
</head>

<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-slate-900">

    @include('keyboard._nav')
    
    <main class="flex-grow pt-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Meeting</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Add meeting details, agendas, and tasks</p>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg p-8">
                <form action="{{ route('meetings.store') }}" method="POST" x-data="meetingForm()">
                    @csrf

                    <!-- Meeting Details -->
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Meeting Details</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Title *</label>
                                <input type="text" name="title" value="{{ old('title') }}" required 
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
                                <input type="text" name="venue" value="{{ old('venue') }}" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Meeting Type</label>
                                <select name="type_id" 
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="">Select Type</option>
                                    @foreach($meetingTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Agendas -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Agendas</h2>
                            <button type="button" @click="addAgenda()" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                <i class="fas fa-plus mr-2"></i> Add Agenda
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(agenda, index) in agendas" :key="index">
                                <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white" x-text="'Agenda ' + (index + 1)"></h3>
                                        <button type="button" @click="removeAgenda(index)" class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" :name="'agendas[' + index + '][title]'" x-model="agenda.title" placeholder="Agenda title" required 
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <textarea :name="'agendas[' + index + '][details]'" x-model="agenda.details" placeholder="Details (optional)" rows="2" 
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                        <div>
                                            <input type="text" :name="'agendas[' + index + '][assigned_personnel]'" x-model="agenda.assigned_personnel" placeholder="Assigned personnel (optional)" 
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Tasks -->
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Tasks</h2>
                            <button type="button" @click="addTask()" 
                                class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition">
                                <i class="fas fa-plus mr-2"></i> Add Task
                            </button>
                        </div>

                        <div class="space-y-4">
                            <template x-for="(task, index) in tasks" :key="index">
                                <div class="bg-gray-50 dark:bg-slate-700 p-4 rounded-lg">
                                    <div class="flex justify-between items-start mb-3">
                                        <h3 class="font-semibold text-gray-900 dark:text-white" x-text="'Task ' + (index + 1)"></h3>
                                        <button type="button" @click="removeTask(index)" class="text-red-600 hover:text-red-700">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" :name="'tasks[' + index + '][title]'" x-model="task.title" placeholder="Task title" required 
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <textarea :name="'tasks[' + index + '][details]'" x-model="task.details" placeholder="Details (optional)" rows="2" 
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                        <div>
                                            <input type="text" :name="'tasks[' + index + '][assigned_personnel]'" x-model="task.assigned_personnel" placeholder="Assigned personnel (optional)" 
                                                class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i> Create Meeting
                        </button>
                        <a href="{{ route('keyboard.index') }}" class="bg-gray-400 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-500 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function meetingForm() {
            return {
                agendas: [],
                tasks: [],
                addAgenda() {
                    this.agendas.push({ title: '', details: '', assigned_personnel: '' });
                },
                removeAgenda(index) {
                    this.agendas.splice(index, 1);
                },
                addTask() {
                    this.tasks.push({ title: '', details: '', assigned_personnel: '' });
                },
                removeTask(index) {
                    this.tasks.splice(index, 1);
                }
            }
        }
    </script>
</body>
</html>
