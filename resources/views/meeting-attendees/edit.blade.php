<x-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-6">
                <a href="{{ route('meeting-attendees.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Attendees
                </a>
            </div>

            <div class="bg-white dark:bg-slate-800 shadow-md rounded-lg p-6">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Edit Meeting Attendee</h1>

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('meeting-attendees.update', $meetingAttendee) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="meeting_detail_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meeting <span class="text-red-500">*</span>
                        </label>
                        <select name="meeting_detail_id" id="meeting_detail_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                            <option value="">Select Meeting</option>
                            @foreach($meetings as $meeting)
                                <option value="{{ $meeting->id }}" 
                                    {{ (old('meeting_detail_id', $meetingAttendee->meeting_detail_id) == $meeting->id) ? 'selected' : '' }}>
                                    {{ $meeting->title }} - {{ $meeting->date->format('M d, Y') }}
                                </option>
                            @endforeach
                        </select>
                        @error('meeting_detail_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="attendee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Attendee <span class="text-red-500">*</span>
                        </label>
                        <select name="attendee_id" id="attendee_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-slate-700 dark:text-white">
                            <option value="">Select Attendee</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" 
                                    {{ (old('attendee_id', $meetingAttendee->attendee_id) == $user->id) ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('attendee_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('meeting-attendees.index') }}" 
                            class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-save mr-2"></i>Update Attendee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
