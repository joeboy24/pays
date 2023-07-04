
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

            <li class="sidebar-item active">
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
        <h3><i class="fa fa-calendar-check-o color1"></i>&nbsp;&nbsp;Validation</h3>
        <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Home</p></a>
        <a href="/staff-validation"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        
        {{-- <div class="row">
            <div class="col-12 col-md-8">
                <form action="{{ url('/staff-validation') }}">
                    @csrf
                    <input type="hidden" name="check" value="employee">
                    <input type="text" name="search_emp" class="search_emp" placeholder="Search">
                    <button class="search_btn" name="store_action" value="search_emp"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div> --}}
    </div>

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 

            <!-- Checked List View -->
            @if (count($validation) > 0)
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <h6><i class="fa fa-th-large"></i> &nbsp; Checked List View | @if ($mth == 'All') All @else {{date('M, Y', strtotime($mth))}} @endif</h6>
                            <form action="{{ url('/staff-validation') }}">
                                @csrf
                                <select name="change_view" class="print_report">
                                    <option value="{{date('01-m-Y')}}" selected>Select Month</option>
                                    @for ($i = 1; $i <= date('m'); $i++)
                                        @if ($i < 10)
                                            {{$i='0'.$i}}
                                        @endif
                                        <option value="{{date('01-'.$i.'-Y')}}">{{date('M, Y', strtotime(date('01-'.$i.'-Y')))}}</option>
                                    @endfor
                                    <option value="all">All</option>
                                </select>
                                <button type="submit" class="gen_btn bg9 genhover color5">&nbsp;<i class="fa fa-filter color5"></i>&nbsp;Load</button>
                            </form>
                            <form action="{{ action('EmployeeController@store') }}" method="POST">
                                @csrf
                                <button type="submit" name="store_action" value="val_withhold_all" class="my_trash2 blue_bg genhover color8" onclick="confirm('Are you sure you want to hold payment for these records?')">&nbsp;<i class="fa fa-warning"></i>&nbsp;Withhold All</button>
                                <button type="submit" name="store_action" value="val_release_all" class="my_trash2 green_bg genhover color8" onclick="confirm('Are you sure you want to release payment for these records?')">&nbsp;<i class="fa fa-check"></i>&nbsp;Release All</button>
                                {{-- <a><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Pay</button></a> --}}
                            </form>

                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Region</th>
                                        <th>Comments/Date</th>
                                        <th class="align_right">Status/Actions</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($validation as $val)
                                        {{-- @if ($val->del == 'yes')
                                            <tr class="del_danger">
                                        @else
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif
                                        @endif --}}
                                        <tr class="del_danger2">
                                            <td class="text-bold-500">{{$c++}}</td>
                                            <td class="text-bold-500"><a href="/employee/{{$val->employee->id}}" class="color10">{{ $val->employee->fname.' '.$val->employee->sname.' '.$val->employee->oname }}</a>
                                                <p class="small_p">SSN: {{ $val->employee->ssn }}</p>
                                                {{-- <p class="small_p_black">Phone: {{ $val->employee->contact }}</p> --}}
                                            </td>
                                            <td class="text-bold-500">{{ $val->employee->cur_pos }}
                                                <p class="small_p">Dept.: {{ $val->employee->dept }}</p>
                                            </td>
                                            <td class="text-bold-500">{{ $val->region->reg_name }}</td>

                                            <form action="{{ action('EmployeeController@update', $val->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_method" value="PUT">
                                                @csrf

                                                <td class="text-bold-500">{{ $val->comments }}
                                                    <p class="small_p">{{ date('F, Y', strtotime($val->created_at)) }}</p>
                                                </td>

                                                <td class="text-bold-500 align_right action_size">
                                                    @if ($val->status == 'Pending')
                                                        <button type="submit" name="update_action" value="confirm_val_withheld" class="my_trash2 blue_bg color8" onclick="return confirm('This action will hold payment for current and subsequent months, Are you sure you want to proceed?')"><i class="fa fa-warning"></i>&nbsp; Withhold</button>
                                                        <button type="submit" name="update_action" value="admi_restore_validation" class="my_trash2 color8 black_bg genhover" onclick="return confirm('Do you want to remove this record from withheld list?')"><i class="fa fa-reply"></i></button>
                                                    @elseif ($val->status == 'Pay')
                                                        <a><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Pay</button></a>
                                                    @else
                                                        <a><button type="button" class="my_trash2 bg6 color8"><i class="fa fa-times"></i>&nbsp; Withheld</button></a>
                                                        @if ($val->employee->status == 'inactive')
                                                            <button type="submit" name="update_action" value="confirm_val_release" class="my_trash2 genhover blue_bg color8" onclick="return confirm('Are you sure you want to release payment for these record?')"><i class="fa fa-check"></i>&nbsp; Release</button>
                                                        @endif
                                                    @endif
                                                    {{-- @if ($emp->del == 'yes')
                                                        <button type="submit" name="update_action" value="restore_employee" class="my_trash2 color8 black_bg genhover" onclick="return confirm('Do you want to restore this record?')"><i class="fa fa-reply"></i></button>
                                                    @else
                                                        @if ($emp->status == 'inactive')
                                                            <a href="#"><button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Inactive</button></a>
                                                        @else
                                                            <a href="#"><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Active</button></a>
                                                        @endif
                                                        <button type="submit" name="update_action" value="change_val_status" class="my_trash2 color8 black_bg genhover" onclick="return confirm('This action will hold payment for current and subsequent months, Are you sure you want to proceed?')"><i class="fa fa-trash"></i></button>
                                                    @endif --}}
                                                </td>
                                            </form>

                                        </tr>
                                    @endforeach
                                    <input type="hidden" value="{{$c = 1}}">
                                </tbody>
                                    {{ $validation->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    No Records Found on Checked List
                </div>
            @endif

            <!-- General List View -->
            {{-- <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <h6><i class="fa fa-th"></i> &nbsp; General List View</h6>
                        @if (count($employees) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Comments</th>
                                        <th class="align_right">Status/Actions</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($employees as $emp)

                                        @if ($val_check->contains('employee_id', $emp->id) == false and $emp->region_id == auth()->user()->employee->region_id)
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
                                                    <p class="small_p">SSN: {{ $emp->ssn }}</p>
                                                    <p class="small_p_black">Phone: {{ $emp->contact }}</p>
                                                </td>
                                                <td class="text-bold-500">{{ $emp->cur_pos }}
                                                    <p class="small_p">Dept.: {{ $emp->dept }}</p>
                                                </td>

                                                <form action="{{ action('EmployeeController@update', $emp->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf

                                                    <td class="text-bold-500">
                                                        <textarea class="valid_comments" name="comments" cols="30" rows="2" required>{{ $emp->valid_comment }}</textarea>
                                                    </td>

                                                    <td class="text-bold-500 align_right action_size">
                                                        @if ($emp->status == 'inactive')
                                                            <a><button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Inactive</button></a>
                                                        @else
                                                            <a><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Active</button></a>
                                                        @endif
                                                        <button type="submit" name="update_action" value="change_val_status" class="my_trash2 color8 black_bg genhover" onclick="return confirm('This action will hold payment for current and subsequent months, Are you sure you want to proceed?')"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                </form>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($c > 20)
                                {{ $employees->appends(['search_emp' => request()->query('search_emp')])->links() }}
                            @endif
                            
                        @else
                            <div class="alert alert-danger">
                                No Records Found
                            </div>
                        @endif
                    </div>

                </div>
            </div> --}}
        </div>
    </div>
        

@endsection

 