<x-layout>
<div class="container mx-auto p-4">
    <div class="mx-auto max-w-screen-lg mt-5 card p-5 shadow-lg rounded-lg">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Import Employees from CSV</h1>

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">CSV Format Requirements</h2>
            <div class="bg-gray-50 p-4 rounded-lg mb-4">
                <p class="text-sm text-gray-700 mb-2 font-mono">employee_number,last_name,first_name,middle_name,position,place_of_assignment,department_id,date_hired,employment_status,employment_type,email</p>
            </div>
            <div class="text-sm text-gray-600 space-y-2">
                <p><strong>Required columns:</strong> employee_number, last_name, first_name, position, employment_status, employment_type, email</p>
                <p><strong>Optional columns:</strong> middle_name, place_of_assignment, department_id, date_hired</p>
                <p><strong>Date format:</strong> YYYY-MM-DD (e.g., 2024-01-15)</p>
                <p><strong>Employment Status:</strong> Active, Inactive, On Leave</p>
                <p><strong>Employment Type:</strong> Permanent, Contractual, Temporary</p>
                <p><strong>Max file size:</strong> 5MB</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('employee-masterlist.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select CSV File *</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-blue-500 transition" id="dropZone">
                        <input type="file" name="csv_file" id="csvFile" accept=".csv,.txt" required class="hidden" onchange="updateFileName(this)">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-600 font-semibold">Drag and drop your CSV file here</p>
                        <p class="text-gray-500 text-sm">or click to browse</p>
                        <p id="fileName" class="text-blue-600 text-sm mt-2"></p>
                    </div>
                    @error('csv_file') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-green-700 transition flex items-center gap-2">
                        <i class="fas fa-upload"></i> Import Employees
                    </button>
                    <a href="{{ route('employee-masterlist.index') }}" class="bg-gray-400 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-500 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
            <h3 class="font-semibold text-blue-900 mb-2">Example CSV Format:</h3>
            <pre class="text-xs text-blue-800 overflow-x-auto">employee_number,last_name,first_name,middle_name,position,place_of_assignment,department_id,date_hired,employment_status,employment_type,email
EMP001,Doe,John,Michael,Software Engineer,Main Office,1,2024-01-15,Active,Permanent,john.doe@example.com
EMP002,Smith,Jane,Anne,Project Manager,Branch Office,2,2024-02-20,Active,Permanent,jane.smith@example.com
EMP003,Johnson,Robert,,HR Specialist,Main Office,3,2024-03-10,Active,Contractual,robert.johnson@example.com</pre>
        </div>
    </div>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const csvFile = document.getElementById('csvFile');

    dropZone.addEventListener('click', () => csvFile.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50');
        csvFile.files = e.dataTransfer.files;
        updateFileName({ files: e.dataTransfer.files });
    });

    function updateFileName(input) {
        const fileName = document.getElementById('fileName');
        if (input.files && input.files[0]) {
            fileName.textContent = 'Selected: ' + input.files[0].name;
        }
    }
</script>
</x-layout>
