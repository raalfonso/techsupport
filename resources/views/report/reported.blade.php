<div class="block mt-4 overflow-scroll">
    <!-- Table: Visible on medium screens (md) and larger -->
    <div class="hidden md:block">
        <table class="items-center text-left text-xs bg-transparent w-full border-collapse ">
            <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="border border-gray-300 px-2 py-2">#</th>
                    <th class="border border-gray-300 px-2 py-2">Ticket Number</th>
                    <th class="border border-gray-300 px-2 py-2">Requestor Name</th>
                    <th class="border border-gray-300 px-2 py-2">Department</th>
                    <th class="border border-gray-300 px-2 py-2">Category</th>
                    <th class="border border-gray-300 px-2 py-2">Location</th>
                    <th class="border border-gray-300 px-2 py-2">Issue</th>
                    <th class="border border-gray-300 px-2 py-2">Status</th>
                    <th class="border border-gray-300 px-2 py-2">Waiting time</th>
                    <th class="border border-gray-300 px-2 py-2">Processing time</th>
                    <th class="border border-gray-300 px-2 py-2">Request Date Time</th>
                    <th class="border border-gray-300 px-2 py-2">Remarks</th>
                    <th class="border border-gray-300 px-2 py-2">Actions</th>
                </tr>
            </thead>
        <tbody>
            <?php 
                $count = 1;
                $now = now();
                ?>
            @foreach($reports as $report)
    
                <tr class="hover:bg-gray-100">
                    
                    <td class="border border-gray-300 px-2 py-2">{{ $count }}</td>
                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">{{ $report->ticket_number }}</td>
                    <td class="border border-gray-300 px-2 py-2">{{ $report->client->name }}</td>
                    <td class="border border-gray-300 px-2 py-2 ">{{ $report->department->title }}</td>
                    <td class="border border-gray-300 px-2 py-2">{{ $report->issues->category->title }}</td>
                    <td class="border border-gray-300 px-2 py-2">{{ $report->location }}</td>
                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">{{ $report->issues->title }}</td>
                    <td class="border border-gray-300 px-2 py-2">{{ $report->status }}</td>
                    @if ($report->status == 'Pending')
                        <td class="border border-gray-300 px-4 py-2 pending{{$count}}" style="display: none;">
                            {{$report->request_datetime}}
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <span id = "pending{{$count}}"></span>
                        </td>
                    @elseif ($report->status == 'Ongoing')
                        <td class="border border-gray-300 px-2 py-2">
                            @php
                                $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                            @endphp
    
                            @if ($diffInMinutes >= 60)
                                {{ round($diffInMinutes / 60) }} hrs
                            @else
                                {{ round($diffInMinutes) }} mins
                            @endif
    
                        </td>
                    
                        
                    @endif
                        <td class="border border-gray-300 px-2 py-2 ongoing{{$count}}" style="display: none;">
                            {{$report->response_datetime}}
    
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($report->status == 'Ongoing')
                            <span id = "ongoing{{$count}}"></span>
                           
                            @endif
                           
                        </td>
                    
                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">{{ date('F d, Y h:i a', strtotime($report->request_datetime)) }}</td>
                    <td class="border border-gray-300 px-2 py-2">{{ $report->remarks }}</td>
                    @if ($report->status == 'Pending')
                        <td class="border border-gray-300 px-2 py-2">
                            <button 
                            @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                            class="bg-blue-500 text-white px-2 py-2 rounded hover:bg-blue-600">
                            Response
                            </button>
                        </td>
                    @else
                        <td class="border border-gray-300 px-2 py-2">
                            <button 
                            @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                            class="btn mb-2">
                            Resolved
                            </button>
                            
                            <button 
                            @click="escalateModal = true; selectedId = '{{ $report->id }}'" 
                            class="bg-yellow-500 text-white px-2 py-2 rounded hover:bg-yellow-600">
                            Escalate
                            </button>
                        </td>
                        
                    @endif
                    
                </tr>
                @php
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
        <div class="border p-4 rounded-lg shadow mb-2">
            <h2 class="font-bold">{{ $report->client->name }} - {{ $report->department->title }}</h2>
            <p>Ticket No: {{ $report->ticket_number }}</p>
            <p>Issues: {{ $report->issues->title }}</p>
            @if ($report->status == 'Pending')
                        <div class="border border-gray-300 px-4 py-2 pending{{$count1}}" style="display: none;">
                            {{$report->request_datetime}}
                        </div>
                        <p>
                            Pending Time :<span id = "pending{{$count1}}"></span>
                        </p>
            @else
                            @php
                                $diffInMinutes = \Carbon\Carbon::parse($report->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($report->response_datetime));
                            @endphp
    
                            @if ($diffInMinutes >= 60)
                               Ongoing Time : {{ round($diffInMinutes / 60) }} hrs
                            @else
                                 Ongoing Time :  {{ round($diffInMinutes) }} mins
                            @endif
                            <br>
            @endif
            <br>
            @if ($report->status == 'Pending')
                       
                            <button 
                            @click="responseModal = true; selectedId = '{{ $report->id }}'" 
                            class="btn mb-2">
                            Response
                            </button>
                   
                    @else
                       
                            <button 
                            @click="resolveModal = true; selectedId = '{{ $report->id }}'" 
                            class="btn mb-2">
                            Resolved
                            </button>
                            
                            <button 
                            @click="escalateModal = true; selectedId = '{{ $report->id }}'" 
                            class="btn-escalate mb-2">
                            Escalate
                            </button>
                  
                        
                    @endif
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

<script>
         $('.iam-checkbox').click(function() {
            console.log($(this).is(":checked"));
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
                    
                    $('#pending'+index).html(Math.round(diffInMinutes / 60)+' hrs');
                }
                else {
                    $('#pending'+index).html(diffInMinutes+' mins');
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
                console.log(requestTime);
                    if (diffInMinutes >= 60) {
                        
                        $('#ongoing'+index).html(Math.round(diffInMinutes / 60)+' hrs');
                    }
                    else {
                        $('#ongoing'+index).html(diffInMinutes+' mins');
                    }
                }
            

            
        }
        
</script>