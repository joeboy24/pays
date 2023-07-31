<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extend2 extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','staff_id','tin','fname','sname','oname','dob','date_emp','gender','prev_place',
        'pos','cur_pos','qual','grade','level','step','ssnit_no','contact','email','del'
    ];
}
