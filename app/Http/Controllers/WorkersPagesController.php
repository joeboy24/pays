<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryCat;
use App\Models\Salary;
use App\Models\Region;
use App\Models\Leave;
use App\Models\Validation;
use PDF;
use Mail;
use Session;

class WorkersPagesController extends Controller
{
    //
    public function __construct(){
        $this->middleware(['auth', 'admin_auth']);
    } 

    public function index(){

        // if (Session::get('https') != 'https'){
        //     Session::put('https', 'https');
        //     return redirect('https://payroll.pivoapps.net');
        // }
        // $sals = Salary::all();
        // foreach ($sals as $sal) {
        //     $sal->month = '05-2023';
        //     $sal->save();
        // }
        // return 'Sal. month change successful';

        $user = auth()->user();
        $cur_pay = Salary::where('employee_id', $user->employee->id)->latest()->first();
        if ($cur_pay->month == date('m-Y')) {
            $limit = 3;
        } else {
            $limit = 2;
        }
        
        $coworkers = Employee::where('region_id', $user->employee->region_id)->get();
        $pay_stubs = Salary::where('employee_id', $user->employee->id)->orderBy('id', 'DESC')->limit(3)->get();
        $leaves = Leave::where('employee_id', $user->employee->id)->orderBy('id', 'DESC')->limit(3)->get();
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
        $leaves = Leave::where('employee_id', $user->employee->id)->orderBy('id', 'DESC')->limit(3)->get();
        // return $coworkers;

        $sends = [
            'leaves' => $leaves,
            'coworkers' => $coworkers,
        ];

        return view('worker.staff_leave')->with($sends);
    }

    public function sal_validation(Request $request){

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
        $data["email"] = "mehear24@yahoo.com";
        $data["title"] = "Mail Check";
        $data["body"] = "This is a live send mail check 01";

        Session::put('trys', 'Just Trying 05');
        // return session('trys');
        $pdf = PDF::loadView('pdf_mail', $data);

        Mail::send('pdf_mail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "Payslip_June-2023.pdf");
        });

        // echo "email send successfully !!";
        dd('Mail sent successfully');
    }

}
