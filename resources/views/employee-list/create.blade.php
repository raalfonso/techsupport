<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} - Add Employee</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-gray-100 dark:bg-slate-950">
    @include('attendance_logs._nav')
    <div class="container mx-auto p-4 mt-20">
        <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Add New Employee</h1>

            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-md p-6">
                <form action="{{ route('employee-list.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Employee Number *</label>
                            <input type="text" name="employee_number" value="{{ old('employee_number') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employee_number') border-red-500 @enderror">
                            @error('employee_number') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">First Name *</label>
                            <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                            @error('first_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Last Name *</label>
                            <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                            @error('last_name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Position *</label>
                            <input type="text" name="position" value="{{ old('position') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('position') border-red-500 @enderror">
                            @error('position') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Place of Assignment</label>
                            <input type="text" name="place_of_assignment" value="{{ old('place_of_assignment') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Department</label>
                            <select name="department_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Date Hired</label>
                            <input type="date" name="date_hired" value="{{ old('date_hired') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Employment Status *</label>
                            <select name="employment_status" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employment_status') border-red-500 @enderror">
                                <option value="">Select Status</option>
                                <option value="Active" {{ old('employment_status') === 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('employment_status') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="On Leave" {{ old('employment_status') === 'On Leave' ? 'selected' : '' }}>On Leave</option>
                            </select>
                            @error('employment_status') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Employment Type *</label>
                            <select name="employment_type" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('employment_type') border-red-500 @enderror">
                                <option value="">Select Type</option>
                                <option value="Permanent" {{ old('employment_type') === 'Permanent' ? 'selected' : '' }}>Permanent</option>
                                <option value="Contractual" {{ old('employment_type') === 'Contractual' ? 'selected' : '' }}>Contractual</option>
                                <option value="COS" {{ old('employment_type') === 'COS' ? 'selected' : '' }}>COS</option>
                                <option value="COS(DBP)" {{ old('employment_type') === 'COS(DBP)' ? 'selected' : '' }}>COS(DBP)</option>
                                <option value="COS(OMNI)" {{ old('employment_type') === 'COS(OMNI)' ? 'selected' : '' }}>COS(OMNI)</option>
                            </select>
                            @error('employment_type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Save Employee
                        </button>
                        <a href="{{ route('employee-list.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-500 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
