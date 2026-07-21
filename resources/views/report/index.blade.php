<x-layout>
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    
    <div class="mx-auto w-full p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Issue Management</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Track and manage all reported issues</p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Stats Cards -->
                    <div class="flex space-x-4">
                        <div class="bg-gradient-to-r from-yellow-400 to-yellow-500 text-white px-4 py-2 rounded-xl shadow-lg">
                            <div class="text-sm font-medium">Pending</div>
                            <div class="text-xl font-bold">{{ $pendingCount }}</div>
                        </div>
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl shadow-lg">
                            <div class="text-sm font-medium">Ongoing</div>
                            <div class="text-xl font-bold">{{ $ongoingCount }}</div>
                        </div>
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-2 rounded-xl shadow-lg">
                            <div class="text-sm font-medium">For Validation</div>
                            <div class="text-xl font-bold">{{ $validationCount }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700" 
            x-data="{ 
                showModal: false, 
                emergencyModal: false,
                qrModal: false,
                resolveModal: false,
                confirmValidateModal: false,
                changeIssueModal: false,
                escalateModal: false, 
                endorseModal: false, 
                responseModal: false, 
                selectedId: null,
                openNewRequest() {
                    this.showModal = true;
                    this.$nextTick(() => {
                        const now = new Date();
                        const year = now.getFullYear();
                        const month = String(now.getMonth() + 1).padStart(2, '0');
                        const day = String(now.getDate()).padStart(2, '0');
                        const hours = String(now.getHours()).padStart(2, '0');
                        const minutes = String(now.getMinutes()).padStart(2, '0');
                        document.getElementById('request_datetime').value = `${year}-${month}-${day}T${hours}:${minutes}`;
                    });
                }
            }">
            
            <!-- Card Header -->
            <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-teal-100 dark:bg-teal-900 rounded-lg">
                            <i class="fa-solid fa-list-check text-teal-600 dark:text-teal-400 text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Active Issues</h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Manage and track issue resolution</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button @click="showModal = true; $nextTick(() => { const now = new Date(); const year = now.getFullYear(); const month = String(now.getMonth() + 1).padStart(2, '0'); const day = String(now.getDate()).padStart(2, '0'); const hours = String(now.getHours()).padStart(2, '0'); const minutes = String(now.getMinutes()).padStart(2, '0'); document.getElementById('request_datetime').value = `${year}-${month}-${day}T${hours}:${minutes}`; })" class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2" style="display:none;">
                            <i class="fa-solid fa-plus"></i>
                            <span>New Request</span>
                        </button>
                        <button @click="emergencyModal = true" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <span>Emergency Report</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="p-8">
                <input type="text" class="firstCount input" style="display: none;" value="{{$countReport}}">
                <div class="report-data"></div>
            </div>
            <!-- Modal -->
            <div x-show="showModal" class="fixed inset-0 bg-gray-900 bg-opacity-60 flex justify-center items-center z-50 backdrop-blur-sm" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                <div class="bg-white w-11/12 md:w-screen lg:w-1/2 max-w-2xl p-0 rounded-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-6 py-4 rounded-t-2xl">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                    <i class="fa-solid fa-plus text-white text-lg"></i>
                                </div>
                                <h2 class="text-xl font-bold text-white">Add New Request</h2>
                            </div>
                            <button @click="showModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                                <i class="fa-solid fa-times text-lg"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Body -->
                    <form action="{{ route('report.store') }}" method="post" class="space-y-5">
                    <div class="p-6 max-h-[70vh] overflow-y-auto">
                       
                            @csrf
                            <!-- Requestor Name -->
                            <div class="space-y-2">
                                <label for="survey_employees_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-user text-teal-600"></i>
                                    <span>Requestor Name</span>
                                </label>
                                <div class="relative" id="client-search-container">
                                    <div class="relative" id="employee-search-container">
                                        <input type="text" id="survey_employees_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm employee-search" placeholder="Search for requestor..." autocomplete="off">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <input type="text" name="survey_employees_id" id="survey_employees_id_data" class="w-full p-3 border-2 border-gray-200 rounded-xl" autocomplete="off">
                                    </div>
                                    <div id="suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
                                    <div id="selected-employee" class="hidden mt-2 p-3 bg-teal-50 border border-teal-200 rounded-xl">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <i class="fa-solid fa-user-check text-teal-600"></i>
                                                <span id="selected-name" class="font-semibold text-teal-800"></span>
                                            </div>
                                            <button id="clear-selection" class="text-teal-600 hover:text-teal-800 text-sm font-medium">
                                                <i class="fa-solid fa-times"></i> Clear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date Created -->
                            <div class="space-y-2">
                                <label for="request_datetime" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-calendar text-teal-600"></i>
                                    <span>Requested Date Time</span>
                                </label>
                                <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200" name="request_datetime" value="{{ old('request_datetime') }}">
                                @error('request_datetime')
                                    <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                        <i class="fa-solid fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Department -->
                            <div class="space-y-2">
                                <label for="department_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-building text-teal-600"></i>
                                    <span>Department</span>
                                </label>
                                <select name="department_id" id="department_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                        <i class="fa-solid fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Issue -->
                            <div class="space-y-2">
                                <label for="issues_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-exclamation-triangle text-teal-600"></i>
                                    <span>Issue</span>
                                </label>
                                <div class="relative" id="issue-search-container">
                                    <div class="relative" id="issue-input-container">
                                        <input type="text" id="issue_search" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm issue-search" placeholder="Search for issue..." autocomplete="off">
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <i class="fas fa-search text-gray-400"></i>
                                        </div>
                                    </div>
                                    <div class="hidden">
                                        <input type="text" name="issues_id" id="issues_id_data" class="w-full p-3 border-2 border-gray-200 rounded-xl" autocomplete="off">
                                    </div>
                                    <div id="issue-suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
                                    <div id="selected-issue" class="hidden mt-2 p-3 bg-teal-50 border border-teal-200 rounded-xl">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <i class="fa-solid fa-check-circle text-teal-600"></i>
                                                <span id="selected-issue-name" class="font-semibold text-teal-800"></span>
                                            </div>
                                            <button id="clear-issue-selection" class="text-teal-600 hover:text-teal-800 text-sm font-medium">
                                                <i class="fa-solid fa-times"></i> Clear
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('issues_id')
                                    <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                        <i class="fa-solid fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div class="space-y-2">
                                <label for="remarks" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-comment text-teal-600"></i>
                                    <span>Remarks</span>
                                </label>
                                <textarea rows="4" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 resize-none" placeholder="Enter your message here..."></textarea>
                            </div>
                        
                    </div>
                    
                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                        <div class="flex justify-end space-x-3">
                            <button @click="showModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                                Cancel
                            </button>
                            <button type="submit" onclick="this.disabled=true;this.form.submit();" class="px-6 py-2.5 bg-gradient-to-r from-teal-600 to-teal-700 text-white rounded-xl hover:from-teal-700 hover:to-teal-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Create Request
                            </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        {{-- resolve modal --}}
        <div x-show="resolveModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
            <div class="bg-white p-0 w-11/12 md:w-screen lg:w-1/2 max-w-2xl rounded-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-2xl">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                                <i class="fa-solid fa-check text-white text-lg"></i>
                            </div>
                            <h3 class="text-xl font-bold text-white">Resolve Issue</h3>
                        </div>
                        <button @click="resolveModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                            <i class="fa-solid fa-times text-lg"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Body -->
                <div class="p-6 max-h-[70vh] overflow-y-auto">
                    <form :action="'/report/resolve/' + selectedId" method="GET">
                        @csrf
                        <div x-data="{ items: [{ name: '', quantity: '' }] }" class="space-y-5">
                            <template x-for="(item, index) in items" :key="index">
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                        <i class="fa-solid fa-user-gear text-green-600"></i>
                                        <span>Technical Staff</span>
                                    </label>
                                    <div class="flex items-center space-x-3">
                                        <select name="user[][user_id]" class="flex-1 p-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" x-model="item.name" required>
                                            <option value="">Select Technical staff</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="bg-red-500 hover:bg-red-600 text-white p-2.5 rounded-xl transition-all duration-200" @click="items.splice(index, 1)" x-show="items.length > 1">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <button type="button" class="bg-green-600 hover:bg-green-700 text-white py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center space-x-2" @click="items.push({ name: '', quantity: '' })">
                                <i class="fa-solid fa-plus"></i>
                                <span>Add Technical Staff</span>
                            </button>
                            
                            <!-- Resolve Date Time -->
                            <div class="space-y-2">
                                <label for="resolve_datetime" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-calendar-check text-green-600"></i>
                                    <span>Resolve Date Time</span>
                                </label>
                                <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200" name="resolve_datetime" value="{{ old('response_datetime', now()->format('Y-m-d\TH:i')) }}">
                                @error('resolve_datetime')
                                    <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                        <i class="fa-solid fa-exclamation-circle"></i>
                                        <span>{{ $message }}</span>
                                    </p>
                                @enderror
                            </div>
                            
                            <!-- Procedure -->
                            <div class="space-y-2">
                                <label for="procedure" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                                    <i class="fa-solid fa-list-check text-green-600"></i>
                                    <span>Procedure</span>
                                </label>
                                <textarea id="procedure" rows="4" name="procedure" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all duration-200 resize-none" placeholder="Describe the procedure you followed to resolve this issue..."></textarea>
                            </div>
                        </div>
                    
                </div>
                
                        <!-- Footer -->
                        <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                            <div class="flex justify-end space-x-3">
                                <button @click="resolveModal = false" type="button" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                                    Cancel
                                </button>
                                <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                    <i class="fa-solid fa-check mr-2"></i>
                                    Mark as Resolved
                                </button>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    {{-- end of resolve --}}

    {{-- Emergency Modal --}}
    <div x-show="emergencyModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white w-11/12 md:w-screen lg:w-1/2 max-w-2xl p-0 rounded-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <i class="fa-solid fa-exclamation-triangle text-white text-lg"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Emergency Report</h2>
                    </div>
                    <button @click="emergencyModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form id="emergencyForm" action="{{ route('report.emergency') }}" method="POST" class="space-y-5">
                    @csrf
                    <!-- Requestor Name -->
                    <div class="space-y-2">
                        <label for="emergency_survey_employees_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-user text-red-600"></i>
                            <span>Requestor Name</span>
                        </label>
                        <div class="relative" id="emergency-client-search-container">
                            <div class="relative" id="emergency-employee-search-container">
                                <input type="text" id="emergency_survey_employees_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 text-sm emergency-employee-search" placeholder="Search for requestor..." autocomplete="off">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div class="hidden">
                                <input type="text" name="survey_employees_id" id="emergency_survey_employees_id_data" class="w-full p-3 border-2 border-gray-200 rounded-xl" autocomplete="off">
                            </div>
                            <div id="emergency-suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
                            <div id="emergency-selected-employee" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-user-check text-red-600"></i>
                                        <span id="emergency-selected-name" class="font-semibold text-red-800"></span>
                                    </div>
                                    <button id="emergency-clear-selection" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        <i class="fa-solid fa-times"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Department -->
                    <div class="space-y-2">
                        <label for="emergency_department_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-building text-red-600"></i>
                            <span>Department</span>
                        </label>
                        <select name="department_id" id="emergency_department_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    <!-- Issue -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-exclamation-triangle text-red-600"></i>
                            <span>Issue</span>
                        </label>
                        <div class="relative" id="emergency-issue-search-container">
                            <div class="relative" id="emergency-issue-input-container">
                                <input type="text" id="emergency_issue_search" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200 text-sm emergency-issue-search" placeholder="Search for issue..." autocomplete="off">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div class="hidden">
                                <input type="text" name="issues_id" id="emergency_issues_id_data" class="w-full p-3 border-2 border-gray-200 rounded-xl" autocomplete="off">
                            </div>
                            <div id="emergency-issue-suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
                            <div id="emergency-selected-issue" class="hidden mt-2 p-3 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-check-circle text-red-600"></i>
                                        <span id="emergency-selected-issue-name" class="font-semibold text-red-800"></span>
                                    </div>
                                    <button id="emergency-clear-issue-selection" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        <i class="fa-solid fa-times"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Location -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-map-marker-alt text-red-600"></i>
                            <span>Location</span>
                        </label>
                        <input type="text" name="location" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-red-500 focus:ring-2 focus:ring-red-200 transition-all duration-200" placeholder="Enter location...">
                    </div>

                    
                    <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                        <div class="flex justify-end space-x-3">
                            <button @click="emergencyModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                                Cancel
                            </button>
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                                <i class="fa-solid fa-exclamation-triangle mr-2"></i>
                                Submit Emergency Report
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            
        </div>
    </div>
    {{-- end of emergency modal --}}

    <!-- QR Code Modal -->
    <div x-show="qrModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white w-11/12 md:w-96 p-0 rounded-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <i class="fa-solid fa-qrcode text-white text-lg"></i>
                        </div>
                        <h2 class="text-xl font-bold text-white">Emergency Report Created</h2>
                    </div>
                    <button @click="qrModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 text-center">
                <div class="mb-4">
                    <div class="bg-green-100 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-check text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Report Status: Ongoing</h3>
                    <p class="text-gray-600 mb-6">Scan the QR code below to mark this report as completed</p>
                </div>
                
                <div id="qrcode" class="flex justify-center mb-6"></div>
                
                <div class="text-sm text-gray-500">
                    <p>Report ID: <span id="reportId" class="font-mono font-semibold"></span></p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                <button @click="qrModal = false" class="w-full px-6 py-2.5 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-all duration-200 font-medium">
                    Close
                </button>
            </div>
        </div>
    </div>

    {{-- escalate modal --}}
    <div x-show="escalateModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white p-0 rounded-2xl w-11/12 md:w-screen lg:w-1/2 max-w-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <i class="fa-solid fa-arrow-up text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Escalate Issue</h3>
                    </div>
                    <button @click="escalateModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form :action="'/report/escalate/' + selectedId" method="GET" class="space-y-5">
                    @csrf
                    <!-- Technical Staff -->
                    <div class="space-y-2">
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-user-gear text-orange-600"></i>
                            <span>Technical Staff</span>
                        </label>
                        <select name="user_id" id="user_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200">
                            <option value="">Select Technical staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Resolve Date Time -->
                    <div class="space-y-2">
                        <label for="resolve_datetime" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-calendar-check text-orange-600"></i>
                            <span>Resolve Date Time</span>
                        </label>
                        <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200" name="resolve_datetime" value="{{ old('resolve_datetime') }}">
                        @error('resolve_datetime')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Procedure -->
                    <div class="space-y-2">
                        <label for="procedure" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-list-check text-orange-600"></i>
                            <span>Procedure</span>
                        </label>
                        <input type="text" name="procedure" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 @error('procedure') border-red-500 @enderror" value="{{ old('procedure')}}" placeholder="Describe the escalation procedure...">
                        @error('procedure')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="space-y-2">
                        <label for="remarks" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-comment text-orange-600"></i>
                            <span>Remarks</span>
                        </label>
                        <input type="text" name="remarks" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 @error('remarks') border-red-500 @enderror" value="{{ old('remarks')}}" placeholder="Additional remarks...">
                        @error('remarks')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <button @click="escalateModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-600 to-orange-700 text-white rounded-xl hover:from-orange-700 hover:to-orange-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-arrow-up mr-2"></i>
                        Escalate Issue
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of escalate --}}

    {{-- endorse modal --}}
    <div x-show="endorseModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white p-0 rounded-2xl w-11/12 md:w-screen lg:w-1/2 max-w-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <i class="fa-solid fa-handshake text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Endorse Issue</h3>
                    </div>
                    <button @click="endorseModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                <form :action="'/report/endorse/' + selectedId" method="GET" class="space-y-5">
                    @csrf
                    <!-- Technical Staff -->
                    <div class="space-y-2">
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-user-gear text-indigo-600"></i>
                            <span>Technical Staff</span>
                        </label>
                        <select name="user_id" id="user_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200">
                            <option value="">Select Technical staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Endorse Date Time -->
                    <div class="space-y-2">
                        <label for="resolve_datetime" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-calendar-check text-indigo-600"></i>
                            <span>Endorse Date Time</span>
                        </label>
                        <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200" name="resolve_datetime" value="{{ old('resolve_datetime') }}">
                        @error('resolve_datetime')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="space-y-2">
                        <label for="remarks" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-comment text-indigo-600"></i>
                            <span>Remarks</span>
                        </label>
                        <input type="text" name="remarks" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-200 @error('remarks') border-red-500 @enderror" value="{{ old('remarks')}}" placeholder="Endorsement remarks...">
                        @error('remarks')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <button @click="endorseModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl hover:from-indigo-700 hover:to-indigo-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-handshake mr-2"></i>
                        Endorse Issue
                    </button>
                </div>
            </div>
        </div>
    </div>
    {{-- end of endorse --}}

    <!-- List of Resolved Issues -->
        </div>
        
    <!-- Resolved Issues Section -->
    <div class="mt-8 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
        <!-- Section Header -->
        <div class="px-8 py-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                    <i class="fa-solid fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Resolved Issues</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View completed and resolved tickets</p>
                </div>
            </div>
        </div>

        <!-- Filters Section -->
        <div class="px-8 py-6 bg-gray-50 dark:bg-gray-700/50">
            <form method="GET" action="{{ route('report.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <!-- Date Range Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <i class="fa-solid fa-calendar text-gray-500"></i>
                            <span>Date Range</span>
                        </label>
                        <div class="flex gap-2">
                            <input type="date" name="date_from" class="flex-1 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm dark:bg-gray-800 dark:text-white" placeholder="From" value="{{ request('date_from') }}">
                            <input type="date" name="date_to" class="flex-1 p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm dark:bg-gray-800 dark:text-white" placeholder="To" value="{{ request('date_to') }}">
                        </div>
                    </div>

                    <!-- Department Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <i class="fa-solid fa-building text-gray-500"></i>
                            <span>Department</span>
                        </label>
                        <select name="department_id" class="w-full p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm dark:bg-gray-800 dark:text-white">
                            <option value="">All Departments</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>{{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Issue Category Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <i class="fa-solid fa-tags text-gray-500"></i>
                            <span>Category</span>
                        </label>
                        <select name="category_id" class="w-full p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm dark:bg-gray-800 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Technical Staff Filter -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 flex items-center space-x-2">
                            <i class="fa-solid fa-user-gear text-gray-500"></i>
                            <span>Technical Staff</span>
                        </label>
                        <select name="user_id" class="w-full p-3 border-2 border-gray-200 dark:border-gray-600 rounded-xl focus:border-teal-500 focus:ring-2 focus:ring-teal-200 transition-all duration-200 text-sm dark:bg-gray-800 dark:text-white">
                            <option value="">All Staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>    
                
                <!-- Filter Actions -->
                <div class="flex flex-wrap justify-end gap-3">
                    <button type="submit" class="bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                        <i class="fa-solid fa-filter"></i>
                        <span>Apply Filters</span>
                    </button>
                    <a href="{{ route('report.index') }}" class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-300 dark:hover:bg-gray-500 px-6 py-3 rounded-xl font-medium transition-all duration-200 flex items-center space-x-2">
                        <i class="fa-solid fa-rotate"></i>
                        <span>Reset</span>
                    </a>
                    <a href="{{ route('report.export', request()->query()) }}" class="bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-700 hover:to-teal-800 text-white px-6 py-3 rounded-xl font-medium shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                        <i class="fa-solid fa-file-export"></i>
                        <span>Export</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Table Content -->
        <div class="p-8">
            <div class="overflow-auto max-h-[650px] rounded-xl border border-gray-200 dark:border-gray-600">
                <!-- Desktop Table -->
                <div class="hidden md:block">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr class="bg-gradient-to-r from-slate-800 to-slate-900">
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ticket Number</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Requestor Name</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Department</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Category</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Issue</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Requested Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Waiting Time</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Resolved Time</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Resolved Date</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Remarks</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-white">Technical Staff</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @foreach($resolved as $index => $resolve)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 font-medium">
                                    {{ $resolved->firstItem() + $index }}
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        <span>{{ $resolve->ticket_number }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->client->name }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-medium">
                                        {{ $resolve->Department?->title }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-xs font-medium">
                                        {{ $resolve->Issues?->Category?->title }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $resolve->Issues?->title }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ date('M d, Y', strtotime($resolve->request_datetime)) }}</span>
                                        <span class="text-xs text-gray-500">{{ date('h:i A', strtotime($resolve->request_datetime)) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        $diffInMinutes = \Carbon\Carbon::parse($resolve->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($resolve->response_datetime));
                                    @endphp
                                    <span class="px-2 py-1 bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 rounded-lg text-xs font-medium">
                                        {{ $diffInMinutes >= 60 ? round($diffInMinutes / 60) . ' hrs' : round($diffInMinutes) . ' mins' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @php
                                        if($resolve->validation_date_time == null){
                                            $diffInMinutes = \Carbon\Carbon::parse($resolve->response_datetime)->diffInMinutes(\Carbon\Carbon::parse($resolve->resolve_datetime));
                                        } else {
                                            $diffInMinutes = \Carbon\Carbon::parse($resolve->validation_date_time)->diffInMinutes(\Carbon\Carbon::parse($resolve->resolve_datetime));
                                        }
                                    @endphp
                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg text-xs font-medium">
                                        {{ $diffInMinutes >= 60 ? round($diffInMinutes / 60) . ' hrs' : round($diffInMinutes) . ' mins' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ date('M d, Y', strtotime($resolve->resolve_datetime)) }}</span>
                                        <span class="text-xs text-gray-500">{{ date('h:i A', strtotime($resolve->resolve_datetime)) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $resolve->remarks }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center">
                                            <span class="text-teal-600 dark:text-teal-400 text-xs font-medium">{{ substr($resolve->resolve->user->name, 0, 1) }}</span>
                                        </div>
                                        <span class="text-gray-900 dark:text-white font-medium">{{ $resolve->resolve->user->name }}</span>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Cards -->
                <div class="block md:hidden space-y-4">
                    @foreach($resolved as $resolve)
                        <div class="bg-white dark:bg-gray-700 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-600 p-6 space-y-4 hover:shadow-xl transition-all duration-200">
                            <!-- Header -->
                            <div class="flex justify-between items-start">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $resolve->client?->name }}
                                    </h3>
                                </div>
                                <span class="px-3 py-1 text-xs font-medium bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full">
                                    {{ $resolve->department?->title }}
                                </span>
                            </div>
                            
                            <!-- Content -->
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Ticket:</span>
                                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $resolve->ticket_number }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Issue:</span>
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $resolve->issues?->title }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Category:</span>
                                    <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-lg text-xs font-medium">
                                        {{ $resolve->Issues?->Category?->title }}
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center">
                                            <span class="text-teal-600 dark:text-teal-400 text-xs font-medium">{{ substr($resolve->resolve->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $resolve->resolve->user->name }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Technical Staff</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ date('M d, Y', strtotime($resolve->resolve_datetime)) }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ date('h:i A', strtotime($resolve->resolve_datetime)) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="px-8 py-6 border-t border-gray-200 dark:border-gray-700">
                {{ $resolved->links() }}
            </div>
        </div>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
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
    
    // Emergency modal employee search functionality
    const emergencySearchInput = document.getElementById('emergency_survey_employees_id');
    const emergencySuggestionsContainer = document.getElementById('emergency-suggestions-container');
    const emergencySelectedEmployee = document.getElementById('emergency-selected-employee');
    const emergencySelectedName = document.getElementById('emergency-selected-name');
    const emergencyEmployeeId = document.getElementById('emergency_survey_employees_id_data');
    const emergencyClearButton = document.getElementById('emergency-clear-selection');
    const emergencyEmployeeSearchContainer = document.getElementById('emergency-employee-search-container');
    
    const employees = @json($employees);
    const issues = @json($issues);
    
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
    
    // Event listener for emergency modal input
    emergencySearchInput.addEventListener('input', debounce(async function(e) {
        const query = e.target.value.trim();
        
        if (query.length < 0) {
            emergencySuggestionsContainer.classList.add('hidden');
            return;
        }
        
        const results = await fetchEmployees(query);
        displayEmergencySuggestions(results);
    }, 300));
    
    // Show all employees when clicking the emergency input
    emergencySearchInput.addEventListener('focus', async function() {
        const results = await fetchEmployees('');
        displayEmergencySuggestions(results);
    });
    
    // Display suggestions for emergency modal
    function displayEmergencySuggestions(employees) {
        if (employees.length === 0) {
            emergencySuggestionsContainer.innerHTML = '<div class="p-4 text-gray-500 text-sm">No employees found</div>';
            emergencySuggestionsContainer.classList.remove('hidden');
            return;
        }
        
        emergencySuggestionsContainer.innerHTML = '';
        employees.forEach(employee => {
            const div = document.createElement('div');
            div.className = 'p-3 border-b border-gray-100 hover:bg-red-50 cursor-pointer transition';
            div.innerHTML = `
                <div class="font-medium text-gray-800 text-sm">${employee.name}</div>
            `;
            div.addEventListener('click', () => {
                selectEmergencyEmployee(employee);
            });
            emergencySuggestionsContainer.appendChild(div);
        });
        
        emergencySuggestionsContainer.classList.remove('hidden');
    }
    
    // Select an employee for emergency modal
    function selectEmergencyEmployee(employee) {
        emergencySelectedName.textContent = employee.name;
        emergencyEmployeeId.value = employee.id;
        document.getElementById('emergency_department_id').value = employee.department_id;
        emergencySelectedEmployee.classList.remove('hidden');
        emergencySearchInput.value = '';
        emergencySuggestionsContainer.classList.add('hidden');
        emergencyEmployeeSearchContainer.classList.add('hidden');
    }
    
    // Clear selection for emergency modal
    emergencyClearButton.addEventListener('click', function(e) {
        e.preventDefault();
        emergencySelectedEmployee.classList.add('hidden');
        emergencyEmployeeSearchContainer.classList.remove('hidden');
        emergencyEmployeeId.value = '';
        emergencySearchInput.value = '';
        emergencySearchInput.focus();
    });
    
    // Close emergency suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!emergencySearchInput.contains(e.target) && !emergencySuggestionsContainer.contains(e.target)) {
            emergencySuggestionsContainer.classList.add('hidden');
        }
    });
    
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
    
    // Issue search functionality
    const issueSearchInput = document.getElementById('issue_search');
    const issueSuggestionsContainer = document.getElementById('issue-suggestions-container');
    const selectedIssue = document.getElementById('selected-issue');
    const selectedIssueName = document.getElementById('selected-issue-name');
    const issueId = document.getElementById('issues_id_data');
    const clearIssueButton = document.getElementById('clear-issue-selection');
    const issueInputContainer = document.getElementById('issue-input-container');
    
    function fetchIssues(query) {
        return new Promise(resolve => {
            setTimeout(() => {
                const results = issues.filter(issue => 
                    issue.title.toLowerCase().includes(query.toLowerCase())
                );
                resolve(results);
            }, 200);
        });
    }
    
    issueSearchInput.addEventListener('input', debounce(async function(e) {
        const query = e.target.value.trim();
        const results = await fetchIssues(query);
        displayIssueSuggestions(results);
    }, 300));
    
    issueSearchInput.addEventListener('focus', async function() {
        const results = await fetchIssues('');
        displayIssueSuggestions(results);
    });
    
    function displayIssueSuggestions(issues) {
        if (issues.length === 0) {
            issueSuggestionsContainer.innerHTML = '<div class="p-4 text-gray-500 text-sm">No issues found</div>';
            issueSuggestionsContainer.classList.remove('hidden');
            return;
        }
        
        issueSuggestionsContainer.innerHTML = '';
        issues.forEach(issue => {
            const div = document.createElement('div');
            div.className = 'p-3 border-b border-gray-100 hover:bg-teal-50 cursor-pointer transition';
            div.innerHTML = `<div class="font-medium text-gray-800 text-sm">${issue.title}</div>`;
            div.addEventListener('click', () => {
                selectIssue(issue);
            });
            issueSuggestionsContainer.appendChild(div);
        });
        
        issueSuggestionsContainer.classList.remove('hidden');
    }
    
    function selectIssue(issue) {
        selectedIssueName.textContent = issue.title;
        issueId.value = issue.id;
        selectedIssue.classList.remove('hidden');
        issueSearchInput.value = '';
        issueSuggestionsContainer.classList.add('hidden');
        issueInputContainer.classList.add('hidden');
    }
    
    clearIssueButton.addEventListener('click', function(e) {
        e.preventDefault();
        selectedIssue.classList.add('hidden');
        issueInputContainer.classList.remove('hidden');
        issueId.value = '';
        issueSearchInput.value = '';
        issueSearchInput.focus();
    });
    
    document.addEventListener('click', function(e) {
        if (!issueSearchInput.contains(e.target) && !issueSuggestionsContainer.contains(e.target)) {
            issueSuggestionsContainer.classList.add('hidden');
        }
    });
    
    // Emergency Issue search functionality
    const emergencyIssueSearchInput = document.getElementById('emergency_issue_search');
    const emergencyIssueSuggestionsContainer = document.getElementById('emergency-issue-suggestions-container');
    const emergencySelectedIssue = document.getElementById('emergency-selected-issue');
    const emergencySelectedIssueName = document.getElementById('emergency-selected-issue-name');
    const emergencyIssueId = document.getElementById('emergency_issues_id_data');
    const emergencyClearIssueButton = document.getElementById('emergency-clear-issue-selection');
    const emergencyIssueInputContainer = document.getElementById('emergency-issue-input-container');
    
    emergencyIssueSearchInput.addEventListener('input', debounce(async function(e) {
        const query = e.target.value.trim();
        const results = await fetchIssues(query);
        displayEmergencyIssueSuggestions(results);
    }, 300));
    
    emergencyIssueSearchInput.addEventListener('focus', async function() {
        const results = await fetchIssues('');
        displayEmergencyIssueSuggestions(results);
    });
    
    function displayEmergencyIssueSuggestions(issues) {
        if (issues.length === 0) {
            emergencyIssueSuggestionsContainer.innerHTML = '<div class="p-4 text-gray-500 text-sm">No issues found</div>';
            emergencyIssueSuggestionsContainer.classList.remove('hidden');
            return;
        }
        
        emergencyIssueSuggestionsContainer.innerHTML = '';
        issues.forEach(issue => {
            const div = document.createElement('div');
            div.className = 'p-3 border-b border-gray-100 hover:bg-red-50 cursor-pointer transition';
            div.innerHTML = `<div class="font-medium text-gray-800 text-sm">${issue.title}</div>`;
            div.addEventListener('click', () => {
                selectEmergencyIssue(issue);
            });
            emergencyIssueSuggestionsContainer.appendChild(div);
        });
        
        emergencyIssueSuggestionsContainer.classList.remove('hidden');
    }
    
    function selectEmergencyIssue(issue) {
        emergencySelectedIssueName.textContent = issue.title;
        emergencyIssueId.value = issue.id;
        emergencySelectedIssue.classList.remove('hidden');
        emergencyIssueSearchInput.value = '';
        emergencyIssueSuggestionsContainer.classList.add('hidden');
        emergencyIssueInputContainer.classList.add('hidden');
    }
    
    emergencyClearIssueButton.addEventListener('click', function(e) {
        e.preventDefault();
        emergencySelectedIssue.classList.add('hidden');
        emergencyIssueInputContainer.classList.remove('hidden');
        emergencyIssueId.value = '';
        emergencyIssueSearchInput.value = '';
        emergencyIssueSearchInput.focus();
    });
    
    document.addEventListener('click', function(e) {
        if (!emergencyIssueSearchInput.contains(e.target) && !emergencyIssueSuggestionsContainer.contains(e.target)) {
            emergencyIssueSuggestionsContainer.classList.add('hidden');
        }
    });
    
    // Validation Issue search functionality (using event delegation for dynamically loaded content)
    $(document).on('input', '#validate_issue_search', debounce(async function(e) {
        const query = e.target.value.trim();
        const results = await fetchIssues(query);
        displayValidateIssueSuggestions(results);
    }, 300));
    
    $(document).on('focus', '#validate_issue_search', async function() {
        const results = await fetchIssues('');
        displayValidateIssueSuggestions(results);
    });
    
    function displayValidateIssueSuggestions(issues) {
        const container = document.getElementById('validate-issue-suggestions-container');
        if (!container) return;
        
        if (issues.length === 0) {
            container.innerHTML = '<div class="p-4 text-gray-500 text-sm">No issues found</div>';
            container.classList.remove('hidden');
            return;
        }
        
        container.innerHTML = '';
        issues.forEach(issue => {
            const div = document.createElement('div');
            div.className = 'p-3 border-b border-gray-100 hover:bg-purple-50 cursor-pointer transition';
            div.innerHTML = `<div class="font-medium text-gray-800 text-sm">${issue.title}</div>`;
            div.addEventListener('click', () => {
                selectValidateIssue(issue);
            });
            container.appendChild(div);
        });
        
        container.classList.remove('hidden');
    }
    
    function selectValidateIssue(issue) {
        const selectedIssueName = document.getElementById('validate-selected-issue-name');
        const issueId = document.getElementById('validate_issues_id_data');
        const selectedIssue = document.getElementById('validate-selected-issue');
        const searchInput = document.getElementById('validate_issue_search');
        const container = document.getElementById('validate-issue-suggestions-container');
        const inputContainer = document.getElementById('validate-issue-input-container');
        
        if (selectedIssueName) selectedIssueName.textContent = issue.title;
        if (issueId) issueId.value = issue.id;
        if (selectedIssue) selectedIssue.classList.remove('hidden');
        if (searchInput) searchInput.value = '';
        if (container) container.classList.add('hidden');
        if (inputContainer) inputContainer.classList.add('hidden');
    }
    
    $(document).on('click', '#validate-clear-issue-selection', function(e) {
        e.preventDefault();
        const selectedIssue = document.getElementById('validate-selected-issue');
        const inputContainer = document.getElementById('validate-issue-input-container');
        const issueId = document.getElementById('validate_issues_id_data');
        const searchInput = document.getElementById('validate_issue_search');
        
        if (selectedIssue) selectedIssue.classList.add('hidden');
        if (inputContainer) inputContainer.classList.remove('hidden');
        if (issueId) issueId.value = '';
        if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
        }
    });
    
    $(document).on('click', function(e) {
        const searchInput = document.getElementById('validate_issue_search');
        const container = document.getElementById('validate-issue-suggestions-container');
        if (searchInput && container && !searchInput.contains(e.target) && !container.contains(e.target)) {
            container.classList.add('hidden');
        }
    });
    
    // Change Issue search functionality (using event delegation for dynamically loaded content)
    $(document).on('input', '#change_issue_search', debounce(async function(e) {
        const query = e.target.value.trim();
        const results = await fetchIssues(query);
        displayChangeIssueSuggestions(results);
    }, 300));
    
    $(document).on('focus', '#change_issue_search', async function() {
        const results = await fetchIssues('');
        displayChangeIssueSuggestions(results);
    });
    
    function displayChangeIssueSuggestions(issues) {
        const container = document.getElementById('change-issue-suggestions-container');
        if (!container) return;
        
        if (issues.length === 0) {
            container.innerHTML = '<div class="p-4 text-gray-500 text-sm">No issues found</div>';
            container.classList.remove('hidden');
            return;
        }
        
        container.innerHTML = '';
        issues.forEach(issue => {
            const div = document.createElement('div');
            div.className = 'p-3 border-b border-gray-100 hover:bg-orange-50 cursor-pointer transition';
            div.innerHTML = `<div class="font-medium text-gray-800 text-sm">${issue.title}</div>`;
            div.addEventListener('click', () => {
                selectChangeIssue(issue);
            });
            container.appendChild(div);
        });
        
        container.classList.remove('hidden');
    }
    
    function selectChangeIssue(issue) {
        const selectedIssueName = document.getElementById('change-selected-issue-name');
        const issueId = document.getElementById('change_issues_id_data');
        const selectedIssue = document.getElementById('change-selected-issue');
        const searchInput = document.getElementById('change_issue_search');
        const container = document.getElementById('change-issue-suggestions-container');
        
        if (selectedIssueName) selectedIssueName.textContent = issue.title;
        if (issueId) issueId.value = issue.id;
        if (selectedIssue) selectedIssue.classList.remove('hidden');
        if (searchInput) searchInput.value = '';
        if (container) container.classList.add('hidden');
    }
    
    $(document).on('click', '#change-clear-issue-selection', function(e) {
        e.preventDefault();
        const selectedIssue = document.getElementById('change-selected-issue');
        const issueId = document.getElementById('change_issues_id_data');
        const searchInput = document.getElementById('change_issue_search');
        
        if (selectedIssue) selectedIssue.classList.add('hidden');
        if (issueId) issueId.value = '';
        if (searchInput) {
            searchInput.value = '';
            searchInput.focus();
        }
    });
    
    $(document).on('click', function(e) {
        const searchInput = document.getElementById('change_issue_search');
        const container = document.getElementById('change-issue-suggestions-container');
        if (searchInput && container && !searchInput.contains(e.target) && !container.contains(e.target)) {
            container.classList.add('hidden');
        }
    });
    
    </script>


</x-layout>
