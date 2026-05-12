<?php

namespace App\Imports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ReportsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Report([
            
            'issues_id' => $row['issues_id'],
            'status' => $row['status'] ?? 'Pending',
            'procedure' => $row['procedure'] ?? null,
            'request_datetime' => isset($row['request_datetime']) ? Carbon::parse($row['request_datetime']) : now(),
            'response_datetime' => isset($row['response_datetime']) ? Carbon::parse($row['response_datetime']) : null,
            'validation_date_time' => isset($row['validation_date_time']) ? Carbon::parse($row['validation_date_time']) : null,
            'survey_employees_id' => function ($row) {
                    $employee = \App\Models\SurveyEmployee::where('email', $row['email'])->first();
                    return $employee ? $employee->id : null;
            },
            'department_id' => function ($row) {
                    $department = \App\Models\SurveyEmployee::where('email', $row['email'])->first();
                    return $department ? $department->department_id : null;
            }
        ]);
    }
}
