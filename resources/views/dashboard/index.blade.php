<x-layout>
    <div class="container-fluid mx-auto">
        {{-- <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
        >
          Reports
        </h2> --}}

        <!-- Scorecards -->
        <!-- Responsive cards -->
       
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Received</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_total}}</p>
                </div>
            </div>
        
            <!-- Card 2 -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>    
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Resolved</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$report_resolved}}</p>
                </div>
            </div>
        
            <!-- Card 3 -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>          
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Pending</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_pending}}</p>
                </div>
            </div>
        
            <!-- Card 4 -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                    </svg>                      
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Ongoing</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_ongoing}}</p>
                </div>
            </div>
        
            <!-- Card 5 -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.806 9-8.25s-4.03-8.25-9-8.25-9 3.806-9 8.25c0 1.88.772 3.616 2.049 4.963a8.814 8.814 0 01-2.212 3.8c-.195.192-.205.498-.024.707a.513.513 0 00.707.024 8.725 8.725 0 003.693-2.275A9.906 9.906 0 0012 20.25z" />
                    </svg>                                       
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Customer Satisfaction</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{round($satisfaction)}}%</p>
                </div>
            </div>
        </div>
        

        <br>
        
   


        {{-- end of Scorecards --}}


        <!-- Bar Chart -->
        <div class="flex">
            <div class="w-2/3 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <!-- Content for the first column (8/12 width) -->
              <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                Total No. of request
                </h4>
                <canvas id="weeklyChart"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    
                     
                    </div>
            </div>
        
            <div class="w-1/3 p-4 ml-2 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <!-- Content for the second column (4/12 width) -->
             
              <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                List of recurring issues per week
                </h4>
                <div class="text-sm mt-5 p-5">
                    <ul class="space-y-4">
                        <!-- List Item 1 -->
                       @foreach ($results as $result)
                        <li class="border-b pb-4">
                            <div class="flex justify-between">
                                <div>
                                    <h3 class="text-gray-700 font-bold">{{$result->title}}</h3>
                                    {{-- <p class="text-gray-500">{{$result->count}}</p> --}}
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="relative w-full h-3 bg-gray-200 rounded-full">
                                    @if ($result->count > 2)
                                    <div class="absolute top-0 left-0 h-3 bg-red-500 rounded-full" style="width: 100%;"></div>
                                   
                                    @elseif ($result->count == 2)
                                    <div class="absolute top-0 left-0 h-3 bg-orange-500 rounded-full" style="width: 66.6%;"></div>
                                    @elseif ($result->count == 1)
                                    <div class="absolute top-0 left-0 h-3 bg-green-500 rounded-full" style="width: 33.3%;"></div>

                                    @endif
                                </div>
                                
                            </div>
                        </li>
                       @endforeach
                        

                
                    </ul>
                </div>
                
            </div>
          </div>    
        
          <div class="flex mt-5">
            <div class="w-full p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                    Technical Staff

                    <table class="table-auto w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200 text-left">
                                <th class="border border-gray-300 px-4 py-2">Name</th>
                                <th class="border border-gray-300 px-4 py-2">Total Resolved</th>
                        
                            </tr>
                        </thead>
                    
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2">{{$user->user_name}}</td>
                                    <td class="border border-gray-300 px-4 py-2">{{$user->resolve_count}}</td>
                                
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </h4>

                    
            </div>
          </div>
           
           
          


        
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
            const ctx = document.getElementById('weeklyChart').getContext('2d');
            const dateRanges = @json($dateRanges);
            const totals = @json($totals);

            new Chart(ctx, {
                type: 'line', // Changed from 'bar' to 'line'
                data: {
                    labels: dateRanges,
                    datasets: [{
                        label: 'Reports per Week',
                        data: totals,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)', // Optional: For filled area under the line
                        borderColor: 'rgba(75, 192, 192, 1)', // Line color
                        borderWidth: 2, // Thickness of the line
                        tension: 0.4 // Smoothness of the line (0 for straight lines, higher for curves)
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
    </script>
    
</x-layout>    
