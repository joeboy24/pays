
@extends('layouts.dashlay')

@section('header_nav')
    @include('inc.header_nav')  
@endsection 

@section('sidebar_menu')
    
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item">
                <a href="/" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-users"></i>
                    <span>Employee</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="/add_employee">Add Employee</a>
                    </li>
                    <li class="submenu-item">
                        <!--a href="/pay_employee">Upload Data</a-->
                    </li>
                    <li class="submenu-item">
                        <a href="/view_employee">View/Edit Data</a>
                    </li>
                    <li class="submenu-item">
                        <a href="/allowance">Allowance</a>
                    </li>
                </ul>
            </li>

            <li class="sidebar-item">
                <a href="/taxation" class='sidebar-link'>
                    <i class="fa fa-bar-chart"></i>
                    <span>Taxation</span>
                </a>
            </li>

            <li class="sidebar-item active">
                <a href="/salaries" class='sidebar-link'>
                    <i class="fa fa-pie-chart"></i>
                    <span>Salary</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/staff-validation" class='sidebar-link'>
                    <i class="fa fa-calendar-check-o"></i>
                    <span>Validation</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/loans" class='sidebar-link'>
                    <i class="fa fa-money"></i>
                    <span>Staff Loans</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/banksummary" class='sidebar-link'>
                    <i class="fa fa-bank"></i>
                    <span>Banks Summary</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/leaves" class='sidebar-link'>
                    <i class="fa fa-clipboard"></i>
                    <span>Manage Leave</span><b class="menu_figure yellow_bg">{{session('leave_count')}}</b>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/retirement" class='sidebar-link'>
                    <i class="fa fa-gift"></i>
                    <span>Retirement</span><b class="menu_figure green_bg">{{session('bday_count')}}</b>
                </a>
            </li>

            <li class="sidebar-item ">
                <a href="/reports" class='sidebar-link'>
                    <i class="fa fa-file-text"></i>
                    <span>Reports</span>
                </a>
            </li>

            <!--li class="sidebar-item">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-calendar"></i>
                    <span>Calendar</span>
                </a>
            </li-->

            <li class="sidebar-item has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <ul class="submenu">
                    <li class="submenu-item">
                        <a href="/companysetup">Company Setup</a>
                    </li>
                    <li class="submenu-item">
                        <a href="/adduser">Manage User</a>
                    </li>
                    <li class="submenu-item">
                        <a href="/add_dept">Add Department</a>
                    </li>
                    <li class="submenu-item">
                        <a href="/sal_cat">Salary Category</a>
                    </li>
                    <li class="submenu-item">
                        <a href="/allowance_mgt">Manage Allowance</a>
                    </li>
                    {{-- <li class="submenu-item ">
                        <a href="#">Accounts</a>
                    </li> --}}
                </ul>
            </li>

        </ul>
    </div>
    
@endsection

