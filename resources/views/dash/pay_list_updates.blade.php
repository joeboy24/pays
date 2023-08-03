
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

            <li class="sidebar-item">
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
        <h3><i class="fa fa-file-text color1"></i>&nbsp;&nbsp;New/Updated Records</h3>

        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            <a href="/taxation"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Taxation</p></a>
            <a href="/salaries"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Salary</p></a>
            {{-- <a href="/emp_report"><p class="print_report">&nbsp;<i class="fa fa-print"></i></p></a>
            <button type="submit" name="store_action" value="calc_taxation" class="print_btn_small"><i class="fa fa-refresh"></i></button>
            <a href="/bulksms"><p class="view_daily_report">&nbsp;<i class="fa fa-envelope color5"></i>&nbsp; SMS</p></a> --}}
            <a href="/finace_notice"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        </form>
    </div>


    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">
                    <p class="warning_action"><i class="fa fa-warning"></i>&nbsp; Showing new Entries/Updates on Staff Records</p>
                    
                    <!-- Employee View -->
                    <div class="table-responsive">
                        @if (count($emp_update) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Salary (GhC)</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($emp_update as $emp)
                                        @if ($emp->del == 'yes')
                                            <tr class="del_danger">
                                        @else
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif
                                        @endif
                                            <td class="text-bold-500">{{$c++}}</td>
                                            <td class="text-bold-500"><a href="/employee/{{$emp->id}}" class="color10">{{ $emp->fname.' '.$emp->sname.' '.$emp->oname }}</a>
                                                <p class="small_p">Phone: {{ $emp->contact }}</p>
                                            </td>
                                            <td class="text-bold-500">{{ $emp->cur_pos }}
                                                <p class="small_p">Dept.: {{ $emp->dept }}</p>
                                                @if ($emp->reg_mgr == 'yes') <button type="button" class="my_trash2 blue_bg color8"><i class="fa fa-user-circle"></i>&nbsp; Regional Mgr.</button> @endif
                                            </td>
                                            <td class="text-bold-500">{{ number_format($emp->salary, 2) }}<br>
                                                @if ($emp->status == 'Active')
                                                    <button type="button" class="my_trash2 green_bg color8"><i class="fa fa-print"></i>&nbsp; Active</button>
                                                @else
                                                    <button type="button" class="my_trash2 bg6 color8"><i class="fa fa-print"></i>&nbsp; Inactive</button>
                                                @endif
                                            </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $emp_update->links() }} --}}
                            
                        @else
                            <div class="alert alert-warning">
                                Oops..! No Records Found on Staff Entries/Updates
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <p class="warning_action"><i class="fa fa-warning"></i>&nbsp; Showing Updates on Allowances </p>
                    
                    <!-- Allowance View -->
                    <div class="table-responsive">
                        @if (count($alw_update) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Allowances</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($alw_update as $alw)
                                        <tr>
                                            <td>{{$x++}}</td>
                                            <td class="text-bold-500">{{ $alw->employee->fname.' '.$alw->employee->sname.' '.$alw->employee->oname }}</td>

                                            <form action="{{ action('EmployeeController@update', $alw->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="PUT">
                                                @csrf

                                                {{-- <td class="text-bold-500">
                                                    <input type="hidden" id="allow_tf{{$alw->id}}" name="allow_tf{{$alw->id}}">
                                                    <!-- Rent Allowance -->
                                                    @if ($alw->rent == 'no')
                                                        <button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Rent</button>
                                                    @else
                                                        <button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Rent</button>
                                                    @endif

                                                    <!-- Professional Allowance -->
                                                    @if ($alw->prof == 'no') 
                                                        <button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Profession</button>
                                                    @else
                                                        <button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Profession</button>
                                                    @endif

                                                    <!-- Resposible Allowance -->
                                                    @if ($alw->resp == 'no') 
                                                        <button type="button" value="set_resp" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Responsible</button>
                                                    @else
                                                        <button type="button" value="remove_resp" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Responsible</button>
                                                    @endif

                                                    <!-- Risk Allowance -->
                                                    @if ($alw->risk == 'no') 
                                                        <button type="button" value="set_risk" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Risk</button>
                                                    @else
                                                        <button type="button" value="remove_risk" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Risk</button>
                                                    @endif

                                                    <!-- VMA Allowance -->
                                                    @if ($alw->vma == 'no') 
                                                        <button type="button" value="set_vma" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; VMA</button>
                                                    @else
                                                        <button type="button" value="remove_vma" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; VMA</button>
                                                    @endif

                                                    <!-- Entertainment Allowance -->
                                                    @if ($alw->ent == 'no') 
                                                        <button type="button" value="set_ent" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Entertainment</button>
                                                    @else
                                                        <button type="button" value="remove_ent" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Entertainment</button>
                                                    @endif
 
                                                    <!-- Domestic Allowance -->
                                                    @if ($alw->dom == 'no') 
                                                        <button type="button" value="set_dom" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Domestic</button>
                                                    @else
                                                        <button type="button" value="remove_dom" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Domestic</button>
                                                    @endif

                                                    <!-- Internet Allowance -->
                                                    @if ($alw->intr == 'no' || $alw->intr == 0) 
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Int. & Util.</button></a>
                                                    @else
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Int. & Util.</button></a>
                                                    @endif
  
                                                    <!-- TnT Allowance -->
                                                    @if ($alw->tnt == 'no' || $alw->tnt == 0) 
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; T & T</button></a>
                                                    @else
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; T & T</button></a>
                                                    @endif

                                                    <!-- Filter Modal2 -->
                                                    <div class="modal fade" id="#" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalRequestLabel">Edit T & T / Internet and Others</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="filter_div">
                                                                    <i class="fa fa-internet-explorer"></i>&nbsp;&nbsp;&nbsp;Int/Ut (GhC)
                                                                    <input type="number" step="any" @if ($alw->intr!='')value="{{$alw->intr}}" @endif min="0" name="intr" required>
                                                                </div>
                                                        
                                                                <div class="filter_div">
                                                                    <i class="fa fa-taxi"></i>&nbsp;&nbsp;&nbsp;T&T (GhC)
                                                                    <input type="number" step="any" @if ($alw->tnt!='')value="{{$alw->tnt}}" @endif min="0" name="tnt" required>
                                                                </div>
                                            
                                                                <div class="form-group modal_footer">
                                                                    <button type="button" value="set_tnt_intr" class="load_btn" onclick="return confirm('Are you sure you want to update these records!?')"><i class="fa fa-save"></i>&nbsp; Update</button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        </div>
                                                    </div>

                                                    <!-- Cola Allowance -->
                                                    @if ($alw->cola == 'no') 
                                                        <button type="button" value="set_cola" class="allow_btn color1"  Cola><i class="fa fa-times"></i>&nbsp; Cola</button>
                                                    @else
                                                        <button type="button" value="remove_cola" class="allow_btn bg4"Cola><i class="fa fa-check"></i>&nbsp; Cola</button>
                                                    @endif
                                                    
                                                    <!-- New Allowances -->
                                                    @if (count($new_allows) > 0)
                                                        @for ($y = 1; $y <= count($new_allows); $y++)
                                                            <input type="hidden" value="{{$val = 'new'.$y}}">
                                                            @if ($alw->$val == 'no') 
                                                                <button type="button" value="{{'set_new'.$y}}" class="allow_btn color1"  {{$new_allows[$y-1]->allow_name}} for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; {{substr($new_allows[$y-1]->allow_name, 0, 10)}}...</button>
                                                            @else
                                                                <button type="button" value="{{'remove_new'.$y}}" class="allow_btn bg4"{{$new_allows[$y-1]->allow_name}} for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; {{substr($new_allows[$y-1]->allow_name, 0, 10)}}...</button>
                                                            @endif
                                                        @endfor
                                                    @endif
                                                </td> --}}

                                                <td class="text-bold-500">
                                                    <input type="hidden" id="allow_tf{{$alw->id}}" name="allow_tf{{$alw->id}}">
                                                    <!-- Rent Allowance -->
                                                    @if ($alw->rent == 'no')
                                                        <button type="submit" name="update_action" value="set_rent" class="allow_btn color1" onclick="return confirm('Do you want to enable Rent Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Rent</button>
                                                        {{-- <button type="button" name="update_action" value="set_rent" class="allow_btn color1" onclick="textfill{{$alw->id}}()"><i class="fa fa-check"></i>&nbsp; Rent</button> --}}
                                                    @else
                                                        <button type="submit" name="update_action" value="remove_rent" class="allow_btn bg4" onclick="return confirm('Do you want to disable Rent Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Rent</button>
                                                        {{-- <button type="button" name="update_action" value="remove_rent" class="allow_btn bg4" onclick="textfill2{{$alw->id}}()"><i class="fa fa-times"></i>&nbsp; Rent</button> --}}
                                                    @endif

                                                    <!-- Professional Allowance -->
                                                    @if ($alw->prof == 'no') 
                                                        <button type="submit" name="update_action" value="set_prof" class="allow_btn color1" onclick="return confirm('Do you want to enable Professional Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Profession</button>
                                                    @else
                                                        <button type="submit" name="update_action" value="remove_prof" class="allow_btn bg4" onclick="return confirm('Do you want to disable Professional Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Profession</button>
                                                    @endif

                                                    <!-- Resposible Allowance -->
                                                    @if ($alw->resp == 'no') 
                                                        <button type="submit" name="update_action" value="set_resp" class="allow_btn color1" onclick="return confirm('Do you want to enable Responsible Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Responsible</button>
                                                    @else
                                                        <button type="submit" name="update_action" value="remove_resp" class="allow_btn bg4" onclick="return confirm('Do you want to disable Responsible Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Responsible</button>
                                                    @endif

                                                    <!-- Risk Allowance -->
                                                    @if ($alw->risk == 'no') 
                                                        <button type="submit" name="update_action" value="set_risk" class="allow_btn color1" onclick="return confirm('Do you want to enable Risk Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Risk</button>
                                                    @else
                                                        <button type="submit" name="update_action" value="remove_risk" class="allow_btn bg4" onclick="return confirm('Do you want to disable Risk Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Risk</button>
                                                    @endif

                                                    <!-- VMA Allowance -->
                                                    @if ($alw->vma == 'no') 
                                                        <button type="submit" name="update_action" value="set_vma" class="allow_btn color1" onclick="return confirm('Do you want to enable VMA Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; VMA</button>
                                                    @else
                                                        <button type="submit" name="update_action" value="remove_vma" class="allow_btn bg4" onclick="return confirm('Do you want to disable VMA Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; VMA</button>
                                                    @endif

                                                    <!-- Entertainment Allowance -->
                                                     @if ($alw->ent == 'no') 
                                                         <button type="submit" name="update_action" value="set_ent" class="allow_btn color1" onclick="return confirm('Do you want to enable Entertainment Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Entertainment</button>
                                                     @else
                                                         <button type="submit" name="update_action" value="remove_ent" class="allow_btn bg4" onclick="return confirm('Do you want to disable Entertainment Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Entertainment</button>
                                                     @endif
 
                                                    <!-- Domestic Allowance -->
                                                     @if ($alw->dom == 'no') 
                                                         <button type="submit" name="update_action" value="set_dom" class="allow_btn color1" onclick="return confirm('Do you want to enable Domestic Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Domestic</button>
                                                     @else
                                                         <button type="submit" name="update_action" value="remove_dom" class="allow_btn bg4" onclick="return confirm('Do you want to disable Domestic Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Domestic</button>
                                                     @endif

                                                    <!-- Internet Allowance -->
                                                    @if ($alw->intr == 'no' || $alw->intr == 0) 
                                                        {{-- <button type="submit" name="update_action" value="set_intr" class="allow_btn color1" onclick="return confirm('Do you want to enable Internet & Other Utilities Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Int. & Util.</button> --}}
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Int. & Util.</button></a>
                                                    @else
                                                        {{-- <button type="submit" name="update_action" value="remove_intr" class="allow_btn bg4" onclick="return confirm('Do you want to disable Internet & Other Utilities Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Int. & Util.</button> --}}
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Int. & Util.</button></a>
                                                    @endif
  
                                                    <!-- TnT Allowance -->
                                                    @if ($alw->tnt == 'no' || $alw->tnt == 0) 
                                                        {{-- <button type="submit" name="update_action" value="set_tnt" class="allow_btn color1" onclick="return confirm('Do you want to enable T&T Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; T & T</button> --}}
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; T & T</button></a>
                                                    @else
                                                        {{-- <button type="submit" name="update_action" value="remove_tnt" class="allow_btn bg4" onclick="return confirm('Do you want to disable T&T Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; T & T</button> --}}
                                                        <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; T & T</button></a>
                                                    @endif

                                                    <!-- Filter Modal2 -->
                                                    <div class="modal fade" id="tnt_intr{{$alw->id}}" tabindex="-1" role="dialog" aria-labelledby="modalRequestLabel" aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalRequestLabel">Edit T & T / Internet and Others</h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="filter_div">
                                                                    <i class="fa fa-internet-explorer"></i>&nbsp;&nbsp;&nbsp;Int/Ut (GhC)
                                                                    <input type="number" step="any" @if ($alw->intr!='') value="{{$alw->intr}}" @endif min="0" name="intr" required>
                                                                </div>
                                                        
                                                                <div class="filter_div">
                                                                    <i class="fa fa-taxi"></i>&nbsp;&nbsp;&nbsp;T&T (GhC)
                                                                    <input type="number" step="any" @if ($alw->tnt!='') value="{{$alw->tnt}}" @endif min="0" name="tnt" required>
                                                                </div>
                                                        
                                                                <div class="filter_div">
                                                                    <i class="fa fa-taxi"></i>&nbsp;&nbsp;&nbsp;Back Pay (GhC)
                                                                    <input type="number" step="any" @if ($alw->back_pay!='') value="{{$alw->back_pay}}" @endif min="0" name="back_pay" required>
                                                                </div>
                                            
                                                                <div class="form-group modal_footer">
                                                                    <button type="submit" name="update_action" value="set_tnt_intr" class="load_btn" onclick="return confirm('Are you sure you want to update these records!?')"><i class="fa fa-save"></i>&nbsp; Update</button>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        </div>
                                                    </div>

                                                    <!-- Cola Allowance -->
                                                    @if ($alw->cola == 'no') 
                                                        <button type="submit" name="update_action" value="set_cola" class="allow_btn color1" onclick="return confirm('Do you want to enable Cola Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; Cola</button>
                                                    @else
                                                        <button type="submit" name="update_action" value="remove_cola" class="allow_btn bg4" onclick="return confirm('Do you want to disable Cola Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; Cola</button>
                                                    @endif
  
                                                    @if (auth()->user()->status == 'Fianace' || auth()->user()->status == 'Administrator')
                                                        <!-- TnT Allowance -->
                                                        @if ($alw->back_pay == 'no' || $alw->back_pay == 0) 
                                                            {{-- <button type="submit" name="update_action" value="set_tnt" class="allow_btn color1" onclick="return confirm('Do you want to enable T&T Allowance for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; T & T</button> --}}
                                                            <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn color1"><i class="fa fa-times"></i>&nbsp; Back Pay</button></a>
                                                        @else
                                                            {{-- <button type="submit" name="update_action" value="remove_tnt" class="allow_btn bg4" onclick="return confirm('Do you want to disable T&T Allowance for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; T & T</button> --}}
                                                            <a data-bs-toggle="modal" data-bs-target="#tnt_intr{{$alw->id}}"><button type="button" class="allow_btn bg4"><i class="fa fa-check"></i>&nbsp; Back Pay</button></a>
                                                        @endif
                                                    @endif
                                                    
                                                    <!-- New Allowances -->
                                                    @if (count($new_allows) > 0)
                                                        @for ($y = 1; $y <= count($new_allows); $y++)
                                                            <input type="hidden" value="{{$val = 'new'.$y}}">
                                                            @if ($alw->$val == 'no') 
                                                                <button type="submit" name="update_action" value="{{'set_new'.$y}}" class="allow_btn color1" onclick="return confirm('Do you want to enable {{$new_allows[$y-1]->allow_name}} for {{$alw->fname}}?')"><i class="fa fa-times"></i>&nbsp; {{substr($new_allows[$y-1]->allow_name, 0, 10)}}...</button>
                                                            @else
                                                                <button type="submit" name="update_action" value="{{'remove_new'.$y}}" class="allow_btn bg4" onclick="return confirm('Do you want to disable {{$new_allows[$y-1]->allow_name}} for {{$alw->fname}}?')"><i class="fa fa-check"></i>&nbsp; {{substr($new_allows[$y-1]->allow_name, 0, 10)}}...</button>
                                                            @endif
                                                        @endfor
                                                        {{-- @foreach ($new_allow as $na)
                                                        @endforeach --}}
                                                    @endif

                                                    <script>
                                                        function textfill{{$alw->id}}() {
                                                            document.getElementById("allow_tf{{$alw->id}}").value = "rent{{$alw->id}}";
                                                            document.getElementById("state_tf").value = "enable{{$alw->id}}";
                                                            // document.getElementById('from').style.display = "block";
                                                            return confirm('{{$alw->id}} Do you want to enable Rent Allowance {{$alw->fname}}?');
                                                        }

                                                        function textfill2{{$alw->id}}() {
                                                            document.getElementById("allow_tf{{$alw->id}}").value = "2rent{{$alw->id}}";
                                                            document.getElementById("state_tf").value = "enable{{$alw->id}}";
                                                            // document.getElementById('from').style.display = "block";
                                                            return confirm('Are you sure you want to disable Rent Allowance for {{$alw->fname}}?');
                                                        }
                                                    </script>
                                                </td>

                                            </form>

                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $emp_update->links() }} --}}
                            
                        @else
                            <div class="alert alert-warning">
                                Oops..! No Records Found on Allowance Updates
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

        

@endsection

 