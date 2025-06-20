<?php
namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
Use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
class ReportsExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    private int $rowNumber = 1;

    private function calculateResponseTime($response){
      $diffInMinutes = \Carbon\Carbon::parse($response->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($response->response_datetime));
      if ($diffInMinutes >= 60){ 
         return round($diffInMinutes / 60)." hours";
        }else{ 
        return round($diffInMinutes)." mins";
        } 
                                   
    }
    private function calculateResolveTime($response){
      $diffInMinutes = \Carbon\Carbon::parse($response->response_datetime)->diffInMinutes(\Carbon\Carbon::parse($response->resolve_datetime));
      if ($diffInMinutes >= 60){ 
         return round($diffInMinutes / 60)." hours";
        }else{ 
        return round($diffInMinutes)." mins";
        } 
                                   
    }
   public function collection()
    {
        return Report::whereIn('status', ['Done'])->get();
    }
    public function map($report): array
    {
        

        return [
            $this->rowNumber++, // Row number (starts at 1)
            Carbon::parse($report->response_datetime)->format('F j, Y h:i A'),
            $report->client->name, // you can also use $report->client->name if you have a client relation
            $report->department?->title ?? 'N/A',
            $report->issues->title,
            $this->calculateResponseTime($report),
            $this->calculateResolveTime($report),
            $report->resolve->user->name,
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'Request Date',
            'Name',
            'Department',
            'Issues',
            'Response Time',
            'Resolve Time',
            'Technical Staff'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Set font size and color for header row
        $sheet->getStyle('A1:K1')->applyFromArray([
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
        $sheet->getStyle('A2:K' . ($sheet->getHighestRow()))
              ->getFont()
              ->setSize(12);

        // Auto-size the columns
        foreach (range('A', 'K') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        return [];
    }
}