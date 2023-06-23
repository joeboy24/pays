<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SalaryCat;
use App\Models\Region;
use Session;

class WorkersPagesController extends Controller
{
    //

    public function index(){

        // if (Session::get('https') != 'https'){
        //     Session::put('https', 'https');
        //     return redirect('https://payroll.pivoapps.net');
        // }

        return view('worker.dashboard');
    }

    public function sal_validation(Request $request){

        $src = $request->input('search_emp');
        if ($src) {
            $employees = Employee::where('fname', 'LIKE', '%'.$src.'%')->orwhere('sname', 'LIKE', '%'.$src.'%')->orwhere('oname', 'LIKE', '%'.$src.'%')->orwhere('staff_id', 'LIKE', '%'.$src.'%')->orwhere('contact', 'LIKE', '%'.$src.'%')->orwhere('position', 'LIKE', '%'.$src.'%')->paginate(20);
        } else {
            $employees = Employee::orderBy('fname', 'ASC')->paginate(20);
        }

        // $users = User::where('status', '!=', 'Student')->get();
        $regions = Employee::select('region')->orderBy('region', 'ASC')->distinct('region')->get();
        $position = SalaryCat::orderBy('position', 'ASC')->get();
        $patch = [
            'c' => 1,
            'regions' => $regions,
            'main_regions' => Region::all(),
            'position' => $position,
            'employees' => $employees
        ];
        return view('dash.validation')->with($patch);
    }

}
