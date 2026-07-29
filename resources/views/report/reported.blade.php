@php
    $count = 1;
@endphp
<div class="block mt-4 overflow-auto">
    @if($reports->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 px-4">
            <div class="bg-gray-100 dark:bg-gray-800 rounded-full p-8 mb-4">
                <svg class="w-24 h-24 text-gray-400 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-2">No Active Issues</h3>
            <p class="text-gray-500 dark:text-gray-400 text-center">There are currently no active issues to display.</p>
        </div>
    @else
    <!-- Cards Layout for all screens -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php 
        $now = now();
        ?>
        @foreach($reports as $report)
            @php
                $waitingMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(now());
                $isOverdue = $report->status == 'Pending' && $waitingMinutes >= 5;
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border {{ $isOverdue ? 'border-red-500 border-l-4 bg-red-50 dark:bg-red-900/20 animate-pulse' : 'border-gray-200 dark:border-gray-700' }} p-6 hover:shadow-xl transition-all duration-200">
                <!-- Header -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $report->status == 'Pending' ? 'bg-yellow-500' : ($report->status == 'Ongoing' ? 'bg-blue-500' : 'bg-purple-500') }} rounded-full"></div>
                        <span class="font-bold text-gray-900 dark:text-white">{{ $report->ticket_number }}</span>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-medium
                        @if($report->status == 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                        @elseif($report->status == 'Ongoing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                        @elseif($report->status == 'For validation') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                        @endif">
                        {{ $report->status }}
                    </span>
                </div>

                <!-- Content -->
                <div class="space-y-3 mb-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Requestor</p>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $report->client->name }}</p>
                    </div>
                    <div class="flex gap-2">
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-medium">
                            {{ $report->department->title }}
                        </span>
                        <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 rounded-lg text-xs font-medium">
                            {{ $report->issues->category->title }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Issue</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $report->issues->title }}</p>
                    </div>
                    @if($report->location)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Location</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $report->location }}</p>
                    </div>
                    @endif
                    <div class="flex justify-between text-xs">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">Request Date</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ date('M d, Y h:i A', strtotime($report->request_datetime)) }}</p>
                        </div>
                    </div>
                    @if ($report->status == 'Pending')
                        <div class="pending{{$count}}" style="display: none;">{{$report->request_datetime}}</div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Waiting:</span>
                            <span class="pendingValue{{$count}} px-2 py-1 rounded-lg text-xs font-medium"></span>
                        </div>
                    @else
                        @php
                            $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                        @endphp
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Response Time:</span>
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 rounded-lg text-xs font-medium">
                                {{ $diffInMinutes >= 60 ? round($diffInMinutes / 60) . ' hrs' : round($diffInMinutes) . ' mins' }}
                            </span>
                        </div>
                    @endif
                    @if ($report->status == 'Ongoing')
                        <div class="ongoing{{$count}}" style="display: none;">
                            {{ $report->validation_date_time ?? $report->response_datetime }}
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Responsed by: {{ $report->response->name;}}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            
                            <span class="text-xs text-gray-500 dark:text-gray-400">Processing:</span>
                            <span class="ongoingValue{{$count}} px-2 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg text-xs font-medium"></span>
                        </div>

                    @elseif($report->status == 'For validation')
                        <div class="flex items-center space-x-2">
                            <span class="text-xs text-gray-500 dark:text-gray-400">Responsed by: {{ $report->response->name;}}</span>
                        </div>
                    @endif

                      @if($report->remarks)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Remarks</p>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $report->remarks }}</p>
                        </div>
                        @endif

                        @if($report->screenshot)
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Attachment</p>
                            <button 
                                type="button"
                                @click="screenshotModal = true; currentScreenshot = '{{ route('report.screenshot', $report->id) }}'; currentTicket = '{{ $report->ticket_number }}'" 
                                class="w-full inline-flex items-center justify-center space-x-2 px-3 py-2 bg-sky-50 hover:bg-sky-100 dark:bg-sky-900/40 dark:hover:bg-sky-900/60 text-sky-700 dark:text-sky-300 rounded-xl text-xs font-semibold transition-all duration-200 border border-sky-200 dark:border-sky-800 shadow-sm hover:shadow">
                                <i class="fa-solid fa-image text-sky-600 dark:text-sky-400 text-sm"></i>
                                <span>View Attached Image</span>
                            </button>
                        </div>
                        @endif
                </div>

                

                <!-- Actions -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    @if ($report->status == 'Pending')
                        <button 
                            @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                            class="w-full bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2.5 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-sm">
                            <i class="fa-solid fa-reply mr-1"></i>
                            Response
                        </button>
                    @elseif ($report->status == 'For validation')
                        <div class="flex flex-col space-y-2">
                            <button 
                                @click="confirmValidateModal = true; selectedId = '{{ $report->id }}'" 
                                class="w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                <i class="fa-solid fa-check-double mr-1"></i>
                                Validate
                            </button>
                            <button 
                                @click="changeIssueModal = true; selectedId = '{{ $report->id }}'" 
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                <i class="fa-solid fa-exchange-alt mr-1"></i>
                                Change Issue
                            </button>
                        </div>
                    @else
                        <div class="flex flex-col space-y-2">
                            <button 
                                @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                                class="w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                <i class="fa-solid fa-check mr-1"></i>
                                Resolved
                            </button>
                            <button 
                                @click="escalateModal = true; selectedId = '{{ $report->id }}'" 
                                class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                <i class="fa-solid fa-arrow-up mr-1"></i>
                                Escalate
                            </button>
                            <button 
                                @click="endorseModal = true; selectedId = '{{ $report->id }}'" 
                                class="w-full bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-3 py-2 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl font-medium text-xs">
                                <i class="fa-solid fa-handshake mr-1"></i>
                                Endorse
                            </button>
                        </div>
                    @endif
                                                
                    </div>
            </div>
            @php
                $count++;
            @endphp
        @endforeach
    </div>
    <div class="mt-4">
        {{ $reports->links() }}
    </div>
    @endif
