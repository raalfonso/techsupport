<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IT Survey Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50">

<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">IT Survey Dashboard</h1>
                <p class="text-gray-600 mt-1">Monitor and analyze IT service feedback</p>
            </div>
            <div class="flex gap-3">
                <button onclick="showQRModal()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-qrcode mr-2"></i>Generate QR Code
                </button>
               
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Surveys -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Surveys</p>
                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $totalSurveys }}</p>
                </div>
                <div class="bg-blue-100 p-4 rounded-full">
                    <i class="fas fa-poll text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Resolution Rate -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resolution Rate</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $resolutionRate }}%</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $resolvedCount }} of {{ $totalSurveys }}</p>
                </div>
                <div class="bg-green-100 p-4 rounded-full">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Avg Response Time -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Avg Response Time</p>
                    <p class="text-3xl font-bold text-purple-600 mt-2">{{ number_format($avgResponseTime, 1) }}/5</p>
                    <p class="text-xs text-gray-500 mt-1">Higher is faster</p>
                </div>
                <div class="bg-purple-100 p-4 rounded-full">
                    <i class="fas fa-clock text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Avg Service Rating -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Avg Service Rating</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ number_format($avgServiceRating, 1) }}/5</p>
                    <p class="text-xs text-gray-500 mt-1">Service quality</p>
                </div>
                <div class="bg-yellow-100 p-4 rounded-full">
                    <i class="fas fa-star text-yellow-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Response Time Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Response Time Distribution</h2>
            <canvas id="responseTimeChart"></canvas>
        </div>

        <!-- Service Rating Chart -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Service Rating Distribution</h2>
            <canvas id="serviceRatingChart"></canvas>
        </div>
    </div>

    <!-- IT Employee Performance Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Employee Survey Count -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">IT Employee Survey Count</h2>
            <canvas id="employeeSurveyChart"></canvas>
        </div>

        <!-- Employee Average Rating -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">IT Employee Average Service Rating</h2>
            <canvas id="employeeRatingChart"></canvas>
        </div>
    </div>

    <!-- Employee Performance Table -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">IT Employee Performance Summary</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Employee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Total Surveys</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Avg Response Time</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Avg Service Rating</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Resolution Rate</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employeeStats as $stat)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            {{ $stat->employee ? $stat->employee->first_name . ' ' . $stat->employee->last_name : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $stat->total_surveys }}</td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($stat->avg_response_time >= 4) bg-green-100 text-green-800
                                @elseif($stat->avg_response_time >= 3) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ number_format($stat->avg_response_time, 2) }}/5
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($stat->avg_service_rating >= 4) bg-green-100 text-green-800
                                @elseif($stat->avg_service_rating >= 3) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ number_format($stat->avg_service_rating, 2) }}/5
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @php
                                $resRate = $stat->total_surveys > 0 ? round(($stat->resolved_count / $stat->total_surveys) * 100, 2) : 0;
                            @endphp
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($resRate >= 80) bg-green-100 text-green-800
                                @elseif($resRate >= 60) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $resRate }}%
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No employee data available</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Resolution Status & Top Issues -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Resolution Status -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Issue Resolution Status</h2>
            <canvas id="resolutionChart"></canvas>
        </div>

        <!-- Top Issues -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Top 5 Issues Surveyed</h2>
            <div class="space-y-3">
                @forelse($topIssues as $issue)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex-1">
                        <p class="font-medium text-gray-800">{{ $issue->issue->title ?? 'N/A' }}</p>
                    </div>
                    <div class="flex items-center">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $issue->count }} surveys
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">No data available</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Export Survey Results</h2>
        <form action="{{ route('it-survey.exportResults') }}" method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                <input type="date" name="start_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                <input type="date" name="end_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-download mr-2"></i>Export Results
            </button>
        </form>
    </div>

    <!-- Survey Table -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Surveys</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Issue</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">IT Employee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Response Time</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Resolved</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Rating</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($surveys as $survey)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $survey->id }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ Str::limit($survey->issue->title ?? 'N/A', 30) }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-900">
                            @if($survey->employee)
                                {{ $survey->employee->first_name }} {{ $survey->employee->last_name }}
                            @else
                                <span class="text-gray-400">Not specified</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($survey->answer_question_1 >= 4) bg-green-100 text-green-800
                                @elseif($survey->answer_question_1 == 3) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $survey->answer_question_1 }}/5
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            @if($survey->answer_question_2 == 'Yes')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Yes</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">No</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($survey->answer_question_3 >= 4) bg-green-100 text-green-800
                                @elseif($survey->answer_question_3 == 3) bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ $survey->answer_question_3 }}/5
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $survey->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">No surveys found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $surveys->links() }}
        </div>
    </div>
