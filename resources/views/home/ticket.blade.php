<x-layout>
    <div class="container mx-auto w-auto  p-4" x-data="{ showModal: false,}">
        <input type="text" style="display: none;" id="ticket-number" value="{{$ticketNumber}}">
      
        <div class="content-status">

        </div>

        <!-- Modal -->
        @foreach ($reports as $report )
        <input type="text" style="display: none;" class="status-text" value="{{$report->feedback}}">
            <div x-show="showModal"  class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center "x-cloak>
                <div class="bg-white w-full max-w-lg p-5 rounded-lg shadow-lg overflow-auto max-h-full" style="">
                    <div class="flex justify-between items-center">
                        <h2 class="text-lg font-bold">ICTD Customer Feedback</h2>
                        <button @click="showModal = true" class="text-gray-600 hover:text-gray-800 showBtn">&times;</button>
                    </div>

                    <div class="flex text-xs justify-between items-center mb-4">
                        We would love to hear your thoughts or feedback on how we can improve your experience!
                    </div>
                        <form action="{{ route('feedback.store') }}" method="post">
                            @csrf
                        
                            <div class="mb-4 mt-4" style="display: none;">
                                <label for="report_id">Report ID <span class="text-green-600 text-xs">(Optional)</span></label>
                                <input type="text" name="report_id" class="input" value="{{ $report->id}}">
                            </div>

                            <div class="mb-4">
                                <p>1. How quickly did the support attend to you? <span class="text-red-600 text-xs">(Required)</span></p>
                                <p class="text-sm text-gray-600 mt-2 ml-4">Please rate, with 1 (Slow) being the lowest and 5 (Fast) as the highest.</p>
                                
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-1" type="radio" value="5" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">5. Within a few minutes</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-2" type="radio" value="4" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4. within a few hours</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-3" type="radio" value="3" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3. Within the day</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-4" type="radio" value="2" name="answer1" class=" rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2. The next day</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-5" type="radio" value="1" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1. After a few days</label>
                                    </div>
                            </div>
                            
                            {{-- if resolve --}}
                            <div class="mb-4">
                                <p>2. Was your issue or concern resolved? <span class="text-red-600 text-xs">(Required)</span></p>
                                    <div class="flex">
                                    
                                        <div class="flex items-center p-2 ml-10">
                                            <input id="default-radio-6" type="radio" value="1" name="answer2" class="rb-q2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-radio-6" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                                        </div>
                                        <div class="flex items-center p-2 ml-10">
                                            <input id="default-radio-7" type="radio" value="0" name="answer2" class="rb-q2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="default-radio-7" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                                        </div>
                                    </div>    
                                    
                            </div>
                            {{-- rate support service provided --}}
                            <div class="mb-4">
                                <p>3. How would you rate the support service provided? <span class="text-red-600 text-xs">(Required)</span></p>
                                <p class="text-sm text-gray-600 mt-2 ml-4">Please rate the service, with 1 (Poor) being the lowest and 5 (Excellent) as the highest. </p>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-8" type="radio" value="5" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-8" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">5. Excellent</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input  id="default-radio-9" type="radio" value="4" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-9" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4. Very Satisfactory</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-10" type="radio" value="3" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-10" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3. Satisfactory</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-11" type="radio" value="2" name="answer3" class=" rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-11" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2. Unsatisfactory</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-12" type="radio" value="1" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="default-radio-12" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1. Poor</label>
                                    </div>
                            </div>

                            <div class="mb-4">
                                <p>4. Why did you rate as you did? <span class="text-green-600 text-xs">(Optional)</span></p>
                                <p class="text-sm text-gray-600 mt-2 ml-4">Provide a reason for your rating. </p>

                                <div class="p-5" style="">
                                {{-- <label for="report_id">Report ID <span class="text-green-600 text-xs">(Optional)</span></label> --}}
                                <input type="text" name="reason" class="input" value="">
                                </div>
                            </div>

                            <div class="mb-4">
                                <p>5. How can we improve? <span class="text-green-600 text-xs">(Optional)</span></p>
                                <p class="text-sm text-gray-600 mt-2 ml-4">Suggest what we can do to improve. </p>

                                <div class="p-5" style="">
                                {{-- <label for="report_id">Report ID <span class="text-green-600 text-xs">(Optional)</span></label> --}}
                                <input type="text" name="suggestion" class="input" value="">
                                </div>
                            </div>


                            <button class="btn">Submit</button>
                        </form>

                    </div>
                </div>

            @endforeach
        <!-- modal -->
    </div>
    <script>
        // Set the page to refresh every 60 seconds (60000 milliseconds)

        $('document').ready(()=>{
            const ticket_number = $('#ticket-number').val();
            setInterval(function() {
                console.log(ticket_number);
                checkStatus(ticket_number);
                feedback(ticket_number);
                // if(feedback == "No"){
                //     $('.showBtn').click();
                // }
             }, 1000);
        

       

             const checkStatus = (ticket_number) => {
                $.ajax({
                    url: `/viewstatus/${ticket_number}`, // Include the ticket_number in the URL
                    method: 'GET',
                    success: function(response) {
                        $('.content-status').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            };

            const feedback = (ticket_number) => {
                $.ajax({
                    url: `/feedback/${ticket_number}`, // Include the ticket_number in the URL
                    method: 'GET',
                    success: function(response) {
                       if(response[0]['feedback'] == 'No')
                       {
                        $('.showBtn').click();
                       }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            }


    });

        $('.rb-q1').click(function() {
            const rd1 = $(this).val(); // Use $(this) to reference the clicked element
            console.log(rd1);          // Log the value of the radio button
        });

        $('.rb-q2').click(function() {
            const rd2 = $(this).val(); // Use $(this) to reference the clicked element
            console.log(rd2);          // Log the value of the radio button
        });
    </script>
 </x-layout>    
 
 