<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; color: #1f2937; margin: 0; padding: 20px; }
        .header-table { width: 100%; border-bottom: 2px solid #2563eb; padding-bottom: 12px; margin-bottom: 16px; }
        .header-table td { vertical-align: middle; padding: 0; border: none; background: none; }
        .header-logo { width: 110px; }
        .header-title { font-size: 16px; font-weight: bold; margin: 0 0 4px 0; }
        .header-subtitle { font-size: 11px; color: #6b7280; margin: 0; }
        table.data { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data thead tr { background-color: #2563eb; color: #fff; }
        table.data th { padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; }
        table.data td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; vertical-align: top; }
        table.data tr:nth-child(even) td { background-color: #f0f4ff; }
        ul { margin: 0; padding-left: 16px; }
        li { margin-bottom: 2px; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 120px;">
                <img src="{{ public_path('images/bcda-removebg-preview.png') }}" class="header-logo">
            </td>
            
        </tr>
        <tr>
            <td>
                <center><p class="header-title">WFH Accomplishments Report</p></center>
                <br>
                <p class="header-title">{{ $wfhDepartment ? $wfhDepartment : '' }}</p>
                <p class="header-subtitle">Date: {{ \Carbon\Carbon::parse($wfhDate)->format('F d, Y') }}</p>
            </td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Employee ID</th>
                
                <th>Accomplishments</th>
               
            </tr>
        </thead>
        <tbody>
            @forelse($wfhAccomplishments as $item)
            <tr>
                <td>{{ $item['employee_name'] }}</td>
                <td>{{ $item['employee_id'] }}</td>
               
                <td>
                    <ul>
                        @foreach($item['accomplishments'] as $acc)
                            <li>{{ $acc }}</li>
                        @endforeach
                    </ul>
                </td>
               
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align:center; color:#6b7280;">No accomplishments recorded for this date.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
