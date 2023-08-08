<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'sender_id','user_id','employee_id','contact'
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
