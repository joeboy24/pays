
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
        <h3><i class="fa fa-warning color1"></i>&nbsp;&nbsp;Changes</h3>
        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            <a href="/salaries"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Salary</p></a>
            <a href="/sal_changes"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        </form>
 
        {{-- <div class="row">
            <div class="col-12 col-md-8">
                <form action="{{ url('/salaries') }}">
                    @csrf
                    <input type="hidden" name="check" value="employee">
                    <input type="text" name="search_emp" class="search_emp" placeholder="Search">
                    <button class="search_btn"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div> --}}
    </div>

    {{ $saledits->links() }}

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                    <!-- Allowances View -->
                    <div class="table-responsive">
                        @if (count($saledits2) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee Name</th>
                                        <th>Position</th>
                                        <th>Basic Salary</th>
                                        <th>Month</th>
                                        <th>SSF&nbsp; {{$allowoverview->ssf}}%</th>
                                        <th>Basic After SSF</th>
                                        <th>{{$allowoverview->rent}}% Rent Allow</th>
                                        <th>{{$allowoverview->prof}}% Prof. Allow</th>
                                        <th>Total Taxable Income</th>
                                        <th>Income Tax</th>
                                        <th>Net After Income Tax</th>
                                        <th>{{$allowoverview->resp}}% Resp. Allow</th>
                                        <th>{{$allowoverview->risk}}% Risk Allow</th>
                                        <th>{{$allowoverview->vma}}% V.M.A Allow</th>
                                        <th>{{$allowoverview->ent}}% Entertainment Allow</th>
                                        <th>{{$allowoverview->dom}}% Domestic Help</th>
                                        <th>{{$allowoverview->intr}} Internet & Other Utilities</th>
                                        <th>{{$allowoverview->tnt}} T&T Allow</th>
                                        <th>{{$allowoverview->cola}}% COLA</th>

                                        @if ($allowoverview->new1 != 0)
                                            @if ($new_allows[0]->allow_perc != 0)
                                                <th>{{$allowoverview->new1}}% {{substr($new_allows[0]->allow_name, 0, 10)}}...</th>
                                            @else
                                                <th>{{$allowoverview->new1}} {{substr($new_allows[0]->allow_name, 0, 10)}}...</th>
                                            @endif
                                        @else
                                            <th>Empty</th>
                                        @endif

                                        @if ($allowoverview->new2 != 0)
                                            @if ($new_allows[1]->allow_perc != 0)
                                                <th>{{$allowoverview->new2}}% {{substr($new_allows[1]->allow_name, 0, 10)}}...</th>
                                            @else
                                                <th>{{$allowoverview->new2}} {{substr($new_allows[1]->allow_name, 0, 10)}}...</th>
                                            @endif
                                        @else
                                            <th>Empty</th>
                                        @endif

                                        @if ($allowoverview->new3 != 0)
                                            @if ($new_allows[2]->allow_perc != 0)
                                                <th>{{$allowoverview->new3}}% {{substr($new_allows[2]->allow_name, 0, 10)}}...</th>
                                            @else
                                                <th>{{$allowoverview->new3}} {{substr($new_allows[2]->allow_name, 0, 10)}}...</th>
                                            @endif
                                        @else
                                            <th>Empty</th>
                                        @endif

                                        @if ($allowoverview->new4 != 0)
                                            @if ($new_allows[3]->allow_perc != 0)
                                                <th>{{$allowoverview->new4}}% {{substr($new_allows[3]->allow_name, 0, 10)}}...</th>
                                            @else
                                                <th>{{$allowoverview->new4}} {{substr($new_allows[3]->allow_name, 0, 10)}}...</th>
                                            @endif
                                        @else
                                            <th>Empty</th>
                                        @endif

                                        @if ($allowoverview->new5 != 0)
                                            @if ($new_allows[4]->allow_perc != 0)
                                                <th>{{$allowoverview->new5}}% {{substr($new_allows[4]->allow_name, 0, 10)}}...</th>
                                            @else
                                                <th>{{$allowoverview->new5}} {{substr($new_allows[4]->allow_name, 0, 10)}}...</th>
                                            @endif
                                        @else
                                            <th>Empty</th>
                                        @endif

                                        {{-- @foreach ($new_allows as $nalws)
                                            <th>{{$allowoverview->tnt}} T&T Allow</th>
                                        @endforeach --}}
                                        <th>Back Pay</th>
                                        <th>Net Salary Before Deduction</th>
                                        <th class="staffloancol">Student Loan</th>
                                        <th class="staffloancol">Staff Loan</th>
                                        <th class="netcol">Net Salary After Deduction</th>
                                        <th>13%/12.5% SSF EMPLOYERS CONT.</th>
                                        <th>Gross Salary</th>
                                        <th>Total Deductions</th>
                                        {{-- <th>Allowances</th> --}}
                                    </tr>
                                </thead>   
                                <tbody>
                                    <tr><td></td><td><p class="small_p">{{date('M-Y')}}</p></td>
                                        @if (count($saledits) > 0)
                                            <td><p class="small_p">{{count($saledits)}}&nbsp;Records</p></td>
                                        @else
                                            <td><p class="small_p">No&nbsp;Records</p></td>
                                        @endif
                                    </tr>
                                    <!-- Current Month -->
                                    @foreach ($saledits as $slt)
                                        @if ($slt->del == 'yes')
                                            <tr class="del_danger">
                                        {{-- @else
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif --}}
                                        @endif
                                            <td>{{$c++}}</td>
                                            <td class="text-bold-500">{{ $slt->employee->fname.' '.$slt->employee->sname.' '.$slt->employee->oname }}
                                                <form action="{{ action('EmployeeController@update', $slt->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf
                                                    @if ($slt->del == 'no')
                                                        <button type="submit" name="update_action" value="del_saledit" 
                                                            onclick="return confirm('This action will remove salary changes for current month. Click ok to proceed.')" 
                                                            class="my_trash2 tomato_bg color8 genhover">
                                                            Delete Changes
                                                        </button>
                                                    @else
                                                        <button type="submit" name="update_action" value="revert_saledit" 
                                                            onclick="return confirm('Are you sure you want to revert changes?')" 
                                                            class="my_trash2 green_bg color8 genhover">
                                                            Revert Changes
                                                        </button>
                                                    @endif
                                                </form>
                                            </td>
                                            <td class="text-bold-500">{{substr($slt->position, 0,12)}}...</td>
                                            <td class="text-bold-500">{{number_format($slt->salary, 2)}}</td>
                                            <td class="text-bold-500">{{date('F Y', strtotime('30-'.$slt->month))}}</td>
                                            <td class="text-bold-500">{{number_format($slt->ssf, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->sal_aft_ssf, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->rent, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->prof, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->taxable_inc, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->income_tax, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->net_aft_inc_tax, 2)}}</td>

                                            <td class="text-bold-500">{{number_format($slt->resp, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->risk, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->vma, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->ent, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->dom, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->intr, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->tnt, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->cola, 2)}}</td>
                                            {{-- @if ($allowoverview->new1 != 0)
                                                
                                            @endif --}}
                                            <td class="text-bold-500">{{number_format($slt->new1, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->new2, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->new3, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->new4, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->new5, 2)}}</td>

                                            <td class="text-bold-500">{{number_format($slt->back_pay, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->net_bef_ded, 2)}}</td>
                                            <td class="text-bold-500 staffloancol">{{number_format($slt->std_loan, 2)}}</td>
                                            <td class="text-bold-500 staffloancol">{{number_format($slt->staff_loan, 2)}}</td>
                                            <td class="text-bold-500 netcol">{{number_format($slt->net_aft_ded, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->ssf_emp_cont, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->gross_sal, 2)}}</td>
                                            <td class="text-bold-500">{{number_format($slt->tot_ded, 2)}}</td>
                                        </tr>
                                    @endforeach
                                    
                                    <tr><td></td><td><p class="small_p">{{date('M-Y', strtotime(date('Y-m')." -1 month"))}}</p></td>
                                        @if (count($saledits2) > 0)
                                            <td><p class="small_p">{{count($saledits2)}}&nbsp;Records</p></td>
                                        @else
                                            <td><p class="small_p">No&nbsp;Records</p></td>
                                        @endif
                                    </tr>
                                    <!-- Previous Month -->
                                    @foreach ($saledits2 as $slt2)
                                        @if ($slt2->status != 'applied')
                                            <tr>
                                                <td>{{$c++}}</td>
                                                <td class="text-bold-500">{{ $slt2->employee->fname.' '.$slt2->employee->sname.' '.$slt2->employee->oname }}
                                                    <form action="{{ action('EmployeeController@update', $slt2->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        @csrf
                                                        <button type="submit" name="update_action" value="up_saledit_status" 
                                                            onclick="return confirm('Are you sure you want to apply changes to record?')" 
                                                            class="my_trash2 blue_bg color8 genhover">
                                                            Apply&nbsp;to&nbsp;{{date('F')}}
                                                        </button>
                                                        {{-- <button type="submit" name="update_action" value="edit_sal" class="my_trash2 blue_bg color8 genhover"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit&nbsp;Record</button> --}}
                                                    </form>
                                                </td>
                                                <td class="text-bold-500">{{substr($slt2->position, 0,12)}}...</td>
                                                <td class="text-bold-500">{{number_format($slt2->salary, 2)}}</td>
                                                <td class="text-bold-500">{{date('F Y', strtotime('30-'.$slt2->month))}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->ssf, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->sal_aft_ssf, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->rent, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->prof, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->taxable_inc, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->income_tax, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->net_aft_inc_tax, 2)}}</td>

                                                <td class="text-bold-500">{{number_format($slt2->resp, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->risk, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->vma, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->ent, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->dom, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->intr, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->tnt, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->cola, 2)}}</td>
                                                {{-- @if ($allowoverview->new1 != 0)
                                                    
                                                @endif --}}
                                                <td class="text-bold-500">{{number_format($slt2->new1, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->new2, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->new3, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->new4, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->new5, 2)}}</td>

                                                <td class="text-bold-500">{{number_format($slt2->back_pay, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->net_bef_ded, 2)}}</td>
                                                <td class="text-bold-500 staffloancol">{{number_format($slt2->std_loan, 2)}}</td>
                                                <td class="text-bold-500 staffloancol">{{number_format($slt2->staff_loan, 2)}}</td>
                                                <td class="text-bold-500 netcol">{{number_format($slt2->net_aft_ded, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->ssf_emp_cont, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->gross_sal, 2)}}</td>
                                                <td class="text-bold-500">{{number_format($slt2->tot_ded, 2)}}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                            {{ $saledits->links() }}
                        @else
                            <div class="alert alert-danger">
                                No Changes Made to Salary Records
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

 