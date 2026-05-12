<x-layout>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Attendance Log Details</h1>
        <a href="{{ route('attendance-logs.index') }}" class="text-blue-500 hover:text-blue-700">Back</a>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600">Date</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->date->format('M d, Y') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Time</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->time }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Current Time</p>
                <p class="text-lg font-semibold" id="current-time">{{ now()->format('H:i:s') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Employee Name</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Employee ID</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->employee_id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Mode</p>
                <p class="text-lg font-semibold">
                    <span class="px-2 py-1 rounded text-sm {{ $attendanceLog->mode === 'Attend' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $attendanceLog->mode }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Terminal ID</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->terminal_id }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Class</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->class }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Type</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->type ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Card Serial</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->card_serial ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Result</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->result ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Coordinate</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->coordinate ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">External Device</p>
                <p class="text-lg font-semibold">{{ $attendanceLog->external_device ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="mt-6 flex gap-4">
            <a href="{{ route('attendance-logs.edit', $attendanceLog) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                Edit
            </a>
            <form action="{{ route('attendance-logs.destroy', $attendanceLog) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure?')">
                    Delete
                </button>
            </form>
        </div>
    </div>
</div>
</x-layout>

<script>
    setInterval(() => {
        const now = new Date();
        document.getElementById('current-time').textContent = now.toLocaleTimeString('en-US', { hour12: false });
    }, 1000);
</script>
