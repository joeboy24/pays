
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

            <li class="sidebar-item active">
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
        <h3><i class="fa fa-calendar color1"></i>&nbsp;&nbsp;Retirement</h3>
        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Home</p></a>
            {{-- <a data-bs-toggle="modal" data-bs-target="#leave_setup"><p class="view_daily_report">&nbsp;<i class="fa fa-gears color5"></i>&nbsp; Leave Setup</p></a> --}}
            <a href="/bulksms"><p class="view_daily_report">&nbsp;<i class="fa fa-envelope color5"></i>&nbsp; SMS</p></a>
            <a href="/retirement"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        </form>
        <form action="{{ url('/retirement') }}">
            @csrf
            <div class="row">
                <div class="col-md-5">
                    <div class="filter_div">
                        <i class="fa fa-filter"></i> &nbsp; Filter
                        <input placeholder="Type No. of Years Remaining (e.g 5)" type="number" name="date_filter" required>
                    </div>
                    <button type="submit" class="load_btn"><i class="fa fa-refresh"></i>&nbsp; Load</button>
                </div>
                {{-- <div class="col-md-2">
                    <button type="submit" class="load_btn"><i class="fa fa-refresh"></i>&nbsp; Load</button>
                </div> --}}
            </div>
        </form>
    </div>

    

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">
                    <p class="small_p">Showing results for retirements due in <b>{{60-$yrs}}</b> years</p>

                    <!-- Birthday View -->
                    <div class="table-responsive">
                        @if (count($retirements) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Date&nbsp;of&nbsp;Birth</th>
                                        <th>Position</th>
                                        <th class="align_right">Action</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($retirements as $rtire)
                                        @if ($rtire->extend_id)
                                            @if ($rtire->extend->dob && date_diff(date_create(date('d-m-Y', strtotime($rtire->extend->dob))), date_create(date('d-m-Y')))->y > $yrs)
                                                @if ($c % 2 == 1)
                                                    <tr class="bg9">
                                                @else
                                                    <tr>
                                                @endif
                                                    <td class="bday_icon">
                                                        @if (number_format(720 - (strtotime(date('d-m-Y'))-strtotime($rtire->extend->dob)) / (60 * 60 * 24) / 30) <= 6)
                                                            <i class="fa fa-calendar-check-o color4"></i>
                                                        @else
                                                            <i class="fa fa-calendar-check-o color1"></i>
                                                        @endif
                                                    </td>
                                                    <td class="text-bold-500">{{ $rtire->fname.' '.$rtire->sname.' '.$rtire->oname }}<br><p class="small_p">{{$rtire->contact}}</p></td>
                                                    <td class="text-bold-500">@if ($rtire->extend->dob != '') {{date('D. M, d Y', strtotime($rtire->extend->dob))}} @endif
                                                        <p class="small_p">Age: {{date_diff(date_create(date('d-m-Y', strtotime($rtire->extend->dob))), date_create(date('d-m-Y')))->y}}</p>
                                                    </td>
                                                    <td class="text-bold-500">{{ $rtire->cur_pos }}</td>
                                                    <td class="text-bold-500 align_right">
                                                        @if (number_format(720 - (strtotime(date('d-m-Y'))-strtotime($rtire->extend->dob)) / (60 * 60 * 24) / 30) <= 6)
                                                            <form action="{{ action('EmployeeController@update', $rtire->id) }}" method="POST">
                                                                <input type="hidden" name="_method" value="PUT">
                                                                @csrf
                                                                <button type="submit" name="update_action" value="add_sms_contact" class="my_trash2 color10 genhover" onclick="return confirm('Click Ok to add {{$rtire->fname}}`s contact to SMS list?')"><i class="fa fa-user-plus"></i></button>
                                                                <button type="submit" name="update_action" value="add_rtire_note" class="my_trash2 green_bg color8 genhover"><i class="fa fa-send"></i>&nbsp; Notify</button>
                                                            </form>
                                                        @else
                                                            <button type="button" class="my_trash2 color10"><i class="fa fa-ban"></i></button>
                                                        @endif
                                                    </td>
                                                    {{-- <td class="text-bold-500">

                                                        <form action="{{ action('HrdashController@update', $rtire->id) }}" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_method" value="PUT">
                                                            @csrf
                
                                                            <button type="button" name="update_action" value="send_wish" class="my_trash2 bg10 color8 genhover" onclick="return confirm('Do you wish to proceed to send birthday message?')"><i class="fa fa-clipboard"></i> &nbsp;Send Wish</button>
                                                        </form>

                                                    </td> --}}
                                                    {{-- <td class="text-bold-500">{{$rtire->status}}</td> --}}
                                                </tr>
                                            @endif
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            
                        @else
                            <div class="alert alert-danger">
                                No Retirement Records Found
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
        

@endsection

 