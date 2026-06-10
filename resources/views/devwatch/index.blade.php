<x-layout>
    <div class="mx-auto w-full p-6" x-data="{ 
        showModal: false, 
        editModal: false, 
        showEditProjectModal: false,
        showProjectModal: false, 
        manageMembersModal: false, 
        editProject: null,
        editItem: null, 
        selectedProject: null, 
        selectedProjectId: null,
        viewMode: 'table' 
    }">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">DevWatch</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Development monitoring and tracking</p>
                </div>
                <div class="flex items-center space-x-3">
                    <!-- View Toggle -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border border-gray-200 dark:border-gray-700 p-1 flex">
                        <button @click="viewMode = 'table'" :class="viewMode === 'table' ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-400'" class="px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                            <i class="fa-solid fa-table"></i>
                            <span class="hidden md:inline">Table</span>
                        </button>
                        <button @click="viewMode = 'kanban'" :class="viewMode === 'kanban' ? 'bg-blue-600 text-white' : 'text-gray-600 dark:text-gray-400'" class="px-4 py-2 rounded-lg transition-all duration-200 flex items-center space-x-2">
                            <i class="fa-solid fa-columns"></i>
                            <span class="hidden md:inline">Kanban</span>
                        </button>
                    </div>
                    <button @click="showProjectModal = true" class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                        <i class="fa-solid fa-folder-plus"></i>
                        <span>New Project</span>
                    </button>
                    <button @click="showModal = true" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                        <i class="fa-solid fa-plus"></i>
                        <span>New Item</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Stats -->
        @php
            $totalProjects = $projects->count();
            $totalItems = $items->total();
            $requestedProjects = $projects->where('status', 'Requested')->count();
            $pendingProjects = $projects->where('status', 'Pending')->count();
            $evaluationProjects = $projects->where('status', 'For Evaluation')->count();
            $deliveryProjects = $projects->where('status', 'Development')->count() + $projects->where('status', 'Testing')->count() + $projects->where('status', 'User Acceptance Training')->count();
            $deployedProjects = $projects->where('status', 'Deployed')->count();
            $blockedProjects = $projects->where('status', 'On Hold')->count() + $projects->where('status', 'For Enhancement')->count();
            $activeProjectCount = $pendingProjects + $evaluationProjects + $deliveryProjects;
            $projectCompletionRate = $totalProjects > 0 ? round(($deployedProjects / $totalProjects) * 100) : 0;

            $projectStatusStyles = [
                'Requested' => 'bg-sky-100 text-sky-800 dark:bg-sky-950/60 dark:text-sky-300',
                'Pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300',
                'For Evaluation' => 'bg-violet-100 text-violet-800 dark:bg-violet-950/60 dark:text-violet-300',
                'Data Gathering' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-950/60 dark:text-cyan-300',
                'On Hold' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/60 dark:text-rose-300',
                'Development' => 'bg-orange-100 text-orange-800 dark:bg-orange-950/60 dark:text-orange-300',
                'Testing' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-950/60 dark:text-indigo-300',
                'User Acceptance Training' => 'bg-fuchsia-100 text-fuchsia-800 dark:bg-fuchsia-950/60 dark:text-fuchsia-300',
                'Deployed' => 'bg-green-100 text-green-800 dark:bg-green-950/60 dark:text-green-300',
                'For Enhancement' => 'bg-lime-100 text-lime-800 dark:bg-lime-950/60 dark:text-lime-300',
            ];
        @endphp

        <div class="mb-8 rounded-3xl border border-gray-200/70 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 shadow-2xl backdrop-blur">
            <div class="flex flex-col gap-4 border-b border-gray-200/70 dark:border-gray-700 px-6 py-5 md:flex-row md:items-end md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.25em] text-blue-600 dark:text-blue-400">Dashboard Snapshot</p>
                    <h2 class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">Project status at a glance</h2>
                    <p class="mt-1 max-w-2xl text-sm text-gray-600 dark:text-gray-400">A quick read on where projects sit in the workflow and which stages need attention right now.</p>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="group relative overflow-hidden rounded-3xl border border-blue-100 bg-gradient-to-br from-blue-50 via-white to-cyan-50 p-5 shadow-sm transition-transform duration-200 hover:-translate-y-1 dark:border-blue-900/60 dark:from-blue-950/70 dark:via-gray-800 dark:to-cyan-950/40">
                    <div class="absolute right-0 top-0 h-24 w-24 -translate-y-1/2 translate-x-1/2 rounded-full bg-blue-500/10 blur-2xl"></div>
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Projects</p>
                            <p class="mt-2 text-4xl font-black tracking-tight text-gray-900 dark:text-white">{{ $totalProjects }}</p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">All projects currently in the dashboard</p>
                        </div>
                        <div class="rounded-2xl bg-blue-600 p-3 text-white shadow-lg shadow-blue-600/20">
                            <i class="fa-solid fa-folder text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-3xl border border-sky-100 bg-gradient-to-br from-sky-50 via-white to-cyan-50 p-5 shadow-sm transition-transform duration-200 hover:-translate-y-1 dark:border-sky-900/60 dark:from-sky-950/70 dark:via-gray-800 dark:to-cyan-950/40">
                    <div class="absolute right-0 top-0 h-24 w-24 -translate-y-1/2 translate-x-1/2 rounded-full bg-sky-500/10 blur-2xl"></div>
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Requested</p>
                            <p class="mt-2 text-4xl font-black tracking-tight text-gray-900 dark:text-white">{{ $requestedProjects }}</p>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Waiting in the intake queue</p>
                        </div>
                        <div class="rounded-2xl bg-sky-600 p-3 text-white shadow-lg shadow-sky-600/20">
                            <i class="fa-solid fa-inbox text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-3xl border border-amber-100 bg-gradient-to-br from-amber-50 via-white to-orange-50 p-5 shadow-sm transition-transform duration-200 hover:-translate-y-1 dark:border-amber-900/60 dark:from-amber-950/70 dark:via-gray-800 dark:to-orange-950/40">
                    <div class="absolute right-0 top-0 h-24 w-24 -translate-y-1/2 translate-x-1/2 rounded-full bg-amber-500/10 blur-2xl"></div>
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">In Progress</p>
                            <p class="mt-2 text-4xl font-black tracking-tight text-gray-900 dark:text-white">{{ $activeProjectCount }}</p>
                            <div class="mt-4 h-2 overflow-hidden rounded-full bg-amber-100 dark:bg-amber-900/50">
                                <div class="h-full rounded-full bg-gradient-to-r from-amber-500 to-orange-500" style="width: {{ $totalProjects > 0 ? min(100, round(($activeProjectCount / $totalProjects) * 100)) : 0 }}%"></div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Pending, evaluation, and delivery stages combined</p>
                        </div>
                        <div class="rounded-2xl bg-amber-500 p-3 text-white shadow-lg shadow-amber-500/20">
                            <i class="fa-solid fa-clock text-xl"></i>
                        </div>
                    </div>
                </div>

                <div class="group relative overflow-hidden rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50 via-white to-teal-50 p-5 shadow-sm transition-transform duration-200 hover:-translate-y-1 dark:border-emerald-900/60 dark:from-emerald-950/70 dark:via-gray-800 dark:to-teal-950/40">
                    <div class="absolute right-0 top-0 h-24 w-24 -translate-y-1/2 translate-x-1/2 rounded-full bg-emerald-500/10 blur-2xl"></div>
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Deployed</p>
                            <p class="mt-2 text-4xl font-black tracking-tight text-gray-900 dark:text-white">{{ $deployedProjects }}</p>
                            <div class="mt-4 h-2 overflow-hidden rounded-full bg-emerald-100 dark:bg-emerald-900/50">
                                <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-500" style="width: {{ $projectCompletionRate }}%"></div>
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Delivered projects out of the total pipeline</p>
                        </div>
                        <div class="rounded-2xl bg-emerald-500 p-3 text-white shadow-lg shadow-emerald-500/20">
                            <i class="fa-solid fa-rocket text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200/70 dark:border-gray-700 px-6 py-5">
                <div class="flex flex-wrap items-center gap-2 text-xs font-medium">
                    @foreach(['Requested', 'Pending', 'For Evaluation', 'Data Gathering', 'On Hold', 'Development', 'Testing', 'User Acceptance Training', 'Deployed', 'For Enhancement'] as $statusLabel)
                        @php
                            $statusCount = $projects->where('status', $statusLabel)->count();
                            $statusClass = $projectStatusStyles[$statusLabel] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200';
                        @endphp
                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1.5 {{ $statusClass }}">
                            <span class="h-1.5 w-1.5 rounded-full bg-current opacity-70"></span>
                            {{ $statusLabel }} {{ $statusCount }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Projects Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8">
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Projects</h2>
                    <div class="flex space-x-3">
                        <select id="project-status-filter" onchange="filterProjects()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">All Status</option>
                            <option value="Requested">Requested</option>
                            <option value="Pending">Pending</option>
                            <option value="For Evaluation">For Evaluation</option>
                            <option value="Data Gathering">Data Gathering</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Development">Development</option>
                            <option value="Testing">Testing</option>
                            <option value="User Acceptance Training">User Acceptance Training</option>
                            <option value="Deployed">Deployed</option>
                            <option value="For Enhancement">For Enhancement</option>
                        </select>
                        <input type="text" id="project-search" onkeyup="filterProjects()" placeholder="Search projects..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                    </div>
                </div>
            </div>
            <div class="p-8">
                @if($projects->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Members</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Items</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="projects-tbody">
                                @foreach($projects as $project)
                                <tr data-status="{{ $project->status }}" data-name="{{ strtolower($project->name) }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $project->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($project->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $projectStatusClass = $projectStatusStyles[$project->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $projectStatusClass }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $project->user->name ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($project->members->take(3) as $member)
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                                                    {{ $member->user->name }}
                                                </span>
                                            @endforeach
                                            @if($project->members->count() > 3)
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">
                                                    +{{ $project->members->count() - 3 }} more
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        @php
                                            $statusCounts = $project->devWatches->groupBy('status')->map->count();
                                        @endphp
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($statusCounts as $status => $count)
                                                <span class="px-2 py-1 text-xs rounded-full
                                                    @if($status == 'open') bg-blue-100 text-blue-800
                                                    @elseif($status == 'in_progress') bg-yellow-100 text-yellow-800
                                                    @elseif($status == 'resolved') bg-green-100 text-green-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst(str_replace('_', ' ', $status)) }}: {{ $count }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button @click="manageMembersModal = true; selectedProject = {{ $project->toJson() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs">
                                                <i class="fa-solid fa-users mr-1"></i>
                                                Manage
                                            </button>
                                            <button @click="showModal = true; selectedProjectId = {{ $project->id }}" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-lg text-xs">
                                                <i class="fa-solid fa-plus mr-1"></i>
                                                Add Item
                                            </button>
                                            <button @click="showEditProjectModal = true; selectedProject = {{ $project->toJson() }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1 rounded-lg text-xs">
                                                <i class="fa-solid fa-pen-to-square mr-1"></i>
                                                Edit    
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600 dark:text-gray-400">No projects created yet</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kanban Board View -->
        <div x-show="viewMode === 'kanban'" x-cloak class="mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">Kanban Board</h2>
                    <div class="flex space-x-3">
                        <select id="kanban-project-filter" onchange="filterKanban()" class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg text-sm">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <select id="kanban-priority-filter" onchange="filterKanban()" class="px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-lg text-sm">
                            <option value="">All Priority</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Open Column -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="bg-blue-600 text-white px-4 py-3 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-dot"></i>
                            <h3 class="font-bold">Open</h3>
                        </div>
                        <span class="bg-blue-700 px-2 py-1 rounded-full text-xs">{{ $items->where('status', 'open')->count() }}</span>
                    </div>
                    <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto kanban-column" data-status="open">
                        @foreach($items->where('status', 'open') as $item)
                            <div class="kanban-card bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all cursor-pointer" 
                                 data-project="{{ $item->project_id }}" 
                                 data-priority="{{ $item->priority }}"
                                 @click="editModal = true; editItem = {{ $item->toJson() }}">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ Str::limit($item->title, 40) }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full flex-shrink-0 ml-2
                                        @if($item->priority == 'critical') bg-red-100 text-red-800
                                        @elseif($item->priority == 'high') bg-orange-100 text-orange-800
                                        @elseif($item->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($item->description, 80) }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-user mr-1"></i>
                                        {{ $item->user->name ?? 'Unknown' }}
                                    </span>
                                    @if($item->reported_date)
                                        <span>{{ $item->reported_date->format('M d') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- In Progress Column -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="bg-yellow-600 text-white px-4 py-3 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-spinner"></i>
                            <h3 class="font-bold">In Progress</h3>
                        </div>
                        <span class="bg-yellow-700 px-2 py-1 rounded-full text-xs">{{ $items->where('status', 'in_progress')->count() }}</span>
                    </div>
                    <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto kanban-column" data-status="in_progress">
                        @foreach($items->where('status', 'in_progress') as $item)
                            <div class="kanban-card bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all cursor-pointer" 
                                 data-project="{{ $item->project_id }}" 
                                 data-priority="{{ $item->priority }}"
                                 @click="editModal = true; editItem = {{ $item->toJson() }}">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ Str::limit($item->title, 40) }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full flex-shrink-0 ml-2
                                        @if($item->priority == 'critical') bg-red-100 text-red-800
                                        @elseif($item->priority == 'high') bg-orange-100 text-orange-800
                                        @elseif($item->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($item->description, 80) }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-user mr-1"></i>
                                        {{ $item->user->name ?? 'Unknown' }}
                                    </span>
                                    @if($item->start_date)
                                        <span>{{ $item->start_date->format('M d') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Resolved Column -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="bg-green-600 text-white px-4 py-3 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-check-circle"></i>
                            <h3 class="font-bold">Resolved</h3>
                        </div>
                        <span class="bg-green-700 px-2 py-1 rounded-full text-xs">{{ $items->where('status', 'resolved')->count() }}</span>
                    </div>
                    <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto kanban-column" data-status="resolved">
                        @foreach($items->where('status', 'resolved') as $item)
                            <div class="kanban-card bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all cursor-pointer" 
                                 data-project="{{ $item->project_id }}" 
                                 data-priority="{{ $item->priority }}"
                                 @click="editModal = true; editItem = {{ $item->toJson() }}">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ Str::limit($item->title, 40) }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full flex-shrink-0 ml-2
                                        @if($item->priority == 'critical') bg-red-100 text-red-800
                                        @elseif($item->priority == 'high') bg-orange-100 text-orange-800
                                        @elseif($item->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($item->description, 80) }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-user mr-1"></i>
                                        {{ $item->user->name ?? 'Unknown' }}
                                    </span>
                                    @if($item->end_date)
                                        <span>{{ $item->end_date->format('M d') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Closed Column -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="bg-gray-600 text-white px-4 py-3 rounded-t-2xl flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-times-circle"></i>
                            <h3 class="font-bold">Closed</h3>
                        </div>
                        <span class="bg-gray-700 px-2 py-1 rounded-full text-xs">{{ $items->where('status', 'closed')->count() }}</span>
                    </div>
                    <div class="p-4 space-y-3 max-h-[600px] overflow-y-auto kanban-column" data-status="closed">
                        @foreach($items->where('status', 'closed') as $item)
                            <div class="kanban-card bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-all cursor-pointer" 
                                 data-project="{{ $item->project_id }}" 
                                 data-priority="{{ $item->priority }}"
                                 @click="editModal = true; editItem = {{ $item->toJson() }}">
                                <div class="flex items-start justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ Str::limit($item->title, 40) }}</h4>
                                    <span class="px-2 py-1 text-xs rounded-full flex-shrink-0 ml-2
                                        @if($item->priority == 'critical') bg-red-100 text-red-800
                                        @elseif($item->priority == 'high') bg-orange-100 text-orange-800
                                        @elseif($item->priority == 'medium') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($item->priority) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($item->description, 80) }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center">
                                        <i class="fa-solid fa-user mr-1"></i>
                                        {{ $item->user->name ?? 'Unknown' }}
                                    </span>
                                    @if($item->end_date)
                                        <span>{{ $item->end_date->format('M d') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- DevWatch Items Table -->
        <div x-show="viewMode === 'table'" x-cloak class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">DevWatch Items</h2>
                    <div class="flex space-x-3">
                        <select id="project-filter" onchange="filterItems()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">All Projects</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        <select id="status-filter" onchange="filterItems()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">All Status</option>
                            <option value="open">Open</option>
                            <option value="in_progress">In Progress</option>
                            <option value="resolved">Resolved</option>
                            <option value="closed">Closed</option>
                        </select>
                        <select id="priority-filter" onchange="filterItems()" class="px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            <option value="">All Priority</option>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="p-8">
                @if($items->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reported By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Reported Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Created By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="items-tbody">
                                @foreach($items as $item)
                                <tr data-status="{{ $item->status }}" data-priority="{{ $item->priority }}" data-project="{{ $item->project_id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $item->title }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($item->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($item->priority == 'critical') bg-red-100 text-red-800
                                            @elseif($item->priority == 'high') bg-orange-100 text-orange-800
                                            @elseif($item->priority == 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($item->priority) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($item->status == 'open') bg-blue-100 text-blue-800
                                            @elseif($item->status == 'in_progress') bg-yellow-100 text-yellow-800
                                            @elseif($item->status == 'resolved') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->requestor_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->reported_date ? $item->reported_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->start_date ? $item->start_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->end_date ? $item->end_date->format('M d, Y') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $item->user->name ?? 'Unknown' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button @click="editModal = true; editItem = {{ $item->toJson() }}" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg text-xs">
                                                <i class="fa-solid fa-edit mr-1"></i>
                                                Update
                                            </button>
                                            <form action="{{ route('devwatch.destroy', $item) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg text-xs" onclick="return confirm('Are you sure?')">
                                                    <i class="fa-solid fa-trash mr-1"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $items->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="fa-solid fa-code text-6xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No DevWatch Items</h3>
                        <p class="text-gray-600 dark:text-gray-400">Create your first development monitoring item</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Create Modal -->
        <div x-show="showModal" x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
            <div class="bg-white w-11/12 md:w-1/2 max-w-lg max-h-[90vh] p-0 rounded-2xl shadow-2xl flex flex-col">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-2xl">
                    <h2 class="text-xl font-bold text-white">Create DevWatch Item</h2>
                </div>
                <form action="{{ route('devwatch.store') }}" method="POST" class="flex-1 overflow-scroll">
                    @csrf
                    <input type="hidden" name="project_id" x-bind:value="selectedProjectId">
                    <div class="p-6 max-h-full" style="scrollbar-width: thin;">
                        <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                            <select name="type" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="Bugs">Bugs</option>
                                <option value="Improvement">Improvement</option>
                                <option value="New Feature">New Feature</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="open" selected>Open</option>
                                <option value="in_progress">In Progress</option>
                                <option value="resolved">Resolved</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                            <textarea name="remarks" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Optional remarks or notes"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Requestor Name</label>
                                <input type="text" name="requestor_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Reported Date</label>
                                <input type="date" name="reported_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <input type="date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <input type="date" name="end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 mt-4 bg-white sticky bottom-0">
                            <button type="button" @click="showModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Create</button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal Projects -->
        <div x-show="showEditProjectModal" x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
            <div class="bg-white w-11/12 md:w-1/2 max-w-lg max-h-[90vh] p-0 rounded-2xl shadow-2xl flex flex-col">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-2xl">
                    <h2 class="text-xl font-bold text-white">Edit Project</h2>
                </div>
                    <form :action="selectedProject ? '/projects/' + selectedProject.id : ''" method="POST" class="flex-1 overflow-hidden">
                    @csrf
                    @method('PUT')
                    <div class="p-6 max-h-full" style="scrollbar-width: thin;">
                        <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Name</label>
                            <input type="text" name="name" :value="selectedProject?.name" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg" x-text="selectedProject?.description"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" x-bind:value="selectedProject?.status" required>
                                <option value="Requested">Requested</option>
                                <option value="Pending">Pending</option>
                                <option value="For Evaluation">For Evaluation</option>
                                <option value="Data Gathering">Data Gathering</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Development">Development</option>
                                <option value="Testing">Testing</option>
                                <option value="User Acceptance Training">User Acceptance Training</option>
                                <option value="Deployed">Deployed</option>
                                <option value="For Enhancement">For Enhancement</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 mt-4 bg-white sticky bottom-0">
                            <button type="button" @click="showEditProjectModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Update</button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Edit Modal -->
        <div x-show="editModal" x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
            <div class="bg-white w-11/12 md:w-1/2 max-w-lg max-h-[90vh] p-0 rounded-2xl shadow-2xl flex flex-col">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-2xl">
                    <h2 class="text-xl font-bold text-white">Edit DevWatch Item</h2>
                </div>
                <form :action="editItem ? '/devwatch/' + editItem.id : ''" method="POST" class="flex-1 overflow-hidden">
                    @csrf
                    @method('PUT')
                    <div class="p-6 overflow-y-scroll max-h-full" style="scrollbar-width: thin;">
                        <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                            <input type="text" name="title" :value="editItem?.title" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg" x-text="editItem?.description" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Priority</label>
                            <select name="priority" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="low" :selected="editItem?.priority === 'low'">Low</option>
                                <option value="medium" :selected="editItem?.priority === 'medium'">Medium</option>
                                <option value="high" :selected="editItem?.priority === 'high'">High</option>
                                <option value="critical" :selected="editItem?.priority === 'critical'">Critical</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="open" :selected="editItem?.status === 'open'">Open</option>
                                <option value="in_progress" :selected="editItem?.status === 'in_progress'">In Progress</option>
                                <option value="resolved" :selected="editItem?.status === 'resolved'">Resolved</option>
                                <option value="closed" :selected="editItem?.status === 'closed'">Closed</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                            <textarea name="remarks" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg" x-text="editItem?.remarks" placeholder="Optional remarks or notes"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Requestor Name</label>
                                <input type="text" name="requestor_name" :value="editItem?.requestor_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Reported Date</label>
                                <input type="date" name="reported_date" :value="editItem?.reported_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                                <input type="date" name="start_date" :value="editItem?.start_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                                <input type="date" name="end_date" :value="editItem?.end_date" class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>
                        <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200 mt-4 bg-white sticky bottom-0">
                            <button type="button" @click="editModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg">Update</button>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Manage Members Modal -->
        <div x-show="manageMembersModal" x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
            <div class="bg-white w-11/12 md:w-1/2 max-w-lg p-0 rounded-2xl shadow-2xl">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 rounded-t-2xl">
                    <h2 class="text-xl font-bold text-white">Manage Project Members</h2>
                </div>
                <form action="{{ route('projects.addMember') }}" method="POST" class="p-6">
                    @csrf
                    <input type="hidden" name="project_id" :value="selectedProject?.id">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select User</label>
                            <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <select name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="member" selected>Member</option>
                                <option value="lead">Lead</option>
                                <option value="manager">Manager</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="manageMembersModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg">Add Member</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Create Project Modal -->
        <div x-show="showProjectModal" x-cloak class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50">
            <div class="bg-white w-11/12 md:w-1/2 max-w-lg p-0 rounded-2xl shadow-2xl">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-2xl">
                    <h2 class="text-xl font-bold text-white">Create Project</h2>
                </div>
                <form action="{{ route('projects.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Project Name</label>
                            <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg" autocomplete="off" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="Requested" selected>Requested</option>
                                <option value="Pending">Pending</option>
                                <option value="For Evaluation">For Evaluation</option>
                                <option value="Data Gathering">Data Gathering</option>
                                <option value="On Hold">On Hold</option>
                                <option value="Development">Development</option>
                                <option value="Testing">Testing</option>
                                <option value="User Acceptance Training">User Acceptance Training</option>
                                <option value="Deployed">Deployed</option>
                                <option value="For Enhancement">For Enhancement</option>
                            </select>
                        </div>
                        <div class="flex justify-end space-x-3 pt-4">
                            <button type="button" @click="showProjectModal = false" class="px-4 py-2 text-gray-600 bg-gray-100 rounded-lg">Cancel</button>
                            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg">Create Project</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script>
function filterProjects() {
    const statusFilter = document.getElementById('project-status-filter').value;
    const searchFilter = document.getElementById('project-search').value.toLowerCase();
    const rows = document.querySelectorAll('#projects-tbody tr[data-status]');
    
    rows.forEach(row => {
        const statusMatch = !statusFilter || row.dataset.status === statusFilter;
        const nameMatch = !searchFilter || row.dataset.name.includes(searchFilter);
        
        if (statusMatch && nameMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function filterItems() {
    const projectFilter = document.getElementById('project-filter').value;
    const statusFilter = document.getElementById('status-filter').value;
    const priorityFilter = document.getElementById('priority-filter').value;
    const rows = document.querySelectorAll('#items-tbody tr[data-status]');
    
    rows.forEach(row => {
        const projectMatch = !projectFilter || row.dataset.project === projectFilter;
        const statusMatch = !statusFilter || row.dataset.status === statusFilter;
        const priorityMatch = !priorityFilter || row.dataset.priority === priorityFilter;
        
        if (projectMatch && statusMatch && priorityMatch) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>


<script>
function filterKanban() {
    const projectFilter = document.getElementById('kanban-project-filter').value;
    const priorityFilter = document.getElementById('kanban-priority-filter').value;
    const cards = document.querySelectorAll('.kanban-card');

    cards.forEach(card => {
        const projectMatch = !projectFilter || card.dataset.project === projectFilter;
        const priorityMatch = !priorityFilter || card.dataset.priority === priorityFilter;

        if (projectMatch && priorityMatch) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
