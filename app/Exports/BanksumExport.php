<?php

namespace App\Exports;

use App\Models\Bank;
use App\Models\Salary;
use App\Models\AllowanceOverview;
// use Maatwebsite\Excel\Concerns\FromArray;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
// use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
// use Session;

// namespace App\Exports;

// use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class BanksumExport implements FromView, WithColumnWidths, WithEvents
{
    public function view(): View
    {
        return view('dash.banksumexp', [
            'c' => 1,
            'salaries' => Salary::where('month', date('m-Y'))->get(),
            'allowoverview' => AllowanceOverview::where('del', 'no')->latest()->first(),
            'banks' => Bank::all()
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,    
            'C' => 30,    
            'D' => 30,    
            'E' => 30,    
            'F' => 30,    
            'G' => 30,      
            // 'Q' => 30,       
        ];
    }

    public function registerEvents() : array
    {
        $sc = Salary::count();
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(10);
                // $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(20);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(30);     
                
                $event->sheet->getDelegate()->getStyle('1:1000')->getFont()->setSize(13);
                // $event->sheet->getDelegate()->getRowDimension('1:700')->setRowHeight(20);
                $event->sheet->getDelegate()->getStyle('A1:F1')->getFont()->setBold(true);
            }
        ];
    }

}

