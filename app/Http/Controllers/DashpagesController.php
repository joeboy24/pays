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
use Session;

class DashpagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'admin_auth']);
    } 

    public function alawa(Request $request){

        // Search Allowance
        $src = $request->input('search_alw');
        $allowances = Allowance::where('fname', 'LIKE', '%'.$src.'%')->orderBy('fname', 'ASC')->paginate(20);
        $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
        $patch = [
            'new_name' => '',
            'allowances' => $allowances,
            'new_allows' => AllowanceList::all(),
            'allowoverview' => $allowoverview
        ];
        return view('dash.pay_allowance')->with($patch);
    }

    public function pay_company(){
        $company = Company::find(1);
        return view('dash.pay_company')->with('company', $company);
    }

    public function pay_loan(){
        $em = Employee::find(1);

        // if ($em->loan) {
        //     return 1;
        // } else {
        //     return 2;
        // }
        // return $em->loan->id;

        // $users = User::where('status', '!=', 'Student')->get();
        $loan_setup = LoanSetup::where('del', 'no')->latest()->first();
        $employees = Employee::orderBy('fname', 'ASC')->paginate(20);
        $patch = [
            'c' => 1,
            'loans' => Loan::all(),
            'loanset' => $loan_setup,
            'employees' => $employees
        ];
        return view('dash.pay_loans')->with($patch);
    }

    public function pay_tax(){
        
        $taxation = Taxation::where('month', date('m-Y'))->paginate(50);
        $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
        if ($allowoverview == '') {
            return redirect(url()->previous())->with('warning', 'Oops..! Define Allowance Percentages to proceed -> Employee / Allowances / Allowance/SSNIT Overview');
        }
        $patch = [
            'c' => 1,
            'taxation' => $taxation,
            'tottax' => Taxation::where('month', date('m-Y'))->get(),
            'allowoverview' => $allowoverview
        ];
        return view('dash.pay_taxation')->with($patch);
    }

    public function pay_sal(){
        $salaries = Salary::where('month', date('m-Y'))->paginate(50);
        $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
        if ($allowoverview == '') {
            return redirect(url()->previous())->with('warning', 'Oops..! Define Allowance Percentages to proceed -> Employee / Allowances / Allowance/SSNIT Overview');
        }
        $patch = [
            'c' => 1,
            'salaries' => $salaries,
            'totsal' => Salary::where('month', date('m-Y'))->get(),
            'new_allows' => AllowanceList::all(),
            'allowoverview' => $allowoverview
        ];
        return view('dash.pay_salary')->with($patch);
    }

    public function pay_banksummary(){
        // $banks = Bank::where('del', 'no')->first();
        // return $banks;
        $salaries = Salary::where('month', date('m-Y'))->get();
        // return $salaries;
        $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
        $patch = [
            'c' => 1,
            'salaries' => $salaries,
            'banks' => Bank::all(),
            // 'banks' => $banks
        ];
        // return $salaries;
        return view('dash.pay_banksummary')->with($patch);
    }

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

    public function pay_add_dept(){

        $dept = Department::where('del', 'no')->orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'departments' => $dept,
        ];
        return view('dash.pay_department')->with($patch);
    }

    public function pay_adduser(){

        $users = User::orderBy('id', 'DESC')->paginate(20);
        $patch = [
            'c' => 1,
            'users' => $users,
        ];
        return view('dash.pay_adduser')->with($patch);
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

    public function pay_allowexp(){

        $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
        if ($allowoverview == '') {
            return redirect(url()->previous())->with('warning', 'Oops..! Define Allowance Percentages to proceed -> Employee / Allowances / Allowance/SSNIT Overview');
        }

        $allowexp = Allowexp::where('del', 'no')->orderBy('updated_at', 'DESC')->get();
        $patch = [
            'c' => 1,
            'allowexp' => $allowexp,
            'new_allows' => AllowanceList::all(),
            'employees' => Employee::where('del', 'no')->orderBy('fname', 'ASC')->get(),
        ];
        return view('dash.pay_allowexp')->with($patch);
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
