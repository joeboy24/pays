<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extend extends Model 
{
    use HasFactory;

    protected $fillable = [
        'user_id','staff_id','tin','fname','sname','oname','dob','date_emp','gender','prev_place',
        'pos','cur_pos','qual','grade','level','step','ssnit_no','contact','email','leave_bal','del'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function empext(){
        return $this->belongsTo('App\Models\EmployeeExt');
    }
}
