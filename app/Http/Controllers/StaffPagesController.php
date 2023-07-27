<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryCat;
use App\Models\Salary;
use App\Models\Taxation;
use App\Models\Region;
use App\Models\Leave;
use App\Models\DirectPay;
use App\Models\Validation;
use App\Models\Department;
use App\Models\SMS;
use App\Models\SmsHistory;
use PDF;
use Mail;
use Session;

class StaffPagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'staff_auth']);
    } 

    public function index(){

        // if (Session::get('https') != 'https'){
        //     Session::put('https', 'https');
        //     return redirect('https://payroll.pivoapps.net');
        // }
        
        // $sals = Salary::where('month', '07-2023')->get();
        // foreach ($sals as $sal) {
        //     $sal->month = '06-2023';
        //     $sal->net_aft_ded = $sal->net_aft_ded - ($sal->net_aft_ded * 0.2);
        //     $sal->save();
        // }
        // $taxes = Taxation::where('month', '07-2023')->get();
        // foreach ($taxes as $tax) {
        //     $tax->month = '06-2023';
        //     $tax->net_aft_ded = $tax->net_amount - ($tax->net_amount * 0.1);
        //     $tax->save();
        // }
        // return 'Sal & Tax month change successful';

        $user = auth()->user();
        $cur_pay = Salary::where('employee_id', $user->employee->id)->latest()->first();
        if ($cur_pay->month == date('m-Y')) {
            $limit = 3;
        } else {
            $limit = 2;
        }
        
        $coworkers = Employee::where('region_id', $user->employee->region_id)->get();
        $pay_stubs = Salary::where('employee_id', $user->employee->id)->orderBy('id', 'DESC')->limit(3)->get();
        $leaves = Leave::where('employee_id', $user->employee_id)->orderBy('id', 'DESC')->limit(3)->get();
        // return $coworkers;

        $sends = [
            'limit' => $limit,
            'leaves' => $leaves,
            'coworkers' => $coworkers,
            'pay_stubs' => $pay_stubs,
        ];

        return view('worker.dashboard')->with($sends);
    }

    public function showProfile()
    {
        $emp = Employee::find(auth()->user()->employee_id);
        $send = [
            'emp' => $emp
        ];
        return view('worker.myprofile')->with($send);
    }

    public function staff_leave()
    {
        $user = auth()->user();
        $coworkers = Employee::where('region_id', $user->employee->region_id)->get();
        $leaves = Leave::where('employee_id', $user->employee_id)->orderBy('id', 'DESC')->limit(3)->get();
        // return $coworkers;

        $sends = [
            'leaves' => $leaves,
            'coworkers' => $coworkers,
        ];

        return view('worker.staff_leave')->with($sends);
    }

    public function staff_loans()
    {
        $user = auth()->user();
        // $coworkers = Employee::where('region_id', $user->employee->region_id)->get();
        $directpay = DirectPay::where('employee_id', $user->employee_id)->orderBy('id', 'DESC')->limit(3)->get();
        $sum_sal_pays = Salary::where('employee_id', $user->employee_id)->get();
        // return $coworkers;

        $sends = [
            'directpay' => $directpay,
            'sal_sum' => $sum_sal_pays,
            // 'coworkers' => $coworkers,
        ];

        return view('worker.staff_loans')->with($sends);
    }

    public function sal_validation(Request $request){

        if (auth()->user()->employee->reg_mgr != 'yes') {
            return redirect('/')->with('error', 'Oops..! Access denied.');
        }

        $src = $request->input('search_emp');
        $cvw = $request->input('change_view');
        $reg_id = auth()->user()->employee->region_id;
        $where = ['region_id' => $reg_id, 'del' => 'no'];
        if ($src) {
            $employees = Employee::where($where)->where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->paginate(20);
        } else {
            $employees = Employee::where($where)->orderBy('fname', 'ASC')->paginate(20);
        }
        
        // $users = User::where('status', '!=', 'Student')->get();
        if ($cvw && $cvw == 'all') {
            $mth = 'All';
            $vals = Validation::where('user_id', auth()->user()->id)->where('region_id', $reg_id)->orderBy('id', 'DESC')->paginate(10);
        } elseif ($cvw && $cvw != 'all') {
            $mth = $cvw;
            $vals = Validation::where('user_id', auth()->user()->id)->where('region_id', $reg_id)->where('month', $mth)->orderBy('id', 'DESC')->paginate(10);
        } else {
            $mth = date('01-m-Y');
            $vals = Validation::where('user_id', auth()->user()->id)->where('region_id', $reg_id)->where('month', $mth)->orderBy('id', 'DESC')->paginate(10);
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
            
        return view('dash.validation')->with($patch);
    }

    public function sendMailWithPDF(Request $request)
    {
        return view('pdf_mail');
        $emp = Employee::find(347);
        $sal = Salary::find(347);

        Session::put('month', date('M Y', strtotime('01-'.$sal->month)));
        Session::put('report_type', 'payslip');
        Session::put('employee', $emp);
        Session::put('payslip', $sal);

        $data["email"] = "mehear24@yahoo.com";
        $data["title"] = "Mail Check";
        $data["body"] = "This is a live send mail check 01";

        Session::put('trys', 'Just Trying 05');
        // return session('trys');
        // $pdf = PDF::loadView('worker.staff_payslip', $data);
        $pdf = PDF::loadView('pdf_mail', $data);


        return $pdf->download('Payslip_June-23.pdf');
        Mail::send('pdf_mail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "Payslip_June-2023.pdf");
        });

        // echo "email send successfully !!";
        dd('Mail sent successfully');
    }

    public function bulk_sms()
    {

        // return $msg;

        Session::put('send01', 0);
        $sends = [
            'c' => 1,
            'sms' => SMS::all(),
            'sms_history' => SmsHistory::all(),
            'department' => Department::all(),
            // 'coworkers' => $coworkers,
        ];

        return view('dash.pay_bulksms')->with($sends);
    }

}
