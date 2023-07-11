<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions; 

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'staff_id',
        'name',
        'email',
        'contact',
        'password',
        'temp_pass',
        'otp_time',
        'status',
        'pass_photo',
        'del', 
    ];
    protected static $logAttributes = [
        'name',
        'email',
        'contact',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])->logOnlyDirty();
        // Chain fluent methods for configuration options
    }

    public function staff(){
        return $this->belongsTo('App\Models\Staff');
    }

    public function student(){
        return $this->belongsTo('App\Models\Student');
    }

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }
    
}
