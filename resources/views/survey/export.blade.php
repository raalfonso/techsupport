<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Set the title from APP_NAME or provide a fallback --}}
    <title>{{ 'ICT PORTAL' }}</title>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    
    {{-- Vite for compiling your Tailwind CSS and JS --}}
    @vite(['resources/js/app.js', 'resources/css/app.css']) 
    
    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body>
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Customer Feedback Summary</h2>
        @if (auth()->user()->role == 'user')
            <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">{{ auth()->user()->department->title}}</h3>
        @else
            <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Department: <?= $department ?? 'All Departments' ?></h3>
        @endif

        @if ($startDate && $endDate)
            <p class="text-md text-gray-600 mb-6 text-center">From <strong>{{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }}</strong> to <strong>{{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}</strong></p>
            
        @endif

        <table class="w-full bg-white shadow-lg rounded-lg overflow-hidden mb-8">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase tracking-wider">Feedback Category</th>
                    <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase tracking-wider">Super Like</th>
                    <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase tracking-wider">Like</th>
                    <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase tracking-wider">Dislike</th>
                    <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase tracking-wider">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <tr class=" hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1. Degree of Competence and Accuracy of Service</td>
                    @foreach ($consolidation as $consolidate) 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $consolidate }}</td>
                    @endforeach                    
        
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2. Degree of Responsiveness/Timeliness</td>
                    @foreach ($consolidationResponse as $response) 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $response }}</td>
                        
                    @endforeach
                    
                </tr>
                <tr class="bg-gray-200 font-bold hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Performance</td>
                    @foreach ($performance as $perf) 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $perf }}</td>
                    @endforeach
                    
                    
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"></td>
                </tr>                                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">1. Good Service</td>
                    @foreach ($consolidationPercentage as $consPercent) 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $consPercent }}%</td>       
                        
                    @endforeach
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">100%</td>
                </tr>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">2. Responsive and Accommodating</td>
                    @foreach ($responsePercentage as $resPercent) 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $resPercent }}%</td>
                    @endforeach
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">100%</td>
                </tr>
                <tr class="bg-gray-200 font-bold hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Performance</td>
                    @foreach ($performancePercentage as $perfCentage) 
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $perfCentage }}%</td>
                    @endforeach
                     <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">100%</td>
                    
                </tr>
            </tbody>
        </table>

        <div class="chart-container bg-white p-6 rounded-lg shadow-lg">
            <div id="feedbackChart" class="max-w-full h-[400px]"></div>    </div>

    <script>
        const chart = Highcharts.chart('feedbackChart', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Customer Feedback Distribution'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '{point.name}: {point.percentage:.1f}%'
            }
        }
    },
    series: [{
        data: [
            {
                name: 'Super Like',
                y: {{ $performancePercentage['super_like_average'] }},
                color: '#4CAF50'
            },
            {
                name: 'Like', 
                y: {{ $performancePercentage['like_average'] }},
                color: '#9381ff'
            },
            {
                name: 'Dislike',
                y: {{ $performancePercentage['dislike_average'] }},
                color: '#ff6392'
            },
        
        ]
    }]
});    

</script>
</body>
</html>    
    
