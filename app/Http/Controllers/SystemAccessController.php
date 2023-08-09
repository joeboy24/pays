<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Department;
use Spatie\Activitylog\Models\Activity;
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

    public function pay_adduser(Request $request){
        $src = $request->input('search_emp');
        if ($src) {
            // return 1;
            $employees = Employee::where('fullname', 'LIKE', '%'.$src.'%')->orwhere('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->get();
            // return $src;
            $users = User::query();
            foreach($employees as $txt){
                $users->orWhere('name', 'LIKE', '%'.$txt->fname.'%');
            }
            $users = $users->distinct()->orderBy('id', 'DESC')->paginate(20);
            // return $users;
        } else {
            $users = User::orderBy('id', 'DESC')->paginate(20);
            // return count($users);
        }

        $patch = [
            'c' => 1,
            'users' => $users,
        ];
        return view('dash.pay_adduser')->with($patch);
    }

    public function pay_activities(){

        // $dept = Department::where('del', 'no')->orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'activities' => Activity::where('log_name', '!=', '')->orderBy('id', 'DESC')->paginate(20),
        ];
        return view('dash.pay_activity')->with($patch);
    }
}
