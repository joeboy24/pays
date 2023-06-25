<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryCat;
use App\Models\Region;
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

        return view('worker.dashboard');
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
        $data["email"] = "durogh24@gmail.com";
        $data["title"] = "Laravel 8 send email with attachment - Techsolutionstuff";
        $data["body"] = "Laravel 8 send email with attachment";

        $pdf = PDF::loadView('pdf_mail', $data);

        Mail::send('pdf_mail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "test.pdf");
        });

        echo "email send successfully !!";
    }

}
