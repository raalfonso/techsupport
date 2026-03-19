<x-layout>
<div class="container mx-auto p-4">
    <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Employee Masterlist</h1>
            <div class="flex gap-3">
                <a href="{{ route('employee-masterlist.import-form') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-green-700 transition flex items-center gap-2">
                    <i class="fas fa-upload"></i> Import CSV
                </a>
                <a href="{{ route('employee-masterlist.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition flex items-center gap-2">
                    <i class="fas fa-plus"></i> Add Employee
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Employee #</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Department</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm font-mono text-gray-900">{{ $employee->employee_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $employee->full_name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->position}}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->department->acronym ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $employee->employment_status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $employee->employment_status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $employee->email }}</td>
                                <td class="px-6 py-4 text-sm flex gap-2">
                                    <a href="{{ route('employee-masterlist.edit', $employee) }}" class="text-blue-600 hover:text-blue-900 font-semibold">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('employee-masterlist.destroy', $employee) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500 text-sm">No employees found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $employees->links() }}
        </div>
    </div>
</div>
</x-layout>
