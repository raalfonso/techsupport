<x-layout>
    <style>
        /* @media (max-width: 767px) {
           .welcome-card {
            max-width: 450px;
           }
        } */
    </style>
    <div class="container-fluid bg-gray-300 mx-auto px-4 font-mono sm:text-sm" x-data="{ showModal: {{ $feedback == 'True' ? 'true' : 'false' }} }"style="background: linear-gradient(to bottom left, #00cb6a, #4dc9fe);
           background-repeat: no-repeat;
           background-attachment: fixed;
           background-size: cover;
           min-height: 100vh; /* Full height */
           width: 100vw; /* Full width */">
        <div class="flex p-2 flex-wrap">
            <div class="w-full mt-10">
                <div class="grid lg:grid-cols-2 sm:grid-cols-1 w-full p-5 gap-4 bg-white border border-gray-200 rounded-lg shadow min-w-[250px]">
                    <div>
                        <p class="text-xl mb-4">Mabuting Araw! <b>{{ $client->name }}</b></p>
                        <p class="text-gray-500 text-justify">
                            We're excited to introduce our enhanced Support System, crafted to meet your needs. Enjoy effortless access to assistance, resources, and solutions—making support more accessible and efficient for you.
                        </p>
                    </div>
                    <div class="p-0 text-center overflow-x-auto">
                        <table class="table-auto border text-sm w-full min-w-[600px]">
                            <thead>
                                <th colspan="4" class="border border-gray-300 px-2 py-2 text-lg">List of Reported Issues</th>
                                <tr>
                                    <th class="border border-gray-300 px-4 py-2">#</th>
                                    <th class="border border-gray-300 px-4 py-2">Issues</th>
                                    <th class="border border-gray-300 px-4 py-2">Status</th>
                                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $count = 1; ?>
                                @if (count($reports) == 0)
                                <td colspan="4" class="border border-gray-300 px-2 py-2 text-center">No previous requests were made</td>
                                @endif
                                @foreach ($reports as $report)
                                <tr>
                                    <td class="border border-gray-300 px-2 py-2">{{ $count++ }}</td>
                                    <td class="border border-gray-300 px-2 py-2 lg:whitespace-nowrap">{{ $report->issues->title }}</td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">
                                        @if ($report->status == "Done")
                                        <span class="w-3 h-3 bg-green-500 rounded-full inline-block"></span>
                                        <span class="text-sm">Closed</span>
                                        @else
                                        <span class="text-sm">{{ $report->status }}</span>
                                        @endif
                                    </td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">
                                        @if ($report->status != "Canceled")
                                        <a href="{{ route('home.view',['id'=> $report->ticket_number])}}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded inline-block">View</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-5 gap-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach([
                        ['id' => 1, 'image' => 'boardroom.png', 'title' => 'Video conferencing / Meeting Support', 'desc' => 'Technical and configurational support from NIS Team.'],
                        ['id' => 2, 'image' => 'acumatica.png', 'title' => 'Acumatica ERP and HRIS', 'desc' => 'Support for Acumatica or HRIS-related issues.'],
                        ['id' => 3, 'image' => 'security.jpg', 'title' => 'Cyber Security', 'desc' => 'Support for malware, phishing, and other cybersecurity issues.'],
                        ['id' => 4, 'image' => 'hardware-failures.png', 'title' => 'Hardware Issues', 'desc' => 'Support for system malfunctions, connectivity issues, and printer errors.'],
                        ['id' => 5, 'image' => 'network.png', 'title' => 'Network Problem', 'desc' => 'Assistance with slow connectivity, VPN failures, and disconnections.'],
                        ['id' => 6, 'image' => 'aodocs_1.png', 'title' => 'AODocs Issues', 'desc' => 'Support for document access, workflow malfunctions, and permissions errors.'],
                        ['id' => 7, 'image' => 'laptop-repair.jpeg', 'title' => 'Software Issues', 'desc' => 'Support for software crashes, installation errors, and performance issues.'],
                        ['id' => 8, 'image' => 'google_1.png', 'title' => 'G Suite / Google Workspace Issues', 'desc' => 'Help with Gmail, Drive, Docs, Sheets, Meet, etc.'],
                        ['id' => 9, 'image' => '10871996.png', 'title' => "Other's Issues", 'desc' => 'Assistance for technical concerns not covered in other categories.']
                    ] as $issue)
                    <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow min-w-[250px] transition-transform transform hover:scale-105">
                        <a href="{{ route('home.add',['id'=> $issue['id'], 'client_id' => $client->id])}}" class="text-slate-950">
                            <img src="{{ asset('images/' . $issue['image']) }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                            <div class="mt-5 text-center">
                                <p class="mb-2 text-lg font-bold tracking-tight text-gray-900">{{ $issue['title'] }}</p>
                                <p class="text-xs text-gray-700">{{ $issue['desc'] }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>




        <!-- Modal -->
        <div x-show="showModal"  class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center "x-cloak>
            <div class="bg-white w-full max-w-lg p-5 rounded-lg shadow-lg overflow-auto max-h-full" style="">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold">ICTD Customer Feedback</h2>
                    <button @click="showModal = true" class="text-black hover:text-gray-800 showBtn">&times;</button>
                </div>
                <div class="flex text-xs justify-between items-center mb-4">
                    We would love to hear your thoughts or feedback on how we can improve your experience!
                
                </div>
                    <form action="{{ route('feedback.store') }}" method="post">
                        @csrf
                    
                        <div class="mb-4 mt-4" style="display: none;">
                            <label for="report_id">Report ID <span class="text-green-600 text-xs">(Optional)</span></label>
                            <input type="text" name="report_id" class="input" value="{{ $id}}">
                        </div>

                        <div class="mb-4">
                            <p>1. How quickly did the support attend to you? <span class="text-red-600 text-xs">(Required)</span></p>
                            <p class="text-sm text-gray-600 mt-2 ml-4">Please rate, with 1 (Slow) being the lowest and 5 (Fast) as the highest.</p>
                            
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-1" type="radio" value="5" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-1" class="ms-2 text-sm font-medium text-gray-900">5. Within a few minutes</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-2" type="radio" value="4" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-2" class="ms-2 text-sm font-medium text-gray-900 ">4. within a few hours</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-3" type="radio" value="3" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-3" class="ms-2 text-sm font-medium text-gray-900 ">3. Within the day</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-4" type="radio" value="2" name="answer1" class=" rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-4" class="ms-2 text-sm font-medium text-gray-900 ">2. The next day</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-5" type="radio" value="1" name="answer1" class="rb-q1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-5" class="ms-2 text-sm font-medium text-gray-900 ">1. After a few days</label>
                                </div>
                        </div>
                        
                        {{-- if resolve --}}
                        <div class="mb-4 " style="display: none;">
                            <p>2. Was your issue or concern resolved? <span class="text-red-600 text-xs">(Required)</span></p>
                                <div class="flex">
                                
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-6" type="radio" value="1" name="answer2" class="rb-q2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" checked>
                                        <label for="default-radio-6" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yes</label>
                                    </div>
                                    <div class="flex items-center p-2 ml-10">
                                        <input id="default-radio-7" type="radio" value="0" name="answer2" class="rb-q2 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" >
                                        <label for="default-radio-7" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">No</label>
                                    </div>
                                </div>    
                                
                        </div>
                        {{-- rate support service provided --}}
                        <div class="mb-4">
                            <p>2. How would you rate the support service provided? <span class="text-red-600 text-xs">(Required)</span></p>
                            <p class="text-sm text-gray-600 mt-2 ml-4">Please rate the service, with 1 (Poor) being the lowest and 5 (Excellent) as the highest. </p>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-8" type="radio" value="5" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-8" class="ms-2 text-sm font-medium text-gray-900 ">5. Excellent</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input  id="default-radio-9" type="radio" value="4" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-9" class="ms-2 text-sm font-medium text-gray-900">4. Very Satisfactory</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-10" type="radio" value="3" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-10" class="ms-2 text-sm font-medium text-gray-900">3. Satisfactory</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-11" type="radio" value="2" name="answer3" class=" rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-11" class="ms-2 text-sm font-medium text-gray-900">2. Unsatisfactory</label>
                                </div>
                                <div class="flex items-center p-2 ml-10">
                                    <input id="default-radio-12" type="radio" value="1" name="answer3" class="rb-q3 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="default-radio-12" class="ms-2 text-sm font-medium text-gray-900">1. Poor</label>
                                </div>
                        </div>

                        <div class="mb-4">
                            <p>3. Why did you rate as you did? <span class="text-green-600 text-xs">(Optional)</span></p>
                            <p class="text-sm text-gray-600 mt-2 ml-4">Provide a reason for your rating. </p>

                            <div class="p-5" style="">
                            {{-- <label for="report_id">Report ID <span class="text-green-600 text-xs">(Optional)</span></label> --}}
                            <input type="text" name="reason" class="input" value="">
                            </div>
                        </div>

                        <div class="mb-4">
                            <p>4. How can we improve? <span class="text-green-600 text-xs">(Optional)</span></p>
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
    </div>
</dov>
    <script>
        var maxHeight = 0;
        var maxWidth = 0;
        var $highestDiv;

    //$('.card issue-card').each(function() {
      //  var currentHeight = $(this).height();
        //var currentWidth = $(this).width();
        //if (currentHeight > maxHeight) {
            maxHeight = currentHeight;
            $highestDiv = $(this);
        //}
        //if (currentWidth > maxWidth) {
            maxWidth = currentHeight;
            $highestDiv = $(this);
        //}
    //});

    // Set the height of all '.card' elements to the maximum height
    //$('.card-body').height(maxHeight);
    //$('.card issue-card').animate({
        // height: 300
    //}, maxHeight);
    //$('.card issue-card').animate({
        // width: 300
    //}, maxWidth);



    



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
