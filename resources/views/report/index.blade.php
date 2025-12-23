<x-layout>

    <div class="mx-auto w-full p-4 mt-5">
        
        <!-- Card Container -->
        <div class="mx-auto bg-white mt-5 shadow-md rounded-lg p-5" 
            x-data="{ showModal: false, resolveModal: false,validateModal: false, escalateModal: false, endorseModal: false, responseModal: false, selectedId: null }">
            
            <h1 class="text-lg md:text-xl font-bold mb-4 text-slate-800 dark:text-slate-100">List of Requested / Reported Issues</h1>
            <input type="text" class="firstCount input" style="display: none;" value="{{$countReport}}">
            <!-- New Report Button -->
            <div class="flex justify-end mb-4">
                <button @click="showModal = true" class="w-40 bg-teal-700 text-white hover:bg-teal-950 rounded px-4 py-2">
                  <i class="fa-solid fa-plus"></i>  New Request
                </button>
            </div>
            <div class="report-data"></div>
            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50" x-cloak>
                <div class="bg-white w-11/12 md:w-screen lg:w-1/2 p-6 rounded-lg shadow-lg">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-bold text-gray-700">Add New Request</h2>
                        <button @click="showModal = false" class="text-gray-600 hover:text-gray-800 text-xl">&times;</button>
                    </div>
                    <form action="{{ route('report.store') }}" method="post" class="space-y-4">
                        @csrf
                        <div class="items-center space-x-2">
                             <label for="survey_employees_id" class="block text-sm font-medium text-gray-700">Requestor Name</label>
                                <div class="relative" id="client-search-container" style="margin-left: -0.03%;">
                                 <div class="relative" id="employee-search-container">
                                    <input type="text" id="survey_employees_id" class="w-full p-2 border rounded-lg resize-y transition text-sm employee-search" autocomplete="off">
                                    
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-caret-down text-gray-400 ml-5"></i>
                                    </div>
                                 </div>
                                 <div class="hidden">
                                     <input type="text" name="survey_employees_id" id="survey_employees_id_data" class="w-full p-2 border rounded-lg resize-y transition text-sm employee-search" autocomplete="off">
                                 </div>
                                <div id="suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg border border-gray-200 max-h-60 overflow-y-auto">
                                   

                                </div>
                                <div id="selected-employee" class="hidden">
                                    <span id="selected-name" class="font-semibold"></span>
                                    <button id="clear-selection" class="ml-2 text-blue-500 text-sm">Clear</button>
                                    </div>
                                </div>
                        </div>


                        
                        <!-- Date Created -->
                        <div>
                            <label for="request_datetime" class="block text-sm font-medium text-gray-700">Requested Date Time</label>
                            <input type="datetime-local" class="w-full p-2 border rounded-lg resize-y" name="request_datetime" value="{{ old('request_datetime') }}">

                                @error('request_datetime')
                                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                                @enderror
                        </div>

                        <!-- Department -->
                        <div>
                            <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                            <select name="department_id" id="department_id" class="input block w-full mt-1 border-gray-300 rounded-lg">
                                <option value="">Select Department</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->title }}</option>
                                @endforeach
                            </select>
                            @error('department_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Issue -->
                        <div>
                            <label for="issues_id" class="block text-sm font-medium text-gray-700">Issue</label>
                            <select name="issues_id" id="issues_id" class="input block w-full mt-1 border-gray-300 rounded-lg">
                                <option value="">Select Issue</option>
                                @foreach($issues as $issue)
                                    <option value="{{ $issue->id }}">{{ $issue->title }}</option>
                                @endforeach
                            </select>
                            @error('issues_id')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remarks -->
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                            <textarea rows="4" class="w-full h-32 p-2 border rounded-lg resize-y" placeholder="Enter your message here..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" onclick="this.disabled=true;this.form.submit();" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                                Create
                            </button>
                     
                        </div>
                    </form>
                </div>
            </div>
        {{-- resolve modal --}}
        <div x-show="resolveModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white p-6  w-11/12 md:w-screen lg:w-1/2 rounded-lg">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold">Resolve</h3>
                    <button @click="resolveModal = false" class="text-gray-500 hover:text-gray-800">X</button>
                </div>
                <form :action="'/report/resolve/' + selectedId" method="GET">
                    <!-- Your form content here -->
                    @csrf
                    {{-- <div class="mb-4 mt-4">
                        <label for="user_id">Technical Staff</label>
                        <select name="user_id1" id="user_id" class="input">
                            <option value="">Select Technical staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="procedure">Procedure</label>
                        <input type="text" name="procedure" class="input @error('procedure') ring-red-500 @enderror" value="{{ old('procedure')}}">
                    </div> --}}
                    <div x-data="{ items: [{ name: '', quantity: '' }] }">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="mb-4 mt-4">
                                <label for="user_id">Technical Staff</label>
                                <select name="user[][user_id]" id="user_id" class="input" x-model="item.name" required>
                                    <option value="">Select Technical staff</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 text-sm px-4 rounded-full mt-4" @click="items.splice(index, 1)" x-show="items.length > 1">Remove</button>
                            </div>

                        </template>
                        {{-- resolve time --}}
                        <div class="mt-2">
                            <label for="resolve_datetime" class="block text-sm font-medium text-gray-700">Resolve Date Time</label>
                            <input type="datetime-local" class="w-full p-2 border rounded-lg resize-y mt-2" name="resolve_datetime" value="{{ old('resolve_datetime') }}">

                            @error('resolve_datetime')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="procedure">Procedure</label>
                            {{-- <input type="text" name="procedure" class="input @error('procedure') ring-red-500 @enderror" value="{{ old('procedure')}}"> --}}
                            <textarea id="procedure" rows="4" name="procedure" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write the procedure you made."></textarea>

                            
                        </div>
                        <button type="button" class="text-sm bg-slate-800 hover:bg-slate-900 text-white py-2 px-4 rounded-full mb-4" @click="items.push({ name: '', quantity: '' })">Add Technical staff</button>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                        Resolved
                    </button>
                </form>
            </div>
        </div>
    {{-- end of resolve --}}

    {{-- escalate modal --}}
    <div x-show="escalateModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg  w-11/12 md:w-screen lg:w-1/2">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Escalate</h3>
                <button @click="escalateModal = false" class="text-gray-500 hover:text-gray-800">X</button>
            </div>
            <form :action="'/report/escalate/' + selectedId" method="GET">
                <!-- Your form content here -->
                @csrf
                <div class="mb-4 mt-4">
                    <label for="user_id">Technical Staff</label>
                    <select name="user_id" id="user_id" class="input">
                        <option value="">Select Technical staff</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="error">{{ $message }}</p>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "{{ $message }}",
                            });
                    </script>
                @enderror
                </div>
                  {{-- resolve time --}}
                        <div class="mt-2">
                            <label for="resolve_datetime" class="block text-sm font-medium text-gray-700">Resolve Date Time</label>
                            <input type="datetime-local" class="w-full p-2 border rounded-lg resize-y mt-2" name="resolve_datetime" value="{{ old('resolve_datetime') }}">

                            @error('resolve_datetime')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                <div class="mb-4">
                    <label for="procedure">Procedure</label>
                    <input type="text" name="procedure" class="input @error('procedure') ring-red-500 @enderror" value="{{ old('procedure')}}">
                    @error('procedure')
                        <p class="error">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "{{ $message }}",
                                });
                        </script>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" class="input @error('remarks') ring-red-500 @enderror" value="{{ old('remarks')}}">
                    @error('remarks')
                        <p class="error">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "{{ $message }}",
                                });
                        </script>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                    Escalate
                </button>
            </form>
        </div>
    </div>
    {{-- end of escalate --}}

    {{-- endorse modal --}}
    <div x-show="endorseModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg  w-11/12 md:w-screen lg:w-1/2">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Endorse</h3>
                <button @click="endorseModal = false" class="text-gray-500 hover:text-gray-800">X</button>
            </div>
            <form :action="'/report/endorse/' + selectedId" method="GET">
                <!-- Your form content here -->
                @csrf
                <div class="mb-4 mt-4">
                    <label for="user_id">Technical Staff</label>
                    <select name="user_id" id="user_id" class="input">
                        <option value="">Select Technical staff</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="error">{{ $message }}</p>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "{{ $message }}",
                            });
                    </script>
                @enderror
                </div>
                  {{-- endorse time --}}
                        <div class="mt-2">
                            <label for="resolve_datetime" class="block text-sm font-medium text-gray-700">Endorse Date Time</label>
                            <input type="datetime-local" class="w-full p-2 border rounded-lg resize-y mt-2" name="resolve_datetime" value="{{ old('resolve_datetime') }}">

                            @error('resolve_datetime')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                <div class="mb-4">
                    <label for="remarks">Remarks</label>
                    <input type="text" name="remarks" class="input @error('remarks') ring-red-500 @enderror" value="{{ old('remarks')}}">
                    @error('remarks')
                        <p class="error">{{ $message }}</p>
                        <script>
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "{{ $message }}",
                                });
                        </script>
                    @enderror
                </div>

                <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                    Endorse
                </button>
            </form>
        </div>
    </div>
    {{-- end of endorse --}}

    <!-- List of Resolved Issues -->
        </div>
        
    <div class="mt-10 card px-6 py-8 bg-white dark:bg-slate-800 rounded-lg shadow-lg">
    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-slate-100">List of Resolved Issues</h1>
    
    <!-- Filter Section -->
    <form method="GET" action="{{ route('report.index') }}">
    <div class="mb-6 grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Date Range Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date Range</label>
            <div class="flex gap-2">
                <input type="date" name="date_from" class="form-input rounded-lg text-sm w-full" placeholder="From" value="{{ request('date_from') }}">
                <input type="date" name="date_to" class="form-input rounded-lg text-sm w-full" placeholder="To" value="{{ request('date_to') }}">
            </div>
        </div>

        <!-- Department Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
            <select name="department_id" class="form-select rounded-lg text-sm w-full">
                <option value="">All Departments</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Issue Category Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Issue Category</label>
            <select name="category_id" class="form-select rounded-lg text-sm w-full">
                <option value="">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Technical Staff Filter -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Technical Staff</label>
            <select name="user_id" class="form-select rounded-lg text-sm w-full">
                <option value="">All Staff</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>    
    <div class="flex justify-end mb-6 gap-4">
        <button type="submit" class="bg-slate-700 text-white hover:bg-slate-800 rounded px-4 py-2 flex items-center gap-2">
            <i class="fa-solid fa-filter"></i>
            <span>Apply Filters</span>
        </button>
        <a href="{{ route('report.index') }}" class="bg-gray-200 text-gray-600 hover:bg-gray-300 rounded px-4 py-2 flex items-center gap-2">
            <i class="fa-solid fa-rotate"></i>
            <span>Reset Filters</span>
        </a>
        <a href="{{ route('report.export', request()->query()) }}" class="bg-teal-600 text-white hover:bg-teal-700 rounded px-4 py-2 flex items-center gap-2">
            <i class="fa-solid fa-file-export"></i>
            <span>Export</span>
        </a>
    </div>
    </form>        
    <div class="overflow-auto max-h-[650px] pb-10">
        <!-- Desktop Table -->
        <div class="hidden md:block">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-800 to-slate-900 text-left text-md text-white">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">#</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Ticket Number</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Requestor Name</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Department</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Category</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Issue</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Requested Date</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Waiting Time</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Resolved Time</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Resolved Date</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Remarks</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white-700 dark:text-white">Technical Staff</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @foreach($resolved as $index => $resolve)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition duration-150">
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            {{ $resolved->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->ticket_number }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->client->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->Department?->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->Issues?->Category?->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->Issues?->title }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ date('F d, Y h:i a', strtotime($resolve->request_datetime)) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            @php
                                $diffInMinutes = \Carbon\Carbon::parse($resolve->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($resolve->response_datetime));
                            @endphp
                            {{ $diffInMinutes >= 60 ? round($diffInMinutes / 60) . ' hrs' : round($diffInMinutes) . ' mins' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
                            @php
                                if($resolve->validation_date_time == null){
                                    $diffInMinutes = \Carbon\Carbon::parse($resolve->response_datetime)->diffInMinutes(\Carbon\Carbon::parse($resolve->resolve_datetime));
                                } else {
                                    $diffInMinutes = \Carbon\Carbon::parse($resolve->validation_date_time)->diffInMinutes(\Carbon\Carbon::parse($resolve->resolve_datetime));
                                }
                            @endphp
                               
                            {{ $diffInMinutes >= 60 ? round($diffInMinutes / 60) . ' hrs' : round($diffInMinutes) . ' mins' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap">{{ date('F d, Y h:i a', strtotime($resolve->resolve_datetime)) }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->remarks }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->resolve->user->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-6">
                {{ $resolved->links() }}
            </div>
        </div>

        <!-- Mobile Cards -->
        <div class="block md:hidden space-y-4">
            @foreach($resolved as $resolve)
                <div class="bg-white dark:bg-slate-700 rounded-xl shadow-md p-6 space-y-3">
                    <div class="flex justify-between items-start">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                            {{ $resolve->client?->name }}
                        </h2>
                        <span class="px-3 py-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full">
                            {{ $resolve->department?->title }}
                        </span>
                    </div>
                    <div class="space-y-2">
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Ticket:</span> {{ $resolve->ticket_number }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Issue:</span> {{ $resolve->issues?->title }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Technical Staff:</span> {{ $resolve->resolve->user->name }}
                        </p>
                    </div>
                </div>
            @endforeach

            <div class="mt-6">
                {{ $resolved->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div></div>
    </div>

    <script>

        $(document).ready(()=>{
          
            const interval = setInterval(function() {
                checkTotal();
            }, 1000); // Execute every 1 second


            const checking = ()=>{
                $.ajax({
                    url: '/reports',
                    method: 'GET',
                    success:function(response){
                        $('.report-data').html(response);
                    }
                });
            }

            checking();

            const checkTotal = ()=>{
                $.ajax({
                    url: '/getstotal',
                    method: 'GET',
                    success:function(response){
                       var first = $('.firstCount').val();  
                        if (first != response) {
                            checking();
                            $('.firstCount').val(response)
                        }
                    }
                });
            }

       
        });

    
        document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('survey_employees_id');
        const suggestionsContainer = document.getElementById('suggestions-container');
        const selectedEmployee = document.getElementById('selected-employee');
        const selectedName = document.getElementById('selected-name');
        const employeeId = document.getElementById('survey_employees_id_data');
        const clearButton = document.getElementById('clear-selection');
        const employeeSearchContainer = document.getElementById('employee-search-container');
        const departmentSelect = document.getElementById('department_id'); 

        const employees = @json($employees);
        
        // console.log(employees);
        
        // Function to fetch employees (simulating AJAX call)
        function fetchEmployees(query) {
            return new Promise(resolve => {
                setTimeout(() => {
                    const results = employees.filter(employee => 
                        employee.name.toLowerCase().includes(query.toLowerCase())
                    );
                    resolve(results);
                }, 200);
            });
        }
        
        // Event listener for input
        searchInput.addEventListener('input', debounce(async function(e) {
            const query = e.target.value.trim();
            
            if (query.length < 0) {
                suggestionsContainer.classList.add('hidden');
                return;
            }
            
            const results = await fetchEmployees(query);
            displaySuggestions(results);
        }, 300));
        // ✅ New: Show all employees when clicking the input
            searchInput.addEventListener('focus', async function() {
                const results = await fetchEmployees(''); // Empty query = show all
                displaySuggestions(results);
            });
        // Display suggestions
        function displaySuggestions(employees) {
            if (employees.length === 0) {
                suggestionsContainer.innerHTML = '<div class="p-4 text-gray-500 text-sm">No employees found</div>';
                suggestionsContainer.classList.remove('hidden');
                return;
            }
            
            suggestionsContainer.innerHTML = '';
            employees.forEach(employee => {
                const div = document.createElement('div');
                div.className = 'p-3 border-b border-gray-100 hover:bg-blue-50 cursor-pointer transition';
                div.innerHTML = `
                    <div class="font-medium text-gray-800 text-sm">${employee.name}</div>
                    
                `;
                div.addEventListener('click', () => {
                    selectEmployee(employee);
                });
                suggestionsContainer.appendChild(div);
            });
            
            suggestionsContainer.classList.remove('hidden');
        }
        
        // Select an employee
        function selectEmployee(employee) {
            console.log(employee);
            selectedName.textContent = employee.name;
            employeeId.value = employee.id;
            department_id.value = employee.department_id;
            selectedEmployee.classList.remove('hidden');
            searchInput.value = '';
            suggestionsContainer.classList.add('hidden');
            employeeSearchContainer.classList.add('hidden');
        }
        
        // Clear selection
        clearButton.addEventListener('click', function(e) {
            e.preventDefault();
            selectedEmployee.classList.add('hidden');
            employeeSearchContainer.classList.remove('hidden');
            employeeId.value = '';
            searchInput.value = '';
            searchInput.focus();
        });
        
        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.classList.add('hidden');
            }
        });
        
        // Debounce function to limit API calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }
    });
    </script>


</x-layout>
