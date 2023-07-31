<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeImport;
use App\Imports\TaxationImport;
use App\Models\Employee;
use App\Models\EmployeeRead;
use App\Models\Extend;
use App\Models\Extend2;
use App\Models\Allowexp;
use App\Models\Allowance;
use App\Models\AllowanceList;
use App\Models\AllowanceOverview;
use App\Models\TaxationRead;
use App\Models\Taxation;
use App\Models\Saledit;
use App\Models\Salary;
use App\Models\Bank;
use App\Models\Loan;
use App\Models\User;
use App\Models\SMS;
use App\Models\Leave;
use App\Models\Region;
use App\Models\LoanSetup;
use App\Models\SalaryCat;
use App\Models\SmsHistory;
use App\Models\Department;
use Spatie\Activitylog\Models\Activity;
use Session;
use DateTime;

class GeneralController extends Controller
{
    //
    public function __construct(){ 
        $this->middleware(['auth', 'general_auth']);
        // $this->middleware(['auth', 'load_auth', 'general_auth']);
    }  
    
    public function index(){

        // if (Session::get('https') != 'https'){
        //     Session::put('https', 'https');
        //     return redirect('https://payroll.pivoapps.net');
        // }

        // $ext = Extend::find(1);

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

        // $salary = Taxation::where('month', '07-2023')->get();
        // foreach ($salary as $val) {
        //     $val->delete();
        // }
        // return 'Done..!';

        
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




    public function pay_tests(){

        // activity()->log('Look mum, I logged something');
        // $activity = Activity::all()->last();
        // return $activity->properties;

        try {

            // return 122;
            return Employee::select('contact')->where('contact', '!=', '')->get();
            return view('sms_test');
        
            $endPoint = 'https://api.mnotify.com/api/sms/quick';
            $apiKey = 'uMl30OFBEGRUJXApCnmkgV9mb';
            $url = $endPoint . '?key=' . $apiKey;
            $data = [
            'recipient' => ['0247873637'],
            'sender' => 'PivoApps',
            'message' => 'Your OTP is 7219. Do not share with anyone.',
            'is_schedule' => 'false',
            'schedule_date' => ''
            ];

            $ch = curl_init();
            $headers = array();
            $headers[] = "Content-Type: application/json";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $result = curl_exec($ch);
            $result = json_decode($result, TRUE);
            curl_close($ch);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $result;
        return "Hello World!";

    }

    public function sendSms($mobile){
        $message ='Your message';
        $url = 'www.your-domain.com/api.php?to='.$mobile.'&text='.$message;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec ($ch);
        $err = curl_error($ch);  //if you need
        curl_close ($ch);
        return $response;
    }

    public function show_admi_profile()
    {
        $emp = Employee::find(auth()->user()->employee_id);
        $send = [
            'emp' => $emp
        ];
        return view('dash.pay_admin_profile')->with($send);
    }

    public function pay_employee_view(){
        if (auth()->user()->status == 'System') {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied!');
        }
        // $users = User::where('status', '!=', 'Student')->get();
        $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
        $position = SalaryCat::orderBy('position', 'ASC')->get();
        $employees = Employee::orderBy('id', 'DESC')->paginate(20);
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

    public function pay_allowance(Request $request){
        if (auth()->user()->status == 'System') {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied!');
        }

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

    public function pay_allowexp(){
        if (auth()->user()->status == 'System') {
            return redirect(url()->previous())->with('warning', 'Oops..! Access Denied!');
        }

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

    public function runs(){

        $string = '9,admin@google.com,8';
        $array = explode(',', $string);
        return $array[1];

        // // EMPLOYEE
        // $emprs = EmployeeRead::all();
        // foreach ($emprs as $emp) {
        //     $staff_loan = $emp->staff_loan;
        //     if (strlen($emp->staff_loan) > 0) {
        //     }else{
        //         $staff_loan = 0;
        //     }
        //     // return $staff_loan;
        //     if ($emp->rent) {
        //         $rent = 'yes';
        //     } else {
        //         $rent = 'no';
        //     }
        //         // $prof = $empr->prof;
        //     if ($emp->prof) {
        //         $prof = 'yes';
        //     } else {
        //         $prof = 'no';
        //     }
        //     if ($emp->resp) {
        //         $resp = 'yes';
        //     } else {
        //         $resp = 'no';
        //     }
        //     if ($emp->risk) {
        //         $risk = 'yes';
        //     } else {
        //         $risk = 'no';
        //     }
        //     if ($emp->vma) {
        //         $vma = 'yes';
        //     } else {
        //         $vma = 'no';
        //     }
        //     if ($emp->ent) {
        //         $ent = 'yes';
        //     } else {
        //         $ent = 'no';
        //     }
        //     if ($emp->dom) {
        //         $dom = 'yes';
        //     } else {
        //         $dom = 'no';
        //     }
        //     if ($emp->intr) {
        //         $intr = $emp->intr;
        //     } else {
        //         $intr = 'no';
        //     }
        //     if ($emp->tnt) {
        //         $tnt = $emp->tnt;
        //     } else {
        //         $tnt = 'no';
        //     }
        //     if ($emp->cola) {
        //         $cola = 'yes';
        //     } else {
        //         $cola = 'no';
        //     }

        // if ($emp->oname == 0) {
        //     $oname = '';
        // }else{
        //     $oname == $emp->oname;
        // }
            
        //     try {
        //         $emp_insert = Employee::firstOrCreate([
        //             'user_id' => auth()->user()->id,
        //             'staff_id' => $emp->staff_id,
        //             // 'salary_id' => $sal_id,
        //             // 'bank_id' => $bank_id,
        //             'afis_no' => $emp->afis_no,
        //             'fullname' => $emp->fullname,
        //             'fname' => $emp->fname,
        //             'sname' => $emp->sname,
        //             'oname' => $oname,
        //             'dob' => $emp->dob,
        //             // 'mname' => $emp->mname,
        //             // 'gender' => $emp->gender,
        //             'email' => $emp->email,
        //             // 'contact' => $contact,
        //             'position' => $emp->position,
        //             'cur_pos' => $emp->cur_pos,
        //             // 'cur_pos' => $salCat->position,
        //             'ssn' => $emp->ssn,
        //             'salary' => $emp->salary,
        //             'dept' => $emp->dept,
        //             'region' => $emp->region,
        //             // 'date_emp' => $emp->date_emp,
        //             'bank' => $emp->bank,
        //             'branch' => $emp->branch,
        //             'acc_no' => $emp->acc_no,
        //             'sub_div' => $emp->sub_div,
        //             // 'photo' => $filenameToStore,
        //             'std_loan' => $emp->std_loan,
        //             'staff_loan' => $staff_loan,
        //             // 'loan_date_started','loan_bal','loan_montly_ded'
        //         ]);
                
        //         $allow_check = Allowance::where('employee_id', $emp_insert->id)->get();
        //         if (count($allow_check) < 1) {
        //             $alw_insert = Allowance::firstOrCreate([
        //                 'user_id' => auth()->user()->id,
        //                 'employee_id' => $emp_insert->id,
        //                 'fname' => $emp->fname,
        //                 'rent' => $rent,
        //                 'prof' => $prof,
        //                 'resp' => $resp,
        //                 'risk' => $risk,
        //                 'vma' => $vma,
        //                 'ent' => $ent,
        //                 'dom' => $dom,
        //                 'intr' => $intr,
        //                 'tnt' => $tnt,
        //                 'cola' => $cola,
        //             ]);

        //             $loan_insert = Loan::firstOrCreate([
        //                 'user_id' => auth()->user()->id,
        //                 'employee_id' => $emp_insert->id,
        //             ]);
                    
        //             $emp_insert->allowance_id = $alw_insert->id;
        //             $emp_insert->save();

        //             $emp_insert->loan_id = $loan_insert->id;
        //             $emp_insert->save();
        //         }

        //         // $empls = Employee::all();
        //         // foreach ($empls as $empl) {
        //             $ext_reads_check = Extend::where('staff_id', $emp_insert->staff_id)->latest()->first();
        //             // return $emp->fname;
        //             if ($ext_reads_check) {
        //                 $emp_insert->extend_id = $ext_reads_check->id;
        //                 $emp_insert->save();
        //             }
        //         // }

        //     } catch (\Throwable $th) {
        //         throw $th;
        //         return redirect(url()->previous())->with('error', 'Oops..! An error occured');
        //     }
        // }
        // return "Employee Insert Successful";

        // // ALLOWANCE 
        // $allows = Allowance::all();
        // foreach ($allows as $alw) {
            // if ($alw->intr == 'yes') {
            //     $empr = EmployeeRead::where('staff_id', $alw->employee->staff_id)->latest()->first();
            //     if ($empr) {
            //         $alw->intr = $empr->intr;
            //         $alw->save();
            //     }
            // }
            // if ($alw->tnt == 'yes') {
            //     $empr = EmployeeRead::where('staff_id', $alw->employee->staff_id)->latest()->first();
            //     if ($empr) {
            //         $alw->tnt = $empr->tnt;
            //         $alw->save();
            //     }
            // }
            // $alw->fname = $alw->employee->fullname;
            // $alw->save();
        // }
        // return "Tnt & Intr Insert Successful";

        // // POSITIONS / CUR_POS
        // $emps = Employee::all();
        // foreach ($emps as $item) {
        //     if ($item->oname == 0) {
        //         $item->oname = '';
        //         $item->save();
        //     }
        //     $ext = Extend::find($item->extend_id);
        //     if ($ext) {
        //         $item->cur_pos = $ext->cur_pos;
        //         $item->save();
        //     }
        // }
        // return "Cur_Pos & Oname Issues Resolved";

        // IMPORT Std_Loan from EmployeeRead
        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     $empr_search = EmployeeRead::where('staff_id', $emp->staff_id)->latest()->first();
        //     if ($empr_search && $empr_search->std_loan != '') {
        //         $emp->std_loan = $empr_search->std_loan;
        //         $emp->save();
        //     }
        // }
        // return "Std_Loan Insert Successful";

        // CHANGE Saledit Month just for Checks
        // $saledit = Saledit::all();
        // foreach ($saledit as $item) {
        //     $item->month = '06-2023';
        //     $item->save();
        // }
        // return "Changes Done..!";

        // // COPY/SPLIT CONTACT FROM EXTEND TO EMP
        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     // return $emp->fullname.': '.$emp->extend->contact;
        //     if ($emp->extend_id != '') {
        //         $contact = $emp->extend->contact;
        //         if ($contact != '') {
        //             if (str_contains($contact, '/')) {
        //                 $contact = explode('/', $contact);
        //                 $contact = $contact[0];
        //             }
        //         $emp->contact = $contact;
        //         $emp->save();
        //         }
        //     }
        // }
        // // $exts = Employee::all();
        // // foreach ($exts as $ext) {
        // //     $empr = EmployeeRead::where('staff_id', $ext->staff_id)->latest()->first();
        // //     if ($empr->oname != '') {
        // //         $ext->oname = $empr->oname;
        // //         $ext->save();
        // //     }
        // // }
        // // $exts = Extend::all();
        // // foreach ($exts as $ext) {
        // //     if ($ext->dob == '1900-01-00') {
        // //         $ext->dob = '';
        // //         $ext->save();
        // //     }
        // // }
        // return "Contact import Done..!";

    }

}