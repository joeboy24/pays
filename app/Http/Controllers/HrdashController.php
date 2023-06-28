<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\LeaveSetup;
use App\Models\Employee;

class HrdashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

            case 'leave_setup':
                // return 987;

                // $employees = Employee::where('allowance_id', 'none')->get();
                // return $employees;
                try {
                    $leaveSetup = LeaveSetup::all();
                    if (count($leaveSetup) > 0) {
                        $lst = LeaveSetup::find(1);
                        $lst->maternity = $request->input('maternity');
                        $lst->casual = $request->input('casual');
                        $lst->annual = $request->input('annual');
                        $lst->study = $request->input('study');
                        $lst->sick = $request->input('sick');
                        $lst->others = $request->input('others');
                        $lst->save();
                    } else {
                        $ls_insert = LeaveSetup::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'maternity' => $request->input('maternity'),
                            'casual' => $request->input('casual'),
                            'annual' => $request->input('annual'),
                            'study' => $request->input('study'),
                            'sick' => $request->input('sick'),
                            'others' => $request->input('others'),
                        ]);
                    }
                    
                } catch (\Throwable $th) {
                    return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                // $patch = [
                //     'leaveset' => LeaveSetup::find(1),
                //     'success' => 'Leave Setup Update Successfully..!'
                // ];
                return redirect(url()->previous())->with('success', 'Leave Setup Updated Successfully..!');

            break;

            // case 'add_leave':
            //     // return 123;
            //     $lv_check = Leave::where('employee_id', $id)->first();
            // break;

            case 'staff_add_leave':
                
                $emp = auth()->user()->employee;
                $lv_check = Leave::where('employee_id', $emp->id)->latest()->first();
                if ($lv_check->status == 'Pending') {
                    return redirect(url()->previous())->with('error', 'Oops..! There is a pending application made on '.date('M, d Y', strtotime($lv_check->created_at)).'. Kindly wait for approval or defer and reapply for a different date');
                }
                $start = $request->input('from');
                $end = $request->input('to');
                $days = $request->input('days');
                $hand_over = $request->input('hand_over');
                $dt_diff = (strtotime($end)-strtotime($start)) / (60 * 60 * 24);
                // return $hand_over;

                if ($dt_diff < 0) {
                    return redirect(url()->previous())->with('error', 'Oops..! Start date cannot be ahead of end date');
                }
                if ($hand_over == 'none') {
                    return redirect(url()->previous())->with('error', 'Oops..! Select who you are handing over to');
                }
                // return $dt_diff;
                // 'user_id','employee_id','leave_type','start_date','end_date','resume_date','days','hand_over','leave_notes','status'
                try {
                    $lv_insert = Leave::firstOrCreate([
                        'user_id' => auth()->user()->id,
                        'employee_id' => $emp->id,
                        'leave_type' => $request->input('leave_type'),
                        'with_pay' => $request->input('with_pay'),
                        'start_date' => $start,
                        'end_date' => $end,
                        'hand_over' => $hand_over,
                        'leave_notes' => $request->input('leave_notes'),
                        'days' => $days
                    ]);
                } catch (\Throwable $th) {
                    throw $th;
                    return redirect(url()->previous())->with('error', 'Oops..! An error occured');
                }
                return redirect(url()->previous())->with('success', 'Leave application successfully sent on '.date('M, d Y').'. Note: Your portal will be updated once approved');
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

            case 'add_leave':
                // return 123;
                $lv_check = Leave::where('employee_id', $id)->latest()->first();
                $leave_type = $request->input('leave_type');
                $payment = $request->input('payment');
                $ls = LeaveSetup::find(1);
                $emp = Employee::find($id);

                if (empty($ls)) {
                    return redirect(url()->previous())->with('error', 'Oops..! Setup Leave at the `Manage Leave` page to proceed');
                }

                if ($leave_type == 'others' && $request->input('others') == '') {
                    return redirect(url()->previous())->with('error', 'Oops..! Define no. of days for `Others`');
                }

                if ($leave_type == 'others') {
                    $days = $request->input('others');
                } else {
                    $days = $ls->$leave_type;
                }
                // return $days;

                try {
                    // $leaveSetup = LeaveSetup::all();

                    if ($lv_check != '') {
                        $lv_check->leave_type = $leave_type;
                        $lv_check->start_date = date('d-m-Y');
                        $lv_check->days = $days;
                        $lv_check->save();
                    } else {
                        $ls_insert = Leave::firstOrCreate([
                            'user_id' => auth()->user()->id,
                            'employee_id' => $id,
                            'leave_type' => $leave_type,
                            'start_date' => date('d-m-Y'),
                            'days' => $days
                        ]);
                    }
                    if ($payment == 0) {
                        $emp->del = 'yes';
                        $emp->status = 'inactive';
                    }else {
                        $emp->status = 'inactive';
                    }
                    $emp->save();
                    
                } catch (\Throwable $th) {
                    // return redirect(url()->previous())->with('error', 'Oops..! An error occured ');
                    
                    throw $th;
                }
                return redirect(url()->previous())->with('success', 'Leave granted for '.$emp->fname);
                // $lv_check = Leave::where('employee_id', $id)->first();
            break;

            case 'resume_leave':
                $lv = Leave::find($id);
                $lv->resume_date = date('d-m-Y');
                $lv->status = 'inactive';
                $lv->save();

                $emp = Employee::find($lv->employee_id);
                $emp->status = 'active';
                $emp->del = 'no';
                $emp->save();
                return redirect(url()->previous())->with('success', 'Leave resumed for '.$lv->employee->fname.' on '.date('d-m-Y'));
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
