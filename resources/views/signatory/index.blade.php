<x-layout>
<div class="container mx-auto p-4">
    <div class="mx-auto max-w-screen-xl mt-5">
        <!-- Header Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <i class="material-icons text-blue-600 text-4xl">draw</i>
                        Signatories
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Manage document signatories and approvers</p>
                </div>
                <a href="{{ route('signatory.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-sm hover:shadow-md">
                    <i class="material-icons text-sm">add</i> Add Signatory
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-lg flex items-center gap-3">
                <i class="fas fa-check-circle text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Search and Filter Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 mb-6">
            <form action="{{ route('signatory.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-search mr-1"></i> Search
                        </label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, Employee #, Position..." class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                    </div>

                    <!-- Department Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fas fa-building mr-1"></i> Department
                        </label>
                        <select name="department" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                            <option value="">All Departments</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ request('department') == $dept->id ? 'selected' : '' }}>
                                    {{ $dept->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2 shadow-sm hover:shadow-md">
                        <i class="fas fa-filter"></i> Apply Filters
                    </button>
                    <a href="{{ route('signatory.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-500 transition flex items-center gap-2">
                        <i class="fas fa-redo"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold uppercase">Total Signatories</p>
                        <p class="text-3xl font-bold mt-2">{{ $signatories->total() }}</p>
                    </div>
                    <i class="fas fa-signature text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold uppercase">Departments</p>
                        <p class="text-3xl font-bold mt-2">{{ \App\Models\Signatory::distinct('department_id')->count('department_id') }}</p>
                    </div>
                    <i class="fas fa-building text-4xl opacity-20"></i>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold uppercase">Active</p>
                        <p class="text-3xl font-bold mt-2">{{ $signatories->total() }}</p>
                    </div>
                    <i class="fas fa-check-circle text-4xl opacity-20"></i>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-700 border-b border-gray-200 dark:border-slate-600">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Employee</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Employee ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Position / Role</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Department</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse($signatories as $signatory)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">
                                    {{ $signatory->id }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold">
                                            @if($signatory->employee)
                                                {{ strtoupper(substr($signatory->employee->first_name, 0, 1)) }}{{ strtoupper(substr($signatory->employee->last_name, 0, 1)) }}
                                            @else
                                                ?
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900 dark:text-white">
                                                {{ $signatory->employee->full_name ?? 'N/A' }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm font-mono font-semibold text-gray-700 dark:text-gray-300">
                                    {{ $signatory->employee->employee_number ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
                                        <i class="fas fa-user-tie mr-1"></i>
                                        {{ $signatory->position }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($signatory->department)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 dark:bg-purple-900 dark:text-purple-300">
                                            <i class="fas fa-building mr-1"></i>
                                            {{ $signatory->department->title }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('signatory.edit', $signatory) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 p-2 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition" title="Edit">
                                            <i class="material-icons text-base">edit</i>
                                        </a>
                                        <form action="{{ route('signatory.destroy', $signatory) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this signatory?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 p-2 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition" title="Delete">
                                                <i class="material-icons text-base">delete</i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-signature text-6xl mb-4 opacity-20"></i>
                                        <p class="text-lg font-semibold">No signatories found</p>
                                        <p class="text-sm mt-1">Try adjusting your search or filters</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($signatories->hasPages())
        <div class="mt-6">
            {{ $signatories->links() }}
        </div>
        @endif
    </div>
</div>
</x-layout>
