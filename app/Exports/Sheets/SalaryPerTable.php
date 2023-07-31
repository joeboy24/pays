<?php 

namespace App\Exports\Sheets;
use App\Models\Bank;
use App\Models\User;
use App\Models\Salary;
use App\Models\Journal;
use App\Models\Taxation;
use App\Models\AllowanceOverview;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalaryPerTable implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize, WithStyles
{
    private $month;
    private $tbl;

    public function __construct(string $month, string $tbl)
    {
        // $m = date('m');
        // $m = $m - 1;
        // if ($m < 10) {
        //     $m = '0'.$m;
        // }
        // $this->m = $m;
        $this->prev_month = date('M-Y', strtotime(date('Y-m')." -1 month"));
        $this->month = $month;
        $this->tbl = $tbl;

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if ($this->tbl == 'Salary') {
            $salary = Salary::select([
                'month','taxation_id','employee_id','position','salary','ssf','sal_aft_ssf','rent','prof',
                'taxable_inc','income_tax','net_aft_inc_tax','resp','risk','vma','ent','dom','intr','tnt','cola','back_pay',
                'net_bef_ded','std_loan','staff_loan','net_aft_ded','ssf_emp_cont','gross_sal','tot_ded','ssn','email','dept','region','bank','branch','acc_no'
            ])->where('month', $this->month)->get();

            foreach ($salary as $key => $value) {
                $mo = '1-'.$salary[$key]->month;
                $salary[$key]['month'] = date('F - Y', strtotime($mo));
                $salary[$key]['taxation_id'] = $salary[$key]->employee->afis_no;
                $salary[$key]['employee_id'] = $salary[$key]->employee->fname.' '.$salary[$key]->employee->sname.' '.$salary[$key]->employee->oname;
            }
            return $salary;

        } elseif ($this->tbl == 'Taxation') {
            $taxes = Taxation::select([
                'employee_id','position','salary','rent','prof','tot_income','ssf','taxable_inc',
                'tax_pay','first1','next1','next2','next3','next4','next5','net_amount'
            ])->where('month', $this->month)->get();

            // $taxes = User::all();
            foreach ($taxes as $key => $value) {
                $taxes[$key]['employee_id'] = $taxes[$key]->employee->fname.' '.$taxes[$key]->employee->sname.' '.$taxes[$key]->employee->oname;
            }
            return $taxes;

        }elseif ($this->tbl == 'Payroll Journals') {
            $jv = Journal::select([
                'month','gross','ssf_emp','fuel_alw','back_pay','total_ssf','total_paye','advances','veh_loan','std_loan','staff_loan','net_pay','debit','credit'
            ])->where('month', $this->month)->get();

            foreach ($jv as $key => $value) {
                $mo = '1-'.$jv[$key]->month;
                $jv[$key]['month'] = date('M - Y', strtotime($mo));
            }
            return $jv;

        } elseif ($this->tbl == 'Comparison') {
            // $prev_salary = Salary::select([
            //     'region','taxation_id','position','month','net_aft_ded','employee_id'
            // ])->where('month', $this->prev_month)->get();

            $salary = Salary::select([
                'employee_id','region','taxation_id','position','month','net_aft_ded','ssn'
            ])->where('month', $this->month)->get();

            foreach ($salary as $key => $value) {
                $premo = Salary::where('employee_id', $salary[$key]['employee_id'])->where('month', '06-2023')->latest()->first();
                // $mo = '1-'.$salary[$key]->month;
                // $salary[$key]['month'] = date('F - Y', strtotime($mo));
                if ($premo) {
                    if ($premo->net_aft_ded != '') {
                        $salary[$key]['month'] = $premo->net_aft_ded;
                        $diff = $salary[$key]['net_aft_ded'] - $premo->net_aft_ded;
                        if ($diff < 1) {
                            $diff = '0';
                        }
                        $salary[$key]['ssn'] = $diff;
                    }
                }else{
                    $salary[$key]['month'] = '';
                    $salary[$key]['ssn'] = '';
                }
                $salary[$key]['taxation_id'] = $salary[$key]->employee->fname.' '.$salary[$key]->employee->sname.' '.$salary[$key]->employee->oname;
            }

            // $salary = Salary::where('month', $this->month)->get();
            // foreach ($salary as $key => $value) {
            //     $premo = Salary::select(['net_aft_ded'])->where('employee_id', $salary[$key]['employee_id'])->where('month', '06-2023')->latest()->first();
            //     return $premo->net_aft_ded;
            // }

            // // foreach ($salary as $item) {
            // //     $sals = Salary::where('employee_id', $item->employee_id)->where('month', $this->prev_month)->latest()->first();
            // // }
            return $salary;
        }
        
    }

    public function headings(): array
    {
        if ($this->tbl == 'Salary') {
            return [
                'MONTH','AFIS NO','Employee Name','Position','Basic Salary','SSF 5.5%','BASIC AFTER SSF','15% Rent Allow',
                '25% Prof. Allow','Total Taxable Income','Income Tax','NET AFTER INCOME TAX','10% Resp. Allow','15% Risk Allow',
                '10% V.M.A','15% Entertaiment Allow','10% Domestic Help','Internet & Other Utilities','T&T Allowance','15% COLA','BACK PAY',
                'Net Salary Before Deductions','Student Loan','Staff Loan','Net Salary After Deductions','13%/12.5% SSF EMPLOYERS CONT.',
                'GROSS SALARY','TOTAL DEDUCTIONS','SOCIAL SECURITY NUMBER','EMAIL ADDRESS','DEPARTMENT','REGION','BANK','BRANCH','A/C NO'
            ];
        } elseif ($this->tbl == 'Taxation') {
            return [
                'Employee Name','Position','Gross Basic Salaries','15% Rent Allow','25% Prof. Allow','Total Income','SSF @5.5%','Taxable Income',
                'Total Tax payable','First GHS319','Next GHS100','Next GHS539','Next GHS3,539','Next GHS16461','Exc. GHS20,000','Net Amount'
                // 'Cum. Income ',
            ];
        }elseif ($this->tbl == 'Payroll Journals') {
            $jv = date('M-Y').' Payroll JV';
            return [
                'Month','Gross','SSF Employer','Fuel Allowance','Back Pay','Total SSF','Total Paye','Advances','Vehicle Loan','Student Loan','Staff Loan','Net Pay','Debit','Credit'
            ];
        } elseif ($this->tbl == 'Comparison') {
            return [
                '##','Region','Employee Name','Position',$this->prev_month,date('M-Y'),'Diff','Remarks'
            ];
        }
    }

    public function styles(Worksheet $sheet)
    {
        // $sheet->getStyle('B2')->getFont()->setBold(true);
        // $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize(17);
        $sheet->getRowDimension('1')->setRowHeight(40);
        // $event->sheet->getDelegate()->getStyle('A1:AG1')->getFont()->setBold(true);
        return [
            // Style the first row as bold text.

            1    => ['font' => ['bold' => true, 'size' => 17, 'align' => 'center']],

            // // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }


    /**
     * @return string
     */
    public function title(): string
    {
        return $this->tbl;
        // return 'Month ' . $this->month;
    }
}