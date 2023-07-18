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
use App\Models\Journal;
use PDF;
use Mail;
use Session;

class FinancePagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'finance_auth']);
    } 

    public function pay_allowance(Request $request){

        $src = $request->input('search_alw');

        // if ($src) {
        //     // return 1;
        //     $employees = Employee::where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->get();
        //    // return $src;
        //     $allowances = Allowance::query();
        //     foreach($employees as $txt){
        //         $allowances->orWhere('fname', $txt->fname);
        //     }
        //     $allowances = $allowances->distinct()->orderBy('fname', 'ASC')->paginate(20);

        // } else {
        //     $allowances = Allowance::orderBy('fname', 'ASC')->paginate(20);
        // }
        // // return $allowances;

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

    public function pay_tax(){
        
        $taxation = Taxation::where('month', date('m-Y'))->orderBy('id', 'DESC')->paginate(50);
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

    public function pay_sal(Request $request){
        $src = $request->input('search_emp');
        if ($src) {
            // return 1;
            $employees = Employee::where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->get();
            // return $src;
            $salaries = Salary::query();
            foreach($employees as $txt){
                $salaries->orWhere('acc_no', 'LIKE', '%'.$txt->acc_no.'%');
            }
            $salaries = $salaries->distinct()->orderBy('id', 'DESC')->paginate(50);
            // return $salaries;
        } else {
            $salaries = Salary::where('month', date('m-Y'))->orderBy('id', 'DESC')->paginate(50);
            // return count($salaries);
        }

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

    public function pay_sal_jv(){

        $jv = Journal::where('month', date('m-Y'))->latest()->first();
        // return $jv;
        $patch = [
            'jv' => $jv,
        ];
        return view('dash.pay_salary_jv')->with($patch);
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

    public function pay_loan(Request $request){

        $src = $request->input('search_emp');
        if ($src) {
            $employees = Employee::where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->paginate(20);
        } else {
            $employees = Employee::orderBy('fname', 'ASC')->paginate(20);
        }
        
        
        // $em = Employee::find(1);
        // if ($em->loan) {
        //     return 1;
        // } else {
        //     return 2;
        // }
        // return $em->loan->id;

        // $users = User::where('status', '!=', 'Student')->get();
        $loan_setup = LoanSetup::where('del', 'no')->latest()->first();
        $patch = [
            'c' => 1,
            'loans' => Loan::all(),
            'loanset' => $loan_setup,
            'employees' => $employees
        ];
        return view('dash.pay_loans')->with($patch);
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

    public function mail_send(Request $request){

        // $emp = Employee::find(347);


        // $sals = Salary::where('month', date('m-Y'))->get();
        // foreach ($sals as $sal) {
        // }
        $emps = Employee::all();
        // Session::put('ctt', 0);
        // // return $emps->count();
        // return view('worker.staff_payslip');
        
        foreach ($emps as $emp) {
            $sal = Salary::where('employee_id', $emp->id)->latest()->first();
            Session::put('ctt', session('ctt') + 1);
            Session::put('month', date('M Y', strtotime('01-'.$sal->month)));
            Session::put('report_type', 'payslip');
            Session::put('employee', $emp);
            Session::put('payslip', $sal);

            if ($emp->email) {
                $data["email"] = $emp->email;
                $data["title"] = "Masloc Payslip-".date('M-Y');
                $data["body"] = "This is a live send mail check 27";

                $pdf = PDF::loadView('pdf_mail', $data);
                // $pdf = PDF::loadView('pdf_mail', ['Data' => $data])->setOptions(['defaultFont' => 'sans-serif']);
                // $pdf = PDF::loadView('worker.staff_payslip', $data);

                // Mail::send('worker.staff_payslip', $data, function ($message) use ($data, $pdf) {
                Mail::send('pdf_mail', $data, function ($message) use ($data, $pdf) {
                    $message->to($data["email"], $data["email"])
                        ->subject($data["title"])
                        ->attachData($pdf->output(), "Payslip-".date('M-Y-').".pdf");
                });
            }
            
        }
        // ->attachData($pdf->output(), "Payslip-".date('M-Y-').$emp->fname.$emp->staff_id.".pdf");

        return redirect(url()->previous())->with('success', 'Mail forwarding successful');
        // return session('ctt');
        dd('Mail sent successfully');
    }
}
