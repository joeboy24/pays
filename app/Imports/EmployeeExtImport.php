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
class EmployeeExtImport implements ToModel, WithStartRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function startRow(): int
    {
        return 4;
    }
    
    public function model(array $row)
    {

        // $search = EmployeeExt::where('fullname', $row[3])->first();
        // $search->acc_no = $row[33];
        // $search->save();
        // 'user_id','employee_id','maiden_fname','maiden_sname','maiden_oname','address','ssnit_no',
        // 'last_emp_place','lep_add','lep_phone','lep_pos','father','father_status','mother_status',
        // 'spouse','spouse_status','nok','nok_contact','del'
        
        return new Extend2([
            'user_id' => auth()->user()->id,
            'staff_id' => $row[2],
            // 'tin' => $row[1],
            'fname' => $row[3],
            'dob' => str_replace("/","-",$row[18]),
            'date_emp' => str_replace("/","-",$row[19]),
            'gender' => $row[7],
            'prev_place' => $row[8],
            'pos' => $row[9],
            'cur_pos' => $row[10],
            'program' => $row[11],
            'qual' => $row[12],
            'grade' => $row[13],
            'level' => $row[14],
            'step' => $row[15],
            'ssnit_no' => $row[16],
            'contact' => $row[17],
            // 'email' => $row[17],
        ]);

    }
}