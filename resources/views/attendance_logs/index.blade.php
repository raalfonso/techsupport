<x-layout>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Attendance Logs</h1>
        <a href="{{ route('attendance-logs.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            New Entry
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Date</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Time</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Employee</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Mode</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Terminal</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $log->date->format('M d, Y') }}</td>
                        <td class="px-6 py-4">{{ $log->time }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm">{{ $log->name }}</div>
                            <div class="text-xs text-gray-500">{{ $log->employee_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-sm {{ $log->mode === 'Attend' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $log->mode }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">{{ $log->terminal_id }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            <a href="{{ route('attendance-logs.show', $log) }}" class="text-blue-500 hover:text-blue-700">View</a>
                            <a href="{{ route('attendance-logs.edit', $log) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                            <form action="{{ route('attendance-logs.destroy', $log) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No attendance logs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
</x-layout>
