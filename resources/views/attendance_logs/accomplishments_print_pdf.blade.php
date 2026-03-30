<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 11px; 
            color: #1f2937; 
            margin: 0; 
            padding: 20px; 
        }
        .header-table { 
            width: 100%; 
            border-bottom: 2px solid #2563eb; 
            padding-bottom: 12px; 
            margin-bottom: 16px; 
        }
        .header-table td { 
            vertical-align: middle; 
            padding: 0; 
            border: none; 
            background: none; 
        }
        .header-logo { 
            width: 100px; 
        }
        .header-title { 
            font-size: 15px; 
            font-weight: bold; 
            margin: 0 0 4px 0; 
        }
        .header-subtitle { 
            font-size: 10px; 
            color: #6b7280; 
            margin: 0; 
        }
        .employee-info {
            background-color: #f3f4f6;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .employee-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .employee-info td {
            padding: 4px 0;
            border: none;
        }
        .employee-info .label {
            font-weight: bold;
            width: 120px;
            color: #374151;
        }
        .employee-info .value {
            color: #1f2937;
        }
        .date-section {
            margin-bottom: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }
        .date-header {
            background-color: #2563eb;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 11px;
        }
        .accomplishment-list {
            padding: 0;
            margin: 0;
            list-style: none;
        }
        .accomplishment-item {
            padding: 10px 12px;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: flex-start;
        }
        .accomplishment-item:last-child {
            border-bottom: none;
        }
        .bullet {
            width: 6px;
            height: 6px;
            background-color: #3b82f6;
            border-radius: 50%;
            margin-right: 10px;
            margin-top: 5px;
            flex-shrink: 0;
        }
        .accomplishment-text {
            flex: 1;
            line-height: 1.5;
        }
        .no-data {
            text-align: center;
            color: #9ca3af;
            padding: 40px 20px;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 9px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 115px;">
                <img src="{{ public_path('images/bcda-removebg-preview.png') }}" class="header-logo">
            </td>
            <td>
                <p class="header-title">WFH Accomplishment Report</p>
                <p class="header-subtitle">Generated: {{ now()->format('F d, Y h:i A') }}</p>
                @if($accStartDate && $accEndDate)
                    <p class="header-subtitle">Period: {{ \Carbon\Carbon::parse($accStartDate)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($accEndDate)->format('M d, Y') }}</p>
                @elseif($accStartDate)
                    <p class="header-subtitle">From: {{ \Carbon\Carbon::parse($accStartDate)->format('M d, Y') }}</p>
                @elseif($accEndDate)
                    <p class="header-subtitle">Until: {{ \Carbon\Carbon::parse($accEndDate)->format('M d, Y') }}</p>
                @endif
            </td>
        </tr>
    </table>

    <div class="employee-info">
        <table>
            <tr>
                <td class="label">Employee Name:</td>
                <td class="value">{{ $employeeName }}</td>
            </tr>
            <tr>
                <td class="label">Position:</td>
                <td class="value">{{ $position ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Employee Number:</td>
                <td class="value">{{ $employeeNumber }}</td>
            </tr>
            <tr>
                <td class="label">Department:</td>
                <td class="value">{{ $department }}</td>
            </tr>
        </table>
    </div>

    @forelse($grouped as $dateKey => $data)
        <div class="date-section">
            <div class="date-header">
                {{ $data['date'] }}
            </div>
            <ul class="accomplishment-list">
                @foreach($data['items'] as $accomplishment)
                    <li class="accomplishment-item">
                        <span class="bullet"></span>
                        <span class="accomplishment-text">{{ $accomplishment }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @empty
        <div class="no-data">
            No accomplishments found for the selected period.
        </div>
    @endforelse

    <!-- Signatories Section -->
    <div style="margin-top: 60px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <!-- Employee Signature (Left) -->
                <td style="width: 50%; vertical-align: top; padding-right: 40px;">
                    <div style="text-align: left;">
                        <div style="margin-top: 40px; margin-bottom: 5px;">
                            <div style="border-bottom: 2px solid #000; padding-bottom: 2px; display: inline-block; min-width: 200px; text-align: center;">
                                <span style="font-size: 11px; font-weight: bold; text-transform: uppercase;">{{ strtoupper($employeeName) }}</span>
                            </div>
                        </div>
                        <div style="font-size: 10px; color: #374151; margin-top: 2px;">{{ $position ?? 'Employee' }}</div>
                        <div style="font-size: 10px; color: #6b7280;">{{ $department }}</div>
                    </div>
                </td>

                <!-- Department Signatory (Right) -->
                <td style="width: 50%; vertical-align: top; padding-left: 40px;">
                    @if(isset($signatories) && $signatories->count() > 0)
                        @php $signatory = $signatories->first(); @endphp
                        <div style="text-align: left;">
                            <div style="margin-top: 40px; margin-bottom: 5px;">
                                <div style="border-bottom: 2px solid #000; padding-bottom: 2px; display: inline-block; min-width: 200px; text-align: center;">
                                    <span style="font-size: 11px; font-weight: bold; text-transform: uppercase;">{{ strtoupper($signatory->employee->full_name ?? '') }}</span>
                                </div>
                            </div>
                            <div style="display: inline-block; min-width: 200px; text-align: left;">
                                <div style="font-size: 10px; color: #374151; margin-top: 2px; text-transform: uppercase;">{{ $signatory->position }}</div>
                                <div style="font-size: 10px; color: #6b7280;">{{ $signatory->department->title ?? '' }}</div>
                            </div>
                        </div>
                    @else
                        <div style="text-align: right;">
                            <div style="margin-top: 40px; margin-bottom: 5px;">
                                <div style="border-bottom: 2px solid #000; padding-bottom: 2px; display: inline-block; min-width: 200px; text-align: center;">
                                    <span style="font-size: 11px; font-weight: bold; text-transform: uppercase;">_____________________</span>
                                </div>
                            </div>
                            <div style="display: inline-block; min-width: 200px; text-align: left;">
                                <div style="font-size: 10px; color: #374151; margin-top: 2px; text-transform: uppercase;">Department Head</div>
                                <div style="font-size: 10px; color: #6b7280;">{{ $department }}</div>
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>© {{ now()->format('Y') }} ClockWize • Powered by the ICT Department – Bases Conversion and Development Authority</p>
    </div>
</body>
</html>
