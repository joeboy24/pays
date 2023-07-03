<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveSetup;
use App\Models\Employee;
use App\Models\Salary;
use App\Models\Bank;
use App\Models\SalaryCat;
use App\Models\Department;
use App\Models\AllowanceList;
use App\Models\Region;
use Session;

class HrpagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'hr_auth']);
    } 

    public function pay_leave()
    {
        // return Leave::where('del', 'no')->get();
        $patch = [
            'c' => 1,
            'leaveset' => LeaveSetup::find(1),
            'leaves' => Leave::where('del', 'no')->orderBy('id', 'DESC')->paginate(10)
        ];
        return view('dash.pay_leave')->with($patch);
    }

    public function pay_birthdays(){
        $bdays = Employee::where('dob', 'LIKE', '%'.date('-m-').'%')->paginate(10);
        $patch = [
            'c' => 1,
            'bdays' => $bdays
        ];
        return view('dash.pay_birthdays')->with($patch);
    }

    public function pay_add_emp(){

        $dept_count = Department::all()->count();
        if ($dept_count<1) {
            return redirect(url()->previous())->with('warning', 'Warning..! Add departments at settings to proceed');
        }

        // $users = User::where('status', '!=', 'Student')->get();
        $department = Department::orderBy('dept_name', 'ASC')->get();
        // $department = Employee::select('dept')->orderBy('dept', 'ASC')->distinct('dept')->get();
        $banks = Employee::select('bank')->orderBy('bank', 'ASC')->distinct('bank')->get();
        $banks2 = Bank::all();
        $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
        $position = SalaryCat::orderBy('position', 'ASC')->get();
        $title = SalaryCat::select('title')->orderBy('title', 'ASC')->distinct('title')->get();
        // $position = Employee::select('position')->orderBy('position', 'ASC')->distinct('position')->get();
        $sub_div = Employee::select('sub_div')->orderBy('sub_div', 'ASC')->distinct('sub_div')->get();
        $bank_branch = Employee::select('branch')->orderBy('branch', 'ASC')->distinct('branch')->get();
        $allowances = AllowanceList::orderBy('allow_name', 'ASC')->get();
        $patch = [
            'c' => 1,
            'banks' => $banks,
            'banks2' => $banks2,
            'regions' => $regions,
            'main_regions' => Region::all(),
            'position' => $position,
            'title' => $title,
            'department' => $department,
            'bank_branch' => $bank_branch,
            'allowances' => $allowances,
            'sub_div' => $sub_div,
        ];
        return view('dash.pay_addemployee')->with($patch);
    }
}
