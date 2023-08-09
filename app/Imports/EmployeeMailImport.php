<?php
  
namespace App\Imports;
  
use App\Models\User;
use App\Models\SalaryCat;
use App\Models\Extend2;
use App\Models\TaxationRead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Session;
  
// class EmployeeImport implements ToModel, WithStartRow, WithCalculatedFormulas, WithMultipleSheets
class EmployeeMailImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 2;
    }
    
    public function model(array $row)
    {
        
        return new Extend2([
            'user_id' => auth()->user()->id,
            'staff_id' => $row[0],
            // 'tin' => $row[1],
            'fname' => $row[1],
            // 'dob' => str_replace("/","-",$row[18]),
            // 'date_emp' => str_replace("/","-",$row[19]),
            // 'gender' => $row[7],
            // 'prev_place' => $row[8],
            // 'pos' => $row[9],
            // 'cur_pos' => $row[10],
            'qual' => $row[3],
            // 'qual' => $row[12],
            // 'grade' => $row[13],
            // 'level' => $row[14],
            // 'step' => $row[15],
            // 'ssnit_no' => $row[16],
            'contact' => $row[2],
            // 'leave_bal' => $row[20],
            // 'email' => $row[17],
        ]);

    }
}