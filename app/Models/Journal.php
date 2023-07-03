<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','month','gross','ssf_emp','fuel_alw','back_pay','total_ssf','total_paye','advances','veh_loan','staff_loan','net_pay','debit','credit','status','del'
    ];

}
