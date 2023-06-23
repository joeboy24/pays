<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectPay extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','employee_id','amt_paid','amt_rem','desc','monthly_dud','del'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }
}
