<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','employee_id','region_id','comments','month','status','del'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function region(){
        return $this->belongsTo('App\Models\Region');
    }
}