</div>

<script>
    // Response Time Chart
    const responseTimeCtx = document.getElementById('responseTimeChart').getContext('2d');
    new Chart(responseTimeCtx, {
        type: 'bar',
        data: {
            labels: @json($responseTimeLabels),
            datasets: [{
                label: 'Number of Responses',
                data: @json($responseTimeData),
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: 'rgba(59, 130, 246, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Service Rating Chart
    const serviceRatingCtx = document.getElementById('serviceRatingChart').getContext('2d');
    new Chart(serviceRatingCtx, {
        type: 'bar',
        data: {
            labels: @json($serviceRatingLabels),
            datasets: [{
                label: 'Number of Ratings',
                data: @json($serviceRatingData),
                backgroundColor: 'rgba(234, 179, 8, 0.8)',
                borderColor: 'rgba(234, 179, 8, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Resolution Chart
    const resolutionCtx = document.getElementById('resolutionChart').getContext('2d');
    new Chart(resolutionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Resolved', 'Unresolved'],
            datasets: [{
                data: [{{ $resolvedCount }}, {{ $unresolvedCount }}],
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(239, 68, 68, 0.8)'
                ],
                borderColor: [
                    'rgba(34, 197, 94, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Employee Survey Count Chart
    const employeeSurveyCtx = document.getElementById('employeeSurveyChart').getContext('2d');
    new Chart(employeeSurveyCtx, {
        type: 'bar',
        data: {
            labels: @json($employeeNames),
            datasets: [{
                label: 'Number of Surveys',
                data: @json($employeeSurveyCount),
                backgroundColor: 'rgba(99, 102, 241, 0.8)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Employee Average Rating Chart
    const employeeRatingCtx = document.getElementById('employeeRatingChart').getContext('2d');
    new Chart(employeeRatingCtx, {
        type: 'bar',
        data: {
            labels: @json($employeeNames),
            datasets: [{
                label: 'Average Service Rating',
                data: @json($employeeAvgRating),
                backgroundColor: 'rgba(16, 185, 129, 0.8)',
                borderColor: 'rgba(16, 185, 129, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>

<!-- QR Code Modal -->
<div id="qrModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold text-gray-900">IT Survey Form - QR Code & Link</h3>
            <button onclick="closeQRModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
        
        <div class="mt-4">
            <!-- Survey Link -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Survey Form Link:</label>
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        id="surveyLink" 
                        value="{{ url('/it-survey/form') }}" 
                        readonly
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 bg-gray-50"
                    >
                    <button onclick="copyLink()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i class="fas fa-copy mr-2"></i>Copy
                    </button>
                </div>
                <p id="copyMessage" class="text-green-600 text-sm mt-2 hidden">Link copied to clipboard!</p>
            </div>

            <!-- QR Code -->
            <div class="text-center">
                <label class="block text-sm font-medium text-gray-700 mb-4">Scan QR Code to access survey:</label>
                <div id="qrcode" class="inline-block p-4 bg-white border-2 border-gray-300 rounded-lg"></div>
                <div class="mt-4">
                    <button onclick="downloadQR()" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-download mr-2"></i>Download QR Code
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
    let qrCodeInstance = null;

    function showQRModal() {
        document.getElementById('qrModal').classList.remove('hidden');
        
        // Clear previous QR code if exists
        const qrcodeDiv = document.getElementById('qrcode');
        qrcodeDiv.innerHTML = '';
        
        // Generate new QR code
        qrCodeInstance = new QRCode(qrcodeDiv, {
            text: "{{ url('/it-survey/form') }}",
            width: 256,
            height: 256,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    function closeQRModal() {
        document.getElementById('qrModal').classList.add('hidden');
    }

    function copyLink() {
        const linkInput = document.getElementById('surveyLink');
        linkInput.select();
        linkInput.setSelectionRange(0, 99999);
        
        navigator.clipboard.writeText(linkInput.value).then(() => {
            const message = document.getElementById('copyMessage');
            message.classList.remove('hidden');
            setTimeout(() => {
                message.classList.add('hidden');
            }, 3000);
        });
    }

    function downloadQR() {
        const canvas = document.querySelector('#qrcode canvas');
        if (canvas) {
            const url = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.download = 'it-survey-qrcode.png';
            link.href = url;
            link.click();
        }
    }

    // Close modal when clicking outside
    document.getElementById('qrModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeQRModal();
        }
    });
</script>

</body>
</html>
