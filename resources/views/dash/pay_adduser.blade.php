
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
                    {{-- <li class="submenu-item ">
                        <a href="#">Accounts</a>
                    </li> --}}
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

            <li class="sidebar-item active has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-cogs"></i>
                    <span>Settings</span>
                </a>
                <ul class="submenu active">
                    <li class="submenu-item">
                        <a href="/companysetup">Company Setup</a>
                    </li>
                    <li class="submenu-item active">
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
        <h3><i class="fa fa-address-card color6"></i>&nbsp;&nbsp;Manage User</h3>
        <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Home</p></a>
        <a href="/bulksms"><p class="view_daily_report">&nbsp;<i class="fa fa-envelope color5"></i>&nbsp; SMS</p></a>
        <a href="/adduser"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
    </div>
 
    <div class="row">
        <div class="col-12 col-md-8">
            <form action="{{ url('/adduser') }}">
                @csrf
                <input type="text" name="search_emp" class="search_emp" placeholder="Search">
                <button class="search_btn"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
    <p>&nbsp;</p>

    <div class="row">
        <div class="col-12 col-xl-10">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                    <p>&nbsp;</p>
                    <div class="col-md-10 offset-md-1">

                        <!-- Add Employee -->
                        <form action="{{ action('EmployeeController@store') }}" method="POST">
                            @csrf
                    
                            <div class="filter_div" id="">
                                <i class="fa fa-user"></i> &nbsp; Username
                                <input type="text" name="name" placeholder="Name" id="first-name-icon" autofocus required>
                            </div>
                  
                            <div class="filter_div" id="">
                                <i class="fa fa-envelope"></i> &nbsp; Email
                                <input type="email" name="email" placeholder="Email" id="first-name-icon" required>
                            </div>
                  
                            <div class="filter_div" id="">
                                <i class="fa fa-phone"></i> &nbsp; Phone
                                <input type="number" name="contact" placeholder="Mobile" required>
                            </div>
                  
                            <div class="filter_div">
                                <i class="fa fa-address-card"></i> &nbsp; Status
                                <select name="status">
                                  <option value="none">Select User/Administrator</option>
                                  {{-- <option value="User">User</option> --}}
                                  <option value="System">System User</option>
                                  <option value="Administrator">System Administrator</option>
                                  <option value="HR">HR Administrator</option>
                                  <option value="AU">Audit Administrator</option>
                                  <option value="Finance">Finance Administrator</option>
                                  {{-- <option value="Administrator">Administrator</option> --}}
                                </select>
                            </div>
                  
                            <div class="filter_div" id="">
                                <i class="fa fa-lock"></i> &nbsp; Password
                                <input type="password" name="password" placeholder="Password" required>
                            </div>
                  
                            <div class="filter_div" id="">
                                <i class="fa fa-lock"></i> &nbsp; Confirm Ps.
                                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                            </div>

                            <div class="form-group modal_footer">
                                <button type="submit" name="store_action" value="create_user" class="load_btn"><i class="fa fa-save"></i>&nbsp; Create User</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{ $users->links() }}
    <div class="row">
        <div class="col-12 col-xl-10">
            <div class="card">
                <div class="card-body">

                    <p>&nbsp;</p>
                    <div class="col-md-10 offset-md-1">
                        <!-- Users View -->
                        <div class="table-responsive">
                            @if (count($users) > 0)
                                <table class="table mb-0 table-lg">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Status</th>
                                            <th class="align_right action_size2">Action</th>
                                        </tr>
                                    </thead>   
                                    <tbody>
                                        @foreach ($users as $user)
                                            @if ($user->del != 'null')
                                                @if ($user->del == 'yes')
                                                    <tr class="del_danger">
                                                @else
                                                    @if ($c % 2 == 1)
                                                        <tr class="bg9">
                                                    @else
                                                        <tr>
                                                    @endif
                                                @endif
                                                    <td class="text-bold-500">{{$c++}}</td>
                                                    <td class="text-bold-500">{{ $user->employee->fullname }}</td>
                                                    <td class="text-bold-500">{{ $user->email }}</td>
                                                    <td class="text-bold-500">{{ $user->contact }}</td>
                                                    <td class="text-bold-500">{{ $user->status }}</td>
                                                    {{-- <td class="text-bold-500">@if ($lv->dob != '') {{date('D.. M, d Y', strtotime($lv->dob))}} @endif</td> --}}
                                                    <td class="text-bold-500 align_right">

                                                        <form action="{{ action('HrdashController@update', $user->id) }}" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_method" value="PUT">
                                                            @csrf
                                                            {{-- @if ($user->id == auth()->user()->id) --}}
                                                                <button type="submit" name="update_action" value="it_add_sms_contact" class="my_trash_small blue_bg color8" onclick="return confirm('Click Ok to add {{$user->employee->fname}}`s contact to SMS list?')"><i class="fa fa-user-plus"></i></button>
                                                                @if ($user->status != 'Administrator')
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#edit{{$user->id}}" class="my_trash_small"><i class="fa fa-pencil"></i></button>
                                                                    <button type="submit" name="update_action" value="it_password_reset" class="my_trash_small bg10 color8" onclick="return confirm('Click Ok to proceed with {{$user->employee->fname}}`s password reset')"><i class="fa fa-gear"></i></button>
                                                                @elseif ($user->status == 'Administrator' && $user->id == auth()->user()->id)
                                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#edit{{$user->id}}" class="my_trash_small"><i class="fa fa-pencil"></i></button>
                                                                    <button type="submit" name="update_action" value="it_password_reset" class="my_trash_small bg10 color8" onclick="return confirm('Click Ok to proceed with {{$user->employee->fname}}`s password reset')"><i class="fa fa-gear"></i></button>
                                                                @endif
                                                            {{-- @endif --}}
                                                        </form>

                                                    </td>
                                                </tr>

                                                <!-- Update Users -->
                                                <div class="modal fade" id="edit{{$user->id}}" tabindex="-1" role="dialog"
                                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                        role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                    Leave Application
                                                                </h5>
                                                                <button type="button" class="close" data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <i class="fa fa-times"></i>
                                                                </button>
                                                            </div>
                                                            <form action="{{ action('EmployeeController@update', $user->id) }}" method="POST">
                                                                <input type="hidden" name="_method" value="PUT">
                                                                @csrf

                                                                <div class="modal-body">
                                                                    
                                                                    <div class="col-md-12">
                                                                        <label>Username</label>
                                                                        <div class="form-group has-icon-left">
                                                                            <div class="position-relative">
                                                                                <input name="name" type="text" class="form-control" placeholder="Title" id="first-name-icon" value="{{ $user->name }}" required>
                                                                                <div class="form-control-icon">
                                                                                    <i class="bi bi-person"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-12">
                                                                        <label>Email</label>
                                                                        <div class="form-group has-icon-left">
                                                                            <div class="position-relative">
                                                                                <input name="email" type="email" class="form-control" placeholder="Email" id="first-name-icon" value="{{ $user->email }}" required>
                                                                                <div class="form-control-icon">
                                                                                    <i class="bi bi-envelope"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-12">
                                                                        <label>Contact</label>
                                                                        <div class="form-group has-icon-left">
                                                                            <div class="position-relative">
                                                                                <input name="contact" type="number" min="0" class="form-control" placeholder="eg. 024456789" id="first-name-icon" value="{{ $user->contact }}" required>
                                                                                <div class="form-control-icon">
                                                                                    <i class="fa fa-phone"></i>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    @if ($user->id == auth()->user()->id)
                                                                        <div class="col-md-12">
                                                                            <label>Password</label>
                                                                            <div class="form-group has-icon-left">
                                                                                <div class="position-relative">
                                                                                    <input name="password" type="password" class="form-control" placeholder="New Password" id="first-name-icon">
                                                                                    <div class="form-control-icon">
                                                                                        <i class="fa fa-unlock-alt"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <label>Confirm Password</label>
                                                                            <div class="form-group has-icon-left">
                                                                                <div class="position-relative">
                                                                                    <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm New Password" id="first-name-icon">
                                                                                    <div class="form-control-icon">
                                                                                        <i class="fa fa-unlock-alt"></i>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if ($user->id == auth()->user()->id || auth()->user()->status == 'Administrator')
                                                                        <div class="col-md-12">
                                                                            <div class="filter_div" id="region">
                                                                                <i class="fa fa-clipboard"></i> &nbsp; Status
                                                                                <select name="status">
                                                                                    <option value="{{$user->status}}" selected>Same '{{$user->status}}'</option>
                                                                                    <option value="System">User</option>
                                                                                    <option value="Administrator">System Administrator</option>
                                                                                    <option value="HR">HR Administrator</option>
                                                                                    <option value="Finance">Finance Administrator</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    <div class="modal-footer modal_footer">
                                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                            <i class="fa fa-times d-block d-sm-none"></i><span class="d-none d-sm-block">Close</span>
                                                                        </button>
                                                                        <button type="submit" name="update_action" value="update_user" class="btn btn-primary me-1 mb-1">Update</button>
                                                                    </div>
                                                                </div>
                                                                
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $users->links() }}
                            @else
                                <div class="alert alert-danger">
                                    No Records Found on Users
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
        

@endsection

 