<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IT Survey Export</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white">

<div class="container mx-auto px-4 py-8">
    <div class="no-print mb-4">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Print Report
        </button>
        <a href="{{ route('it-survey.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 ml-2">
            Back to Dashboard
        </a>
    </div>

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold">IT Survey Results</h1>
        @if($startDate && $endDate)
        <p class="text-gray-600 mt-2">Period: {{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</p>
        @endif
    </div>

    <div class="mb-6">
        <h2 class="text-xl font-semibold mb-4">Summary</h2>
        <p>Total Surveys: {{ $surveys->count() }}</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-4 py-2">ID</th>
                    <th class="border px-4 py-2">Issue</th>
                    <th class="border px-4 py-2">Employee Number</th>
                    <th class="border px-4 py-2">Name</th>
                    <th class="border px-4 py-2">Q1</th>
                    <th class="border px-4 py-2">Q2</th>
                    <th class="border px-4 py-2">Q3</th>
                    <th class="border px-4 py-2">Q4</th>
                    <th class="border px-4 py-2">Suggestion</th>
                    <th class="border px-4 py-2">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surveys as $survey)
                <tr>
                    <td class="border px-4 py-2">{{ $survey->id }}</td>
                    <td class="border px-4 py-2">{{ $survey->issue->title ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $survey->employee_number ?? 'N/A' }}</td>
                    <td class="border px-4 py-2">{{ $survey->name ?? 'Anonymous' }}</td>
                    <td class="border px-4 py-2">{{ $survey->answer_question_1 }}</td>
                    <td class="border px-4 py-2">{{ $survey->answer_question_2 }}</td>
                    <td class="border px-4 py-2">{{ $survey->answer_question_3 }}</td>
                    <td class="border px-4 py-2">{{ $survey->answer_question_4 }}</td>
                    <td class="border px-4 py-2">{{ $survey->suggestion }}</td>
                    <td class="border px-4 py-2">{{ $survey->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="border px-4 py-2 text-center text-gray-500">No surveys found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
