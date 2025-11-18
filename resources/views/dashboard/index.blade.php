<x-layout>
    
    <div class="container-fluid p-5 mt-5">
        <!-- Scorecards -->
        <!-- Responsive cards -->
       
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 ">
            <!-- Card 1 -->
            <div class="flex items-center p-4 bg-slate-100 rounded-lg shadow-xs dark:bg-slate-800">
                <div class="p-3 mr-4 text-gray-100 bg-blue-700 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                </div>
                <div class=" text-gray-800">
                    <p class="mb-2 text-sm font-medium">Received</p>
                    <p class="text-lg font-semibold">{{$reports_total}}</p>
                </div>
            </div>
        
            <!-- Card 2 -->
            <div class="flex items-center p-4 bg-slate-100 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-gray-100 bg-blue-700 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                    </svg>    
                </div>
                <div class=" text-gray-800">
                    <p class="mb-2 text-sm font-medium">Resolved</p>
                    <p class="text-lg font-semibold">{{$report_resolved}}</p>
                </div>
            </div>
        
            <!-- Card 3 -->
            <div class="flex items-center p-4 bg-slate-100 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-gray-100 bg-blue-700 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>          
                </div>
                <div class=" text-slate-800 dark:text-gray-200">
                    <p class="mb-2 text-sm font-medium">Pending</p>
                    <p class="text-lg font-semibold ">{{$reports_pending}}</p>
                </div>
            </div>
        
            <!-- Card 4 -->
            <div class="flex items-center p-4 bg-slate-100 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-gray-100 bg-blue-700 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12c0-1.232-.046-2.453-.138-3.662a4.006 4.006 0 0 0-3.7-3.7 48.678 48.678 0 0 0-7.324 0 4.006 4.006 0 0 0-3.7 3.7c-.017.22-.032.441-.046.662M19.5 12l3-3m-3 3-3-3m-12 3c0 1.232.046 2.453.138 3.662a4.006 4.006 0 0 0 3.7 3.7 48.656 48.656 0 0 0 7.324 0 4.006 4.006 0 0 0 3.7-3.7c.017-.22.032-.441.046-.662M4.5 12l3 3m-3-3-3 3" />
                    </svg>                      
                </div>
                <div class=" text-slate-800 dark:text-gray-200">
                    <p class="mb-2 text-sm font-medium">Ongoing</p>
                    <p class="text-lg font-semibold">{{$reports_ongoing}}</p>
                </div>
            </div>
        
            <!-- Card 5 -->
            <div class="flex items-center p-4 bg-slate-100 rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-gray-100 bg-blue-700 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.806 9-8.25s-4.03-8.25-9-8.25-9 3.806-9 8.25c0 1.88.772 3.616 2.049 4.963a8.814 8.814 0 01-2.212 3.8c-.195.192-.205.498-.024.707a.513.513 0 00.707.024 8.725 8.725 0 003.693-2.275A9.906 9.906 0 0012 20.25z" />
                    </svg>                                       
                </div>
                <div class=" text-slate-800 dark:text-gray-200">
                    <p class="mb-2 text-sm font-medium ">Customer Satisfaction</p>
                    <p class="text-lg font-semibold ">{{round($satisfaction)}}%</p>
                </div>
            </div>
        </div>
        


        {{-- end of Scorecards --}}


    <!-- 2nd layer Chart -->

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-4 mt-5">
            <div class="bg-slate-100 text-slate-100 p-4 rounded-lg shadow-md dark:bg-slate-800 dark:text-slate-100">
                <div class="flex items-center justify-between">
                  <div class="flex items-center">
                    
                  </div>
                </div>
            
                <!-- Highcharts container -->
                <div id="chart-container" class="mt-4 text-red-300"></div>
              </div>

              <div class="bg-slate-100 text-slate-800 p-4 rounded-lg shadow-md dark:bg-slate-800 dark:text-slate-100">
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
            

            <div class="bg-slate-100 text-slate-100 p-4 rounded-lg shadow-md dark:bg-slate-800 dark:text-slate-100">
                <div id="container" style="height: 400px;"></div>   
            </div>
            <div class="bg-slate-100 text-slate-100 p-4 rounded-lg shadow-md dark:bg-slate-800 dark:text-slate-100">
                <div id="container-recurring" class="mt-4"></div>
            </div>
        </div>
        <br>
            
     </div>

        
        

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
$(document).ready(function() {
   
      if (Highcharts.charts[0]) {
        Highcharts.charts[0].destroy();
      }
        const isDark = document.documentElement.classList.contains('dark');
        const titleColor = isDark ? '#fff' : '#000';
        const labelColor = isDark ? '#fff' : '#000';
        const legendColor = isDark ? '#fff' : '#000';
      renderChart(titleColor,labelColor,legendColor);

  
});
$('.theme-toggle').click(function(){
    if (Highcharts.charts[0]) {
      Highcharts.charts[0].destroy();
    }
    const isDark = document.documentElement.classList.contains('dark');
        const titleColor = isDark ? '#000' : '#fff';
        const labelColor = isDark ? '#000' : '#fff';
        const legendColor = isDark ? '#000' : '#fff';
      renderChart(titleColor,labelColor,legendColor);
   
  
});

