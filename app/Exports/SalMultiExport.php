<?php

namespace App\Exports;
use App\Exports\Sheets\SalaryPerTable;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SalMultiExport implements WithMultipleSheets
{
    use Exportable;

    protected $month;
    
    public function __construct(string $month)
    {
        $this->month = $month;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        for ($i = 1; $i <= 4; $i++) {
            $tbl = session('tbl')[$i-1];
            $sheets[] = new SalaryPerTable($this->month, $tbl);
        }

        return $sheets;
    }
}
