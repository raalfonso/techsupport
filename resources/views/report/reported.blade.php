<div class="block mt-4 overflow-auto">
    <!-- Table: Visible on medium screens (md) and larger -->
    <div class="hidden md:block">
        <table class="items-center text-left text-sm bg-white w-full border-collapse shadow-lg rounded-lg overflow-hidden">
    <thead>
        <tr class="bg-gradient-to-r from-slate-800 to-slate-900 text-left text-md text-white">
            <th class="px-4 py-4 font-semibold">#</th>
            <th class="px-4 py-4 font-semibold">Ticket Number</th>
            <th class="px-4 py-4 font-semibold">Requestor Name</th>
            <th class="px-4 py-4 font-semibold">Department</th>
            <th class="px-4 py-4 font-semibold">Category</th>
            <th class="px-4 py-4 font-semibold">Location</th>
            <th class="px-4 py-4 font-semibold">Issue</th>
            <th class="px-4 py-4 font-semibold">Status</th>
            <th class="px-4 py-4 font-semibold">Waiting time</th>
            <th class="px-4 py-4 font-semibold">Processing time</th>
            <th class="px-4 py-4 font-semibold">Request Date Time</th>
            <th class="px-4 py-4 font-semibold">Remarks</th>
            <th class="px-4 py-4 font-semibold">Actions</th>
        </tr>
    </thead>
    <tbody>            
        <?php 
                $count = 1;
                $now = now();
                ?>
            @foreach($reports as $report)
    
                <tr class="hover:bg-slate-100 dark:bg-slate-800 dark:text-white text-slate-950 dark:hover:bg-slate-500 transition duration-150">
    <td class="border border-gray-300 px-4 py-3 text-center">{{ $count }}</td>
    <td class="border border-gray-300 px-4 py-3 whitespace-nowrap font-medium">{{ $report->ticket_number }}</td>
    <td class="border border-gray-300 px-4 py-3 font-medium">{{ $report->client->name }}</td>
    <td class="border border-gray-300 px-4 py-3">{{ $report->department->title }}</td>
    <td class="border border-gray-300 px-4 py-3">{{ $report->issues->category->title }}</td>
    <td class="border border-gray-300 px-4 py-3">{{ $report->location }}</td>
    <td class="border border-gray-300 px-4 py-3 whitespace-nowrap">{{ $report->issues->title }}</td>
    <td class="border border-gray-300 px-4 py-3">
        <span class="px-3 py-1 text-nowrap rounded-full text-sm font-medium
            @if($report->status == 'Pending') bg-yellow-100 text-yellow-800
            @elseif($report->status == 'Ongoing') bg-blue-100 text-blue-800
            @elseif($report->status == 'For validation') bg-purple-100 text-purple-800 
            @endif">
            {{ $report->status }}
        </span>
    </td>
    @if ($report->status == 'Pending')
        <td class="border border-gray-300 px-4 py-3 pending{{$count}}" style="display: none;">
            {{$report->request_datetime}}
        </td>
        <td class="border border-gray-300 px-4 py-3">
            <span class="pendingValue{{$count}} text-orange-600 font-medium"></span>
        </td>
    @elseif ($report->status == 'For validation')
        <td class="border border-gray-300 px-4 py-3">
            @php
                $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
            @endphp
            <span class="text-blue-600 font-medium">
                @if ($diffInMinutes >= 60)
                    {{ round($diffInMinutes / 60) }} hrs
                @else
                    {{ round($diffInMinutes) }} mins
                @endif
            </span>
        </td>
    @elseif ($report->status == 'Ongoing')
        <td class="border border-gray-300 px-4 py-3">
            @php
                $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
            @endphp
            <span class="text-blue-600 font-medium">
                @if ($diffInMinutes >= 60)
                    {{ round($diffInMinutes / 60) }} hrs
                @else
                    {{ round($diffInMinutes) }} mins
                @endif
            </span>
        </td>
    @endif
    <td class="border border-gray-300 px-4 py-3 ongoing{{$count}}" style="display: none;">
        @if ($report->validation_date_time != null)
        {{ $report->validation_date_time }}
        @else
        {{$report->response_datetime}}
        @endif
        
    </td>
    <td class="border border-gray-300 px-4 py-3">
        @if ($report->status == 'Ongoing')
            <span class="ongoingValue{{$count}} text-blue-600 font-medium"></span>
        @endif
    </td>
    <td class="border border-gray-300 px-4 py-3 whitespace-nowrap text-sm">{{ date('F d, Y h:i a', strtotime($report->request_datetime)) }}</td>
    <td class="border border-gray-300 px-4 py-3">{{ $report->remarks }}</td>
    @if ($report->status == 'Pending')
        <td class="border border-gray-300 px-4 py-3">
            <button 
                @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full transition duration-150 shadow-sm">
                Response
            </button>
        </td>
    @elseif ($report->status == 'For validation')
        <td class="border border-gray-300 px-4 py-3">
            <button 
                @click="validateModal = true; selectedId = '{{ $report->id }}'" 
                class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 w-full transition duration-150 shadow-sm">
                Validate
            </button>
        </td>
    @else
        <td class="border border-gray-300 px-4 py-3 space-y-2">
            <button 
                @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                class="bg-teal-600 text-white px-4 py-2 rounded-lg hover:bg-teal-700 w-full transition duration-150 shadow-sm">
                Resolved
            </button>
            
            <button 
                @click="escalateModal = true; selectedId = '{{ $report->id }}'" 
                class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 w-full transition duration-150 shadow-sm">
                Escalate
            </button>

            <button 
                @click="endorseModal = true; selectedId = '{{ $report->id }}'" 
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 w-full transition duration-150 shadow-sm">
                Endorse
            </button>
        </td>
    @endif
