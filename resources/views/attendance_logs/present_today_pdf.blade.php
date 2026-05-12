<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Present Today Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #1a1a1a;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .report-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 12px;
        }
        
        .report-info div {
            flex: 1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background-color: #f0f0f0;
            border-bottom: 2px solid #333;
        }
        
        th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 12px;
            color: #333;
        }
        
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        
        .summary {
            background-color: #f0f0f0;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .summary strong {
            color: #1a1a1a;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Present Today Report</h1>
            <p>Bases Conversion and Development Authority (BCDA)</p>
        </div>
        
        <div class="report-info">
            <div>
                <strong>Report Date:</strong> {{ \Carbon\Carbon::parse($date ?? today())->format('M d, Y') }}
            </div>
            <div>
                <strong>Time Generated:</strong> {{ now()->format('g:i A') }}
            </div>
            <div>
                <strong>Total Present:</strong> {{ count($presentEmployees) }}
            </div>
        </div>
        
        <div class="summary">
            <strong>Summary:</strong> This report shows all employees who clocked in on {{ \Carbon\Carbon::parse($date ?? today())->format('M d, Y') }}.
        </div>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th style="width: 30%;">Employee Name</th>
                    <th style="width: 15%;">Employee #</th>
                    <th style="width: 30%;">Department</th>
                    <th style="width: 20%;">Time In</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presentEmployees as $index => $employee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $employee['name'] }}</td>
                        <td>{{ $employee['employee_number'] }}</td>
                        <td>{{ $employee['department'] }}</td>
                        <td>{{ date('g:i A', strtotime($employee['time'])) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #999;">No employees present today</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <div class="footer">
            <p>This is an automatically generated report. For inquiries, please contact the HR Department.</p>
            <p style="margin-top: 10px;">© 2026 BCDA • ClockWize Attendance System</p>
        </div>
    </div>
</body>
</html>
