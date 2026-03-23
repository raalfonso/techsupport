{{-- Employee search --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Employee</label>
    <div class="relative">
        <input type="text" id="employeeSearch"
            placeholder="Search by name or employee number..."
            value="{{ isset($signatory) && $signatory->employee ? $signatory->employee->full_name . ' (' . $signatory->employee->employee_number . ')' : old('_employee_display', '') }}"
            autocomplete="off"
            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
        <input type="hidden" name="employee_id" id="employee_id"
            value="{{ old('employee_id', $signatory->employee_id ?? '') }}">
        <div id="employeeDropdown" class="absolute z-10 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 hidden max-h-52 overflow-y-auto"></div>
    </div>
    @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Position --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Position / Role</label>
    <input type="text" name="position" id="position"
        value="{{ old('position', $signatory->position ?? '') }}"
        placeholder="e.g. Prepared by, Noted by, Approved by"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm @error('position') border-red-400 @enderror">
    @error('position') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

{{-- Department (auto-filled from employee, but editable) --}}
<div>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Department</label>
    <select name="department_id" id="department_id"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm @error('department_id') border-red-400 @enderror">
        <option value="">-- Select Department --</option>
        @foreach($departments as $dept)
            <option value="{{ $dept->id }}" {{ old('department_id', $signatory->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                {{ $dept->title }}
            </option>
        @endforeach
    </select>
    @error('department_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>

<script>
    const searchInput   = document.getElementById('employeeSearch');
    const hiddenInput   = document.getElementById('employee_id');
    const dropdown      = document.getElementById('employeeDropdown');
    const deptSelect    = document.getElementById('department_id');
    let searchTimeout;

    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const q = this.value.trim();
        if (q.length < 1) { dropdown.classList.add('hidden'); return; }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('signatory.employees.search') }}?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => {
                    dropdown.innerHTML = '';
                    if (!data.length) {
                        dropdown.innerHTML = '<div class="px-4 py-3 text-sm text-gray-400">No results found</div>';
                        dropdown.classList.remove('hidden');
                        return;
                    }
                    data.forEach(emp => {
                        const item = document.createElement('div');
                        item.className = 'px-4 py-2 text-sm cursor-pointer hover:bg-blue-50 border-b border-gray-100';
                        item.innerHTML = `<span class="font-medium text-gray-900">${emp.name}</span> <span class="text-gray-400 text-xs">${emp.employee_number}</span><div class="text-xs text-gray-500">${emp.department}</div>`;
                        item.addEventListener('click', () => {
                            searchInput.value  = `${emp.name} (${emp.employee_number})`;
                            hiddenInput.value  = emp.id;
                            // auto-select department
                            if (emp.department_id) {
                                deptSelect.value = emp.department_id;
                            }
                            dropdown.classList.add('hidden');
                        });
                        dropdown.appendChild(item);
                    });
                    dropdown.classList.remove('hidden');
                });
        }, 250);
    });

    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
