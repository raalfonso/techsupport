<x-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Task Assignment</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Task: {{ $taskAssign->meetingTask->title }}</p>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6">
                <form action="{{ route('task-assigns.update', $taskAssign) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assign To</label>
                        <select name="assigned_personnel_id" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-700 dark:text-white">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $taskAssign->assigned_personnel_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('assigned_personnel_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-md dark:bg-slate-700 dark:text-white">
                            <option value="Pending" {{ $taskAssign->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="In Process" {{ $taskAssign->status === 'In Process' ? 'selected' : '' }}>In Process</option>
                            <option value="Done" {{ $taskAssign->status === 'Done' ? 'selected' : '' }}>Done</option>
                        </select>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('task-assigns.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-300 dark:hover:bg-slate-600">
                            Cancel
                        </a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Update Assignment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
