<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryCat;
use App\Models\Salary;
use App\Models\Region;
use App\Models\Leave;
use App\Models\Validation;
use Session;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return 45894;
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
        $emp = auth()->user()->employee;
        $sal = Salary::find($id);
        
        // if ($emp->id != $sal->employee_id) {
        //     return redirect(url()->previous())->with('error', 'Oops..! Access Denied');
        // }

        // if (session('payslip')) {
        //     return view('dash.pay_slip');
        // }else{
            Session::put('month', date('M Y', strtotime('01-'.$sal->month)));
            Session::put('report_type', 'payslip');
            Session::put('employee', $emp);
            Session::put('payslip', $sal);
            return view('worker.staff_payslip');
        // }
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
