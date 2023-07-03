<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Faqs;
use App\Models\User;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Allowance;
use App\Models\EmployeeRead;
use App\Models\AllowanceOverview;
use App\Models\TaxationRead;
use App\Models\Taxation;
use App\Models\Salary;
use App\Models\Bank;
use App\Models\Loan;
use App\Models\LoanSetup;
use App\Models\SalaryCat;
use App\Models\Department;
use App\Models\AllowanceList;
use App\Models\Region;
use App\Models\Allowexp;
use App\Models\Validation;
use Session;

class DashpagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'admin_auth']);
    } 
 
    // public function pay_company(){
    //     $company = Company::find(1);
    //     return view('dash.pay_company')->with('company', $company);
    // }

    public function emp_report(){
        $send = [
            'c' => 1,
            'tax' => 44205.05,
            'from' => date('D, d-M-Y'),
            'to' => date('D, d-M-Y'),
            'report_type' => 'employee',
            'cur_date' => date('D, d-M-Y'),
            // 'region' => Region::all(),
            'query_region' => 'Ashanti',
            'employees' => Employee::all(),
        ];
        return view('dash.pay_emp_report')->with($send);
    }

    public function staff_validation(Request $request){

        $src = $request->input('search_emp');
        $cvw = $request->input('change_view');
        $reg_id = auth()->user()->employee->region_id;
        $where = ['del' => 'no'];
        if ($src) {
            $employees = Employee::where($where)->where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->paginate(20);
        } else {
            $employees = Employee::where($where)->orderBy('fname', 'ASC')->paginate(20);
        }
        
        // $users = User::where('status', '!=', 'Student')->get();
        if ($cvw && $cvw == 'all') {
            $mth = 'All';
            $vals = Validation::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->paginate(10);
        } elseif ($cvw && $cvw != 'all') {
            $mth = $cvw;
            $vals = Validation::where('user_id', auth()->user()->id)->where('month', $mth)->orderBy('id', 'DESC')->paginate(10);
        } else {
            $mth = date('01-m-Y');
            $vals = Validation::where('user_id', auth()->user()->id)->where('month', $mth)->orderBy('id', 'DESC')->paginate(10);
        }
        
        $val_check = Validation::select('employee_id')->where('user_id', auth()->user()->id)->where('month', date('01-m-Y'))->get();
        $patch = [
            'c' => 1,
            'mth' => $mth,
            'main_regions' => Region::all(),
            'validation' => $vals,
            'val_check' => $val_check,
            'employees' => $employees
        ];
        
        // if ($val_check->contains('employee_id', '187') == true) {
        //     return 1;
        // }else{
        //     return 0;
        // }
        // return $val_check;
            
        return view('dash.pay_validation')->with($patch);
    }






















 
    public function index(){
        $patch = [
            'exam' => 'none'
        ];
        return view('dash.index')->with($patch);
    }

    public function programs_course_reg(){
        $patch = [
            'departments' => Department::all(),
            'programs' => Program::orderBy('program_name', 'ASC')->paginate(10),
            'courses' => Course::orderBy('id', 'DESC')->paginate(10),
        ];
        return view('dash.programs_course_reg')->with($patch);
        // return view('dash.addstaff');
    }

    public function companysetup(){
        $company = Company::all();
        return view('dash.companysetup')->with('company', $company);
    }

    public function dbase(){
        return view('dash.databasetbl');
    }



    

}
