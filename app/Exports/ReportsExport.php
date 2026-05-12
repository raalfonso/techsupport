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
    private $filters;
    private $responseRatings = [];
    private $resolveRatings = [];

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

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

    //this is for the rating
     private function calculateResponse($response){
      $diffInMinutes = \Carbon\Carbon::parse($response->request_datetime)->diffInMinutes(\Carbon\Carbon::parse($response->response_datetime));
      if ($diffInMinutes >= 60){ 
         return round($diffInMinutes / 60);
        }else{ 
        return round($diffInMinutes);
        } 
                                   
    }
    private function calculateResolve($response){
      $diffInMinutes = \Carbon\Carbon::parse($response->response_datetime)->diffInMinutes(\Carbon\Carbon::parse($response->resolve_datetime));
      if ($diffInMinutes >= 60){ 
         return round($diffInMinutes / 60);
        }else{ 
        return round($diffInMinutes);
        }                          
    }
    
    public function collection()
    {
        $query = Report::whereIn('status', ['Done']);
        
        // Apply filters
        if (!empty($this->filters['date_from'])) {
            $query->whereDate('resolve_datetime', '>=', $this->filters['date_from']);
        }
        
        if (!empty($this->filters['date_to'])) {
            $query->whereDate('resolve_datetime', '<=', $this->filters['date_to']);
        }
        
        if (!empty($this->filters['department_id'])) {
            $query->where('department_id', '=', $this->filters['department_id']);
        }
        
        if (!empty($this->filters['category_id'])) {
            $query->whereHas('Issues', function($q) {
                $q->where('category_id', '=', $this->filters['category_id']);
            });
        }
        
        if (!empty($this->filters['user_id'])) {
            $query->whereHas('resolve', function($q) {
                $q->where('user_id', '=', $this->filters['user_id']);
            });
        }
        
        $reports = $query->get();
        
        // Calculate ratings for all reports first
        foreach ($reports as $report) {
            $this->responseRatings[] = $this->computingResponseTime($this->calculateResponse($report));
            $this->resolveRatings[] = $this->computingResolvedTime($this->calculateResolve($report), $report->issues->resolution_timeline);
        }
        
        // Add average row
        if (!$reports->isEmpty()) {
            $avgResponse = round(array_sum($this->responseRatings) / count($this->responseRatings), 2);
            $avgResolve = round(array_sum($this->resolveRatings) / count($this->resolveRatings), 2);
            
            $reports->push((object)[
                'avg_response' => $avgResponse,
                'avg_resolve' => $avgResolve
            ]);
        }
        
        return $reports;
    }

    private function computingResponseTime($actualResponsedTime){
        $planned = 5;
        
        if ($actualResponsedTime <= $planned * 0.70) {
            return 5;
        } elseif ($actualResponsedTime <= $planned * 0.85) {
            return 4;
        } elseif ($actualResponsedTime <= $planned * 1.14) {
            return 3;
        } elseif ($actualResponsedTime <= $planned * 1.89) {
            return 2;
        } else {
            return 1;
        }

    }
     private function computingResolvedTime($actualResolvedTime,$planned){
        
        if ($actualResolvedTime <= $planned * 0.70) {
            return 5;
        } elseif ($actualResolvedTime <= $planned * 0.85) {
            return 4;
        } elseif ($actualResolvedTime <= $planned * 1.14) {
            return 3;
        } elseif ($actualResolvedTime <= $planned * 1.89) {
            return 2;
        } else {
            return 1;
        }

    }
    
    public function map($report): array
    {
        // Handle average row
        if (isset($report->avg_response)) {
            return [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'AVERAGE:',
                $report->avg_response,
                $report->avg_resolve,
            ];
        }
        
        $responseRating = $this->computingResponseTime($this->calculateResponse($report));
        $resolveRating = $this->computingResolvedTime($this->calculateResolve($report),$report->issues->resolution_timeline);

        return [
            $this->rowNumber++,
            Carbon::parse($report->response_datetime)->format('F j, Y h:i A'),
            $report->client->name,
            $report->department?->title ?? 'N/A',
            $report->issues->title,
            $this->calculateResponseTime($report),
            $this->calculateResolveTime($report),
            $report->resolve->user->name,
            $responseRating,
            $resolveRating,
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'Requested Date',
            'Name',
            'Department',
            'Issues',
            'Responsed Time',
            'Resolved Time',
            'Technical Staff',
            'Responsed Rating',
            'Resolved Rating',
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