<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\Imports\TaxationImport;
use App\Models\Employee;
use App\Models\EmployeeRead;
use App\Models\EmployeeExtRead;
use App\Models\Allowance;
use App\Models\AllowanceOverview;
use App\Models\TaxationRead;
use App\Models\Taxation;
use App\Models\Salary;
use App\Models\Bank;
use App\Models\Loan;
use App\Models\User;
use App\Models\Leave;
use App\Models\Region;
use App\Models\LoanSetup;
use App\Models\SalaryCat;
use App\Models\AllowanceList;
use Session;
use DateTime;

class GeneralController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'general_auth']);
    }  
    
    public function index(){

        // if (Session::get('https') != 'https'){
        //     Session::put('https', 'https');
        //     return redirect('https://payroll.pivoapps.net');
        // }


        // $ext = EmployeeExtRead::find(1);

        // $dob = date('d-m-Y', strtotime($ext->dob));
        // // // $dt_diff = (strtotime(date('d-m-Y'))-strtotime($dob)) / (60 * 60 * 24);
        // // // return ($dt_diff / 30) / 12;

        // // $age = date_diff(date_create($dob), date_create(date('d-m-Y')))->y;
        // $age = date_diff(date_create(date('d-m-Y', strtotime($ext->dob))), date_create(date('d-m-Y')))->y;
        // return $age;
        
        // $date = new DateTime($dob);
        // $now = new DateTime(date('d-m-Y'));
        // $interval = $now->diff($date);
        // return $ext->dob.' Age: '.$interval->y;
        // return date('M-Y', strtotime(date('Y-m')." -1 month"));

        // $salary = Salary::where('month', '07-2023')->get();
        // foreach ($salary as $key => $value) {
        //     $premo = Salary::select(['net_aft_ded'])->where('employee_id', $salary[$key]['employee_id'])->where('month', '06-2023')->latest()->first();
        //     return $premo->net_aft_ded;
        // }

        
        $system_users = User::where('del', 'no')->count();
        $emp_count = Employee::where('del', 'no')->count();
        $leave_count = Leave::where('status', 'active')->count();
        $sal_sum = Salary::where('del', 'no')->sum('net_aft_ded');
        $bday_count = Employee::where('dob', 'LIKE', '%'.date('-m-').'%')->count();
        // return $bday_count;

        Session::put('system_users', $system_users);
        Session::put('emp_count', $emp_count);
        Session::put('leave_count', $leave_count);
        Session::put('sal_sum', number_format($sal_sum, 2));
        Session::put('bday_count', $bday_count);

        return view('dash.pay_dashboard');
    }
    
    public function pay_employee(){
        return view('dash.pay_employee');
    }





    public function show_admi_profile()
    {
        $emp = Employee::find(auth()->user()->employee_id);
        $send = [
            'emp' => $emp
        ];
        return view('worker.myprofile')->with($send);
    }

    public function pay_employee_view(){
        if (auth()->user()->status == 'System') {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied!');
        }
        // $users = User::where('status', '!=', 'Student')->get();
        $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
        $position = SalaryCat::orderBy('position', 'ASC')->get();
        $employees = Employee::orderBy('fname', 'ASC')->paginate(20);
        $patch = [
            'c' => 1,
            'regions' => $regions,
            'main_regions' => Region::all(),
            'position' => $position,
            'employees' => $employees
        ];
        return view('dash.pay_employee_view')->with($patch);
    }

    public function pay_reports(){
        // $users = User::where('status', '!=', 'Student')->get();
        $loan_setup = LoanSetup::where('del', 'no')->latest()->first();
        $employees = Employee::orderBy('fname', 'ASC')->get();
        $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
        $banks = Employee::select('bank')->orderBy('bank', 'ASC')->distinct('bank')->get();
        $patch = [
            'c' => 1,
            'banks' => $banks,
            'regions' => $regions,
            'loanset' => $loan_setup,
            'employees' => $employees
        ];
        return view('dash.pay_reports')->with($patch);
    }
}
