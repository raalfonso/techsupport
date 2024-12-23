<x-layout>
    <div class="container mx-auto w-auto  p-4">
        @foreach ($reports as $report)
        

        <div class="bg-white p-6 rounded-lg shadow-md max-w-md mx-auto">
            <div class="flex justify-between items-center py-2">
                <span class="text-gray-600">Ticket Number: </span>
                <span class="font-medium text-gray-800">{{$report->ticket_number}}</span>
            </div>
           
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Details</h2>
            <div class="border-t border-gray-200 pt-4">
                <!-- Card Name -->
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Reported/Requested by</span>
                    <span class="font-medium text-gray-800">{{$report->requestor_name}}</span>
                </div>
                <!-- Card Name -->
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Issue/Request</span>
                    <span class="font-medium text-gray-800">{{$report->issues->title}}</span>
                </div>
                <!-- Status -->
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Status</span>

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
                @if ($report->status !== 'Pending')
                    
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-600">Assigend Technical</span>
                    <span class="font-medium text-gray-800">{{$report->user->name}}</span>
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
           
        </div>
       
        
        
        @endforeach
           
           
                
    </div>
    <script>
        // Set the page to refresh every 60 seconds (60000 milliseconds)
        setInterval(function() {
            location.reload(); // This will reload the page
        }, 60000);
    </script>
 </x-layout>    
 
 