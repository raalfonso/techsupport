<?php

namespace App\Exports;

use App\Models\EmployeeMasterlist;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private int $rowNumber = 1;
    private $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = EmployeeMasterlist::with('department');

        // Only export active employees
        $query->where('employment_status', 'Active');

        // Apply filters
        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('employee_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('middle_name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhereRaw("CONCAT(first_name, ' ', middle_name, ' ', last_name) LIKE ?", ["%{$search}%"]);
            });
        }

        if (!empty($this->filters['department'])) {
            $query->where('department_id', $this->filters['department']);
        }

        if (!empty($this->filters['type'])) {
            $query->where('employment_type', $this->filters['type']);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            '#',
            'Employee Number',
            'Full Name',
            'First Name',
            'Middle Name',
            'Last Name',
            'Position',
            'Department',
            'Place of Assignment',
            'Date Hired',
            'Employment Status',
            'Employment Type',
            'Email',
            'Remarks'
        ];
    }

    public function map($employee): array
    {
        return [
            $this->rowNumber++,
            $employee->employee_number,
            $employee->full_name,
            $employee->first_name,
            $employee->middle_name ?? '',
            $employee->last_name,
            $employee->position,
            $employee->department?->title ?? 'N/A',
            $employee->place_of_assignment ?? '',
            $employee->date_hired ? $employee->date_hired->format('Y-m-d') : '',
            $employee->employment_status,
            $employee->employment_type,
            $employee->email,
            $employee->remarks ?? ''
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