function renderChart(titleColor,labelColor,legendColor) {
 

    Highcharts.chart('chart-container', {
        chart: {
        type: 'line',
        backgroundColor: 'transparent'
        },
        title: {
        text: 'Request Per Month',
        style: { color: titleColor }
        },
        xAxis: {
        categories: @json($labels),
        labels: { style: { color: labelColor } }
        },
        yAxis: {
        title: {
            text: 'Number of Request',
            style: { color: labelColor }
        },
        labels: { style: { color: labelColor } }
        },
        legend: {
        itemStyle: { color: legendColor }
        },
        series: [{
        name: 'Request',
        data:  @json($values),
        color: '#344fd9'
        }]
    });

//   second chart
    // document.addEventListener('DOMContentLoaded', function () {
        Highcharts.chart('employee_chart', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent' // Remove white background, no comma after this
            },
            title: {
                text: "Department Showdown 2025",
                style: { color: titleColor }
            },
            subtitle: {
                text: '',
                style: { color: titleColor }
            },
            xAxis: {
                type: 'category',
                labels: {
                    style: {
                        fontSize: '13px',
                        fontFamily: 'Verdana, sans-serif',
                        color: titleColor
                    }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Request count',
                    style: { color: titleColor }
                },
                labels: {
                    style: { color: titleColor }
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
                color: '#344fd9',
                colorByPoint: false,
                data: @json($formattedData),
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

// console.log(@json($recurringIssues));
// 3rd recurring issues
       Highcharts.chart('container-recurring', {
            chart: {
                type: 'bar',
                backgroundColor: 'transparent'
            },
            title: {
                text: 'Recurring Issues (3+ Occurrences)',
                style: { color: titleColor }
            },
            xAxis: {
                type: 'category',
                labels: { style: { color: titleColor } }
            },
            yAxis: {
                title: {
                    text: 'Occurrences',
                    style: { color: titleColor }
                },
                labels: { style: { color: titleColor } }
            },
            series: [{
                name: 'Issues',
                color: '#344fd9', // This will work now
                data: @json($recurringIssues)
            }]
        });



    // 4th technical staff efficiency
    Highcharts.chart('container', {
            chart: {
                type: 'column',
                 backgroundColor: 'transparent'
            },
            title: {
                text: 'Technical Staff Efficiency: Total Resolved Requests',
                style: { color: titleColor }
            },
            accessibility: {
                announceNewData: {
                    enabled: true,
                    style: { color: titleColor }
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    style: { color: titleColor }  // White labels for x-axis
                }
            },
            yAxis: {
                title: {
                    text: 'Total number of issue resolved',
                    style: { color: titleColor }
                },
                labels: {
                    style: { color: titleColor }  // White labels for x-axis
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
                color: '#344fd9',
                data: @json($userData)
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                
            }
        });
}


        

    


    


    
        


    
    </script>
    
</x-layout>    