@section('content')

    <div class="page-heading">
        <h3><i class="fa fa-pie-chart color3"></i>&nbsp;&nbsp;Payroll JV</h3>
        <form action="{{ url('/payroll_jv') }}">
            @csrf
            <a href="/salaries"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Salary </p></a>
            <select name="mth" class="view_daily_report genhover" name="" id="">
                <option value="" selected>-- Change Month --</option>
                @for ($i = 0; $i < date('m'); $i++)
                    {{-- @for ($i = 0; $i < $count; $i++) --}}
                    <option value="{{date('m-Y', strtotime('-'.$i.' months'))}}">{{date('Y F', strtotime('-'.$i.' months'))}}</option>
                @endfor
            </select>
            <button class="view_daily_report genhover"><i class="fa fa-refresh color10"></i></button>
            {{-- <a href="/sal-multiexport"><p class="view_daily_report">&nbsp;<i class="fa fa-download color5"></i>&nbsp; Export to Excel</p></a>
            <button type="submit" name="store_action" value="calc_taxation" class="print_btn_small"><i class="fa fa-refresh"></i></button> --}}
        </form>
    </div>


    <div class="row">
        <div class="col-12 col-xl-7">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                    <!-- Allowances View -->
                    <div class="table-responsive">
                        @if ($jv)
                            <table class="mytable">
                                <thead>
                                    <tr>
                                        <th class="td_right"><h6>{{date('F Y', strtotime('01-'.$mth))}} Payroll JV</h6></th>
                                        <th class="td_right"></th>
                                        <th class="td_right"></th>
                                    </tr>
                                    <tr>
                                        <th class="td_right"></th>
                                        <th class="td_right"><h6>Debit</h6></th>
                                        <th class="td_right"><h6>Credit</h6></th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    <tr>
                                        <td class="td_right">Gross</td>
                                        <td class="td_right">{{number_format($jv->gross, 2)}}</td>
                                        <td class="td_right"></td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">SSF Employer</td>
                                        <td class="td_right">{{number_format($jv->ssf_emp, 2)}}</td>
                                        <td class="td_right"></td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Fuel Allowance</td>
                                        <td class="td_right">{{number_format($jv->fuel_alw, 2)}}</td>
                                        <td class="td_right"></td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Back Pay</td>
                                        <td class="td_right">{{number_format($jv->back_pay, 2)}}</td>
                                        <td class="td_right"></td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Total SSF</td>
                                        <td class="td_right"></td>
                                        <td class="td_right">{{number_format($jv->total_ssf, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Total Paye</td>
                                        <td class="td_right"></td>
                                        <td class="td_right">{{number_format($jv->total_paye, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Student Loan</td>
                                        <td class="td_right"></td>
                                        <td class="td_right">{{number_format($jv->std_loan, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Vehicle Loan</td>
                                        <td class="td_right"></td>
                                        <td class="td_right">-</td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Staff Loan</td>
                                        <td class="td_right"></td>
                                        <td class="td_right">{{number_format($jv->staff_loan, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td_right">Net Pay</td>
                                        <td class="td_right"></td>
                                        <td class="td_right">{{number_format($jv->net_pay, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td class="td_right"><h6>Total</h6></td>
                                        <td class="td_right"><h6>{{number_format($jv->debit, 2)}}</h6></td>
                                        <td class="td_right"><h6>{{number_format($jv->credit, 2)}}</h6></td>
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-danger">
                                No Records Found on {{date('F Y', strtotime('01-'.$mth))}} Payroll JV
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Filter Modal -->
    <div class="modal fade" id="allow_overview" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRequestLabel">Allowance/SSNIT Overview (%)</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
            </div>
            <div class="modal-body">
                <form action="{{ action('EmployeeController@store') }}" method="POST">
                    @csrf
                    {{-- <div class="filter_div">
                    <i class="fa fa-list"></i>
                        <select onchange="report_script()" name="report_type" id="report_id">
                            <option>Customer Reports</option>
                            <option>Consumption Reports</option>
                            <option>Payment Reports</option>
                            <option>Generate Bill</option>
                        </select>
                    </div> --}}

                    <div class="filter_div">
                        <i class="fa fa-home"></i>&nbsp;&nbsp; Rent
                        <input type="number" step="any" min="0" max="100" placeholder="Rent Allowance eg. 15" name="rent">
                    </div>
                
                    {{-- <div class="filter_div">
                        <i class="fa fa-arrow-left"></i>&nbsp; To
                        <input type="text" name="to">
                    </div>
                    
                    <div class="filter_div" id="orderby">
                        <i class="fa fa-filter"></i>
                        <select name="order">
                            <option value="Asc" selected>Ascending</option>
                            <option value="Desc">Descending</option>
                        </select>
                    </div> --}}
                    
                    <div class="form-group modal_footer">
                        <button type="submit" name="store_action" value="add_allow_ssnit" class="load_btn" onclick="return confirm('Are you sure you want to update Allowances/SSNIT Percentages!?')"><i class="fa fa-save"></i>&nbsp; Update</button>
                    </div>
                </form>
            </div>
            
        </div>
        </div>
    </div>
        

@endsection

 