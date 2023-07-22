<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id','employee_id','leave_type','with_pay','start_date','end_date','resume_date','days','hand_over','file_scan','leave_notes','status'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

}
