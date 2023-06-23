<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanGrant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','employee_id','loan_amt','monthly_dud','dur','loan_type','status','del'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }
}
