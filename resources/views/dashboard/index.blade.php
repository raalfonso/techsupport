<x-layout>
    
    <div class="container-fluid mx-auto">
        <!-- Scorecards -->
        <!-- Responsive cards -->
       
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            <!-- Card 1 -->
            <div class="flex items-center p-4 bg-slate-800 rounded-lg shadow-xs dark:bg-slate-800">
                <div class="p-3 mr-4 text-gray-100 bg-teal-600 rounded-full dark:text-orange-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-100 dark:text-gray-100">Received</p>
                    <p class="text-lg font-semibold text-gray-100 dark:text-gray-200">{{$reports_total}}</p>
                </div>
            </div>
        
            <!-- Card 2 -->
            <div class="flex items-center p-4 bg-slate-800 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-gray-100 bg-teal-600 rounded-full dark:text-green-100 dark:bg-green-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>    
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-100 dark:text-gray-400">Resolved</p>
                    <p class="text-lg font-semibold text-gray-100 dark:text-gray-200">{{$report_resolved}}</p>
                </div>
            </div>
        
            <!-- Card 3 -->
            <div class="flex items-center p-4 bg-slate-800 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-gray-100 bg-teal-600 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>          
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-100 dark:text-gray-400">Pending</p>
                    <p class="text-lg font-semibold text-gray-100 dark:text-gray-200">{{$reports_pending}}</p>
                </div>
            </div>
        
            <!-- Card 4 -->
            <div class="flex items-center p-4 bg-slate-800 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-100 bg-teal-600 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                    </svg>                      
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-100 dark:text-gray-400">Ongoing</p>
                    <p class="text-lg font-semibold text-gray-100 dark:text-gray-200">{{$reports_ongoing}}</p>
                </div>
            </div>
        
            <!-- Card 5 -->
            <div class="flex items-center p-4 bg-slate-800 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-100 bg-teal-600 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.806 9-8.25s-4.03-8.25-9-8.25-9 3.806-9 8.25c0 1.88.772 3.616 2.049 4.963a8.814 8.814 0 01-2.212 3.8c-.195.192-.205.498-.024.707a.513.513 0 00.707.024 8.725 8.725 0 003.693-2.275A9.906 9.906 0 0012 20.25z" />
                    </svg>                                       
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-100 dark:text-gray-400">Customer Satisfaction</p>
                    <p class="text-lg font-semibold text-gray-100 dark:text-gray-200">{{round($satisfaction)}}%</p>
                </div>
            </div>
        </div>
        


        {{-- end of Scorecards --}}


    <!-- 2nd layer Chart -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4 mt-5">
            <div class="bg-slate-800 text-white p-4 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
             
                    {{-- <div>
                      <p class="text-sm font-medium">Total No. of Request</p>

                    </div> --}}
                  </div>
                </div>
            
                <!-- Highcharts container -->
                <div id="chart-container" class="mt-4"></div>
              </div>

              <div class="bg-slate-800 text-white p-4 rounded-lg shadow-md">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
             
                    {{-- <div>
                      <p class="text-sm font-medium">Total No. of Request</p>

                    </div> --}}
                  </div>
                </div>
            
                <!-- Highcharts container -->
                <div id="employee_chart" class="mt-4"></div>
              </div>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-2 gap-4 mt-5">
            

            <div class="p-4 ml-2 bg-slate-800 rounded-lg shadow-xs dark:bg-gray-800">
                <div id="container" style="height: 400px;"></div>   
            </div>
            <div class="p-4 ml-2 bg-slate-800 rounded-lg shadow-xs dark:bg-gray-800">
                <div id="container-recurring" class="mt-4"></div>
            </div>
        </div>
        <br>
            
     </div>

        
        

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
            // const ctx = document.getElementById('weeklyChart').getContext('2d');
           

            // new Chart(ctx, {
            //     type: 'line', // Changed from 'bar' to 'line'
            //     data: {
            //         labels: dateRanges,
            //         datasets: [{
            //             label: 'Reports per Week',
            //             data: totals,
            //             backgroundColor: 'rgba(75, 192, 192, 0.2)', // Optional: For filled area under the line
            //             borderColor: 'rgba(75, 192, 192, 1)', // Line color
            //             borderWidth: 2, // Thickness of the line
            //             tension: 0.4 // Smoothness of the line (0 for straight lines, higher for curves)
            //         }]
            //     },
            //     options: {
            //         scales: {
            //             y: {
            //                 beginAtZero: true
            //             }
            //         }
            //     }
            // });

            const dateRanges = @json($dateRanges);
    const totals = @json($totals);
    Highcharts.chart('chart-container', {
        chart: {
            type: 'line',
            backgroundColor: 'transparent'
        },
        title: {
            text: 'Request Per Month',
            style: { color: '#fff' }
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            labels: { style: { color: '#fff' } }
        },
        yAxis: {
            title: {
                text: 'Number of Request',
                style: { color: '#fff' }
            },
            labels: { style: { color: '#fff' } }
        },
        legend: {
            itemStyle: {
                color: '#fff' // Set legend text color to white
            }
        },
        series: [{
            name: 'Request',
            data: [800, 870, 800, 1100, 1200, 1107],
            color: '#14B8A6'
        }]
    });


        document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('employee_chart', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent' // Remove white background, no comma after this
            },
            title: {
                text: "Department Showdown 2025",
                style: { color: '#fff' }
            },
            subtitle: {
                text: '',
                style: { color: '#fff' }
            },
            xAxis: {
                type: 'category',
                labels: {
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        color: '#fff'
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Request count',
                    style: { color: '#fff' }
                },
                labels: {
                    style: { color: '#fff' }
                }
            },
            legend: {
                enabled: false
            },
            tooltip: {
                pointFormat: 'Request in 2025: <b>{point.y}</b>'
            },
            series: [{
                name: 'Population',
                color: '#14B8A6',
                colorByPoint: false,
                data: [
                    ['OPCEO', 37],
                    ['OSVP LSG', 31],
                    ['HRMD', 27],
                    ['PAD', 22],
                    ['SAPMD', 21],
                    ['RAD', 21],
                    ['EESD', 21],
                    ['GSD', 20],
                    ['Accounting', 20],
                    ['Budget', 19],
                    ['OEVP', 16],
                    ['PPMD', 16],
                    ['Property', 15],
                    ['LSD', 15],
                    ['BAC', 14],
                    ['CPD', 14],
                    ['OCBS', 14],
                    ['SCRP', 14],
                    ['OC', 13],
                    ['SMD', 13]
                ],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#FFFFFF',
                    inside: true,
                    verticalAlign: 'top',
                    format: '{point.y}',
                    y: 10,
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            }]
        });
    });

    Highcharts.chart('container-recurring', {
        chart: {
            type: 'bar',
            backgroundColor: 'transparent'
        },
        title: {
            text: 'Recurring Issues (3+ Occurrences) for the week',
            style: { color: '#fff' }
        },
        xAxis: {
            categories: ['Network Issue', 'Printer Issue','Scanner Issues'],
            labels: { style: { color: '#fff' } }
        },
        yAxis: {
            title: {
                text: 'Occurrences',
                style: { color: '#fff' }
            },
            labels: { style: { color: '#fff' } }
        },
        series: [{
            name: 'Occurrences',
            data: [5, 2, 2],
            color: '#14B8A6'
        }]
    });


    document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('container', {
            chart: {
                type: 'column',
                 backgroundColor: 'transparent'
            },
            title: {
                text: 'Technical Staff Efficiency: Total Resolved Requests',
                style: { color: '#fff' }
            },
            accessibility: {
                announceNewData: {
                    enabled: true,
                    style: { color: '#fff' }
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    style: { color: '#fff' }  // White labels for x-axis
                }
            },
            yAxis: {
                title: {
                    text: 'Total number of issue resolved',
                    style: { color: '#fff' }
                },
                labels: {
                    style: { color: '#fff' }  // White labels for x-axis
                }
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:}'
                    }
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> of total<br/>'
            },
            series: [{
                name: 'Staff',
                colorByPoint: false,
                color: '#14B8A6',
                data: @json($browserData)
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: @json($drilldownSeries)
            }
        });
    });

    
    </script>
    
</x-layout>    
