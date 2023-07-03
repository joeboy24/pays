<?php

namespace App\Http\Controllers;


use App\Http\Requests;
use Illuminate\Http\Request;
use Input;
use App\Post;
use DB;
use Session;
use Validator;
use App\Expense;

use App\Models\Taxation;
use App\Exports\ExamExport;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Imports\StdImport;
use App\Exports\TaxExport;
use App\Exports\SalExport;
use App\Exports\BanksumExport;
use App\Exports\SalMultiExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportsController extends Controller 
{
    
    public function importFile(){
        return view('uploadtest');
    }

    public function pay_multiexport() 
    {
        $tbl = [
            'Salary',
            'Taxation',
            // 'Banks-Bank Summary',
            'Payroll Journals',
            'Comparison',
        ];
        Session::put('tbl', $tbl);
        // $tbl = session('tbl')[0];
        // return $tbl;
        return (new SalMultiExport(date('m-Y')))->download('salaries-'.date('M-Y').'.xlsx');
        // return Excel::download(new MultiExport(2023), date('M-Y').'_Salary.xlsx');
    }

    public function pay_sal_export() 
    {
        return Excel::download(new SalExport, date('M-Y').'_Salary.xlsx');
    }

    public function pay_tax_export() 
    {
        return Excel::download(new TaxExport, date('M-Y').'_Taxation.xlsx');
    }

    public function pay_banksum_export() 
    {
        // return Excel::download(new InvoicesExport, 'invoices.xlsx');
        return Excel::download(new BanksumExport, date('M-Y').'_BankSummary.xlsx');
    }

    public function export() 
    {
        return Excel::download(new UsersExport, 'users_export.xlsx');
    }


    public function exam_export() 
    {
        return Excel::download(new ExamExport, 'users_export.xlsx');
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request) 
    {

        try {
            $this->validate($request, [
                'file'   => 'required|max:5000|mimes:xlsx,xls,csv'
            ]);

            Excel::import(new UsersImport,request()->file('file'));
            return redirect('/importfile')->with('success', 'File successfully uploaded');

        } catch (ValidationException $exception) {
            return redirect('/importfile')->with('Error', $exception->errors());
        }

    }


    public function importquestion(Request $request) 
    {

        try {
            $this->validate($request, [
                'file'   => 'required|max:5000|mimes:xlsx,xls,csv'
            ]);

            Excel::import(new UsersImport,request()->file('file'));
            return redirect(url()->previous())->with('success', 'Questions successfully uploaded');

        } catch (ValidationException $exception) {
            return redirect(url()->previous())->with('Error', $exception->errors());
        }

    }

    public function importStd(Request $request) 
    {

        // try {
        //     $this->validate($request, [
        //         'file'   => 'required|max:5000|mimes:xlsx,xls,csv'
        //     ]);

        //     Excel::import(new StdImport,request()->file('file'));
        //     return redirect('/addstudent')->with('success', 'File successfully uploaded');

        // } catch (ValidationException $exception) {
        //     return redirect('/addstudent')->with('Error', $exception->errors());
        // }

        switch ($request->input('store_action')) {

            case 'import_std':
                $class = $request->input('imp_std_cls');

                // if ($class != 'Click here to choose class'){
                    try {
                        $this->validate($request, [
                            'import_file'   => 'required|max:5000|mimes:xlsx,xls,csv'
                        ]);
            
                        Excel::import(new StdImport,request()->file('import_file'));
                        return redirect('/addstudent')->with('success', 'File successfully uploaded');
            
                    } catch (ValidationException $exception) {
                        return redirect('/addstudent')->with('error', $exception->errors());
                    }
                // }else{
                //     return redirect('/addstudent')->with('error', 'Oops..! Select Class To Proceed.');
                // }
            break;

        }

    }


    


}