</tr>                @php
                    $count++;
                @endphp
            @endforeach
        </tbody>
    </table>
    </div>

    <!-- Card: Visible only on small screens (mobile) -->
    <div class="block md:hidden">
        <?php 
        $count1 = 1;
        $now = now();
        ?>
         @foreach($reports as $report)
        <div class="border p-4 rounded-lg shadow-md mb-4 dark:text-white bg-white dark:bg-slate-800 transition-all hover:shadow-lg">
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
                    <td class="border border-gray-300 px-4 py-3">
                        <button 
                            @click="validateModal = true; selectedId = '{{ $report->id }}'" 
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 w-full transition duration-150 shadow-sm">
                            Validate
                        </button>
                    </td>
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


<!-- Modal -->
    <div x-show="responseModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white p-6 rounded-lg  w-11/12 md:w-screen lg:w-1/2">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Response</h3>
                <button @click="responseModal = false" class="text-gray-500 hover:text-gray-800">X</button>
            </div>
            <form :action="'/report/edit/' + selectedId" method="GET">
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
                    <div class="flex items-center">
                        <input checked id="checked-checkbox" name="iam_check" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 mt-4 ml-1 iam-checkbox">
                        <label for="checked-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 mt-4">I will response</label>
                    </div>

                    <!-- Date Response -->
                    <div class="mt-2">
                        <label for="request_datetime" class="block text-sm font-medium text-gray-700">Response Date Time</label>
                        <input type="datetime-local" class="w-full p-2 border rounded-lg resize-y mt-2" name="response_datetime" value="{{ old('response_datetime') }}">

                            @error('response_datetime')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                    </div>
                    
                    
                    <label for="notes" class="block mb-2 text-sm mt-4 font-medium text-gray-900 dark:text-white">Notes</label>
                    <textarea id="notes" rows="4" name="notes" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>

                </div>

                <button type="submit" class="bg-blue-500 text-white hover:bg-blue-600 px-4 py-2 rounded">
                    Response
                </button>
            </form>
        </div>
    </div>
<!-- Modal -->
<!-- Validation Modal -->
<div x-show="validateModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
    <div class="bg-white p-6 rounded-lg w-11/12 md:w-screen lg:w-1/2">
        <div class="flex justify-between items-center">
            <h3 class="text-xl font-semibold">Validate Resolution</h3>
            <button @click="validateModal = false" class="text-gray-500 hover:text-gray-800">X</button>
        </div>
        <form action="{{ route('report.validate') }}" method="POST">
            @csrf
            <div class="mb-4 mt-4">
                <div class="hidden">
                 
                    <input type="text" name="id-issues" id="id-issues" :value="selectedId">
                </div>
                <div class="mt-2">
                    <label for="validation_datetime" class="block text-sm font-medium text-gray-700">Validation Date Time</label>
                    <input type="datetime-local" class="w-full p-2 border rounded-lg resize-y mt-2" name="validation_datetime" value="{{ old('validation_datetime') }}">
                    @error('validation_datetime')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700">Confirmation Status</label>
                    <div class="mt-2 space-y-2">
                        <div class="flex items-center">
                            <input type="radio" id="resolved" name="validation_status" value="confirm" class="h-4 w-4 text-blue-600 border-gray-300" onclick="document.getElementById('changeIssueDiv').classList.add('hidden')">  
                            <label for="resolved" class="ml-2 text-sm text-gray-700">Confirm</label>
                        </div>
                        <div class="flex items-center">
                            <input type="radio" id="unresolved" name="validation_status" value="unresolved" class="h-4 w-4 text-blue-600 border-gray-300" onclick="document.getElementById('changeIssueDiv').classList.remove('hidden')">                           
                            <label for="unresolved" class="ml-2 text-sm text-gray-700">Change Issue</label>
                        </div>
                    </div>
                </div>
                <div class="mt-4 hidden" id="changeIssueDiv">
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

                
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" @click="validateModal = false" class="bg-gray-500 text-white hover:bg-gray-600 px-4 py-2 rounded">
                    Cancel
                </button>
                <button type="submit" class="bg-purple-600 text-white hover:bg-purple-700 px-4 py-2 rounded">
                    Submit Validation
                </button>
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