</div>


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
                        <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200" name="response_datetime" value="{{ old('response_datetime', now()->format('Y-m-d\TH:i')) }}">
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
                    <button type="button" @click="responseModal = false" 
                        class="px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all duration-200 font-medium">
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
                    <input type="datetime-local" class="w-full p-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200" name="validation_datetime" value="{{ old('validation_datetime', now()->format('Y-m-d\TH:i')) }}" required>
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

<!-- Screenshot Modal -->
<div x-show="screenshotModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm z-50 p-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="bg-white dark:bg-gray-800 p-0 rounded-2xl w-11/12 md:w-3/4 lg:w-1/2 max-w-3xl shadow-2xl border border-gray-100 dark:border-gray-700 overflow-hidden" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" @click.away="screenshotModal = false">
        <!-- Header -->
        <div class="bg-gradient-to-r from-sky-600 to-sky-700 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="bg-white/20 p-2 rounded-lg text-white">
                    <i class="fa-solid fa-image text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Attached Screenshot</h3>
                    <p class="text-xs text-sky-100" x-text="'Ticket: ' + currentTicket"></p>
                </div>
            </div>
            <button type="button" @click="screenshotModal = false" class="text-white hover:bg-white/20 rounded-full p-2 transition-all duration-200">
                <i class="fa-solid fa-times text-lg"></i>
            </button>
        </div>
        
        <!-- Body -->
        <div class="p-6 flex flex-col items-center justify-center max-h-[70vh] overflow-auto bg-gray-50 dark:bg-gray-900">
            <template x-if="currentScreenshot">
                <img :src="currentScreenshot" alt="Attached Screenshot" class="max-h-[60vh] max-w-full rounded-xl shadow-md object-contain bg-white dark:bg-gray-800">
            </template>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-50 dark:bg-gray-800 px-6 py-4 rounded-b-2xl border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <a :href="currentScreenshot" target="_blank" class="inline-flex items-center space-x-2 text-sm text-sky-600 hover:text-sky-800 dark:text-sky-400 font-medium">
                <i class="fa-solid fa-external-link-alt"></i>
                <span>Open Original Image</span>
            </a>
            <button type="button" @click="screenshotModal = false" class="px-6 py-2.5 text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all duration-200 font-medium">
                Close
            </button>
        </div>
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
           
                const $element = $('.pendingValue'+index);
                
                if (diffInMinutes < 3) {
                    $element.removeClass('bg-red-100 text-red-800').addClass('bg-yellow-100 text-yellow-800 animate-pulse');
                } else if (diffInMinutes >= 5) {
                    $element.removeClass('bg-yellow-100 text-yellow-800 animate-pulse').addClass('bg-red-100 text-red-800 animate-pulse');
                } else {
                    $element.removeClass('bg-yellow-100 text-yellow-800 bg-red-100 text-red-800 animate-pulse').addClass('bg-orange-100 text-orange-800');
                }
                
                if (diffInMinutes >= 60) {
                    $element.html(Math.round(diffInMinutes / 60)+' hrs');
                }
                else {
                    $element.html(diffInMinutes+' mins');
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