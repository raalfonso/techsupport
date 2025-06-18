<?php
namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportsExport implements FromCollection
{
   public function collection()
    {
        return Report::select('ticket_number', 'client_id', 'department_id')->get();
    }

    public function headings(): array
    {
        return [
            'Ticket Number',
            'Name',
            'Department',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set font size and color for header row
        $sheet->getStyle('A1:C1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4F81BD'],
            ],
        ]);

        // Set font size for all data rows
        $sheet->getStyle('A2:C' . ($sheet->getHighestRow()))
              ->getFont()
              ->setSize(12);

        // Auto-size the columns
        foreach (range('A', 'C') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}