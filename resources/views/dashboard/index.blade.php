<x-layout>
    <div class="container mx-auto">
        {{-- <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
        >
          Reports
        </h2> --}}

        <!-- Scorecards -->
        <!-- Responsive cards -->
       
        <div class="flex gap-2 grid-cols-1 md:grid-cols-3 xl:grid-cols-3">
            <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total report concern / issues</p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_total}}</p>
                    </div>
                </div>
            <!-- Card -->
                <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                    <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Today concern and issue reported</p>
                        <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_today}}</p>
                    </div>
                </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Pending concern and issue reported</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_pending}}</p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Ongoing concern and issue reported</p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">{{$reports_ongoing}}</p>
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
                <canvas id="myChart"></canvas>
                <div class="flex justify-center mt-4 space-x-3 text-sm text-gray-600 dark:text-gray-400">
                    <!-- Chart legend -->
                    
                     
                    </div>
            </div>
        
            <div class="w-1/3 p-4 ml-2 bg-white rounded-lg shadow-xs dark:bg-gray-800">
              <!-- Content for the second column (4/12 width) -->
             
              <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                List of recurring issues per week
                </h4>
              <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md text-sm mt-5">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-6 py-3 text-gray-700 font-bold uppercase">Issues</th>
                        <th class="px-6 py-3 text-gray-700 font-bold uppercase">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table Row 1 -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-600">Login Issue</td>
                        <td class="px-6 py-4 text-gray-600">1</td>
                    </tr>
                    <!-- Table Row 2 -->
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-600">Page Load Error</td>
                        <td class="px-6 py-4 text-gray-600">1</td>
                    </tr>
                    <!-- Table Row 3 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-gray-600">Missing Data</td>
                        <td class="px-6 py-4 text-gray-600">1</td>
                    </tr>
                </tbody>
            </table>
            </div>
          </div>    
        
           
           
          
       
        <!-- Bars chart -->

        
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const data = @json($values);

        const ctx = document.getElementById('myChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // You can change this to 'line', 'pie', etc.
            data: {
                labels: labels,
                datasets: [{
                    label: 'Monthly Reported Issues / Concern',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    
</x-layout>    
