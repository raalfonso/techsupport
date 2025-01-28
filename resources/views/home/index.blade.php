<x-layout>
    <style>
        /* @media (max-width: 767px) {
           .welcome-card {
            max-width: 450px;
           }
        } */
    </style>
    <div class="container mx-auto px-4 font-mono sm:text-sm" x-data="{ showModal: {{ $feedback == 'True' ? 'true' : 'false' }} }">
        <div class="flex">
            <div class="w-full min-w-fit sm:max-w-8">
                <div class="card welcome-card">
                    <div class="grid lg:grid-cols-2 p-2 gap-4 sm:overflow-auto lg:overflow-hidden">
                        <div>
                            <p class="text-xl mb-4">Mabuting Araw!   <b>{{$client->name}}</b> </p>
                            <p class="text-gray-500 text-justify">We're excited to introduce our enhanced Support System, crafted to meet your needs. Enjoy effortless access to assistance, resources, and solutions—making support more accessible and efficient for you.</p>
                        </div>
                        <div class="p-0 text-center">
                            <table class="table-auto border text-sm w-full">
                                <thead>
                                    <th colspan="4" class="border border-gray-30 px-2 py-2 text-lg">List of Repored Issues</th>
                                    <tr class="">
                                        <th class="border border-gray-30 px-4 py-2">#</th>
                                        <th class="border border-gray-30 px-4 py-2">Issues</th>
                                        <th class="border border-gray-30 px-4 py-2">Status</th>
                                        <th class="border border-gray-30 px-4 py-2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @if (count($reports) == 0)
                                    <td colspan="4" class="border border-gray-300 px-2 py-2">No previous requests were made</td>
                                    @endif
                                    @foreach ($reports as $report)
                                    <tr>
                                    <td class="border border-gray-300 px-2 py-2">{{ $count++; }}</td>
                                    <td class="border border-gray-300 px-2 py-2 lg:whitespace-nowrap">{{ $report->issues->title }}</td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap"><span class="text-sm">{{ $report->status }}</span></td>
                                    <td class="border border-gray-300 px-2 py-2 whitespace-nowrap">@if ($report->status == "Canceled")
                                        @else
                                        
                                        <a href="{{ route('home.view',['id'=> $report->ticket_number])}}" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded inline-block">View</a></td>
                                    @endif
                                    </tr>
         
                                    @endforeach
                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="mt-5 gap-2 grid lg:grid-cols-3 sm:grid-cols-2">
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'1','client_id' => $client->id ])}}" class="text-blue-500">Video conferencing / Meeting Support
                        </a></p>
                        <img src="{{ asset('images/boardroom.png') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'2','client_id' => $client->id ])}}" class="text-blue-500">Acumatica ERP and HRIS</a></p><br>
                        <img src="{{ asset('images/acumatica.png') }}" alt="Example Image" class="w-full h-60  drop-shadow">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'3','client_id' => $client->id ])}}" class="text-blue-500">Cyber Security
                        </a></p> <br>
                        <img src="{{ asset('images/security.jpg') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'4','client_id' => $client->id ])}}" class="text-blue-500">Hardware Issues
                        </a></p> <br>
                        <img src="{{ asset('images/hardware-failures.png') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'5','client_id' => $client->id ])}}" class="text-blue-500">Network Issues
                        </a></p> <br>
                        <img src="{{ asset('images/network.png') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'6','client_id' => $client->id ])}}" class="text-blue-500">AODocs Issues
                        </a></p> <br>
                        <img src="{{ asset('images/aodocs.png') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'7','client_id' => $client->id ])}}" class="text-blue-500">Software Issues
                        </a></p> <br>
                        <img src="{{ asset('images/laptop-repair.jpeg') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'8','client_id' => $client->id ])}}" class="text-blue-500">G Suite / Google Workspace Issues
                        </a></p> <br>
                        <img src="{{ asset('images/gerror.png') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                    <div class="card-body max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 min-w-52 ">
                        <p class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white"><a href="{{ route('home.add',['id'=>'9','client_id' => $client->id ])}}" class="text-blue-500">Other's Issues
                            <br><br>
                            <img src="{{ asset('images/10871996.png') }}" alt="Example Image" class="w-full h-60 shadow-lg rounded-md">
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-transparent to-transparent blur-md"></div>
                    </div>
                 
                </div>
            </div>
        </div>


        <!-- Modal -->
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
                            <input type="text" name="report_id" class="input" value="{{ $id}}">
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
    </div>
    
    <script>
        var maxHeight = 0;
        var maxWidth = 0;
        var $highestDiv;

    $('.card-body').each(function() {
        var currentHeight = $(this).height();
        var currentWidth = $(this).width();
        if (currentHeight > maxHeight) {
            maxHeight = currentHeight;
            $highestDiv = $(this);
        }
        if (currentWidth > maxWidth) {
            maxWidth = currentHeight;
            $highestDiv = $(this);
        }
    });

    // Set the height of all '.card' elements to the maximum height
    //$('.card-body').height(maxHeight);
    $('.card-body').animate({
        // height: 300
    }, maxHeight);
    $('.card-body').animate({
        // width: 300
    }, maxWidth);







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
