
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


    {{-- <div class="page-heading">
        <h3><i class="fa fa-file-text color6"></i>&nbsp;&nbsp;Staff Loans</h3>
        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Home</p></a>
            <a data-bs-toggle="modal" data-bs-target="#loan_setup"><p class="view_daily_report">&nbsp;<i class="fa fa-download color5"></i>&nbsp; Loan Setup</p></a>
            <button type="submit" name="store_action" value="calc_taxation" class="print_btn_small"><i class="fa fa-refresh"></i></button>
        </form>

        <div class="row">
            <div class="col-12 col-md-8">
                <form action="{{ url('/loans') }}">
                    @csrf
                    <input type="hidden" name="check" value="employee">
                    <input type="text" name="search_emp" class="search_emp" placeholder="Search">
                    <button class="search_btn" name="store_action" value="search_emp"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div> --}}

    {{ $activities->links() }}
    {{-- {{ $activities->appends(['search_emp' => request()->query('search_emp')])->links() }} --}}

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                    <!-- Employee View -->
                    <div class="table-responsive">
                        @if (count($activities) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        {{-- <th>User</th>
                                        <th>Date</th>
                                        <th>Description</th> --}}
                                        <th>System Logs ({{count($activities)}})</th>
                                        {{-- <th class="align_right">Actions</th> --}}
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($activities as $act)
                                        @if ($act->causer->status != 'Staff')
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif
                                                
                                                <td class="text-bold-500">{{$c++}}</td>
                                                {{-- <td class="text-bold-500">{{ $act->causer->name }}
                                                    <p class="">{{ $act->causer->employee->fname.' '.$act->causer->employee->sname.' '.$act->causer->employee->oname.' / '.$act->causer->employee->cur_pos }}</p>
                                                </td>
                                                <td class="text-bold-500">{{ date('D, M d, Y @ H:i', strtotime($act->created_at)) }}</td>
                                                <td class="text-bold-500">{{ $act->description }}</td> --}}
                                                <td class="text-bold-500">
                                                    <p class="gray_p">User: {{ $act->causer->name }}</p>
                                                    <p class="small_p">{{ $act->causer->employee->fname.' '.$act->causer->employee->sname.' '.$act->causer->employee->oname.' / '.$act->causer->employee->cur_pos }}</p>
                                                    {{ $act->properties }}
                                                    <p class="small_p">Date: {{ date('D, M d, Y @ H:i', strtotime($act->created_at)) }}</p>
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $activities->links() }}
                            {{-- {{ $activities->appends(['search_emp' => request()->query('search_emp')])->links() }} --}}
                        @else
                            <div class="alert alert-danger">
                                No Logs Found
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
        

@endsection

 