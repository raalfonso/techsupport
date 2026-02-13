<x-layout>
    <div class="mx-auto w-full p-6" x-data="{ showModal: false, editModal: false, showProjectModal: false, manageMembersModal: false, editItem: null, selectedProject: null, selectedProjectId: null }">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">DevWatch</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Development monitoring and tracking</p>
                </div>
                <div class="flex items-center space-x-3">
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                        <i class="fa-solid fa-folder text-blue-600 dark:text-blue-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Projects</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $projects->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                        <i class="fa-solid fa-code text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Items</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $items->total() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                        <i class="fa-solid fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">In Progress</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $items->where('status', 'in_progress')->count() }}</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                        <i class="fa-solid fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Critical Items</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $items->where('priority', 'critical')->count() }}</p>
                    </div>
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
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                            <option value="on_hold">On Hold</option>
                            <option value="inactive">Inactive</option>
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
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($project->status == 'active') bg-green-100 text-green-800
                                            @elseif($project->status == 'completed') bg-blue-100 text-blue-800
                                            @elseif($project->status == 'on_hold') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $project->status)) }}
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

        <!-- DevWatch Items Table -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
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
                            <input type="text" name="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg" required>
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="completed">Completed</option>
                                <option value="on_hold">On Hold</option>
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