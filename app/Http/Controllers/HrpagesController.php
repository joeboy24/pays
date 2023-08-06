<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveSetup;
use App\Models\Employee;
use App\Models\Extend;
use App\Models\Salary;
use App\Models\Bank;
use App\Models\SalaryCat;
use App\Models\Department;
use App\Models\Allowance;
use App\Models\AllowanceList;
use App\Models\AllowanceOverview;
use App\Models\Region;
use Session;

class HrpagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'load_auth', 'hr_auth']);
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

    public function pay_retirement(Request $request){

        if ($request->input('date_filter')) {
        //     $yr = date('Y', strtotime($request->input('date_filter')));
            $yrs = 60 - $request->input('date_filter');
        }else {
            $yrs = 55;
        }
        // return $yrs;
        // $yr = date('Y') - 60;
        // $yr = $yr.'-01-03';
        // return date('01-02-').$yr;
        // $bdays = Employee::where('created_at', '<=', '2023-07-03')->paginate(10);
        // return $bdays;
        $retirements = Employee::where('del', 'no')->get();
        // return $retirements[0]->extend->dob;
        $patch = [
            'c' => 1,
            'yrs' => $yrs,
            'retirements' => $retirements
        ];
        return view('dash.pay_retirement')->with($patch);
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

    public function pay_sal_cat(){

        $bs = 500;
        $emps = Employee::select(['position', 'sub_div'])->distinct('position')->get();
        for ($i=0; $i < count($emps); $i++) { 
            // foreach ($emps as $emp) {
            if ($i % 4 == 0) {
                $bs = $bs * 1.1;
            }
            
            $salcat = SalaryCat::firstOrCreate([
                'user_id' => auth()->user()->id,
                'title' => $emps[$i]->sub_div,
                'position' => $emps[$i]->position,
                'basic_sal' => $bs,
            ]);
        }
        $ttsalarycat = SalaryCat::select('title')->orderBy('title', 'ASC')->distinct('title')->get();
        $possalarycat = SalaryCat::select('position')->distinct('position')->orderBy('position', 'ASC')->get();
        $salarycat = SalaryCat::where('del', 'no')->orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'salarycat' => $salarycat,
            'ttsalarycat' => $ttsalarycat,
            'possalarycat' => $possalarycat,
        ];
        return view('dash.pay_salary_cat')->with($patch);
    }

    public function pay_allowance_mgt(){

        $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
        if ($allowoverview == '') {
            return redirect(url()->previous())->with('warning', 'Oops..! Define Allowance Percentages to proceed -> Employee / Allowances / Allowance/SSNIT Overview');
        }

        $allow = AllowanceList::where('del', 'no')->orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'allowance' => $allow,
        ];
        return view('dash.pay_allowancemgt')->with($patch);
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
