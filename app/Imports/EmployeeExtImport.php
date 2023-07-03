<?php
  
namespace App\Imports;
  
use App\Models\User;
use App\Models\SalaryCat;
use App\Models\EmployeeExtRead;
use App\Models\TaxationRead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Session;
  
// class EmployeeImport implements ToModel, WithStartRow, WithCalculatedFormulas, WithMultipleSheets
class EmployeeExtImport implements ToModel, WithStartRow, WithCalculatedFormulas
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

        // $search = EmployeeExt::where('fullname', $row[3])->first();
        // $search->acc_no = $row[33];
        // $search->save();
        // 'user_id','employee_id','maiden_fname','maiden_sname','maiden_oname','address','ssnit_no',
        // 'last_emp_place','lep_add','lep_phone','lep_pos','father','father_status','mother_status',
        // 'spouse','spouse_status','nok','nok_contact','del'
        
        return new EmployeeExtRead([
            'user_id' => auth()->user()->id,
            'staff_id' => $row[0],
            'tin' => $row[1],
            'fname' => $row[2],
            'dob' => str_replace("/","-",$row[3]),
            'date_emp' => str_replace("/","-",$row[5]),
            'gender' => $row[6],
            'prev_place' => $row[7],
            'cur_pos' => $row[8],
            'qual' => $row[9],
            'grade' => $row[10],
            'level' => $row[11],
            'step' => $row[12],
            'ssnit_no' => $row[13],
            'contact' => $row[14],
            'email' => $row[15],
        ]);

    }
}