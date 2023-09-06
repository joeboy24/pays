<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmployeeMailImport;
use App\Imports\EmployeeExtImport;
use App\Imports\EmployeeImport;
use App\Imports\TaxationImport;
use App\Models\Employee;
use App\Models\EmployeeRead;
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
use App\Models\Department;
use App\Models\AllowanceList;
use App\Models\Allowexp;
use App\Models\DirectPay;
use App\Models\LoanGrant;
use App\Models\Validation;
use App\Models\Journal;
use App\Models\JV;
use App\Models\SMS;
use App\Models\SmsHistory;
use App\Models\Saledit;
use Session;
use Auth;
use \Illuminate\Support\Facades\Crypt;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return sprintf('%.d', 1.9100000011024E+15);
        // $emps = Employee::all();
        // foreach ($emps as $emp) {
        //     $emp->cur_pos = $emp->position;
        //     $emp->save();
        // }
        // return redirect('/view_employee');
        // $posts = Employee::all();
        // foreach ($posts as $pos) {
        //     $pos->cur_pos = $pos->position;
        //     $pos->save();
        // }
        // return "Done";

        // if ($check == 'employee') {
            
            // Search Employee Data
            $src = $request->input('search_emp');
            $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
            $position = SalaryCat::orderBy('position', 'ASC')->get();
            $employees = Employee::where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->paginate(20);
            $patch = [
                'c' => 1,
                'regions' => $regions,
                'main_regions' => Region::all(),
                'position' => $position,
                'employees' => $employees
            ];
            return view('dash.pay_employee_view')->with($patch);
            

        // } elseif ($check == 'allowance') {

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

        // }

        return redirect(url()->previous());

        // Salary share to Employee & Allowances
        $emprs = EmployeeRead::where('del', 'no')->get();
        // $emprs = EmployeeRead::All();
        // return $emprs;
        foreach ($emprs as $empr) {

            if ($empr->staff_loan == '') {
                $empr->staff_loan = 0;
                $empr->save();
            }
        
            $full = explode(' ', $empr->fullname);
            $fname = $full[0];
            $oname = '';
            $sname = str_replace($full[0],"",$empr->fullname);
            if ($empr->oname != 0 || $empr->oname != '') {
                $oname = $empr->oname;
            }

            $emp_insert = Employee::firstOrCreate([
                'user_id' => auth()->user()->id,
                'afis_no' => $empr->afis_no,
                'fname' => $empr->fname,
                'sname' => $empr->sname,
                'oname' => $oname,
                'position' => $empr->position,
                'cur_pos' => $empr->position,
                'ssn' => $empr->ssn,
                'salary' => $empr->salary,
                'dept' => $empr->dept,
                'region' => $empr->region,
                'bank' => $empr->bank,
                'branch' => $empr->branch,
                'acc_no' => $empr->acc_no,
                'sub_div' => $empr->sub_div,
                'staff_loan' => $empr->staff_loan
                // 'loan_date_started','loan_bal','loan_montly_ded'
            ]);

            // Allowances Insert
            $alw_check = Allowance::where('employee_id', $emp_insert->id)->count();
            if ($alw_check == 0) {
                # code...
                if ($empr->rent != '' && $empr->rent != 0) {
                    $rent = 'yes';
                } else {
                    $rent = 'no';
                }
                    // $prof = $empr->prof;
                if ($empr->prof != '' && $empr->prof != 0) {
                    $prof = 'yes';
                } else {
                    $prof = 'no';
                }
                if ($empr->resp != '' && $empr->resp != 0) {
                    $resp = 'yes';
                } else {
                    $resp = 'no';
                }
                if ($empr->risk != '' && $empr->risk != 0) {
                    $risk = 'yes';
                } else {
                    $risk = 'no';
                }
                if ($empr->vma != '' && $empr->vma != 0) {
                    $vma = 'yes';
                } else {
                    $vma = 'no';
                }
                if ($empr->ent != '' && $empr->ent != 0) {
                    $ent = 'yes';
                } else {
                    $ent = 'no';
                }
                if ($empr->dom != '' && $empr->dom != 0) {
                    $dom = 'yes';
                } else {
                    $dom = 'no';
                }
                // if ($empr->intr != '' && $empr->intr != 0) {
                //     $intr = 'yes';
                // } else {
                //     $intr = 'no';
                // }
                // if ($empr->tnt != '' && $empr->tnt != 0) {
                //     $tnt = 'yes';
                // } else {
                //     $tnt = 'no';
                // }
                if ($empr->intr == '' || $empr->intr == 0) {
                    $intr = 0;
                } else {
                    $intr = $empr->intr;
                }
                if ($empr->tnt == '' || $empr->tnt == 0) {
                    $tnt = 0;
                } else {
                    $tnt = $empr->tnt;
                }
                
                if ($empr->cola != '' && $empr->cola != 0) {
                    $cola = 'yes';
                } else {
                    $cola = 'no';
                }
                
                $alw_insert = Allowance::firstOrCreate([
                    'user_id' => auth()->user()->id,
                    'employee_id' => $emp_insert->id,
                    'fname' => $full[0],
                    'rent' => $rent,
                    'prof' => $prof,
                    'resp' => $resp,
                    'risk' => $risk,
                    'vma' => $vma,
                    'ent' => $ent,
                    'dom' => $dom,
                    'intr' => $intr,
                    'tnt' => $tnt,
                    'cola' => $cola,
                ]);
                // Insert Allowance ID
                // $all_ins = Employee::find($emp_insert->id);
                $emp_insert->allowance_id = $alw_insert->id;
                $emp_insert->save();
            }
            
        }

        // Loan Insert
        // 'user_id','employee_id','elig_amt','lump_sum','dur','monthly_ded','bal','date_started','months_left','status'
        
        
        $emps = Employee::all();
        foreach ($emps as $emp) {
            $loan_insert = Loan::firstOrCreate([
                'user_id' => auth()->user()->id,
                'employee_id' => $emp->id,
            ]);
        }

        // Remove 0's
        foreach ($emps as $emp) {
            if ($emp->oname == 0) {
                $emp->oname = '';
                $emp->save();
            }
        }
        // return 'Loan & Leave Insert Done!';

        // Get Banks
        $banks = Employee::distinct('bank')->get();
        foreach ($banks as $emp) {
            # code...
            $bank_insert = Bank::firstOrCreate([
                'user_id' => auth()->user()->id,
                'bank_abr' => $emp->bank,
                'bank_fullname' => $emp->bank,
            ]);
            $emp->bank_id = $bank_insert->id;
            $emp->save();
        }

        return 'Employee, Allowance, Loans & Banks Insert Done!';




        $emps = Employee::All();
        foreach ($emps as $emp) {
            // $tax_search = TaxationRead::where('name', 'Like', '%'.$emp->fname.'%'.$emp->sname.'%')->first();
            $emp_search = EmployeeRead::where('fullname', 'Like', '%'.$emp->fname.'%')->where('ssn', 'Like', '%'.$emp->ssn.'%')->first();
            // return $emp_search;
            if ($emp_search) {
                // 'email', 'dept', 'region', 'bank', 'branch', 'acc_no', 'sub_div'
                $emp_search->staff_id = $emp->id;
                $emp_search->save();

                $emp->email = $emp_search->email;
                $emp->dept = $emp_search->dept;
                $emp->region = $emp_search->region;
                $emp->bank = $emp_search->bank;
                $emp->branch = $emp_search->branch;
                $emp->acc_no = $emp_search->acc_no;
                $emp->sub_div = $emp_search->sub_div;
                $emp->save();
            }
        }
        // Get Banks
        $banks = Employee::distinct('bank')->get();
        foreach ($banks as $emp) {
            # code...
            $bank_insert = Bank::firstOrCreate([
                'user_id' => auth()->user()->id,
                'bank_abr' => $emp->bank,
                'bank_fullname' => $emp->bank,
            ]);
            $emp->bank_id = $bank_insert->id;
            $emp->save();
        }
        return 'Done';



        

        $emps = Employee::All();
        foreach ($emps as $emp) {
            $tax_search = TaxationRead::where('name', 'Like', '%'.$emp->sname.'%')->where('basic_sal', '%'.$emp->sname.'%')->first();
            if ($tax_search) {
                $tax_search->employee_id = $emp->id;
                $tax_search->save();
            }
        }
        return redirect(url()->previous())->with('success', 'Mapping Successfull!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        switch ($request->input('store_action')) {

            case 'create_user':

                $ps1 = $request->input('password');
                $ps2 = $request->input('password_confirmation');
                $username = $request->input('name');
                $email = $request->input('email');
                $contact = $request->input('contact');
                $status = $request->input('status');
                // return $status;
                // $pass_photo = $request->input('pass_photo');

                if ($status == 'none') {
                    return redirect(url()->previous())->with('error', 'Oops..! Select Status to procceed.');
                }

                if ($ps1 == $ps2){

                    try {
                        // $this->validate($request, [
                        //     'pass_photo'  => 'max:5000|mimes:jpeg,jpg,png'
                        // ]);
                        //     $filenameWithExt = $request->file('pass_photo')->getClientOriginalName();
                        //     $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        //     $fileExt = $request->file('pass_photo')->getClientOriginalExtension();
                        //     $filenameToStore = $username.substr( $contact, -4).'.'.$fileExt;
                        //     $path = $request->file('pass_photo')->storeAs('public/classified/users', $filenameToStore);
                        
                    } catch (Exception $ex) {
                        // return redirect(previous()->url())->with('error', 'Ooops..! File Error');
                    }

                    try {

                        $create_user = User::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'employee_id' => '347',
                            'staff_id' => '227',
                            'name' => $username,
                            'email' => $email,
                            'contact' => $contact,
                            'status' => $status,
                            'password' => Hash::make($ps1),
                            'pass_photo' => 'noimage.png',
                            // 'pass_photo' => $filenameToStore
                        ]);
                        return redirect(url()->previous())->with('success', 'User `'.$username.'` successfully added!');
                        
                    }catch(\Throwable $th){
                        return $th;
                        return redirect(url()->previous())->with('error', 'Oops..! Something is wrong! Could be duplicate entry.');
                    }
                }else{
                    return redirect(url()->previous())->with('error', 'Oops..! Passwords do not match');
                }

            break;

            case 'import_employee':

                // return 'Im in!';

                try {
                    $this->validate($request, [
                        'ex_file'   => 'required|max:5000|mimes:xlsx,xls,csv'
                    ]);

                    Excel::import(new EmployeeImport,request()->file('ex_file'));
                    // Excel::import(new TaxationImport,request()->file('ex_file'))->selectSheets('TAXATION');
                    // Excel::selectSheetsByIndex(0)->load();
                    return redirect(url()->previous())->with('success', 'Employee Data successfully uploaded');

                } catch (ValidationException $exception) {
                    return redirect(url()->previous())->with('Error', $exception->errors());
                }

            break;

            case 'import_employee_ext':

                // return 'Im in!';

                try {
                    $this->validate($request, [
                        'ext_file'   => 'required|max:5000|mimes:xlsx,xls,csv'
                    ]);

                    Excel::import(new EmployeeExtImport,request()->file('ext_file'));
                    // Excel::import(new TaxationImport,request()->file('ex_file'))->selectSheets('TAXATION');
                    // Excel::selectSheetsByIndex(0)->load();
                    return redirect(url()->previous())->with('success', 'Employee Ext. Data successfully uploaded');

                } catch (ValidationException $exception) {
                    return redirect(url()->previous())->with('Error', $exception->errors());
                }

            break;

            case 'insert_allowances':
                // return 987;

                $employees = Employee::where('allowance_id', 'none')->get();
                // return $employees;
                foreach ($employees as $item) {
                    $alw_check = Allowance::where('employee_id', $item->employee_id)->count();
                    // return $alw_check;
                    if ($alw_check == 0) {
                        # code...
                        $alw_insert = Allowance::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'employee_id' => $item->id,
                            'fname' => $item->fname,
                        ]);
                        $item->allowance_id = $alw_insert->id;
                        $item->save();
                    }
                }
                return redirect(url()->previous());
                // return redirect(url()->previous())->with('success', 'Page Refresh Successful');

            break;

            case 'add_allow_ssnit':
                // return 777;
                $alw_del = AllowanceOverview::all();
                foreach ($alw_del as $item) {
                    $item->delete();
                }
                if ($request->input('new1')) {
                    $new1 = $request->input('new1');
                } else {
                    $new1 = 0;
                }
                if ($request->input('new2')) {
                    $new2 = $request->input('new2');
                } else {
                    $new2 = 0;
                }
                if ($request->input('new3')) {
                    $new3 = $request->input('new3');
                } else {
                    $new3 = 0;
                }
                if ($request->input('new4')) {
                    $new4 = $request->input('new4');
                } else {
                    $new4 = 0;
                }
                if ($request->input('new5')) {
                    $new5 = $request->input('new5');
                } else {
                    $new5 = 0;
                }
                
                try {
                    $alwovr_insert = AllowanceOverview::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'rent' => $request->input('rent'),
                        'prof' => $request->input('prof'),
                        'resp' => $request->input('resp'),
                        'risk' => $request->input('risk'),
                        'vma' => $request->input('vma'),
                        'ent' => $request->input('ent'),
                        'dom' => $request->input('dom'),
                        'intr' => $request->input('intr'),
                        'tnt' => $request->input('tnt'),
                        'cola' => $request->input('cola'),
                        'ssf' => $request->input('ssf'),
                        'ssf1' => $request->input('ssf1'),
                        'ssf2' => $request->input('ssf2'),
                        'new1' => $new1,
                        'new2' => $new2,
                        'new3' => $new3,
                        'new4' => $new4,
                        'new5' => $new5,
                    ]);
                    $aloc = AllowanceList::all();
                    for ($i=1; $i <= count($aloc); $i++) { 
                        $aloc_up = AllowanceList::find($i);

                        if ($i == 1) {
                            $perc = $new1;
                            $amt = $new1;
                        } elseif ($i == 2) {
                            $perc = $new2;
                            $amt = $new2;
                        } elseif ($i == 3) {
                            $perc = $new3;
                            $amt = $new3;
                        } elseif ($i == 4) {
                            $perc = $new4;
                            $amt = $new4;
                        } elseif ($i == 5) {
                            $perc = $new5;
                            $amt = $new5;
                        }
                        
                        if ($aloc_up->allow_perc != 0) {
                            $aloc_up->allow_perc = $perc;
                        }else{
                            $aloc_up->allow_amt = $amt;
                        }
                        $aloc_up->save();
                    }
                } catch (\Throwable $th) {
                    // throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }

                return redirect(url()->previous())->with('success', 'Allowances / SSNIT (%) Successfully Updated');
                // return redirect(url()->previous())->with('success', 'Page Refresh Successful');

            break;

            case 'calc_taxation':
                // return 777;
                $allowoverview = AllowanceOverview::where('del', 'no')->latest()->first();
                if ($allowoverview == '') {
                    return redirect(url()->previous())->with('warning', 'Oops..! Define Allowance Percentages to proceed -> Employee / Allowances / Allowance/SSNIT Overview');
                }
                // $alo = AllowanceOverview::where('del', 'no')->latest()->first();
                // $rent = $alo->rent;
                // $prof = $alo->prof;
                // $ssf = $alo->ssf;
                
                $employees = Employee::get();
                // if (count($employee) < 1) {
                //     return redirect(url()->previous())->with('error', 'Allowances / SSNIT (%) Successfully Updated');
                // }

                if ($employees) {
                    foreach ($employees as $emp) {
                        if ($emp->del != 'no') {
                            $check_sal_exist = Salary::where('month', date('m-Y'))->where('employee_id', $emp->id)->latest()->first();
                            $check_tax_exist = Taxation::where('month', date('m-Y'))->where('employee_id', $emp->id)->latest()->first();
                            if ($check_sal_exist) {
                                $check_sal_exist->delete();
                                $check_tax_exist->delete();
                                // return false;
                                // break;
                            }
                        }else{
                            $saledit = Saledit::where('month', date('m-Y'))->where('employee_id', $emp->id)->latest()->first();
                            $alx = Allowexp::where('employee_id', $emp->id)->where('del', 'no')->latest()->first();
                            if ($alx) {
                                // return 'Yh';
                                $alo = Allowexp::find($alx->id);
                                $rent = $alo->rent;
                                $prof = $alo->prof;
                                $ssf = $alo->ssf;
                                $ssf1 = $alo->ssf1;
                            }else{
                                $alo = AllowanceOverview::where('del', 'no')->latest()->first();
                                $rent = $alo->rent;
                                $prof = $alo->prof;
                                $ssf = $alo->ssf;
                                $ssf1 = $alo->ssf1;
                            }
                            if ($emp->allowance->rent == 'no') {
                                $rent = 0;
                            }else {
                                $rent = $alo->rent;
                            }
                            if ($emp->allowance->prof == 'no') {
                                $prof = 0;
                            }else {
                                $prof = $alo->prof;
                            }
                            
                            // $basic_sal = $emp->salary * ($emp->pay_perc / 100);
                            // return $basic_sal;

                            $send_rent = ($rent/100) * $emp->salary;
                            $send_prof = ($prof/100) * $emp->salary;
                            $send_ssf = ($ssf/100) * $emp->salary;
                            // $total_income = $send_rent;
                            $total_income = $emp->salary + $send_rent + $send_prof;
                            $taxable_inc = $total_income - $send_ssf;
                            $first1 = 0;
                            $next1 = 0;
                            $next2 = 0;
                            $next3 = 0;
                            $next4 = 0;
                            $next5 = 0;
                            $tax_pay = 0;
                            // return $send_prof;

                            // Next 1 Calc
                            if (($taxable_inc - 319) > 100) {
                                $next1 = (5/100) * 100;
                                if ($next1 < 0) { $next1 = 0; }
                            } else {
                                $next1 = ($taxable_inc - 319) * (5/100);
                            }

                            // Next 2 Calc
                            if (($taxable_inc - 419) > 120) {
                                $next2 = (10/100) * 120;
                                if ($next2 < 0) { $next2 = 0; }
                            } else {
                                $next2 = ($taxable_inc - 419) * (10/100);
                            }

                            // Next 3 Calc
                            if (($taxable_inc - 539) < 3000) {
                                $next3 = ($taxable_inc - 539) * (17.5/100);
                                if ($next3 < 0) { $next3 = 0; }
                            } else {
                                $next3 = (17.5/100) * 3000;
                            }

                            // Next 4 Calc
                            if (($taxable_inc - 3539) < 16461) {
                                $next4 = ($taxable_inc - 3539) * (25/100);
                                if ($next4 < 0) { $next4 = 0; }
                            } else {
                                $next4 = (25/100) * 16461;
                            }

                            // Next 5 Calc
                            if (($taxable_inc - 20000) > 0) {
                                $next5 = ($taxable_inc - 20000) * (30/100);
                                if ($next5 < 0) { $next5 = 0; }
                            } else {
                                $next5 = 0;
                            }

                            // Total Tax Payable
                            // $tax_pay = $next1 + $next2 + $next3 + $next4 + $next5;
                            if ($emp->salary <= 319) {
                                $tax_pay = 0;
                            } elseif ($emp->salary > 319 && $emp->salary <= 419) {
                                $tax_pay = $next1;
                            } elseif ($emp->salary > 419 && $emp->salary <= 539) {
                                $tax_pay = $next2;
                                $next3 = 0;
                                $next4 = 0;
                                $next5 = 0;
                                // $tax_pay = $next1 + $next2;
                            } elseif ($emp->salary > 539 && $emp->salary <= 3000) {
                                $tax_pay = $next1 + $next2 + $next3;
                                $next4 = 0;
                                $next5 = 0;
                            } elseif ($emp->salary > 3000 && $emp->salary <= 16461) {
                                $tax_pay = $next1 + $next2 + $next3 + $next4;
                                $next5 = 0;
                            } elseif ($emp->salary > 16461 && $emp->salary <= 20000) {
                                $tax_pay = $next1 + $next2 + $next3 + $next4 + $next5;
                            } elseif ($emp->salary > 20000) {
                                $tax_pay = $next1 + $next2 + $next3 + $next4 + $next5;
                            }
                            // return $tax_pay;

                            // Salary Workings
                            $sal_aft_ssf = $emp->salary - $send_ssf;
                            $sal_taxable_inc = $sal_aft_ssf + $send_rent + $send_prof;
                            $income_tax = $tax_pay;
                            $net_aft_inc_tax = $sal_taxable_inc - $income_tax;
                            // Get Resp Allow
                            if ($emp->allowance->resp == 'no') {
                                $resp = 0;
                            }else {
                                $resp = ($alo->resp/100) * $emp->salary;
                            }
                            // Get Risk Allow
                            if ($emp->allowance->risk == 'no') {
                                $risk = 0;
                            }else {
                                $risk = ($alo->risk/100) * $emp->salary;
                            }
                            // Get VMA Allow
                            if ($emp->allowance->vma == 'no') {
                                $vma = 0;
                            }else {
                                $vma = ($alo->vma/100) * $emp->salary;
                            }
                            // Get Ent Allow
                            if ($emp->allowance->ent == 'no') {
                                $ent = 0;
                            }else {
                                $ent = ($alo->ent/100) * $emp->salary;
                            }
                            // Get Dom Allow
                            if ($emp->allowance->dom == 'no') {
                                $dom = 0;
                            }else {
                                $dom = ($alo->dom/100) * $emp->salary;
                            }
                            // Get Intr Allow
                            if ($emp->allowance->intr == 'no' || $emp->allowance->intr == 0) {
                                $intr = 0;
                            }else {
                                $intr = $emp->allowance->intr;
                            }
                            // Get T&T Allow
                            if ($emp->allowance->tnt == 'no' || $emp->allowance->tnt == 0) {
                                $tnt = 0;
                            }else {
                                $tnt = $emp->allowance->tnt;
                            }
                            // Get T&T Allow
                            if ($emp->allowance->cola == 'no') {
                                $cola = 0;
                            }else {
                                $cola = ($alo->cola/100) * $emp->salary;
                            }
                            // Get New1 Allow
                            if ($emp->allowance->new1 == 'no') {
                                $new1 = 0;
                            }else {
                                $find1 = AllowanceList::find(1);
                                if ($find1->allow_perc != 0) {
                                    $new1 = ($alo->new1/100) * $emp->salary;
                                } else {
                                    $new1 = $alo->new1;
                                }
                            }
                            // Get New2 Allow
                            if ($emp->allowance->new2 == 'no') {
                                $new2 = 0;
                            }else {
                                $find2 = AllowanceList::find(2);
                                if ($find2->allow_perc != 0) {
                                    $new2 = ($alo->new2/100) * $emp->salary;
                                } else {
                                    $new2 = $alo->new2;
                                }
                            }
                            // Get New3 Allow
                            if ($emp->allowance->new3 == 'no') {
                                $new3 = 0;
                            }else {
                                $find3 = AllowanceList::find(3);
                                if ($find3->allow_perc != 0) {
                                    $new3 = ($alo->new3/100) * $emp->salary;
                                } else {
                                    $new3 = $alo->new3;
                                }
                            }
                            // Get New4 Allow
                            if ($emp->allowance->new4 == 'no') {
                                $new4 = 0;
                            }else {
                                $find4 = AllowanceList::find(4);
                                if ($find4->allow_perc != 0) {
                                    $new4 = ($alo->new4/100) * $emp->salary;
                                } else {
                                    $new4 = $alo->new4;
                                }
                            }
                            // Get New5 Allow
                            if ($emp->allowance->new5 == 'no') {
                                $new5 = 0;
                            }else {
                                $find5 = AllowanceList::find(5);
                                if ($find5->allow_perc != 0) {
                                    $new5 = ($alo->new5/100) * $emp->salary;
                                } else {
                                    $new5 = $alo->new5;
                                }
                            }

                            // Updated

                            $back_pay = $emp->allowance->back_pay;
                            $net_bef_ded = $net_aft_inc_tax + $resp + $risk + $vma + $ent + $dom + $intr + $tnt + $cola + $new1 + $new2 + $new3 + $new4 + $new5 + $back_pay;
                            // $staff_loan = $emp->staff_loan;
                            // $net_aft_ded = $net_bef_ded - $staff_loan;
                            // $ssf_emp_cont = ((18.5 - $ssf) / 100) * $emp->salary;
                            // $tot_ded = $send_ssf + $income_tax + $staff_loan;
                            $std_loan = $emp->std_loan;
                            $staff_loan = $emp->staff_loan;
                            $net_aft_ded = $net_bef_ded - $staff_loan - $std_loan;
                            // $ssf_emp_cont = ($ssf1 / 100) * $emp->salary;
                            $ssf_emp_cont = ((18.5 - $ssf) / 100) * $emp->salary;
                            $tot_ded = $send_ssf + $income_tax + $staff_loan + $std_loan;
                            $gross_sal = $sal_aft_ssf + $send_rent + $send_prof + $resp + $risk + $vma + $ent + $dom + $intr + $tnt + $cola + $new1 + $new2 = + $new3 + $new4 + $new5 + $back_pay;
                            

                            $where = [
                                'month' => date('m-Y'),
                                'employee_id' => $emp->id
                            ];
                            $taxation_check = Taxation::where($where)->first();
                            $sal_check = Salary::where($where)->first();
                            $saledit = Saledit::where($where)->first();
                            
                            // $send_ssf = number_format($send_ssf, 2);
                            // return $send_ssf;
                            // if ($saledit) {} else {
                                try {

                                    if ($taxation_check) {
                                        // return 1;
                                        if ($saledit && $saledit->status == 'used') {
                                            // Copy Calc from Saledit to Update Salary
                                            $sl = Salary::find($sal_check->id);
                                            $sl->ssf = $saledit->ssf;
                                            $sl->sal_aft_ssf = $saledit->sal_aft_ssf;
                                            $sl->rent = $saledit->rent;
                                            $sl->prof = $saledit->prof;
                                            $sl->taxable_inc = $saledit->taxable_inc;
                                            $sl->income_tax = $saledit->income_tax;
                                            $sl->net_aft_inc_tax = $saledit->net_aft_inc_tax;
                                            $sl->resp = $saledit->resp;
                                            $sl->risk = $saledit->risk;
                                            $sl->vma = $saledit->vma;
                                            $sl->ent = $saledit->ent;
                                            $sl->dom = $saledit->dom;
                                            $sl->intr = $saledit->intr;
                                            $sl->tnt = $saledit->tnt;
                                            $sl->cola = $saledit->cola;
                                            $sl->new1 = $saledit->new1;
                                            $sl->new2 = $saledit->new2;
                                            $sl->new3 = $saledit->new3;
                                            $sl->new4 = $saledit->new4;
                                            $sl->new5 = $saledit->new5;
                                            $sl->back_pay = $saledit->back_pay;
                                            $sl->net_bef_ded = $saledit->net_bef_ded;
                                            $sl->std_loan = $saledit->std_loan;
                                            $sl->staff_loan = $saledit->staff_loan;
                                            $sl->net_aft_ded = $saledit->net_aft_ded;
                                            $sl->pay_perc = $emp->pay_perc;
                                            $sl->ssf_emp_cont = $saledit->ssf_emp_cont;
                                            $sl->gross_sal = $saledit->gross_sal;
                                            $sl->tot_ded = $saledit->tot_ded;
                                            $sl->save();
                                        } else {
                                            $tx = Taxation::find($taxation_check->id);
                                            // $tx->month = date('m-Y');
                                            // $tx->employee_id = $emp->id;
                                            // $tx->cur_pos = 'No Position';
                                            $tx->salary = $emp->salary;
                                            $tx->rent = $send_rent;
                                            $tx->prof = $send_prof;
                                            $tx->tot_income = $total_income;
                                            $tx->ssf = $send_ssf;
                                            $tx->taxable_inc = $taxable_inc;
                                            $tx->tax_pay = $tax_pay;
                                            $tx->first1 = $first1;
                                            $tx->next1 = $next1;
                                            $tx->next2 = $next2;
                                            $tx->next3 = $next3;
                                            $tx->next4 = $next4;
                                            $tx->next5 = $next5;
                                            $tx->net_amount = $taxable_inc - $tax_pay;
                                            $tx->save();

                                            // Calc & Insert in Salary as well
                                            $sl = Salary::find($sal_check->id);
                                            // $sl->user_id = $xyz;
                                            // $sl->month = $xyz;
                                            // $sl->employee_id = $xyz;
                                            // $sl->cur_pos = $xyz;
                                            $sl->salary = $emp->salary;
                                            $sl->ssf = $send_ssf;
                                            $sl->sal_aft_ssf = $sal_aft_ssf;
                                            $sl->rent = $send_rent;
                                            $sl->prof = $send_prof;
                                            $sl->taxable_inc = $sal_taxable_inc;
                                            $sl->income_tax = $income_tax;
                                            $sl->net_aft_inc_tax = $net_aft_inc_tax;
                                            $sl->resp = $resp;
                                            $sl->risk = $risk;
                                            $sl->vma = $vma;
                                            $sl->ent = $ent;
                                            $sl->dom = $dom;
                                            $sl->intr = $intr;
                                            $sl->tnt = $tnt;
                                            $sl->cola = $cola;
                                            $sl->new1 = $new1;
                                            $sl->new2 = $new2;
                                            $sl->new3 = $new3;
                                            $sl->new4 = $new4;
                                            $sl->new5 = $new5;
                                            $sl->back_pay = $back_pay;
                                            $sl->net_bef_ded = $net_bef_ded;
                                            $sl->std_loan = $std_loan;
                                            $sl->staff_loan = $staff_loan;
                                            $sl->net_aft_ded = $net_aft_ded;
                                            $sl->pay_perc = $emp->pay_perc;
                                            $sl->ssf_emp_cont = $ssf_emp_cont;
                                            $sl->gross_sal = $gross_sal;
                                            $sl->tot_ded = $tot_ded;
                                            $sl->ssn = $emp->ssn;
                                            $sl->email = $emp->email;
                                            $sl->dept = $emp->dept;
                                            $sl->region = $emp->region;
                                            $sl->bank = $emp->bank;
                                            $sl->branch = $emp->branch;
                                            $sl->acc_no = $emp->acc_no;
                                            $sl->save();

                                        }
                                        // return $new1.' - '.$new2.' - '.$new3.' - '.$new4.' - '.$new5;
                                    } else {
                                        $tx = Taxation::firstOrCreate([
                                            'user_id' => auth()->user()->id,
                                            'month' => date('m-Y'),
                                            'employee_id' => $emp->id,
                                            'position' => $emp->cur_pos,
                                            'salary' => $emp->salary,
                                            'rent' => $send_rent,
                                            'prof' => $send_prof,
                                            'tot_income' => $total_income,
                                            'ssf' => $send_ssf,
                                            'taxable_inc' => $taxable_inc,
                                            'tax_pay' => $tax_pay,
                                            'first1' => $first1,
                                            'next1' => $next1,
                                            'next2' => $next2,
                                            'next3' => $next3,
                                            'next4' => $next4,
                                            'next5' => $next5,
                                            'net_amount' => $taxable_inc - $tax_pay,
                                        ]);

                                        if ($saledit && $saledit->status == 'used') {
                                            // return 3;
                                            // Copy Calc from Saledit to Update Salary
                                            $sl = Salary::firstOrCreate([
                                                'user_id' => auth()->user()->id,
                                                'month' => date('m-Y'),
                                                'taxation_id' => $tx->id,
                                                'employee_id' => $emp->id,
                                                'position' => $emp->cur_pos,
                                                'salary' => $emp->salary,
                                                'ssf' => $saledit->ssf,
                                                'sal_aft_ssf' => $saledit->sal_aft_ssf,
                                                'rent' => $saledit->rent,
                                                'prof' => $saledit->prof,
                                                'taxable_inc' => $saledit->taxable_inc,
                                                'income_tax' => $saledit->income_tax,
                                                'net_aft_inc_tax' => $saledit->net_aft_inc_tax,
                                                'resp' => $saledit->resp,
                                                'risk' => $saledit->risk,
                                                'vma' => $saledit->vma,
                                                'ent' => $saledit->ent,
                                                'dom' => $saledit->dom,
                                                'intr' => $saledit->intr,
                                                'tnt' => $saledit->tnt,
                                                'cola' => $saledit->cola,
                                                'new1' => $saledit->new1,
                                                'new2' => $saledit->new2,
                                                'new3' => $saledit->new3,
                                                'new4' => $saledit->new4,
                                                'new5' => $saledit->new5,
                                                'back_pay' => $saledit->back_pay,
                                                'net_bef_ded' => $saledit->net_bef_ded,
                                                'std_loan' => $saledit->std_loan,
                                                'staff_loan' => $saledit->staff_loan,
                                                'net_aft_ded' => $saledit->net_aft_ded,
                                                'ssf_emp_cont' => $saledit->ssf_emp_cont,
                                                'gross_sal' => $saledit->gross_sal,
                                                'tot_ded' => $saledit->tot_ded,
                                                'ssn' => $saledit->ssn,
                                                'email' => $emp->email,
                                                'dept' => $emp->dept,
                                                'region' => $emp->region,
                                                'bank' => $emp->bank,
                                                'branch' => $emp->branch,
                                                'acc_no' => $emp->acc_no,
                                            ]);
                                        }else{
                                            // return 4;
                                            // Calc & Insert in Salary as well
                                            $sl = Salary::firstOrCreate([
                                                'user_id' => auth()->user()->id,
                                                'month' => date('m-Y'),
                                                'taxation_id' => $tx->id,
                                                'employee_id' => $emp->id,
                                                'position' => $emp->cur_pos,
                                                'salary' => $emp->salary,
                                                'ssf' => $send_ssf,
                                                'sal_aft_ssf' => $sal_aft_ssf,
                                                'rent' => $send_rent,
                                                'prof' => $send_prof,
                                                'taxable_inc' => $sal_taxable_inc,
                                                'income_tax' => $income_tax,
                                                'net_aft_inc_tax' => $net_aft_inc_tax,
                                                'resp' => $resp,
                                                'risk' => $risk,
                                                'vma' => $vma,
                                                'ent' => $ent,
                                                'dom' => $dom,
                                                'intr' => $intr,
                                                'tnt' => $tnt,
                                                'cola' => $cola,
                                                'new1' => $new1,
                                                'new2' => $new2,
                                                'new3' => $new3,
                                                'new4' => $new4,
                                                'new5' => $new5,
                                                'back_pay' => $back_pay,
                                                'net_bef_ded' => $net_bef_ded,
                                                'std_loan' => $std_loan,
                                                'staff_loan' => $staff_loan,
                                                'net_aft_ded' => $net_aft_ded,
                                                'ssf_emp_cont' => $ssf_emp_cont,
                                                'gross_sal' => $gross_sal,
                                                'tot_ded' => $tot_ded,
                                                'ssn' => $emp->ssn,
                                                'email' => $emp->email,
                                                'dept' => $emp->dept,
                                                'region' => $emp->region,
                                                'bank' => $emp->bank,
                                                'branch' => $emp->branch,
                                                'acc_no' => $emp->acc_no,
                                            ]);
                                        }
                                    }
                                    
                                } catch (\Throwable $th) {
                                    throw $th;
                                return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                                }
                        }
                    }
                }

                // 'user_id','month','gross','ssf_emp','fuel_alw','back_pay','total_ssf','total_paye',
                // 'advances','veh_loan','staff_loan','net_pay','debit','credit','status','del'
                $sals = Salary::where('month', date('m-Y'))->get();
                $new_gross = $sals->sum('salary') + $sals->sum('rent') + $sals->sum('prof') + $sals->sum('resp') + $sals->sum('risk') + $sals->sum('vma') + $sals->sum('ent') + $sals->sum('dom') + $sals->sum('intr') + $sals->sum('cola');
                    
                $jv_check = Journal::where('month', date('m-Y'))->first();
                if ($jv_check) {

                    $jv_check->gross = $new_gross;
                    $jv_check->ssf_emp = $sals->sum('ssf_emp_cont');
                    $jv_check->fuel_alw = $sals->sum('tnt');
                    $jv_check->back_pay = $sals->sum('back_pay');
                    $jv_check->total_ssf = $sals->sum('ssf_emp_cont') + $sals->sum('ssf');
                    $jv_check->total_paye = $sals->sum('income_tax');
                    // $jv_check->advances = '';
                    // $jv_check->veh_loan = '';
                    $jv_check->std_loan = $sals->sum('std_loan');
                    $jv_check->staff_loan = $sals->sum('staff_loan');
                    $jv_check->net_pay = $sals->sum('net_aft_ded');
                    $jv_check->debit = $new_gross + $sals->sum('ssf_emp_cont') + $sals->sum('tnt') + $sals->sum('back_pay');
                    $jv_check->credit = $sals->sum('net_aft_ded') + $sals->sum('std_loan') + $sals->sum('staff_loan') + $sals->sum('income_tax') + ($sals->sum('ssf_emp_cont') + $sals->sum('ssf'));
                    $jv_check->save();
                } else {
                    $jv_insert = Journal::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'month' => date('m-Y'),
                        'gross' => $new_gross,
                        'ssf_emp' => $sals->sum('ssf_emp_cont'),
                        'fuel_alw' => $sals->sum('tnt'),
                        'back_pay' => $sals->sum('back_pay'),
                        'total_ssf' => $sals->sum('ssf_emp_cont') + $sals->sum('ssf'),
                        'total_paye' => $sals->sum('income_tax'),
                        // 'advances' => '',
                        // 'veh_loan' => '',
                        'std_loan' => $sals->sum('std_loan'),
                        'staff_loan' => $sals->sum('staff_loan'),
                        'net_pay' => $sals->sum('net_aft_ded'),
                        'debit' => $new_gross + $sals->sum('ssf_emp_cont') + $sals->sum('tnt') + $sals->sum('back_pay'),
                        'credit' => $sals->sum('net_aft_ded') + $sals->sum('std_loan') + $sals->sum('staff_loan') + $sals->sum('income_tax') + ($sals->sum('ssf_emp_cont') + $sals->sum('ssf')),
                    ]);
                }

                // New JV
                try {
                    //code...
                    JV::truncate();
                    $jor = Journal::where('del', 'no')->latest()->first();
                    // Debit
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Gross',
                        'debit' => $jor->gross,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'SSF Employer',
                        'debit' => $jor->ssf_emp,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Fuel Allowance',
                        'debit' => $jor->fuel_alw,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Back Pay',
                        'debit' => $jor->back_pay,
                    ]);

                    // Credit
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Total SSF',
                        'credit' => $jor->total_ssf,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Total Paye',
                        'credit' => $jor->total_paye,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Student Loan',
                        'credit' => $jor->std_loan,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Vehicle Loan',
                        'credit' => $jor->veh_loan,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Staff Loan',
                        'credit' => $jor->staff_loan,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Net Pay',
                        'credit' => $jor->net_pay,
                    ]);
                    $jv = JV::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => 'Staff Loan',
                        'debit' => $jor->debit,
                        'credit' => $jor->credit,
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                }

                return redirect(url()->previous())->with('success', 'Taxation & Salaries Recalculated!');
                // return redirect(url()->previous())->with('success', 'Page Refresh Successful');

            break;

            case 'calc_salaries':
                return 'Oops..!';
            break;

            case 'loan_setup':

                try {
                    $loanset = LoanSetup::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'interest' => $request->input('interest'),
                        'dur' => $request->input('dur'),
                    ]);
                } catch (\Throwable $th) {
                    // throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', 'Loan Interest and Duration successfully set');

            break;

            case 'direct_pay2':
                return 777234235;
            break;

            case 'direct_pay':

                $emp_id = $request->input('emp_id');
                $emp = Employee::find($emp_id);
                // $check = DirectPay::where('employee_id', $emp_id)->latest()->first();
                // if ($check->amt_rem != 0) {
                //     return redirect(url()->previous())->with('error', 'Oops..! '.$emp->fname.' has an outstanding debt. Kindly clear debt to request for a new loan');
                // }

                $amt_paid = $request->input('amt_paid');
                $amt_rem = $emp->loan_bal - $amt_paid;
                $mth_dud = $emp->loan_monthly_ded;
                try {
                    // 'employee_id','amt_paid','amt_rem','dur','del','monthly_dud'
                    $dpay = DirectPay::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'employee_id' => $emp_id,
                        'amt_paid' => $amt_paid,
                        'amt_rem' => $amt_rem,
                        // 'dur' => $request->input('dur'),
                        'monthly_dud' => $mth_dud,
                    ]);

                    if ($dpay) {
                        $loan = Loan::where('employee_id', $emp_id)->first();
                        $loan->bal = $amt_rem;
                        if ($amt_rem < 50) {
                            $loan->dur = 0;
                        }
                        $loan->save();

                        $emp->loan_bal = $amt_rem;
                        $emp->save();
                    }

                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', 'Payment Successful..!');

            break;

            case 'special_loan':
                // $check = DirectPay::where('employee_id', $emp_id)->latest()->first();
                // if ($check->amt_rem != 0) {
                //     return redirect(url()->previous())->with('error', 'Oops..! '.$emp->fname.' has an outstanding debt. Kindly clear debt to request for a new loan');
                // }

                $emp_id = $request->input('emp_id');
                $loan_amt = $request->input('loan_amt');
                $mth_dud = $request->input('mth_dud');
                $dur = $request->input('dur');
                $emp = Employee::find($emp_id);

                $grant_check = LoanGrant::where('employee_id', $emp_id)->where('loan_type', 'special')->latest()->first();
                if ($grant_check != '' && $emp->loan_bal > 50) {
                    return redirect(url()->previous())->with('error', 'Oops..! '.$emp->fname.' has an outstanding debt. Kindly clear debt to request for a new loan');
                }

                // 'user_id','employee_id','loan_amt','monthly_dud','dur','loan_type','status','del'
                $loangrant = LoanGrant::firstOrCreate([
                    'user_id' => auth()->user()->id,
                    'employee_id' => $emp_id,
                    'loan_amt' => $loan_amt,
                    'monthly_dud' => $mth_dud,
                    'dur' => $dur,
                    'loan_type' => 'special',
                    'dur' => $dur,
                ]);

                // return 98789;

                try {
                    $loan = Loan::where('employee_id', $emp_id)->first();
                    $loan->bal = $loan->bal + $loan_amt;
                    if ($loan->bal < 50) {
                        $loan->dur = $dur;
                    }else {
                        $loan->dur = $loan->dur + $dur;
                    }

                    $emp->loan_bal = $emp->loan_bal + $loan_amt;
                    if ($mth_dud != '') {
                        $emp->staff_loan = $mth_dud;
                        $emp->loan_monthly_ded = $mth_dud;
                        $loan->monthly_ded = $mth_dud;
                    }
                    $emp->save();
                    $loan->save();
                } catch (\Throwable $th) {
                    // throw $th;
                    return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', 'Special loan grant successful!');

            break;

            case 'add_salary_cat':
                
                $title = $request->input('title');
                $position = $request->input('position');
                $basic_sal = $request->input('basic_sal');
                $where = [
                    'title' => $title,
                    'position' => $position,
                ];
                $sc_check = SalaryCat::where($where)->count();

                if ($position == 0 && $title == 0) {
                    return redirect(url()->previous())->with('error', 'Oops..! Choose Title & Position to Proceed');
                }
                if ($sc_check > 0) {
                    return redirect(url()->previous())->with('error', 'Position `'.$position.'` Already Exists');
                }
                
                try {
                    if ($title == 'na') {
                        $title = $request->input('title2');
                    }
                    if ($position == 'na') {
                        $position = $request->input('position2');
                    }
                    
                    $salcat = SalaryCat::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'title' => $title,
                        'position' => $position,
                        'basic_sal' => $basic_sal,
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', 'Salary Category Added Successfully');

            break;

            case 'add_dept':
                
                try {
                    $dept_insert = Department::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'dept_name' => $request->input('dept_name'),
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', '`'.$request->input('dept_name').'` Successfully Added to Departments');

            break;

            case 'add_allow':

                $allow_count = AllowanceList::all()->count();
                if ($allow_count == 5) {
                    return redirect(url()->previous())->with('error', 'Oops..! New Allowance slots for five(5) entries exausted');
                }

                $allow_name = $request->input('allow_name');
                $sel_perc = $request->input('sel_perc');
                $allow_perc = $request->input('allow_perc');
                $allow_amt = 0;

                $name_check = AllowanceList::where('allow_name', $allow_name)->count();
                if ($name_check > 0) {
                    return redirect(url()->previous())->with('error', 'Oops..! Allowance already exists');
                }

                if ($sel_perc == 0) {
                    return redirect(url()->previous())->with('error', 'Oops..! Select Percentage / Amount');
                } elseif ($sel_perc == 2) {
                    $allow_amt = $allow_perc;
                    $allow_perc = 0;
                }
                
                
                try {
                    $allowlist = AllowanceList::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'allow_name' => $allow_name,
                        'allow_perc' => $allow_perc,
                        'allow_amt' => $allow_amt,
                    ]);
                    $alo = AllowanceOverview::where('del', 'no')->latest()->first();
                    $new = 'new'.$allowlist->id;
                    if ($allow_amt == 0) {
                        $alo->$new = $allow_perc;
                    } else {
                        $alo->$new = $allow_amt;
                    }
                    $alo->save();

                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', '`'.$request->input('allow_name').'` Successfully Added to Allowances');

            break;

            case 'search_emp':

                // Search Employee Data
                $src = $request->input('search_emp');
                // return $src;
                $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
                $position = SalaryCat::orderBy('position', 'ASC')->get();
                $employees = Employee::where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->paginate(20);
                $patch = [
                    'c' => 1,
                    'regions' => $regions,
                    'main_regions' => Region::all(),
                    'position' => $position,
                    'employees' => $employees
                ];
                return view('dash.pay_employee_view')->with($patch);
                // End Search

            break;

            case 'search_alw':

                // Search Allowance Data
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

            break;

            case 'add_emp':
                // $bank = $request->input('bankk');
                // return $bank;

                // return 789;
                if ($request->input('rent_allow')) {
                    $rent = 'yes';
                } else {
                    $rent = 'no';
                }
                    // $prof = $empr->prof;
                if ($request->input('prof_allow')) {
                    $prof = 'yes';
                } else {
                    $prof = 'no';
                }
                if ($request->input('resp_allow')) {
                    $resp = 'yes';
                } else {
                    $resp = 'no';
                }
                if ($request->input('risk_allow')) {
                    $risk = 'yes';
                } else {
                    $risk = 'no';
                }
                if ($request->input('vma_allow')) {
                    $vma = 'yes';
                } else {
                    $vma = 'no';
                }
                if ($request->input('ent_allow')) {
                    $ent = 'yes';
                } else {
                    $ent = 'no';
                }
                if ($request->input('dom_allow')) {
                    $dom = 'yes';
                } else {
                    $dom = 'no';
                }
                // if ($request->input('intr_allow')) {
                //     $intr = 'yes';
                // } else {
                //     $intr = 'no';
                // }
                // if ($request->input('tnt_allow')) {
                //     $tnt = 'yes';
                // } else {
                //     $tnt = 'no';
                // }
                if ($request->input('cola_allow')) {
                    $cola = 'yes';
                } else {
                    $cola = 'no';
                }
                if ($request->input('allow1')) {
                    $new1 = 'yes';
                } else {
                    $new1 = 'no';
                }
                if ($request->input('allow2')) {
                    $new2 = 'yes';
                } else {
                    $new2 = 'no';
                }
                if ($request->input('allow3')) {
                    $new3 = 'yes';
                } else {
                    $new3 = 'no';
                }
                if ($request->input('allow4')) {
                    $new4 = 'yes';
                } else {
                    $new4 = 'no';
                }
                if ($request->input('allow5')) {
                    $new5 = 'yes';
                } else {
                    $new5 = 'no';
                }



                $region = $request->input('region');
                if ($region == 'all' || $request->input('bank') == 'all' || $request->input('branch') == 'all') {
                    return redirect(url()->previous())->with('error', 'Oops..! Select Region, Bank & Branch to Proceed');
                }
                if ($request->input('bank') == 'na' && $request->input('branch') == '') {
                    return redirect(url()->previous())->with('error', 'Oops..! Type Bank & Branch to Proceed');
                }
                if ($request->input('position') == 'all' || $request->input('sub_div') == 'all' || $request->input('salary_cat') == 'all' || $request->input('dept') == 'all') {
                    return redirect(url()->previous())->with('error', 'Oops..! Position / Sub Div. / Salary Cat. & Department fields are required');
                }

                $bank = $request->input('bank');
                // return $bank;
                if ($request->input('bank') == 'na') {
                    $bank = $request->input('bank2');
                    $bank_check = Bank::where('bank_abr', $bank)->orwhere('bank_fullname', $bank)->count();
                    if ($bank_check > 0) {
                        return redirect(url()->previous())->with('error', 'Oops..! '.$bank.' already exists');
                    } else {
                        $bank_insert = Bank::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'bank_abr' => $bank,
                            'bank_fullname' => $bank,
                        ]);
                    }
                    $bank = $bank_insert->bank_abr;
                    $bank_id = $bank_insert->id;
                    
                } else {
                    $find_bank = Bank::find($bank);
                    $bank = $find_bank->bank_abr;
                    $bank_id = $find_bank->id;
                }

                if ($request->input('branch') == 'na') {
                    $branch = $request->input('branch2');
                } else {
                    $branch = $request->input('branch');
                }

                $fname = $request->input('fname');
                $sal_id = $request->input('position');
                $salCat = SalaryCat::find($sal_id);
                $contact = $request->input('contact');
                $email = $request->input('email');
                $ssn = $request->input('ssn');
                $emp_check = Employee::where('contact', $contact)->orwhere('email', $email)->orwhere('ssn', $ssn)->get();
                
                if (count($emp_check) > 0) {
                    return redirect(url()->previous())->with('error', 'Oops..! Details already exist');
                } else {

                    try {
                        $this->validate($request, [
                            'pass_photo'  => 'max:5000|mimes:jpeg,jpg,png'
                        ]);
                        if($request->hasFile('pass_photo')){
                            //get filename with ext
                            $filenameWithExt = $request->file('pass_photo')->getClientOriginalName();
                            //get filename
                            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                            //get file ext
                            $fileExt = $request->file('pass_photo')->getClientOriginalExtension();
                            //filename to store
                            $filenameToStore = $fname.substr( $contact, -4).'.'.$fileExt;
                            //upload path
                            $path = $request->file('pass_photo')->storeAs('public/classified/emps', $filenameToStore);
                        }else{
                        //     return 171819;
                            $filenameToStore = 'noimage.png';
                        }
            
                    } catch (Exception $ex) {
                        return redirect(url()->previous())->with('error', 'Ooops..! File Error');
                    }
                
                    try {
                        $emp_insert = Employee::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'salary_id' => $sal_id,
                            'bank_id' => $bank_id,
                            'afis_no' => $request->input('afis_no'),
                            'fname' => $fname,
                            'sname' => $request->input('sname'),
                            'oname' => $request->input('oname'),
                            'dob' => $request->input('dob'),
                            'mname' => $request->input('mname'),
                            'gender' => $request->input('gender'),
                            'email' => $email,
                            'contact' => $contact,
                            // 'oname' => $oname,
                            'position' => $salCat->position,
                            'cur_pos' => $salCat->position,
                            'ssn' => $ssn,
                            'salary' => $request->input('basic_sal'),
                            'dept' => $request->input('dept'),
                            'region' => $region,
                            'date_emp' => $request->input('date_emp'),
                            'bank' => $bank,
                            'branch' => $branch,
                            'acc_no' => $request->input('acc_no'),
                            'sub_div' => $request->input('sub_div'),
                            'photo' => $filenameToStore,
                            'staff_loan' => 0,
                            // 'loan_date_started','loan_bal','loan_montly_ded'
                        ]);

                        if ($request->input('intr') == '') {
                            $intr2 = 0;
                        }else{
                            $intr2 = $request->input('intr');
                        }
                        if ($request->input('tnt') == '') {
                            $tnt2 = 0;
                        }else{
                            $tnt2 = $request->input('tnt');
                        }
                
                        $allow_check = Allowance::where('employee_id', $emp_insert->id)->get();
                        if (count($allow_check) < 1) {
                            $alw_insert = Allowance::firstOrCreate([
                                'user_id' => auth()->user()->id,
                                'employee_id' => $emp_insert->id,
                                'fname' => $request->input('fname'),
                                'rent' => $rent,
                                'prof' => $prof,
                                'resp' => $resp,
                                'risk' => $risk,
                                'vma' => $vma,
                                'ent' => $ent,
                                'dom' => $dom,
                                'intr' => $intr2,
                                'tnt' => $tnt2,
                                'cola' => $cola,
                                'new1' => $new1,
                                'new2' => $new2,
                                'new3' => $new3,
                                'new4' => $new4,
                                'new5' => $new5,
                            ]);

                            $loan_insert = Loan::firstOrCreate([
                                'user_id' => auth()->user()->id,
                                'employee_id' => $emp_insert->id,
                            ]);

                            // Insert Allowance ID
                            // $all_ins = Employee::find($emp_insert->id);
                            $emp_insert->allowance_id = $alw_insert->id;
                            $emp_insert->save();

                            $emp_insert->loan_id = $loan_insert->id;
                            $emp_insert->save();
                        }

                        // if ($request->input('bank2') != '') {
                        //     $bank_insert = Bank::firstOrCreate([
                        //         'user_id' => auth()->user()->id,
                        //         'bank_abr' => $emp_insert->bank,
                        //         'bank_fullname' => $emp_insert->bank,
                        //     ]);
                        //     $emp_insert->bank_id = $bank_insert->id;
                        //     $emp_insert->save();
                        // }
                        

                    } catch (\Throwable $th) {
                        throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                    }

                    return redirect(url()->previous())->with('success', $request->input('fname').'`s details successfully added');
                }

            break;

            case 'add_allowexp':
                $emp_id = $request->input('employee');
                if ($emp_id == 'all') {
                    return redirect(url()->previous())->with('error', 'Select name to proceed');
                }
                $emp = Employee::find($emp_id);
                // return $emp_id;

                $alx = Allowexp::where('employee_id', $emp_id)->latest()->first();
                if ($alx) {
                    $alx->del = 'no';
                    $alx->save();
                } else {
                    $alv = Allowanceoverview::where('del', 'no')->latest()->first();
                    try {
                        $alx = Allowexp::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'employee_id' => $emp_id,
                            'allowance_id' => $emp->allowance_id,
                            'rent' => $alv->rent,
                            'prof' => $alv->prof,
                            'resp' => $alv->resp,
                            'risk' => $alv->risk,
                            'vma' => $alv->vma,
                            'ent' => $alv->ent,
                            'dom' => $alv->dom,
                            'intr' => $alv->intr,
                            'tnt' => $alv->tnt,
                            'cola' => $alv->cola,
                            'ssf' => $alv->ssf,
                            'ssf1' => $alv->ssf1,
                            'ssf2' => $alv->ssf2,
                            'new1' => $alv->new1,
                            'new2' => $alv->new2,
                            'new3' => $alv->new3,
                            'new4' => $alv->new4,
                            'new5' => $alv->new5,
                        ]);
                    } catch (\Throwable $th) {
                        throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                    }
                }
                

                return redirect(url()->previous())->with('success', 'Allowance exception added for '.$emp->fname);

            break;

            case 'remove_allowexp':
                // return 777;
                $emp_id = $request->input('employee');
                
                $alv = Allowanceoverview::where('del', 'no')->latest()->first();
                $alx = Allowexp::where('employee_id', $emp_id)->latest()->first();
                // return $alx->employee->fname;
                if ($alx) {
                    $alx->rent = $alv->rent;
                    $alx->prof = $alv->prof;
                    $alx->resp = $alv->resp;
                    $alx->risk = $alv->risk;
                    $alx->vma = $alv->vma;
                    $alx->ent = $alv->ent;
                    $alx->dom = $alv->dom;
                    $alx->intr = $alv->intr;
                    $alx->tnt = $alv->tnt;
                    $alx->cola = $alv->cola;
                    $alx->ssf = $alv->ssf;
                    $alx->ssf1 = $alv->ssf1;
                    $alx->ssf2 = $alv->ssf2;
                    $alx->new1 = $alv->new1;
                    $alx->new2 = $alv->new2;
                    $alx->new3 = $alv->new3;
                    $alx->new4 = $alv->new4;
                    $alx->new5 = $alv->new5;
                    $alx->del = 'yes';
                    $alx->save();
                    return redirect(url()->previous())->with('success', 'Record deletion successfull for '.$alx->employee->fname);
                } else {
                    return redirect(url()->previous())->with('error', 'Oops..! No record found');
                }
                
                    

                // return redirect(url()->previous())->with('success', 'Page Refresh Successful');

            break;

            case 'val_withhold_all':
                $validation = Validation::where('month', date('01-m-Y'))->where('status', 'Pending')->get();
                try {
                    foreach ($validation as $val) {
                        $val->status = 'Withheld';
                        $val->save();
                        $emp = Employee::find($val->employee->id);
                        $emp->status = 'inactive';
                        $emp->save();
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                return redirect(url()->previous())->with('success', 'Records successfully validated for '. date('F, Y'));
            break;

            case 'val_release_all':
                $validation = Validation::where('month', date('01-m-Y'))->where('status', 'Withheld')->get();
                try {
                    foreach ($validation as $val) {
                        $val->status = 'Pay';
                        $val->save();
                        $emp = Employee::find($val->employee->id);
                        $emp->status = 'Active';
                        $emp->save();
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
                return redirect(url()->previous())->with('success', 'Release records successfully validated for '.date('F, Y'));
            break;

            case 'verify_otp':

                $start = auth()->user()->otp_time;
                $end = date("Y-m-d h:i:s");
                $dt_diff = round((strtotime($end)-strtotime($start)) / 60, 2);
                // return $dt_diff;
                // return auth()->user()->temp_pass.' | '.$request->input('temp_pass');
                if (auth()->user()->temp_pass == $request->input('temp_pass')) {
                    Session::put('temp_pass', $request->input('temp_pass'));
                    Session::put('check_otp_redirect', 'verified');
                    Session::put('otp_try_count', 0);
                    Session::put('otp_sms_count', 0); 
                    return redirect('/');
                } else {
                    if ($dt_diff >= 1) {
                        return redirect('/otp-verification')->with('error', 'Oops..! OTP verification timeout. Resend OTP');
                    }
                    // Increase count and disable at 3
                    Session::put('otp_try_count', session('otp_try_count') + 1);
                    if (session('otp_try_count') >= 3) {
                        // Auth::logout();
                        return redirect('/account-block')->with('error', 'Account disabled..! Try log in after 10 minutes.');
                        // return redirect('/logout')->with('error', 'Account disabled..! Try logging in after 10 minutes');
                    }
                    return redirect(url()->previous())->with('error', 'Oops..! Incorrect OTP. Account will be disabled after third try');
                }
                
                // try {
                //     return redirect('/');
                // } catch (ValidationException $exception) {
                //     return redirect(url()->previous())->with('Error', $exception->errors());
                // }

            break;

            case 'send_new_otp':
                return 89787987;
                Session::put('otp_sms_count', 0);
                return redirect('/otp-verification')->with('warning', 'Input new OTP sent to '.substr(auth()->user()->contact, 0, 5).'*****');
            break;

            case 'clear_sms_contacts':
                // return 112;
                
                $smss = SMS::where('user_id', auth()->user()->id)->get();
                foreach ($smss as $sms) {
                    $sms->delete();
                }
                return redirect(url()->previous());

            break;

            case 'send_sms':
                $sms_hold = '';
                $msg = $request->input('message');
                $sms_act = $request->input('sms_action');
                if ($sms_act != 'Selected Contacts') {
                    if ($sms_act != 'All') {
                        $emp_sel = Employee::where('department_id', $sms_act)->get();
                    }else {
                        $emp_sel = Employee::all();
                    }
                    foreach ($emp_sel as $es) {
                        $user = User::where('employee_id', $es->id)->latest()->first();
                        if (!empty($es->contact)) {
                            $insert_sms = SMS::firstOrCreate([
                                'sender_id' => auth()->user()->id,
                                'user_id' => $user->id,
                                'employee_id' => $es->id,
                                'contact' => $user->contact
                            ]);
                        }
                    }
                }
                $smss = SMS::where('sender_id', auth()->user()->id)->get(); 
                if ($sms_act == 'Selected Contacts' && count($smss) == 0) {
                    return redirect(url()->previous())->with('error', 'Oops..! Select contacts from `View/Edit Data` page to add to queue');
                }
                if ($msg == '') {
                    return redirect(url()->previous())->with('error', 'Oops..! Type message to proceed');
                }
                Session::put('smss', $smss);
                Session::put('send01', 1);
                try {
                    // 'user_id','message','sent_to'
                    if ($sms_act == 'Selected Contacts') {
                        foreach ($smss as $sms) {
                            $sms_hold = $sms->contact.','.$sms_hold;
                        }
                    }else {
                        $sms_hold = $sms_act;
                        // return $sms_hold;
                    }
                    $send_sms = SmsHistory::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'sent_to' => $sms_hold,
                        'message' => $msg,
                        // 'message' => str_replace('*FULLNAME*, ','',$msg),
                    ]);
                    // return $sms_hold;

                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                foreach ($smss as $sms) {
                    $sms->delete();
                }
                // Kindly be informed that bla bla bla....
                $patch = [
                    // 'c' => 1,
                    'c' => 1,
                    'msg' => $msg,
                    'sms_det' => $send_sms,
                    'sms' => SMS::all(),
                    'sms_history' => SmsHistory::all(),
                    'department' => Department::all(),
                    'success' => 'Message successfully sent to all contacts in queue',
                ];
                return view('dash.pay_bulksms')->with($patch);
                return redirect('/bulksms')->with($patch);
                return view('dash.sendsms')->with('success', 'Message successfully sent to all contacts in queue');

            break;

            case 'publish_sal':
                $sals = Salary::where('month', date('m-Y'))->get();
                foreach ($sals as $sal) {
                    $sal->status = 'Paid';
                    $sal->save();
                }
                return redirect(url()->previous())->with('success', 'Salary records for '.date('M-Y').' successfully published');
            break;

            case 'unpublish_sal':
                $sals = Salary::where('month', date('m-Y'))->get();
                foreach ($sals as $sal) {
                    $sal->status = 'no';
                    $sal->save();
                }
                return redirect(url()->previous())->with('success', 'Salary records for '.date('M-Y').' has been unpublished');
            break;

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $emp = Employee::find($id);
        // return $emp->photo;
        $send = [
            'emp' => $emp
        ];
        return view('dash.emp_profile')->with($send);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

        switch ($request->input('update_action')) {


            // Update

            case 'pin_sms':
                $smh = SmsHistory::find($id);
                $smh->pin = 'yes';
                $smh->save();
                return redirect(url()->previous())->with('success', 'Template pin successfull');
            break;

            case 'unpin_sms':
                $smh = SmsHistory::find($id);
                $smh->pin = 'no';
                $smh->save();
                return redirect(url()->previous())->with('success', 'Template has been unpined');
            break;

            case 'edit_sal':
                // return 'KKOops..!';
                $sal = Salary::find($id);
                $sl = Saledit::where('month', date('m-Y'))->where('employee_id', $sal->employee_id)->latest()->first();
                // return $sl;

                $rent = $request->input('rent');
                $prof = $request->input('prof');
                // $request->input('taxable_inc') $sal_taxable_inc;
                // $request->input('income_tax') $income_tax;
                // $request->input('net_aft_inc_tax') $net_aft_inc_tax;
                $resp = $request->input('resp');
                $risk = $request->input('risk');
                $vma = $request->input('vma');
                $ent = $request->input('ent');
                $dom = $request->input('dom');
                $intr = $request->input('intr');
                $tnt = $request->input('tnt');
                $cola = $request->input('cola');

                $pay_perc = $request->input('pay_perc');
                // return 2675.253682125 * ($pay_perc / 100);

                if ($request->input('new1')) {
                    $new1 = $request->input('new1');
                }else {
                    $new1 = 0;
                }
                if ($request->input('new2')) {
                    $new2 = $request->input('new2');
                }else {
                    $new2 = 0;
                }
                if ($request->input('new3')) {
                    $new3 = $request->input('new3');
                }else {
                    $new3 = 0;
                }
                if ($request->input('new4')) {
                    $new4 = $request->input('new4');
                }else {
                    $new4 = 0;
                }
                if ($request->input('new5')) {
                    $new5 = $request->input('new5');
                }else {
                    $new5 = 0;
                }
                $back_pay = $request->input('back_pay');
                $std_loan = $request->input('std_loan');
                $staff_loan = $request->input('staff_loan');
                $inc_tax = $request->input('income_tax');
                // $std_loan = $emp->std_loan;
                // $staff_loan = $emp->staff_loan;
                

                // Salary Workings
                $sal_taxable_inc = $sal->sal_aft_ssf + $rent + $prof;
                $net_aft_inc_tax = $sal_taxable_inc - $inc_tax;
                $net_bef_ded = $net_aft_inc_tax + $resp + $risk + $vma + $ent + $dom + $intr + $tnt + $cola + $new1 + $new2 + $new3 + $new4 + $new5 + $back_pay;
                $net_aft_ded = $net_bef_ded - $staff_loan - $std_loan;
                // $net_aft_ded = ($net_bef_ded - $staff_loan - $std_loan) * ($pay_perc / 100);
                $tot_ded = $sal->ssf + $inc_tax + $std_loan + $staff_loan;
                $gross_sal = $sal->sal_aft_ssf + $rent + $prof + $resp + $risk + $vma + $ent + $dom + $intr + $tnt + $cola + $new1 + $new2 + $new3 + $new4 + $new5 + $back_pay;
                // return $net_aft_ded;
                try {

                    if ($sl) {
                        $sl->rent = $rent;
                        $sl->prof = $prof;
                        $sl->taxable_inc = $sal_taxable_inc;
                        $sl->income_tax = $inc_tax;
                        $sl->net_aft_inc_tax = $net_aft_inc_tax;
                        $sl->resp = $resp;
                        $sl->risk = $risk;
                        $sl->vma = $vma;
                        $sl->ent = $ent;
                        $sl->dom = $dom;
                        $sl->intr = $intr;
                        $sl->tnt = $tnt;
                        $sl->cola = $cola;
                        $sl->new1 = $new1;
                        $sl->new2 = $new2;
                        $sl->new3 = $new3;
                        $sl->new4 = $new4;
                        $sl->new5 = $new5;
                        $sl->back_pay = $back_pay;
                        $sl->net_bef_ded = $net_bef_ded;
                        $sl->std_loan = $std_loan;
                        $sl->staff_loan = $staff_loan;
                        $sl->net_aft_ded = $net_aft_ded;
                        // $sl->pay_perc = $pay_perc;
                        // $sl->ssf_emp_cont = $ssf_emp_cont;
                        $sl->gross_sal = $gross_sal;
                        $sl->tot_ded = $tot_ded;
                        $sl->save();
                    } else {
                        $sl = Saledit::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'month' => date('m-Y'),
                            'taxation_id' => $sal->taxation_id,
                            'employee_id' => $sal->employee_id,
                            'position' => $sal->position,
                            'salary' => $sal->salary,
                            'ssf' => $sal->ssf,
                            'sal_aft_ssf' => $sal->sal_aft_ssf,
                            'rent' => $rent,
                            'prof' => $prof,
                            'taxable_inc' => $sal_taxable_inc,
                            'income_tax' => $inc_tax,
                            'net_aft_inc_tax' => $net_aft_inc_tax,
                            'resp' => $resp,
                            'risk' => $risk,
                            'vma' => $vma,
                            'ent' => $ent,
                            'dom' => $dom,
                            'intr' => $intr,
                            'tnt' => $tnt,
                            'cola' => $cola,
                            'new1' => $new1,
                            'new2' => $new2,
                            'new3' => $new3,
                            'new4' => $new4,
                            'new5' => $new5,
                            'back_pay' => $back_pay,
                            'net_bef_ded' => $net_bef_ded,
                            'std_loan' => $std_loan,
                            'staff_loan' => $staff_loan,
                            'net_aft_ded' => $net_aft_ded,
                            // 'pay_perc' => $pay_perc,
                            'ssf_emp_cont' => $sal->ssf_emp_cont,
                            'gross_sal' => $gross_sal,
                            'tot_ded' => $tot_ded,
                            'ssn' => $sal->ssn,
                            'email' => $sal->email,
                            'dept' => $sal->dept,
                            'region' => $sal->region,
                            'bank' => $sal->bank,
                            'branch' => $sal->branch,
                            'acc_no' => $sal->acc_no,
                        ]);
                        $sl->status = 'used';
                        $sl->save();
                    }


                    // Update Salary with neww values
                    $sal->rent = $rent;
                    $sal->prof = $prof;
                    $sal->taxable_inc = $sal_taxable_inc;
                    $sal->income_tax = $inc_tax;
                    $sal->net_aft_inc_tax = $net_aft_inc_tax;
                    $sal->resp = $resp;
                    $sal->risk = $risk;
                    $sal->vma = $vma;
                    $sal->ent = $ent;
                    $sal->dom = $dom;
                    $sal->intr = $intr;
                    $sal->tnt = $tnt;
                    $sal->cola = $cola;
                    $sal->new1 = $new1;
                    $sal->new2 = $new2;
                    $sal->new3 = $new3;
                    $sal->new4 = $new4;
                    $sal->new5 = $new5;
                    $sal->back_pay = $back_pay;
                    $sal->net_bef_ded = $net_bef_ded;
                    $sal->std_loan = $std_loan;
                    $sal->staff_loan = $staff_loan;
                    $sal->net_aft_ded = $net_aft_ded;
                    // $sal->pay_perc = $pay_perc;
                    // $sal->ssf_emp_cont = $ssf_emp_cont;
                    $sal->gross_sal = $gross_sal;
                    $sal->tot_ded = $tot_ded;
                    $sal->save();


                    // Update Journals with new values
                    $sals = Salary::where('month', date('m-Y'))->get();
                    $new_gross = $sals->sum('salary') + $sals->sum('rent') + $sals->sum('prof') + $sals->sum('resp') + $sals->sum('risk') + $sals->sum('vma') + $sals->sum('ent') + $sals->sum('dom') + $sals->sum('intr') + $sals->sum('cola');
                    

                    $jv_check = Journal::where('month', date('m-Y'))->first();
                    if ($jv_check) {
                        $jv_check->gross = $new_gross;
                        $jv_check->ssf_emp = $sals->sum('ssf_emp_cont');
                        $jv_check->fuel_alw = $sals->sum('tnt');
                        $jv_check->back_pay = $sals->sum('back_pay');
                        $jv_check->total_ssf = $sals->sum('ssf_emp_cont') + $sals->sum('ssf');
                        $jv_check->total_paye = $sals->sum('income_tax');
                        // $jv_check->advances = '';
                        // $jv_check->veh_loan = '';
                        $jv_check->std_loan = $sals->sum('std_loan');
                        $jv_check->staff_loan = $sals->sum('staff_loan');
                        $jv_check->net_pay = $sals->sum('net_aft_ded');
                        $jv_check->debit = $new_gross + $sals->sum('ssf_emp_cont') + $sals->sum('tnt') + $sals->sum('back_pay');
                        $jv_check->credit = $sals->sum('net_aft_ded') + $sals->sum('std_loan') + $sals->sum('staff_loan') + $sals->sum('income_tax') + ($sals->sum('ssf_emp_cont') + $sals->sum('ssf'));
                        $jv_check->save();
                    } else {
                        $jv_insert = Journal::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'month' => date('m-Y'),
                            'gross' => $new_gross,
                            'ssf_emp' => $sals->sum('ssf_emp_cont'),
                            'fuel_alw' => $sals->sum('tnt'),
                            'back_pay' => $sals->sum('back_pay'),
                            'total_ssf' => $sals->sum('ssf_emp_cont') + $sals->sum('ssf'),
                            'total_paye' => $sals->sum('income_tax'),
                            // 'advances' => '',
                            // 'veh_loan' => '',
                            'std_loan' => $sals->sum('std_loan'),
                            'staff_loan' => $sals->sum('staff_loan'),
                            'net_pay' => $sals->sum('net_aft_ded'),
                            'debit' => $new_gross + $sals->sum('ssf_emp_cont') + $sals->sum('tnt') + $sals->sum('back_pay'),
                            'credit' => $sals->sum('net_aft_ded') + $sals->sum('std_loan') + $sals->sum('staff_loan') + $sals->sum('income_tax') + ($sals->sum('ssf_emp_cont') + $sals->sum('ssf')),
                        ]);
                    }

                    // New JV
                    try {
                        //code...
                        JV::truncate();
                        $jor = Journal::where('del', 'no')->latest()->first();
                        // Debit
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Gross',
                            'debit' => $jor->gross,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'SSF Employer',
                            'debit' => $jor->ssf_emp,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Fuel Allowance',
                            'debit' => $jor->fuel_alw,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Back Pay',
                            'debit' => $jor->back_pay,
                        ]);

                        // Credit
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Total SSF',
                            'credit' => $jor->total_ssf,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Total Paye',
                            'credit' => $jor->total_paye,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Student Loan',
                            'credit' => $jor->std_loan,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Vehicle Loan',
                            'credit' => $jor->veh_loan,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Staff Loan',
                            'credit' => $jor->staff_loan,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Net Pay',
                            'credit' => $jor->net_pay,
                        ]);
                        $jv = JV::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'title' => 'Staff Loan',
                            'debit' => $jor->debit,
                            'credit' => $jor->credit,
                        ]);
                    } catch (\Throwable $th) {
                        throw $th;
                    }
                
                } catch (\Throwable $th) {
                    //throw $th;
                    return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', $sal->employee->fname.'`s record changes successfully saved');
                
            break;

            case 'up_saledit_status':
                $slt = Saledit::find($id);
                // return $slt->employee->fname;
                $slt->status = 'applied';
                $slt->save();

                // $where = ['month' => date('m-Y'), 'employee_id' => $emp->id];
                // $saledit = Saledit::where($where)->first();

                // Copy Calc from Saledit to Update Salary
                $new_slt = Saledit::firstOrCreate([
                    'user_id' => auth()->user()->id,
                    'month' => date('m-Y'),
                    'taxation_id' => $slt->taxation_id,
                    'employee_id' => $slt->employee_id,
                    'position' => $slt->position,
                    'salary' => $slt->salary,
                    'ssf' => $slt->ssf,
                    'sal_aft_ssf' => $slt->sal_aft_ssf,
                    'rent' => $slt->rent,
                    'prof' => $slt->prof,
                    'taxable_inc' => $slt->taxable_inc,
                    'income_tax' => $slt->income_tax,
                    'net_aft_inc_tax' => $slt->net_aft_inc_tax,
                    'resp' => $slt->resp,
                    'risk' => $slt->risk,
                    'vma' => $slt->vma,
                    'ent' => $slt->ent,
                    'dom' => $slt->dom,
                    'intr' => $slt->intr,
                    'tnt' => $slt->tnt,
                    'cola' => $slt->cola,
                    'new1' => $slt->new1,
                    'new2' => $slt->new2,
                    'new3' => $slt->new3,
                    'new4' => $slt->new4,
                    'new5' => $slt->new5,
                    'back_pay' => $slt->back_pay,
                    'net_bef_ded' => $slt->net_bef_ded,
                    'std_loan' => $slt->std_loan,
                    'staff_loan' => $slt->staff_loan,
                    'net_aft_ded' => $slt->net_aft_ded,
                    'ssf_emp_cont' => $slt->ssf_emp_cont,
                    'gross_sal' => $slt->gross_sal,
                    'tot_ded' => $slt->tot_ded,
                    'ssn' => $slt->ssn,
                    'email' => $slt->email,
                    'dept' => $slt->dept,
                    'region' => $slt->region,
                    'bank' => $slt->bank,
                    'branch' => $slt->branch,
                    'acc_no' => $slt->acc_no,
                ]);
                $new_slt->status = 'used';
                $new_slt->save();
                return redirect(url()->previous())->with('success', date('M-Y', strtotime(date('Y-m')." -1 month")).' salary record changes for '.$slt->employee->fname.' has been successfully applied to '.date('M-Y').' records');
            break;

            case 'abc':
                return 12;
            break;

            case 'staff_update_leave':
                try {
                    $emp = auth()->user()->employee;
                    $start = $request->input('from');
                    $end = $request->input('to');
                    // $days = $request->input('days');
                    $hand_over = $request->input('hand_over');
                    $dt_diff = (strtotime($end)-strtotime($start)) / (60 * 60 * 24);
                    // return $hand_over;

                    if ($dt_diff < 0) {
                        return redirect(url()->previous())->with('error', 'Oops..! Start date cannot be ahead of end date');
                    }
                    if ($hand_over == 'none') {
                        return redirect(url()->previous())->with('error', 'Oops..! Select who you are handing over to');
                    }

                    $leave = Leave::find($id);
                    $leave->user_id = auth()->user()->id;
                    $leave->employee_id = $emp->id;
                    $leave->leave_type = $request->input('sname');
                    $leave->start_date = $start;
                    $leave->end_date = $end;
                    $leave->hand_over = $hand_over;
                    $leave->leave_notes = $request->input('leave_notes');
                    $leave->days = $dt_diff;
                    $leave->save();
                    return redirect(url()->previous())->with('success', "Leave update successful");
                } catch (\Throwable $th) {
                    throw $th;
                    return redirect(url()->previous())->with('error', 'Oops..! Something went wrong');
                }
            break;

            // case 'del_leave_request':
            //     return $id;
            //     $leave = Leave::find($id);
            //     $leave->del = 'no';
            //     $leave->save();
            //     return redirect(url()->previous())->with('success', 'Record deletion successful!');
            // break;

            case 'update_employee':
                try {
                    $emp = Employee::find($id);
                    $emp->afis_no = $request->input('afis_no');
                    $emp->fname = $request->input('fname');
                    $emp->sname = $request->input('sname');
                    $emp->oname = $request->input('oname');
                    $emp->contact = $request->input('contact');
                    $emp->position = $emp->cur_pos;
                    $emp->cur_pos = $request->input('position');
                    $emp->region = $request->input('region');
                    $emp->reg_mgr = $request->input('reg_mgr');
                    $emp->salary = $request->input('sal_txtfield'); // 1871.218
                    $emp->pay_perc = $request->input('pay_perc');
                    $emp->save();
                    return redirect(url()->previous())->with('success', $request->input('fname')."'s details successfully updated!");
                } catch (\Throwable $th) {
                    // throw $th;
                    return redirect(url()->previous())->with('error', 'Oops..! Something went wrong');
                }
            break;

            case 'grant_loan':

                $loanset = LoanSetup::all()->count();
                if ($loanset < 1) {
                    return redirect(url()->previous())->with('warning', 'Warning..! Set up loan interest & duration at `Loan Setup` to proceed');
                }
                // return 'Grant Loan';
                // 841.99804131162

                $emp = Employee::find($id);
                $loan = Loan::where('employee_id', $id)->latest()->first();
                $loanset = LoanSetup::latest()->first();
                $interest = $loanset->interest;
                $dur = $loanset->dur;
                $elig_calc = $emp->salary * 12;
                $lump_sum = $elig_calc + (($interest/100) * $elig_calc);
                $amt_paid = Salary::where('employee_id', $id)->sum('staff_loan');

                if ($loan->interest != '') {
                    // Employee promotions may affect $lump_sum & others
                    $interest = $loan->interest;
                    $dur = $loan->dur;
                    $lump_sum = $elig_calc + (($interest/100) * $elig_calc);
                }
                
                $bal = $lump_sum - $amt_paid;

                try {
                    // $loan = Loan::firstOrCreate([
                    //     'user_id' => auth()->user()->id,
                    //     'interest' => $request->input('interest'),
                    //     'dur' => $request->input('dur'),
                    // ]);
                    // 'user_id','employee_id','elig_amt','lump_sum','dur','interest','monthly_ded','bal','date_started','months_left','status'
                    
                    if ($bal <= 0) {
                        $loan->elig_amt = '';
                        $loan->lump_sum = '';
                        $loan->dur = '';
                        $loan->interest = '';
                        $loan->monthly_ded = 0;
                        $loan->bal = 0;
                        $loan->status = 'paid';
                        $loan->date_started = '';
                    } else {
                        $loan->elig_amt = $elig_calc;
                        $loan->lump_sum = $lump_sum;
                        $loan->dur = $dur;
                        $loan->interest = $interest;
                        $loan->monthly_ded = $lump_sum / $dur;
                        $loan->bal = $bal;
                        $loan->status = 'active';
                    }
                    if ($loan->date_started == '') {
                        $loan->date_started = date('d-m-Y');
                        $emp->loan_date_started = date('d-m-Y');
                    }
                    $loan->save();
                    $emp->staff_loan = $lump_sum / $dur;
                    $emp->loan_bal = $bal;
                    // $emp->loan_monthly_ded = $lump_sum / $dur;
                    $emp->save();

                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }

                $patch = [
                    'loans' => Loan::all(),
                    'success' => 'Loan granted for '.$emp->fname.' with an interest of '.$interest.'% through '.$dur.' months.',
                ];
                return redirect(url()->previous())->with($patch);

            break;

            case 'staff_del_leave':
                $leave = Leave::find($id);
                // $leave->del = 'yes';
                $leave->delete();
                return redirect(url()->previous())->with('success', 'Leave record successfully deleted!');
            break;

            case 'update_dept':
                $dept = Department::find($id);
                $dept->dept_name = $request->input('dept_name');
                $dept->save();
                return redirect(url()->previous())->with('success', $dept->name.' Updated Successfully!');
            break;

            case 'update_user':
                $ps1 = $request->input('password');
                $ps2 = $request->input('password_confirmation');
                $status = $request->input('status');
                if ($ps1 != $ps2) {
                    return redirect(url()->previous())->with('error', 'Oops..! Passwords do not match');
                }
                $user = User::find($id);
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->contact = $request->input('contact');
                if ($status) {
                    $user->status = $status;
                }
                if ($ps1) {
                    $user->password = Hash::make($ps1);
                }
                $user->save();
                return redirect(url()->previous())->with('success', $user->name.' Updated Successfully!');
            break;

            case 'update_sal_cat':
                $scat = SalaryCat::find(97);
                // return $id;
                // $scat->title = $request->input('title');
                // $scat->position = $request->input('position');
                $scat->basic_sal = $request->input('basic_sal');
                $scat->save();
                return redirect(url()->previous())->with('success', 'Position `'.$scat->position.'` Successfully Updated!');
            break;

            case 'update_allow':
                $allow_amt = $request->input('allow_amt');
                $allow_perc = $request->input('allow_perc');

                if ($allow_amt != 0 && $allow_perc != 0 || $allow_amt == 0 && $allow_perc == 0 ) {
                    return redirect(url()->previous())->with('error', 'Oops..! Both Percentage and Amount fields can`t be filled.. Fill one(1) and put the other to zero(0)');
                }
                
                $allow = AllowanceList::find($id);
                $allow->allow_name = $request->input('allow_name');
                $allow->allow_perc = $allow_perc;
                $allow->allow_amt = $allow_amt;
                $allow->save();

                $alo = AllowanceOverview::where('del', 'no')->latest()->first();
                $new = 'new'.$allow->id;
                if ($allow_amt == 0) {
                    $alo->$new = $allow_perc;
                } else {
                    $alo->$new = $allow_amt;
                }
                $alo->save();

                return redirect(url()->previous())->with('success', $allow->name.' Updated Successfully!');
            break;

            case 'add_sms_contact':
                // return $id;
                
                $emp = Employee::find($id);
                if (empty($emp->contact)) {
                    return redirect(url()->previous())->with('error', 'Oops..! Update '.$emp->fname.'`s contact details to proceed');
                }
                try {
                    $user = User::where('employee_id', $id)->latest()->first();
                    $add_sms = SMS::firstOrCreate([
                        'sender_id' => auth()->user()->id,
                        'user_id' => $user->id,
                        'employee_id' => $id,
                        'contact' => $emp->contact,
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', $emp->fname.'`s contact successfully added to SMS queue');

            break;

            case 'add_rtire_note':
                // return $id;
                
                $emp = Employee::find($id);
                if (empty($emp->contact)) {
                    return redirect(url()->previous())->with('error', 'Oops..! Update '.$emp->fname.'`s contact details to proceed');
                }
                try {
                    $add_sms = SMS::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'employee_id' => $id,
                        'contact' => $emp->contact,
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                        return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect('/bulksms')->with('success', $emp->fname.'`s contact added. Type message to send');

            break;



            // Delete

            case 'any_value':
                return 'Works Perfect';
                $emp = Employee::find($id);
                $emp->del = 'yes';
                $emp->save();
                return redirect(url()->previous())->with('success', $emp->fname.'`s records deleted!');
            break;

            case 'del_loan':
                $emp = Employee::find($id);
                $loan = Loan::where('employee_id', $id)->latest()->first();
                $loan->elig_amt = '';
                $loan->lump_sum = '';
                $loan->dur = '';
                $loan->interest = '';
                $loan->monthly_ded = 0;
                $loan->bal = 0;
                $loan->status = 'active';
                $loan->date_started = '';
                $loan->save();

                $emp->staff_loan = 0;
                $emp->loan_bal = 0;
                $emp->loan_monthly_ded = 0;
                $emp->save();
                return redirect(url()->previous())->with('success', 'Loan details successfully cleared!');
            break;

            case 'del_employee':
                $emp = Employee::find($id);
                $emp->del = 'yes';
                $emp->save();
                return redirect(url()->previous())->with('success', $emp->fname.'`s records deleted!');
            break;

            case 'change_val_status':
                $emp = Employee::find($id);
                // 'user_id','employee_id','region_id','comments','month','del'
                
                try {
                    $val_insert = Validation::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'employee_id' => $id,
                        'region_id' => $emp->region_id,
                        'comments' => $request->input('comments'),
                        'status' => 'Pending',
                        'month' => Date('01-m-Y'),
                    ]);
                } catch (\Throwable $th) {
                    // throw $th;
                    return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }

                // $emp->status = 'inactive';
                // $emp->del = 'yes';
                // $emp->valid_comment = $request->input('comments');
                // $emp->save();
                return redirect(url()->previous())->with('success', $emp->fname.'`s records have been checked!');
            break;

            case 'del_allowexp':

                $alv = Allowanceoverview::where('del', 'no')->latest()->first();
                $alx = Allowexp::find($id);
                $alx->rent = $alv->rent;
                $alx->prof = $alv->prof;
                $alx->resp = $alv->resp;
                $alx->risk = $alv->risk;
                $alx->vma = $alv->vma;
                $alx->ent = $alv->ent;
                $alx->dom = $alv->dom;
                $alx->intr = $alv->intr;
                $alx->tnt = $alv->tnt;
                $alx->cola = $alv->cola;
                $alx->ssf = $alv->ssf;
                $alx->ssf1 = $alv->ssf1;
                $alx->ssf2 = $alv->ssf2;
                $alx->new1 = $alv->new1;
                $alx->new2 = $alv->new2;
                $alx->new3 = $alv->new3;
                $alx->new4 = $alv->new4;
                $alx->new5 = $alv->new5;
                $alx->del = 'yes';
                $alx->save();
                return redirect(url()->previous())->with('success', 'Record deletion successfull for '.$alx->employee->fname);
            break;

            case 'confirm_val_withheld':
                $val = Validation::find($id);
                $val->status = 'Withheld';
                $val->save();
                $emp = Employee::find($val->employee_id);
                $emp->status = 'inactive';
                $emp->save();
                return redirect(url()->previous())->with('success', $val->employee->fname.'`s details Successfully Restored!');
            break;

            case 'confirm_val_release':
                $val = Validation::find($id);
                $val->status = 'Pay';
                $val->save();
                $emp = Employee::find($val->employee_id);
                $emp->status = 'active';
                $emp->save();
                return redirect(url()->previous())->with('success', $val->employee->fname.'`s details Successfully Restored!');
            break;

            case 'remove_sms_contact':
                $val = SMS::find($id);
                $val->delete();
                return redirect(url()->previous())->with('success', 'Contact Deleted');
            break;



            
            // Restore
            case 'restore_employee':
                $emp = Employee::find($id);
                $emp->valid_comment = '';
                $emp->del = 'no';
                $emp->save();
                return redirect(url()->previous())->with('success', $emp->name.' Successfully Restored!');
            break;

            case 'restore_validation':
                $val = Validation::find($id);
                $val->delete();
                return redirect(url()->previous())->with('success', $val->employee->fname.'`s details Successfully Restored!');
            break;

            case 'admi_restore_validation':
                $val = Validation::find($id);
                $val->status = 'Pay';
                $val->save();
                $emp = Employee::find($val->employee_id);
                $emp->status = 'active';
                $emp->save();
                return redirect(url()->previous())->with('success', $val->employee->fname.'`s details Successfully Restored!');
            break;





            // Rent Allowance
            case 'set_rent':
                $allow = Allowance::find($id);
                $allow->rent = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Rent Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_rent':
                $allow = Allowance::find($id);
                $allow->rent = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Rent Allowance for '.$allow->fname.' has been Removed!');
            break;

            // Professional Allowance
            case 'set_prof':
                $allow = Allowance::find($id);
                $allow->prof = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Professional Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_prof':
                $allow = Allowance::find($id);
                $allow->prof = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Professional Allowance for '.$allow->fname.' has been Removed!');
            break;

            // Responsible Allowance
            case 'set_resp':
                $allow = Allowance::find($id);
                $allow->resp = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Responsible Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_resp':
                $allow = Allowance::find($id);
                $allow->resp = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Responsible Allowance for '.$allow->fname.' has been Removed!');
            break;

            // Risk Allowance
            case 'set_risk':
                $allow = Allowance::find($id);
                $allow->risk = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Risk Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_risk':
                $allow = Allowance::find($id);
                $allow->risk = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Risk Allowance for '.$allow->fname.' has been Removed!');
            break;

            // VMA Allowance
            case 'set_vma':
                $allow = Allowance::find($id);
                $allow->vma = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'VMA Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_vma':
                $allow = Allowance::find($id);
                $allow->vma = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'VMA Allowance for '.$allow->fname.' has been Removed!');
            break;

            // Entertainment Allowance
            case 'set_ent':
                $allow = Allowance::find($id);
                $allow->ent = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Entertainment Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_ent':
                $allow = Allowance::find($id);
                $allow->ent = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Entertainment Allowance for '.$allow->fname.' has been Removed!');
            break;

            // Domestic Allowance
            case 'set_dom':
                $allow = Allowance::find($id);
                $allow->dom = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Domestic Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_dom':
                $allow = Allowance::find($id);
                $allow->dom = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Domestic Allowance for '.$allow->fname.' has been Removed!');
            break;


            // Set General T&T / Intr. Allowance
            case 'set_tnt_intr':
                $allow = Allowance::find($id);
                $allow->tnt = $request->input('tnt');
                $allow->intr = $request->input('intr');
                $allow->back_pay = $request->input('back_pay');
                $allow->save();
                return redirect(url()->previous())->with('success', 'T&T / Internet & Other Utilities Allowance for '.$allow->fname.' Successfully Updated!');
            break;


            // Internet & Other Utilities Allowance
            case 'set_intr':
                $allow = Allowance::find($id);
                $allow->intr = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Internet & Other Utilities Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_intr':
                $allow = Allowance::find($id);
                $allow->intr = 0;
                $allow->save();
                return redirect(url()->previous())->with('success', 'Internet & Other Utilities Allowance for '.$allow->fname.' has been Removed!');
            break;

            // T&T Allowance
            case 'set_tnt':
                $allow = Allowance::find($id);
                $allow->tnt = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'T&T Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_tnt':
                $allow = Allowance::find($id);
                $allow->tnt = 0;
                $allow->save();
                return redirect(url()->previous())->with('success', 'T&T Allowance for '.$allow->fname.' has been Removed!');
            break;

            // Cola Allowance
            case 'set_cola':
                $allow = Allowance::find($id);
                $allow->cola = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Cola Allowance for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_cola':
                $allow = Allowance::find($id);
                $allow->cola = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', 'Cola Allowance for '.$allow->fname.' has been Removed!');
            break;

            // New Allowances

            // New1
            case 'set_new1':
                $new1 = AllowanceList::find(1);
                $allow = Allowance::find($id);
                $allow->new1 = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', $new1->allow_name.' for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_new1':
                $new1 = AllowanceList::find(1);
                $allow = Allowance::find($id);
                $allow->new1 = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', $new1->allow_name.' for '.$allow->fname.' has been Removed!');
            break;

            // New2
            case 'set_new2':
                $new2 = AllowanceList::find(2);
                $allow = Allowance::find($id);
                $allow->new2 = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', $new2->allow_name.' for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_new2':
                $new2 = AllowanceList::find(2);
                $allow = Allowance::find($id);
                $allow->new2 = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', $new2->allow_name.' for '.$allow->fname.' has been Removed!');
            break;

            // New3
            case 'set_new3':
                $new3 = AllowanceList::find(3);
                $allow = Allowance::find($id);
                $allow->new3 = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', $new3->allow_name.' for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_new3':
                $new3 = AllowanceList::find(3);
                $allow = Allowance::find($id);
                $allow->new3 = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', $new3->allow_name.' for '.$allow->fname.' has been Removed!');
            break;

            // New4
            case 'set_new4':
                $new4 = AllowanceList::find(4);
                $allow = Allowance::find($id);
                $allow->new4 = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', $new4->allow_name.' for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_new4':
                $new4 = AllowanceList::find(4);
                $allow = Allowance::find($id);
                $allow->new4 = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', $new4->allow_name.' for '.$allow->fname.' has been Removed!');
            break;

            // New5
            case 'set_new5':
                $new5 = AllowanceList::find(5);
                $allow = Allowance::find($id);
                $allow->new5 = 'yes';
                $allow->save();
                return redirect(url()->previous())->with('success', $new5->allow_name.' for '.$allow->fname.' Successfully Set!');
            break;
            case 'remove_new5':
                $new5 = AllowanceList::find(5);
                $allow = Allowance::find($id);
                $allow->new5 = 'no';
                $allow->save();
                return redirect(url()->previous())->with('success', $new5->allow_name.' for '.$allow->fname.' has been Removed!');
            break;



            case 'up_allowexp':
                // return $id;
                if ($request->input('new1')) {
                    $new1 = $request->input('new1');
                } else {
                    $new1 = 0;
                }
                if ($request->input('new2')) {
                    $new2 = $request->input('new2');
                } else {
                    $new2 = 0;
                }
                if ($request->input('new3')) {
                    $new3 = $request->input('new3');
                } else {
                    $new3 = 0;
                }
                if ($request->input('new4')) {
                    $new4 = $request->input('new4');
                } else {
                    $new4 = 0;
                }
                if ($request->input('new5')) {
                    $new5 = $request->input('new5');
                } else {
                    $new5 = 0;
                }
                
                $alx = Allowexp::find($id);
                $alx->rent = $request->input('rent');
                $alx->prof = $request->input('prof');
                $alx->resp = $request->input('resp');
                $alx->risk = $request->input('risk');
                $alx->vma = $request->input('vma');
                $alx->ent = $request->input('ent');
                $alx->dom = $request->input('dom');
                $alx->intr = $request->input('intr');
                $alx->tnt = $request->input('tnt');
                $alx->cola = $request->input('cola');
                $alx->ssf = $request->input('ssf');
                $alx->ssf1 = $request->input('ssf1');
                $alx->ssf2 = $request->input('ssf2');
                $alx->new1 = $new1;
                $alx->new2 = $new2;
                $alx->new3 = $new3;
                $alx->new4 = $new4;
                $alx->new5 = $new5;
                // $alv->del = 'yes';
                $alx->save();
                    

                return redirect(url()->previous())->with('success', 'Allowance exception values updated for '.$alx->employee->fname);
                // return redirect(url()->previous())->with('success', 'Page Refresh Successful');

            break;

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
