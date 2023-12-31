
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
    <h3><i class="fa fa-address-book color5"></i>&nbsp;&nbsp;Admin Profile</h3>
    <a href="/mydashboard"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Dashboard</p></a>
    <a class="color5" data-bs-toggle="modal" data-bs-target="#update_user"><p class="print_report">&nbsp;<i class="fa fa-unlock-alt"></i>&nbsp; Change Password</p></a>
    <p>&nbsp;</p>
    </div>


    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                {{-- <p>&nbsp;</p> --}}
                <div class="row emp_profile">

                    <div class="col-md-4 offset-md-4 hhh">
                    @if ($emp->photo != 'noimage.png')
                        <img src="/storage/classified/emps/{{$emp->photo}}" class="emp_profile_img" alt="">
                    @else
                        <img src="/maindir/images/user3.png" class="emp_profile_img" alt="">
                    @endif
                    </div>
                </div>

                    <h4 style="text-align: center">{{ $emp->fname.' '.$emp->sname.' '.$emp->oname }}</h4>

                <p class="line1">&nbsp;</p>

                <div class="row emp_profile">

                    <div class="col-md-5 offset-md-1">
                    
                    <table class="prof_tbl1">
                        <thead>
                        <th>&nbsp;</th>
                        </thead>
                        <thead>
                        <th>Bank Details</th>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="faint_td">Bank</td>
                            <td>: &nbsp; {{ $emp->bank }}</td>
                        </tr>
                        <tr>
                            <td class="faint_td">Branch</td>
                            <td>: &nbsp; {{ $emp->branch }}</td>
                        </tr>
                        <tr>
                            <td class="faint_td">Account No.</td>
                            <td>: &nbsp; {{ $emp->acc_no }}</td>
                        </tr>
                        <tr>
                            <td class="faint_td">Department</td>
                            <td>: &nbsp; {{ $emp->dept }}</td>
                        </tr>
                        </tbody>
                    </table>

                    <p class="line1">&nbsp;</p>
                    
                    <div class="non_edit">
                        <table class="prof_tbl1">
                        </tbody>
                            <tr>
                            <td class="faint_td">Fullname</td>
                            <td>: &nbsp; {{ $emp->fname.' '.$emp->sname.' '.$emp->oname }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Staff ID.</td>
                            <td>: &nbsp; {{ $emp->staff_id }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">AFIS No.</td>
                            <td>: &nbsp; {{ $emp->afis_no }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">SSNIT</td>
                            <td>: &nbsp; {{ $emp->ssn }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Position</td>
                            <td>: &nbsp; {{ $emp->cur_pos }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Date Employed&nbsp;</td>
                            <td>: &nbsp; {{ date('F d, Y', strtotime($emp->date_emp)) }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Department</td>
                            <td>: &nbsp; {{ $emp->dept }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Basic Sal.</td>
                            <td>: &nbsp; {{ number_format($emp->salary, 2) }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Region</td>
                            <td>: &nbsp; {{ $emp->region }}</td>
                            </tr>
                            <tr>
                            <td class="faint_td">Status</td>
                            <td style="text-transform: capitalize">: &nbsp; {{ $emp->status }}</td>
                            </tr>
                        </tbody>
                        </table>
                    </div>

                    </div>

                    <div class="col-md-6">
                    <p>&nbsp;</p>
                    <table class="prof_tbl2">
                        <thead>
                        <th>Other Details</th>
                        {{-- </th>.......................................</th> --}}
                        </thead>
                        <tbody> 
                            <tr>
                              <td class="faint_td2">Qualification</td>
                              <td>: &nbsp; {{$emp->extend->qual}}</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Classification</td>
                              <td>: &nbsp; Null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Grade</td>
                              <td>: &nbsp; {{$emp->extend->grade}}</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Marital Status</td>
                              <td>: &nbsp; Null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">National Id</td>
                              <td>: &nbsp; Null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Date of Birth</td>
                              <td>: &nbsp; {{date('F d, Y', strtotime($emp->extend->dob))}}</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Gender</td>
                              <td>: &nbsp; {{$emp->extend->gender}}</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">contact</td>
                              <td>: &nbsp; {{$emp->extend->contact}}</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Email</td>
                              <td>: &nbsp; {{$emp->extend->email}}</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Passport</td>
                              <td>: &nbsp; Null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Residential Addr.</td>
                              <td>: &nbsp; null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Religion</td>
                              <td>: &nbsp; null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">Next of Kin</td>
                              <td>: &nbsp; Null</td>
                            </tr>
                            <tr>
                              <td class="faint_td2">NOK's Contact</td>
                              <td>: &nbsp; Null</td>
                            </tr>
                          </tbody>
                    </table>
                    </div>
                </div>

                <!-- Employee Profile View -->
                

                </div>
            </div>
        </div>
    </div>

    <!-- Update User -->
    <div class="modal fade" id="update_user" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
            role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">
                        Edit User Here
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <form action="{{ action('EmployeeController@update', auth()->user()->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="col-md-12">
                            <label>Username</label>
                            <div class="form-group has-icon-left">
                                <div class="position-relative">
                                    <input name="name" type="text" class="form-control" placeholder="Title" id="first-name-icon" value="{{ auth()->user()->name }}" required>
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
                                    <input name="email" type="email" class="form-control" placeholder="Email" id="first-name-icon" value="{{ auth()->user()->email }}" required>
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
                                    <input name="contact" type="number" min="0" class="form-control" placeholder="Title" id="first-name-icon" value="{{ auth()->user()->contact }}" required>
                                    <div class="form-control-icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                        
                    </div> 
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times d-block d-sm-none"></i><span class="d-none d-sm-block">Close</span>
                        </button>
                        <!--button id="success" class="btn btn-outline-success btn-lg btn-block" type="submit" name="update_action" value="update_user">Update</button-->
                        <button type="submit" name="update_action" value="update_user" class="btn btn-primary me-1 mb-1">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        

@endsection

 