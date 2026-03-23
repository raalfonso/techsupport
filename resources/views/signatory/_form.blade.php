{{-- Employee --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Employee</label>
    <select name="employee_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm @error('employee_id') border-red-400 @enderror">
        <option value="">-- Select Employee --</option>
        @foreach($employees as $emp)
            <option value="{{ $emp->id }}" {{ old('employee_id', $signatory->employee_id ?? '') == $emp->id ? 'selected' : '' }}>
                {{ $emp->name }} ({{ $emp->masterlist->employee_number ?? 'N/A' }})
            </option>
        @endforeach
    </select>
    @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Position --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Position / Role</label>
    <input type="text" name="position" value="{{ old('position', $signatory->position ?? '') }}"
        placeholder="e.g. Prepared by, Noted by, Approved by"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm @error('position') border-red-400 @enderror">
    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Department --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Department</label>
    <select name="department_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm @error('department_id') border-red-400 @enderror">
        <option value="">-- Select Department --</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id', $signatory->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                {{ $dept->title }}
            </option>
        @endforeach
    </select>
    @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
