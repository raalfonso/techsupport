@foreach ($reports as $report)

        <div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto">
            @if ($report->status == 'Pending')
            <div class="flex items-center space-x-2 float-end">
                <button class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 btn-cancel" data-cancel-url="{{ route('home.cancel', ['id' => $report->id]) }}">
                    Cancel
                </button>
            </div>
            <br>
            @endif
            <div class="flex justify-between items-center py-2 mt-8">
                <span class="text-gray-600">Ticket Number: </span>
                <span class="font-medium text-gray-800">{{$report->ticket_number}}</span>
            </div>
           
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Details</h2>
            <div class="border-t border-gray-200 pt-4">
                <!-- Card Name -->
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Requested by</span>
                    <span class="font-medium text-gray-800">{{$report->client->name}}</span>
                </div>
                <!-- Card Name -->
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Issue/Request</span>
                    <span class="font-medium text-gray-800">{{$report->issues->title}}</span>
                </div>
                <!-- Status -->
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Status</span>
                        <input type="text" style="display: none;" class="status-text" value="{{$report->status}}">
                        @if ($report->status == 'Pending')
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 bg-orange-500 rounded-full"></span>
                                <span class="font-medium text-gray-800">Pending</span>
                            </div>
                        
                        @elseif ($report->status == 'Ongoing')
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 bg-amber-200 rounded-full"></span>
                            <span class="font-medium text-gray-800">Ongoing</span>
                        </div> 
                    
                        @else
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                            <span class="font-medium text-gray-800">Done</span>
                        </div> 
                        @endif
                        
                    </div>
                
                <!-- Location -->
                @if ($report->location)
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Location</span>
                        <span class="font-medium text-gray-800">{{$report->location}}</span>
                    </div>
                @endif
                @if ($report->status !== 'Pending')
                    
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Acknowledged by:</span>
                    <span class="font-medium text-gray-800">{{$report->response->name}}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Note:</span>
                    <span class="font-medium text-gray-800">{{$report->notes}}</span>
                </div>
                @endif
            </div>
            <div class="flex items-center justify-center">
                <div class="bg-white p-6">
                   
                    <div class="flex justify-center">
                        @if ($report->status == 'Pending')
                        <img src="{{ asset('images/Hourglass.gif') }}" alt="Centered GIF" class="">
                        @elseif ($report->status == 'Ongoing')
                        <img src="{{ asset('images/ongoing.gif') }}" alt="Centered GIF" class="w-40">
                        @else
                        <img src="{{ asset('images/done.gif') }}" alt="Centered GIF" class="w-65">
                        @endif
                    </div>
                </div>
            </div>

            
            <div class="text-center mt-10">
                <form action="{{ route('client.login.submit')}}" method="post">
                    @csrf
                    <div class="mb-4" style="display: none;">
                      
                        <input type="text" id="auto-suggest" name="email_address" class="input" autocomplete="off" value="{{$report->client->email_address}}">
                        
                    </div>
                    <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300" id="return">
                        New request / View all request click me
                      </button>
                </form>
                
                
            </div>
        </div>

        
 @endforeach


 <script>

$('.btn-cancel').click(function () {
    const cancelUrl = $(this).data('cancel-url'); // Get the dynamic URL from the data attribute
    console.log(cancelUrl);
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showDenyButton: true,
        confirmButtonText: "Yes",
        showLoaderOnConfirm: true,
        denyButtonText: `Don't Cancel`,
        preConfirm: async (remarks) => {
           $.ajax({
            url:cancelUrl,
            method: 'get',
            success:function(response){
              
                Swal.fire("Canceled!", "The item has been canceled.", "success");
                $('#return').click();
            },
            error:function(response){
                Swal.fire("Not Canceled", "The action was not performed.", "info");
            },
           });
        },
       
    });
});



 </script>