<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saledit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'month', 'taxation_id', 'employee_id', 'position', 'salary', 'ssf', 'sal_aft_ssf', 'rent', 'prof', 'taxable_inc',
        'income_tax', 'net_aft_inc_tax', 'resp', 'risk', 'vma', 'ent', 'dom', 'intr', 'tnt', 'cola', 'back_pay', 'net_bef_ded', 'std_loan', 'staff_loan',
        'staff_loan', 'net_aft_ded', 'ssf_emp_cont', 'gross_sal', 'tot_ded', 'ssn', 'email', 'dept', 'region', 'bank', 'branch', 'acc_no', 'new1', 'new2', 'new3', 'new4', 'new5',
    ];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function taxation(){
        return $this->belongsTo('App\Models\Taxation');
    }
}
