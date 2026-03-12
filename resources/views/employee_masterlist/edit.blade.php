<x-layout>
<div class="container mx-auto p-4">
    <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Employee</h1>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('employee-masterlist.update', $employeeMasterlist) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Employee Number *</label>
                        <input type="text" name="employee_number" value="{{ old('employee_number', $employeeMasterlist->employee_number) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employee_number') border-red-500 @enderror">
                        @error('employee_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $employeeMasterlist->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">First Name *</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $employeeMasterlist->first_name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                        @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Middle Name</label>
                        <input type="text" name="middle_name" value="{{ old('middle_name', $employeeMasterlist->middle_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Last Name *</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $employeeMasterlist->last_name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                        @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Position *</label>
                        <input type="text" name="position" value="{{ old('position', $employeeMasterlist->position) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('position') border-red-500 @enderror">
                        @error('position') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Place of Assignment</label>
                        <input type="text" name="place_of_assignment" value="{{ old('place_of_assignment', $employeeMasterlist->place_of_assignment) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Department</label>
                        <select name="department_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Department</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id', $employeeMasterlist->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Date Hired</label>
                        <input type="date" name="date_hired" value="{{ old('date_hired', $employeeMasterlist->date_hired?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Employment Status *</label>
                        <select name="employment_status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employment_status') border-red-500 @enderror">
                            <option value="">Select Status</option>
                            <option value="Active" {{ old('employment_status', $employeeMasterlist->employment_status) === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ old('employment_status', $employeeMasterlist->employment_status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="On Leave" {{ old('employment_status', $employeeMasterlist->employment_status) === 'On Leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                        @error('employment_status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Employment Type *</label>
                        <select name="employment_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employment_type') border-red-500 @enderror">
                            <option value="">Select Type</option>
                            <option value="Permanent" {{ old('employment_type', $employeeMasterlist->employment_type) === 'Permanent' ? 'selected' : '' }}>Permanent</option>
                            <option value="Contractual" {{ old('employment_type', $employeeMasterlist->employment_type) === 'Contractual' ? 'selected' : '' }}>Contractual</option>
                            <option value="Contract of Service - Direct" {{ old('employment_type', $employeeMasterlist->employment_type) === 'Contract of Service - Direct' ? 'selected' : '' }}>Contract of Service - Direct</option>
                            <option value="Contract of Service - Agency" {{ old('employment_type', $employeeMasterlist->employment_type) === 'Contract of Service - Agency' ? 'selected' : '' }}>Contract of Service - Agency</option>
                        </select>
                        @error('employment_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Update Employee
                    </button>
                    <a href="{{ route('employee-masterlist.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-500 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layout>
