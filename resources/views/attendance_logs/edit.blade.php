<x-layout>
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Edit Attendance Log</h1>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('attendance-logs.update', $attendanceLog) }}" method="POST" class="bg-white rounded-lg shadow p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Date</label>
                <input type="date" name="date" value="{{ old('date', $attendanceLog->date->format('Y-m-d')) }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Time</label>
                <input type="time" name="time" value="{{ old('time', $attendanceLog->time) }}" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Employee</label>
            <select name="user_id" required class="w-full border rounded px-3 py-2">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id', $attendanceLog->user_id) == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $attendanceLog->name) }}" required class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Employee ID</label>
                <input type="text" name="employee_id" value="{{ old('employee_id', $attendanceLog->employee_id) }}" required class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-semibold mb-2">Mode</label>
                <select name="mode" required class="w-full border rounded px-3 py-2">
                    <option value="Attend" {{ old('mode', $attendanceLog->mode) == 'Attend' ? 'selected' : '' }}>Attend</option>
                    <option value="Leave" {{ old('mode', $attendanceLog->mode) == 'Leave' ? 'selected' : '' }}>Leave</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Terminal ID</label>
                <input type="text" name="terminal_id" value="{{ old('terminal_id', $attendanceLog->terminal_id) }}" class="w-full border rounded px-3 py-2">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Coordinate</label>
            <input type="text" name="coordinate" value="{{ old('coordinate', $attendanceLog->coordinate) }}" placeholder="lat,lng" class="w-full border rounded px-3 py-2">
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update
            </button>
            <a href="{{ route('attendance-logs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Cancel
            </a>
        </div>
    </form>
</div>
</x-layout>
