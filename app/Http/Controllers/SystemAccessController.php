<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Department;
use Session;

class SystemAccessController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'system_auth']);
    } 

    public function pay_company(){
        $company = Company::find(1);
        return view('dash.pay_company')->with('company', $company);
    }

    public function pay_adduser(){

        $users = User::orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'users' => $users,
        ];
        return view('dash.pay_adduser')->with($patch);
    }

    public function pay_add_dept(){

        $dept = Department::where('del', 'no')->orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'departments' => $dept,
        ];
        return view('dash.pay_department')->with($patch);
    }
}
