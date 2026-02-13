<div class="block mt-4 overflow-auto">
    <!-- Table: Visible on medium screens (md) and larger -->
    <div class="hidden md:block">
        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-600 shadow-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-slate-800 to-slate-900">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Actions</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Ticket Number</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Requestor Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Department</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Category</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Location</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Issue</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Waiting Time</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Processing Time</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Request Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-white">Remarks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">            
        <?php 
                $count = 1;
                $now = now();
                ?>
            @foreach($reports as $report)
    
                @php
                    $waitingMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(now());
                    $isOverdue = $report->status == 'Pending' && $waitingMinutes >= 5;
                @endphp
                <tr class="{{ $isOverdue ? 'bg-red-50 hover:bg-red-100 animate-pulse border-l-4 border-red-500' : 'hover:bg-gray-50' }} dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition-all duration-200">
                    @if ($report->status == 'Pending')
                        <td class="px-6 py-4">
                            <button 
                                @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                                class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2.5 rounded-xl w-full transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-sm">
                                <i class="fa-solid fa-reply mr-1"></i>
                                Response
                            </button>
                        </td>
                    @elseif ($report->status == 'For validation')
                        <td class="px-6 py-4">
                            <div class="flex flex-col space-y-2">
                                <button 
                                    @click="confirmValidateModal = true; selectedId = '{{ $report->id }}'" 
                                    class="bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                    <i class="fa-solid fa-check-double mr-1"></i>
                                    Validate
                                </button>
                                <button 
                                    @click="changeIssueModal = true; selectedId = '{{ $report->id }}'" 
                                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                    <i class="fa-solid fa-exchange-alt mr-1"></i>
                                    Change Issue
                                </button>
                            </div>
                        </td>
                    @else
                        <td class="px-6 py-4">
                            <div class="flex flex-col space-y-2">
                                <button 
                                    @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                    <i class="fa-solid fa-check mr-1"></i>
                                    Resolved
                                </button>
                                
                                <button 
                                    @click="escalateModal = true; selectedId = '{{ $report->id }}'" 
                                    class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                    <i class="fa-solid fa-arrow-up mr-1"></i>
                                    Escalate
                                </button>

                                <button 
                                    @click="endorseModal = true; selectedId = '{{ $report->id }}'" 
                                    class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                    <i class="fa-solid fa-handshake mr-1"></i>
                                    Endorse
                                </button>
                            </div>
                        </td>
                    @endif
                    <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                        <div class="flex items-center space-x-2">
                            <div class="w-2 h-2 {{ $report->status == 'Pending' ? 'bg-yellow-500' : ($report->status == 'Ongoing' ? 'bg-blue-500' : 'bg-purple-500') }} rounded-full"></div>
                            <span>{{ $report->ticket_number }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $report->client->name }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-full text-xs font-medium">
                            {{ $report->department->title }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-full text-xs font-medium">
                            {{ $report->issues->category->title }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $report->location }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">{{ $report->issues->title }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            @if($report->status == 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($report->status == 'Ongoing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($report->status == 'For validation') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @endif">
                            {{ $report->status }}
                        </span>
                    </td>
                    @if ($report->status == 'Pending')
                        <td class="px-6 py-4 pending{{$count}}" style="display: none;">{{$report->request_datetime}}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="pendingValue{{$count}} px-2 py-1 bg-orange-100 dark:bg-orange-900 text-orange-800 dark:text-orange-200 rounded-lg text-xs font-medium"></span>
                        </td>
                    @elseif ($report->status == 'For validation')
                        <td class="px-6 py-4 text-sm">
                            @php
                                $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                            @endphp
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-medium">
                                @if ($diffInMinutes >= 60)
                                    {{ round($diffInMinutes / 60) }} hrs
                                @else
                                    {{ round($diffInMinutes) }} mins
                                @endif
                            </span>
                        </td>
                    @elseif ($report->status == 'Ongoing')
                        <td class="px-6 py-4 text-sm">
                            @php
                                $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                            @endphp
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-medium">
                                @if ($diffInMinutes >= 60)
                                    {{ round($diffInMinutes / 60) }} hrs
                                @else
                                    {{ round($diffInMinutes) }} mins
                                @endif
                            </span>
                        </td>
                    @endif
                    <td class="px-6 py-4 ongoing{{$count}}" style="display: none;">
                        @if ($report->validation_date_time != null)
                            {{ $report->validation_date_time }}
                        @else
                            {{$report->response_datetime}}
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm">
                        @if ($report->status == 'Ongoing')
                            <span class="ongoingValue{{$count}} px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg text-xs font-medium"></span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                        <div class="flex flex-col">
                            <span class="font-medium">{{ date('M d, Y', strtotime($report->request_datetime)) }}</span>
                            <span class="text-xs text-gray-500">{{ date('h:i A', strtotime($report->request_datetime)) }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 max-w-xs truncate">{{ $report->remarks }}</td>
                </tr>                @php
                    $count++;
                @endphp
            @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Card: Visible only on small screens (mobile) -->
    <div class="block md:hidden">
        <?php 
        $count1 = 1;
        $now = now();
        ?>
         @foreach($reports as $report)
        @php
            $waitingMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(now());
            $isOverdue = $report->status == 'Pending' && $waitingMinutes >= 5;
        @endphp
        <div class="border p-4 rounded-lg shadow-md mb-4 dark:text-white {{ $isOverdue ? 'bg-red-50 border-red-200 animate-pulse' : 'bg-white' }} dark:bg-slate-800 transition-all hover:shadow-lg {{ $isOverdue ? 'border-l-4 border-l-red-500' : '' }}">
            <div class="flex justify-between items-center mb-3">
                <h2 class="font-bold text-lg">{{ $report->client->name }} - {{ $report->department->title }}</h2>
                <span class="px-3 py-1 rounded-full text-sm font-medium
                    @if($report->status == 'Pending') bg-yellow-100 text-yellow-800
                    @elseif($report->status == 'Ongoing') bg-blue-100 text-blue-800
                    @elseif($report->status == 'For validation') bg-purple-100 text-purple-800
                    @endif">
                    {{ $report->status }}
                </span>
            </div>
            <div class="space-y-2 mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-300"><span class="font-medium">Ticket No:</span> {{ $report->ticket_number }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300"><span class="font-medium">Issues:</span> {{ $report->issues->title }}</p>
                @if ($report->status == 'Pending')
                    <div class="border border-gray-300 px-4 py-2 pending{{$count1}}" style="display: none;">
                        {{$report->request_datetime}}
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <span class="font-medium">Pending Time:</span>
                        <span class="dark:text-white ml-2 pendingValue{{$count1}} text-orange-600"></span>
                    </p>
                @else
                    @php
                        $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                    @endphp
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        <span class="font-medium">Ongoing Time:</span>
                        <span class="text-blue-600 ml-2">
                            @if ($diffInMinutes >= 60)
                                {{ round($diffInMinutes / 60) }} hrs
                            @else
                                {{ round($diffInMinutes) }} mins
                            @endif
                        </span>
                    </p>
                @endif
            </div>

            <div class="flex flex-col gap-2">
                @if ($report->status == 'Pending')
                    <button 
                        @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                        class="w-full bg-teal-600 text-white px-4 py-2.5 rounded-lg hover:bg-teal-700 transition duration-150 shadow-sm text-sm font-medium">
                        Response
                    </button>
                @elseif ($report->status == 'For validation')
                    <div class="flex flex-col gap-2">
                        <button 
                            @click="confirmValidateModal = true; selectedId = '{{ $report->id }}'" 
                            class="w-full bg-purple-600 text-white px-4 py-2.5 rounded-lg hover:bg-purple-700 transition duration-150 shadow-sm text-sm font-medium">
                            <i class="fa-solid fa-check-double mr-1"></i>
                            Validate
                        </button>
                        <button 
                            @click="changeIssueModal = true; selectedId = '{{ $report->id }}'" 
                            class="w-full bg-orange-500 text-white px-4 py-2.5 rounded-lg hover:bg-orange-600 transition duration-150 shadow-sm text-sm font-medium">
                            <i class="fa-solid fa-exchange-alt mr-1"></i>
                            Change Issue
                        </button>
                    </div>
                @else
                    <button 
                        @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                        class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg hover:bg-blue-700 transition duration-150 shadow-sm text-sm font-medium">
                        Resolved
                    </button>
                    
                    <button 
                        @click="escalateModal = true; selectedId = '{{ $report->id }}'" 
                        class="w-full bg-yellow-500 text-white px-4 py-2.5 rounded-lg hover:bg-yellow-600 transition duration-150 shadow-sm text-sm font-medium">
                        Escalate
                    </button>

                    <button 
                        @click="endorseModal = true; selectedId = '{{ $report->id }}'" 
                        class="w-full bg-green-500 text-white px-4 py-2.5 rounded-lg hover:bg-green-600 transition duration-150 shadow-sm text-sm font-medium">
                        Endorse
                    </button>
                @endif
            </div>
            @php
                $count1++;
            @endphp
        </div>
        @endforeach
    </div>
<div>
    {{ $reports->links() }}


<!-- Response Modal -->
    <div x-show="responseModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        <div class="bg-white p-0 rounded-2xl w-11/12 md:w-screen lg:w-1/2 max-w-2xl shadow-2xl border border-gray-100" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                            <i class="fa-solid fa-reply text-white text-lg"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white">Response to Issue</h3>
                    </div>
                    <button @click="responseModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                        <i class="fa-solid fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <!-- Body -->
            <form :action="'/report/edit/' + selectedId" method="GET" class="space-y-5">
            <div class="p-6 max-h-[70vh] overflow-y-auto">
                
                    @csrf
                    <!-- Technical Staff -->
                    <div class="space-y-2">
                        <label for="user_id" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-user-gear text-blue-600"></i>
                            <span>Technical Staff</span>
                        </label>
                        <select name="user_id" id="user_id" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200">
                            <option value="">Select Technical staff</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        
                        <!-- I will response checkbox -->
                        <div class="flex items-center mt-3 p-3 bg-blue-50 rounded-xl border border-blue-200">
                            <input checked id="checked-checkbox" name="iam_check" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 iam-checkbox">
                            <label for="checked-checkbox" class="ml-3 text-sm font-medium text-blue-800 flex items-center space-x-2">
                                <i class="fa-solid fa-user-check"></i>
                                <span>I will respond to this issue</span>
                            </label>
                        </div>
                    </div>

                    <!-- Response Date Time -->
                    <div class="space-y-2">
                        <label for="response_datetime" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-calendar-check text-blue-600"></i>
                            <span>Response Date Time</span>
                        </label>
                        <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" name="response_datetime" value="{{ old('response_datetime') }}">
                        @error('response_datetime')
                            <p class="text-red-500 text-sm mt-1 flex items-center space-x-1">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Notes -->
                    <div class="space-y-2">
                        <label for="notes" class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-sticky-note text-blue-600"></i>
                            <span>Notes</span>
                        </label>
                        <textarea id="notes" rows="4" name="notes" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 resize-none" placeholder="Write your response notes here..."></textarea>
                    </div>
                
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <button @click="responseModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-reply mr-2"></i>
                        Send Response
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
<!-- Confirm Validate Modal -->
<div x-show="confirmValidateModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50">
    <div class="bg-white p-0 rounded-2xl w-11/12 md:w-screen lg:w-1/2 max-w-2xl shadow-2xl border border-gray-100">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                        <i class="fa-solid fa-check-double text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Validate Resolution</h3>
                </div>
                <button @click="confirmValidateModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('report.confirmValidate') }}" method="POST">
            @csrf
            <div class="p-6">
                <input type="hidden" name="report_id" :value="selectedId">
                <div class="space-y-2 mb-4">
                    <label class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                        <i class="fa-solid fa-calendar-check text-purple-600"></i>
                        <span>Validation Date Time</span>
                    </label>
                    <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200" name="validation_datetime" required>
                </div>
                <div class="text-center py-4">
                    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-purple-100 mb-4">
                        <i class="fa-solid fa-question text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Confirm Validation</h3>
                    <p class="text-gray-600">Are you sure you want to validate this issue?</p>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="confirmValidateModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-purple-700 text-white rounded-xl hover:from-purple-700 hover:to-purple-800 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-check mr-2"></i>
                        Yes, Validate
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Change Issue Modal -->
<div x-show="changeIssueModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50">
    <div class="bg-white p-0 rounded-2xl w-11/12 md:w-screen lg:w-1/2 max-w-2xl shadow-2xl border border-gray-100">
        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="bg-white bg-opacity-20 p-2 rounded-lg">
                        <i class="fa-solid fa-exchange-alt text-white text-lg"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white">Change Issue</h3>
                </div>
                <button @click="changeIssueModal = false" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
            </div>
        </div>
        
        <form action="{{ route('report.changeIssue') }}" method="POST">
            @csrf
            <div class="p-6">
                <input type="hidden" name="report_id" :value="selectedId">
                <div class="space-y-5">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-calendar-check text-orange-600"></i>
                            <span>Validation Date Time</span>
                        </label>
                        <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200" name="validation_datetime">
                    </div>
                    
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 flex items-center space-x-2">
                            <i class="fa-solid fa-exclamation-triangle text-orange-600"></i>
                            <span>New Issue</span>
                        </label>
                        <div class="relative" id="change-issue-search-container">
                            <div class="relative">
                                <input type="text" id="change_issue_search" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-orange-500 focus:ring-2 focus:ring-orange-200 transition-all duration-200 text-sm" placeholder="Search for issue..." autocomplete="off">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div class="hidden">
                                <input type="text" name="issues_id" id="change_issues_id_data" class="w-full" autocomplete="off" required>
                            </div>
                            <div id="change-issue-suggestions-container" class="absolute z-10 w-full mt-1 bg-white rounded-xl shadow-lg border border-gray-200 max-h-60 overflow-y-auto"></div>
                            <div id="change-selected-issue" class="hidden mt-2 p-3 bg-orange-50 border border-orange-200 rounded-xl">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <i class="fa-solid fa-check-circle text-orange-600"></i>
                                        <span id="change-selected-issue-name" class="font-semibold text-orange-800"></span>
                                    </div>
                                    <button type="button" id="change-clear-issue-selection" class="text-orange-600 hover:text-orange-800 text-sm font-medium">
                                        <i class="fa-solid fa-times"></i> Clear
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 rounded-b-2xl border-t border-gray-100">
                <div class="flex justify-end space-x-3">
                    <button type="button" @click="changeIssueModal = false" class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all duration-200 font-medium shadow-lg hover:shadow-xl">
                        <i class="fa-solid fa-check mr-2"></i>
                        Submit Change
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
         $('.iam-checkbox').click(function() {
            // console.log($(this).is(":checked"));
        });

       

        



        setInterval(() => {
            pendingTime();
            ongoingTime();
        }, 1000);
        const pendingTime = () =>{
            const count = @json($count);

            for (let index = 1; index < count; index++) {
                
                const requestTime = $('.pending'+index).html();
                
                const startTime = new Date(requestTime);
                const endTime = new Date();
                const diffInMs = endTime - startTime;
                
                const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
           
                if (diffInMinutes >= 60) {
                  
                    $('.pendingValue'+index).html(Math.round(diffInMinutes / 60)+' hrs');
                }
                else {
                    $('.pendingValue'+index).html(diffInMinutes+' mins');
                }
            }
        }

        const ongoingTime = () =>{
            const count = @json($count);
         
            for (let index = 1; index < count; index++) {
                
                const requestTime = $('.ongoing'+index).html();

                const startTime = new Date(requestTime);
                const endTime = new Date();
                const diffInMs = endTime - startTime;
                
                const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
                    if (diffInMinutes >= 60) {
                        
                        $('.ongoingValue'+index).html(Math.round(diffInMinutes / 60)+' hrs');
                    }
                    else {
                        $('.ongoingValue'+index).html(diffInMinutes+' mins');
                    }
                }
            

            
        }
        
</script>