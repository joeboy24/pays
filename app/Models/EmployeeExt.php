<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeExt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','employee_id','maiden_fname','maiden_sname','maiden_oname','address','ssnit_no',
        'last_emp_place','lep_add','lep_phone','lep_pos','father','father_status','mother_status',
        'spouse','spouse_status','nok','nok_contact','del'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }
}
