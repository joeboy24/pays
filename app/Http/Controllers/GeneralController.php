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
use App\Models\Journal;
use App\Models\LoanSetup;
use App\Models\SalaryCat;
use App\Models\SmsHistory;
use App\Models\Department;
use Spatie\Activitylog\Models\Activity;
use Session;
use DateTime;
use \Illuminate\Support\Facades\Crypt;

class GeneralController extends Controller
{
    //
    public function __construct(){ 
        // $this->middleware(['auth', 'general_auth']);
        $this->middleware(['auth', 'load_auth', 'general_auth']);
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
            'sms_history' => SmsHistory::orderBy('id', 'DESC')->get(),
            'department' => Department::all(),
            // 'coworkers' => $coworkers,
        ];

        return view('dash.pay_bulksms')->with($sends);
    }

    public function runs(){

        // $str = 'aBgkI902343';
        // return Hash::make('laurenda@masloc');

        // $exts = Extend2::all();
        // foreach ($exts as $ext) {
        //     $user = User::where('staff_id', $ext->staff_id)->latest()->first();
            
        //     if ($user) {
        //         $emp = Employee::find($user->employee_id);
        //         $contact = $ext->contact;
        //         if (str_contains($contact, '/')) {
        //             $contact = explode('/', $contact);
        //             $contact = $contact[0];
        //         }
        //         $user->contact = $contact;
        //         $user->email = $ext->qual;
        //         $user->save();
                
        //         $emp->contact = $ext->contact;
        //         $emp->email = $ext->qual;
        //         $emp->save();
        //     }
        // }
        // return 'Done..!';

        // $users = User::all();
        // $ids = '';
        // foreach ($users as $usr) {
        //     // $contact = $usr->contact;
        //     $email = $usr->email;
        //     if (str_contains($usr->email, 'MSLC')) {
        //         // if (empty($contact)) {
        //             $email = 'replace_email'.$usr->id.'@masloc';
        //         // }
        //         // $usr->email = $contact;
        //         $usr->email = $email;
        //         $usr->save();
        //     }
        //     if (str_contains($usr->email, 'MSLC') || str_contains($usr->email, '@')) {}else{
        //         // if (empty($contact)) {
        //             $email = 'replace_email'.$usr->id.'@masloc';
        //         // }
        //         // $usr->email = $contact;
        //         $usr->email = $email;
        //         $usr->save();
        //     }
        // }
        // return 777;
        
        // $emps = Employee::all();
        // $ids = '';
        // foreach ($emps as $emp) {
        //     $user = User::where('employee_id', $emp->id)->latest()->first();
        //     if ($user) {}else {
        //         $ids = $ids.$emp->id.', ';
        //     }
        // }
        // return $ids;

        // $encrypted = Crypt::encrypt("Jay's");
        // $decrypted_string = Crypt::decrypt($encrypted);
        // return $encrypted;

        // $words = "Hello *FULLNAME*, you can now access your payslip, leave and loan requests on MASLOC's new staff portal. Please do not share your credentials. Email:  *EMAIL*  Password:  *PASSWORD* ";
        // $words = str_replace('*', 'zz', $words);
        // return $words;
    
        // GENERALIZE CREATE USERS

        // $ps1 = $request->input('password');
        // $ps2 = $request->input('password_confirmation');
        // $username = $request->input('name');
        // $email = $request->input('email');
        // $contact = $request->input('contact');
        // $status = $request->input('status');

        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     // pass = (fnam0,-3).contact/3*1234.(contact1,+3)
        //     $user_src = User::where('employee_id', $emp->id)->latest()->first();
        //     if ($user_src) {}else{
        //         if ($emp->contact) {
        //             $contact = $emp->contact;
        //         }else {
        //             $contact = '0247873637';
        //         }
        //         if ($emp->email) {
        //             $email = $emp->email;
        //         } else {
        //             $email = $emp->staff_id;
        //         }
        //         $contact = str_replace(' ', '', $contact);
                
        //         $pass = substr($emp->fname, 0, 3).substr((substr($contact, -5) / 3) * 1234, 0, 5).substr($contact, 1, 3);
        //         // return $contact;
        //         // return $pass;
        //         $create_user = User::firstOrCreate([
        //             'user_id' => auth()->user()->id,
        //             'employee_id' => $emp->id,
        //             'staff_id' => $emp->staff_id,
        //             'name' => $emp->fname,
        //             'email' => $email,
        //             'contact' => $contact,
        //             'status' => 'Staff',
        //             'password' => Hash::make($pass),
        //             'pass_photo' => 'noimage.png',
        //             'entry_code' => $pass,
        //             // 'pass_photo' => $filenameToStore
        //         ]);
        //     }
        // }
        // return 'Done..!';

        // try {
        //     return redirect(url()->previous())->with('success', 'User `'.$username.'` successfully added!');
            
        // }catch(\Throwable $th){
        //     return $th;
        //     return redirect(url()->previous())->with('error', 'Oops..! Something is wrong! Could be duplicate entry.');
        // }

        // $emps = Extend::all();
        // foreach ($emps as $emp) {
        //     $ext2 = Extend2::where('staff_id', $emp->staff_id)->latest()->first();
        //     if ($ext2) {
        //         // return $ext2->leave_bal;
        //         $emp->leave_bal = $ext2->leave_bal;
        //         $emp->save();
        //     }
        // }
        // return 'Done..!';
        
        // // $sals = Taxation::all();
        // // foreach ($sals as $sal) {
        // //     $sal->month = '07-2023';
        // //     $sal->save();
        // // }
        // $sals = Salary::where('month', '07-2023')->get();
        // foreach ($sals as $sal) {
        //     $sal->status = 'Paid';
        //     $sal->save();
        // }
        // return 'Paid..!';
        // $sals = Salary::where('month', '07-2023')->get();
        // $new_gross = $sals->sum('salary') + $sals->sum('rent') + $sals->sum('prof') + $sals->sum('resp') + $sals->sum('risk') + $sals->sum('vma') + $sals->sum('ent') + $sals->sum('dom') + $sals->sum('intr') + $sals->sum('cola');
        // $jv_check = Journal::find(1);
        // $jv_check->gross = $new_gross;
        // $jv_check->ssf_emp = $sals->sum('ssf_emp_cont');
        // $jv_check->fuel_alw = $sals->sum('tnt');
        // $jv_check->back_pay = $sals->sum('back_pay');
        // $jv_check->total_ssf = $sals->sum('ssf_emp_cont') + $sals->sum('ssf');
        // $jv_check->total_paye = $sals->sum('income_tax');
        // // $jv_check->advances = '';
        // // $jv_check->veh_loan = '';
        // $jv_check->std_loan = $sals->sum('std_loan');
        // $jv_check->staff_loan = $sals->sum('staff_loan');
        // $jv_check->net_pay = $sals->sum('net_aft_ded');
        // $jv_check->debit = $new_gross + $sals->sum('ssf_emp_cont') + $sals->sum('tnt') + $sals->sum('back_pay');
        // $jv_check->credit = $sals->sum('net_aft_ded') + $sals->sum('std_loan') + $sals->sum('staff_loan') + $sals->sum('income_tax') + ($sals->sum('ssf_emp_cont') + $sals->sum('ssf'));
        // $jv_check->save();
        // return 'Update Done..!';

        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     $emp_src = EmployeeRead::where('staff_id', $emp->staff_id)->latest()->first();
        //     // $sal->month = '08-2023';
        //     // $sal->save();
        //     // Update Salary with Fada's July values
        //     if ($emp_src) {
        //         $sal = Salary::where('employee_id', $emp->id)->latest()->first();
        //         $sal->ssf = $emp_src->ssf;
        //         $sal->sal_aft_ssf = $emp_src->sal_aft_ssf;
        //         $sal->rent = $emp_src->rent;
        //         $sal->taxable_inc = $emp_src->taxable_inc;
        //         $sal->income_tax = $emp_src->income_tax;
        //         $sal->net_aft_inc_tax = $emp_src->net_aft_inc_tax;

        //         if (!empty($emp_src->prof)) { $sal->prof = $emp_src->prof; }
        //         if (!empty($emp_src->resp)) { $sal->resp = $emp_src->resp; }
        //         if (!empty($emp_src->risk)) { $sal->risk = $emp_src->risk; }
        //         if (!empty($emp_src->vma)) { $sal->vma = $emp_src->vma; }
        //         if (!empty($emp_src->ent)) { $sal->ent = $emp_src->ent; }
        //         if (!empty($emp_src->dom)) { $sal->dom = $emp_src->dom; }
        //         if (!empty($emp_src->intr)) { $sal->intr = $emp_src->intr; }
        //         if (!empty($emp_src->cola)) { $sal->cola = $emp_src->cola; }
        //         if (!empty($emp_src->tnt)) { $sal->tnt = $emp_src->tnt; }
        //         if (!empty($emp_src->back_pay)) { $sal->back_pay = $emp_src->back_pay; }
        //         if (!empty($emp_src->std_loan)) { $sal->std_loan = $emp_src->std_loan; }
        //         if (!empty($emp_src->staff_loan)) { $sal->staff_loan = $emp_src->staff_loan; }
                
        //         $sal->net_bef_ded = $emp_src->net_bef_ded;
        //         $sal->net_aft_ded = $emp_src->net_aft_ded;
        //         $sal->ssf_emp_cont = $emp_src->ssf_emp_cont;
        //         $sal->gross_sal = $emp_src->gross_sal;
        //         $sal->tot_ded = $emp_src->tot_ded;
        //         $sal->save();
        //     }else {
        //         return $emp_src->id;
        //     }
        // }
        // return 'Update Done..!';

        // $sals = Salary::where('month', '07-2023')->get();
        // foreach ($sals as $sal) {
        //     $sal->month = '08-2023';
        //     $sal->save();
        // }
        // return 'Update Done..!';
        

        // $string = '9,admin@google.com,8';
        // $array = explode(',', $string);
        // return $array[1];

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

        // ACCOUNT NO OMIT -
        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     if (str_contains($emp->acc_no, '-')) { 
        //         $emp->acc_no = str_replace('-', '', $emp->acc_no);
        //         $emp->save();
        //     }
        // }

        // ADD DEPARTMENT ID's
        // $depts = Employee::select('dept')->orderBy('dept', 'ASC')->distinct('dept')->get();
        // foreach ($depts as $item) {
        //     // if ($item->dept == 'CEO SECRETARIAT') {
        //     //     $item->dept = "CEO'S SECRETARIAT";
        //     //     $item->save();
        //     // }
        //     $insert_dept = Department::firstOrCreate([
        //         'user_id' => auth()->user()->id,
        //         'dept_name' => $item->dept,
        //         // 'contact' => $es->contact
        //     ]);
        // }

        // $emps = Employee::all();
        // foreach ($emps as $item) {
        //     $dept = Department::where('dept_name', $item->dept)->latest()->first();
        //     $item->department_id = $dept->id;
        //     $item->save();
        // }
        // return 'Done..!';


        // // ADD DEPARTMENT ID's
        // $emps = Employee::all();
        // foreach ($emps as $item) {
        //     // $er = EmployeeRead::where('staff_id', $item->staff_id)->latest()->first();
        //     if (str_contains($item->sub_div, 'Managers')) {
        //         $item->sub_div = str_replace("Managers", "Manager", $item->sub_div);
        //         // $item->sub_div = $er->sub_div;
        //         $item->save();
        //     }
        // }

        // // $sub_divs = Employee::select('position')->orderBy('position', 'ASC')->distinct('position')->get();
        // $sub_divs = SalaryCat::all();
        // foreach ($sub_divs as $slc) {
        //     $emp = Employee::where('position', $slc->position)->latest()->first();
        //     // return $slc->position;
        //     $slc->basic_sal = $emp->salary;
        //     $slc->save();
        //     // $insert_sal_cat = SalaryCat::firstOrCreate([
        //     //     'user_id' => auth()->user()->id,
        //     //     'title' => $sub->position,
        //     //     'position' => $sub->position,
        //     //     'basic_sal' => 0
        //     // ]);
        // }
        // return $sub_divs;


        // // ADD REGIONS
        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     $reg_src = Region::where('reg_name', $emp->region)->latest()->first();
        //     if ($reg_src) {
        //         $emp->region_id = $reg_src->id;
        //         $emp->save();
        //     }
        // }
        // return 'Done';


        // // ADD REGIONS
        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     $bank_src = Bank::where('bank_abr', $emp->bank)->latest()->first();
        //     if ($bank_src) {
        //         $emp->bank_id = $bank_src->id;
        //         $emp->save();
        //     }
        // }
        // return 'Done';

    }

}