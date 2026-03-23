<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1f2937; margin: 0; padding: 20px; }
        .header-table { width: 100%; border-bottom: 2px solid #2563eb; padding-bottom: 12px; margin-bottom: 16px; }
        .header-table td { vertical-align: middle; padding: 0; border: none; background: none; }
        .header-logo { width: 100px; }
        .header-title { font-size: 15px; font-weight: bold; margin: 0 0 4px 0; }
        .header-subtitle { font-size: 10px; color: #6b7280; margin: 0; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data thead tr { background-color: #2563eb; color: #fff; }
        table.data th { padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
        table.data td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        table.data tr:nth-child(even) td { background-color: #f0f4ff; }
        .badge-in  { color: #15803d; font-weight: bold; }
        .badge-out { color: #b91c1c; font-weight: bold; }
        .na { color: #9ca3af; }
        .signatory-section { margin-top: 40px; }
        .signatory-block { display: inline-block; min-width: 180px; margin-right: 40px; vertical-align: top; }
        .signatory-name { font-size: 11px; font-weight: bold; text-transform: uppercase; padding-top: 4px; margin-top: 24px; }
        .signatory-position { font-size: 10px; color: #374151; }
        .signatory-dept { font-size: 10px; color: #6b7280; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 115px;">
                <img src="{{ public_path('images/bcda-removebg-preview.png') }}" class="header-logo">
            </td>
            <td>
                <p class="header-title">Attendance Report</p>
                <p class="header-subtitle">Generated: {{ now()->format('F d, Y h:i A') }}</p>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee Name</th>
                <th>Time In</th>
                <th>Time Out</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $row)
            <tr>
                <td>{{ $row['date'] }}</td>
                <td>{{ $row['employee_name'] }}</td>
                <td class="{{ $row['time_in'] ? 'badge-in' : 'na' }}">{{ $row['time_in'] ?? '—' }}</td>
                <td class="{{ $row['time_out'] ? 'badge-out' : 'na' }}">{{ $row['time_out'] ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center; color:#6b7280; padding: 20px;">No attendance records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(isset($signatories) && $signatories->count())
    <div class="signatory-section">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                @foreach($signatories as $sig)
                <td style="width: {{ round(100 / $signatories->count()) }}%; vertical-align: top; padding-right: 20px;">
                    <div style="margin-top: 30px;">
                        <div style="padding-top: 4px;">
                            <div class="signatory-name">{{ strtoupper($sig->employee->name ?? '') }}</div>
                            <div class="signatory-position">{{ $sig->position }}</div>
                            <div class="signatory-dept">{{ $sig->department->title ?? '' }}</div>
                        </div>
                    </div>
                </td>
                @endforeach
            </tr>
        </table>
    </div>
    @endif

</body>
</html>
