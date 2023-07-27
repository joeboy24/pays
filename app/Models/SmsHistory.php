<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','message','sent_to','pin'
    ];
 
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
