<?php
  
namespace App\Imports;
  
use App\Models\User;
use App\Models\EmployeeRead;
use App\Models\SalaryCat;
use App\Models\TaxationRead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Session;
  
// class EmployeeImport implements ToModel, WithStartRow, WithCalculatedFormulas, WithMultipleSheets
class EmployeeImport implements ToModel, WithStartRow, WithCalculatedFormulas
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

    // public function sheets(): array
    // {
    //     return [
    //         0 => $this,
    //     ];
    // }
    
    public function model(array $row)
    {

        // $search = EmployeeRead::where('fullname', $row[3])->first();
        // $search->acc_no = $row[33];
        // $search->save();
        
        return new EmployeeRead([
            'user_id' => auth()->user()->id,
            // 'taxation_id' => $tx->id,
            // 'employee_id' => $emp->id,
            'staff_id' => $row[37],
            'afis_no' => $row[1],
            'fullname' => $row[2],
            'position' => $row[3],
            'salary' => $row[4],
            'ssf' => $row[5],
            'sal_aft_ssf' => $row[6],
            'rent' => $row[7],
            'prof' => $row[8],
            'taxable_inc' => $row[9],
            'income_tax' => $row[10],
            'net_aft_inc_tax' => $row[11],
            'resp' => $row[12],
            'risk' => $row[13],
            'vma' => $row[14],
            'ent' => $row[15],
            'dom' => $row[16],
            'intr' => $row[17],
            'tnt' => $row[18],
            'cola' => $row[19],
            'back_pay' => $row[20],
            'net_bef_ded' => $row[21],
            'std_loan' => $row[22],
            'staff_loan' => $row[23],
            'net_aft_ded' => $row[24],
            'ssf_emp_cont' => $row[25],
            'gross_sal' => $row[26],
            'tot_ded' => $row[27],
            'month' => $row[28],
            'ssn' => $row[29],
            'email' => $row[30],
            'dept' => $row[31],
            'region' => $row[32],
            'bank' => $row[33],
            'branch' => $row[34],
            'acc_no' => $row[41],
            'sub_div' => $row[36],
            'fname' => $row[42],
            'sname' => $row[43],
            'oname' => $row[44]
        ]);

    }
}