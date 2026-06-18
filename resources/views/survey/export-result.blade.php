<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ 'ICT PORTAL' }}</title>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/highcharts@11.4.3/highcharts.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <link rel="icon" type="image/png" href="{{ asset('img/itd_logo.png') }}">
</head>
<body class="bg-slate-50">
  
  <style>
      @media print {
      table {
          font-size: 10px;
      }

      th,
      td {
          padding: 4px !important;
      }

      .material-icons {
          font-size: 12px !important;
      }
      } 
  </style>
  
    @php
        $totalReports = $reports->count();
        $positiveReports = $reports->filter(function ($survey) {
            return $survey->accuracy_of_service >= 1 && $survey->response_time >= 1;
        })->count();
        $needsAttention = max($totalReports - $positiveReports, 0);
        $positivePercent = $totalReports > 0 ? round(($positiveReports / $totalReports) * 100) : 0;

        $accuracyCounts = [
            'Super Like' => $reports->where('accuracy_of_service', 2)->count(),
            'Like' => $reports->where('accuracy_of_service', 1)->count(),
            'Dislike' => $reports->where('accuracy_of_service', 0)->count(),
        ];

        $responseCounts = [
            'Super Like' => $reports->where('response_time', 2)->count(),
            'Like' => $reports->where('response_time', 1)->count(),
            'Dislike' => $reports->where('response_time', 0)->count(),
        ];
    @endphp

    <div class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-indigo-50">
        <div class="mx-auto w-full max-w-7xl px-3 py-6 sm:px-4 sm:py-8 lg:px-8 lg:py-10">
            <div class="mb-6 rounded-3xl bg-white shadow-sm ring-1 ring-slate-200 sm:mb-8">
                <div class="flex flex-col gap-3 border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.28em] text-sky-600 sm:text-sm">Customer Feedback</p>
                        <h2 class="mt-1 text-2xl font-bold text-slate-800 sm:text-3xl">Summary Report</h2>
                    </div>
                    <div class="inline-flex w-fit items-center gap-2 rounded-full bg-sky-50 px-3 py-2 text-xs font-medium text-sky-700 sm:text-sm">
                        <span class="material-icons text-base">analytics</span>
                        {{ auth()->user()->role == 'user' ? auth()->user()->department->title : 'All Departments' }}
                    </div>
                </div>

                <div class="grid gap-3 px-4 py-4 sm:grid-cols-2 sm:px-6 sm:py-5 xl:grid-cols-4">
                    <div class="rounded-2xl bg-slate-50 p-4">
                        <p class="text-xs text-slate-500 sm:text-sm">Total Responses</p>
                        <h3 class="mt-1 text-xl font-semibold text-slate-800 sm:text-2xl">{{ $totalReports }}</h3>
                    </div>
                    <div class="rounded-2xl bg-emerald-50 p-4">
                        <p class="text-xs text-emerald-600 sm:text-sm">Positive Feedback</p>
                        <h3 class="mt-1 text-xl font-semibold text-emerald-700 sm:text-2xl">{{ $positivePercent }}%</h3>
                    </div>
                    <div class="rounded-2xl bg-amber-50 p-4">
                        <p class="text-xs text-amber-600 sm:text-sm">Needs Attention</p>
                        <h3 class="mt-1 text-xl font-semibold text-amber-700 sm:text-2xl">{{ $needsAttention }}</h3>
                    </div>
                    <div class="rounded-2xl bg-indigo-50 p-4">
                        <p class="text-xs text-indigo-600 sm:text-sm">Date Range</p>
                        <h3 class="mt-1 text-sm font-semibold text-indigo-700 sm:text-sm">
                            @if ($startDate && $endDate)
                                {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}
                            @else
                                All Available Dates
                            @endif
                        </h3>
                    </div>
                </div>
            </div>

            <div class="mb-6 rounded-3xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:mb-8 sm:p-6">
                <div class="mb-3 sm:mb-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500 sm:text-sm">Performance Overview</p>
                    <h3 class="mt-1 text-lg font-semibold text-slate-800 sm:text-xl">Feedback Distribution</h3>
                </div>
                <div id="feedbackChart" class="h-[300px] w-full sm:h-[360px] lg:h-[420px]"></div>
            </div>

            <div class="overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-100 px-4 py-4 sm:px-6 sm:py-5">
                    <h3 class="text-lg font-semibold text-slate-800 sm:text-xl">Feedback Entries</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500 sm:px-6 sm:text-xs">Date</th>
                                <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500 sm:px-6 sm:text-xs">Employee</th>
                                <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500 sm:px-6 sm:text-xs">Competence & Accuracy</th>
                                <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500 sm:px-6 sm:text-xs">Responsiveness</th>
                                <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500 sm:px-6 sm:text-xs">Comment</th>
                                <th class="px-3 py-3 text-left text-[11px] font-semibold uppercase tracking-wider text-slate-500 sm:px-6 sm:text-xs">Client</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($reports as $survey)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-3 py-4 text-sm text-slate-600 sm:px-6">{{ $survey->created_at->format('F j, Y') }}</td>
                                    <td class="px-3 py-4 text-sm font-medium text-slate-800 sm:px-6">{{ $survey->surveyEmployee->name }}</td>
                                    <td class="px-3 py-4 sm:px-6">
                                        @if ($survey->accuracy_of_service == 2)
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 sm:px-3 sm:text-sm">
                                                <span class="material-icons mr-1 text-sm sm:text-base">thumb_up</span>
                                                Super Like
                                            </span>
                                        @elseif ($survey->accuracy_of_service == 1)
                                            <span class="inline-flex items-center rounded-full bg-sky-100 px-2.5 py-1 text-xs font-medium text-sky-700 sm:px-3 sm:text-sm">
                                                <span class="material-icons mr-1 text-sm sm:text-base">thumb_up</span>
                                                Like
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700 sm:px-3 sm:text-sm">
                                                <span class="material-icons mr-1 text-sm sm:text-base">thumb_down</span>
                                                Dislike
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-4 sm:px-6">
                                        @if ($survey->response_time == 2)
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-medium text-emerald-700 sm:px-3 sm:text-sm">
                                                <span class="material-icons mr-1 text-sm sm:text-base">thumb_up</span>
                                                Super Like
                                            </span>
                                        @elseif ($survey->response_time == 1)
                                            <span class="inline-flex items-center rounded-full bg-sky-100 px-2.5 py-1 text-xs font-medium text-sky-700 sm:px-3 sm:text-sm">
                                                <span class="material-icons mr-1 text-sm sm:text-base">thumb_up</span>
                                                Like
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-rose-100 px-2.5 py-1 text-xs font-medium text-rose-700 sm:px-3 sm:text-sm">
                                                <span class="material-icons mr-1 text-sm sm:text-base">thumb_down</span>
                                                Dislike
                                            </span>
                                        @endif
                                    </td>
                                    <td class="max-w-xs px-3 py-4 text-sm text-slate-600 sm:px-6">
                                        <div class="line-clamp-3">{{ $survey->comments ?: 'No additional comments provided.' }}</div>
                                    </td>
                                    <td class="px-3 py-4 text-sm text-slate-600 sm:px-6">{{ $survey->client_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500 sm:px-6">
                                        No feedback records found for the selected period.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Highcharts.chart('feedbackChart', {
                chart: {
                    type: 'column',
                    backgroundColor: 'transparent'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: ['Super Like', 'Like', 'Dislike'],
                    crosshair: true,
                    labels: {
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Count'
                    }
                },
                tooltip: {
                    shared: true,
                    useHTML: true
                },
                legend: {
                    align: 'right',
                    verticalAlign: 'top'
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [
                    {
                        name: 'Competence & Accuracy',
                        data: @json(array_values($accuracyCounts)),
                        color: '#38bdf8'
                    },
                    {
                        name: 'Responsiveness',
                        data: @json(array_values($responseCounts)),
                        color: '#22c55e'
                    }
                ]
            });
        });
    </script>
</body>
</html>
    
