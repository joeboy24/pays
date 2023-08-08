
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

            <li class="sidebar-item active has-sub">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-users"></i>
                    <span>Employee</span>
                </a>
                <ul class="submenu active">
                    <li class="submenu-item">
                        <a href="/add_employee">Add Employee</a>
                    </li>
                    <li class="submenu-item">
                        <!--a href="/pay_employee">Upload Data</a-->
                    </li>
                    <li class="submenu-item active">
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
        <h3><i class="fa fa-file-text color6"></i>&nbsp;&nbsp;Employee Management</h3>

        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Home</p></a>
            {{-- <a href="/emp_report"><p class="print_report">&nbsp;<i class="fa fa-print"></i></p></a> --}}
            {{-- <button type="submit" name="store_action" value="calc_taxation" class="print_btn_small"><i class="fa fa-refresh"></i></button> --}}
            <a href="/bulksms"><p class="view_daily_report">&nbsp;<i class="fa fa-envelope color5"></i>&nbsp; SMS</p></a>
            <a href="/view_employee"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        </form>
 
        <div class="row">
            <div class="col-12 col-md-8">
                <form action="{{ url('/employee') }}">
                    @csrf
                    <input type="hidden" name="check" value="employee">
                    <input type="text" name="search_emp" class="search_emp" placeholder="Search">
                    <button class="search_btn" name="store_action" value="search_emp"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>

    {{ $employees->appends(['search_emp' => request()->query('search_emp')])->links() }}

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                    <!-- Employee View -->
                    <div class="table-responsive">
                        @if (count($employees) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Salary (GhC)</th>
                                        {{-- <th>Contact</th> --}}
                                        <th>Status</th>
                                        <th class="align_right">Actions</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($employees as $emp)
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
                                                @if ($emp->reg_mgr == 'yes') <button type="button" class="my_trash2 blue_bg color8"><i class="fa fa-user-circle"></i>&nbsp; Regional Mgr.</button> @endif
                                            </td>
                                            <td class="text-bold-500">{{ number_format($emp->salary, 2) }}<br>
                                                @if ($emp->del != 'yes')
                                                    <a href="/reporting/{{$emp->id}}"><button type="button" class="my_trash2 green_bg color8 genhover"><i class="fa fa-print"></i>&nbsp; Pay Slip</button></a>
                                                @endif
                                            </td>
                                            {{-- <td class="text-bold-500">{{ $emp->contact }}</td> --}}
                                            <td class="text-bold-500">{{ $emp->status }}<br>
                                                @if ($emp->valid_comment != '')
                                                    <textarea class="valid_comments" name="comments" cols="30" rows="2" readonly>{{ $emp->valid_comment }}</textarea>
                                                @endif
                                                {{-- <button type="button" value="del_loan" class="my_trash2 green_bg color8 genhover"><i class="fa fa-folder-open"></i></button> --}}
                                            </td>

                                            <form action="{{ action('EmployeeController@update', $emp->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_method" value="PUT">
                                                @csrf


                                                @if ($emp->del == 'yes')
                                                    <td class="text-bold-500 align_right action_size">
                                                        <button type="submit" name="update_action" value="restore_employee" class="my_trash" onclick="return confirm('Do you want to restore this record?')"><i class="fa fa-reply"></i></button>
                                                    </td>
                                                @else
                                                    <td class="text-bold-500 align_right action_size">
                                                        {{-- <button type="submit" name="update_action" value="del_employee" class="my_trash"><i class="fa fa-folder-open"></i></button> --}}
                                                        {{-- <button type="submit" value="add_leave" class="my_trash2 green_bg color8 genhover"><i class="fa fa-print"></i>&nbsp; Leave</button> --}}
                                                        <button type="submit" name="update_action" value="add_sms_contact" class="my_trash_small" onclick="return confirm('Click Ok to add {{$emp->fname}}`s contact to SMS list?')"><i class="fa fa-user-plus"></i></button>
                                                        @if ($emp->status == 'inactive')
                                                            {{-- <button type="button" class="my_trash_small bg7" onclick="alert('You can only resume leave from the `Manage Leave` page')"><i class="fa fa-leaf"></i></button> --}}
                                                        @else
                                                        {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#leave{{$emp->id}}" class="my_trash_small"><i class="fa fa-leaf"></i></button> --}}
                                                        @endif
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#edit{{$emp->id}}" class="my_trash_small"><i class="fa fa-pencil"></i></button>
                                                        <button type="submit" name="update_action" value="del_employee" class="my_trash_small" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                @endif
                                            </form>

                                        </tr>

                                        <!-- Add Leave -->
                                        <div class="modal fade" id="leave{{$emp->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                                            Add Leave to {{$emp->fname}}'s Records
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ action('HrdashController@update', $emp->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        @csrf
                    
                                                        <div class="modal-body">
                                                            {{-- <div class="filter_div" id="orderby">
                                                                <i class="fa fa-user"></i>&nbsp;&nbsp; Staff
                                                                <select name="staff_id">
                                                                    <option value="1" selected>With Pay</option>
                                                                    <option value="0">Without Pay</option>
                                                                </select>
                                                            </div> --}}
                                                            
                                                            <div class="filter_div" id="orderby">
                                                                <i class="fa fa-clipboard"></i>&nbsp;&nbsp; Leave Type
                                                                <select name="leave_type" id="leave_type{{$emp->id}}" onchange="others_check{{$emp->id}}()">
                                                                    <option value="casual" selected>Casual</option>
                                                                    <option value="annual">Annual</option>
                                                                    <option value="study">Study</option>
                                                                    <option value="maternity">Maternity</option>
                                                                    <option value="compassionate">Compassionate</option>
                                                                    <option value="examamination">Examamination</option>
                                                                    {{-- <option value="others">Others</option> --}}
                                                                </select>
                                                            </div>

                                                            <script>

                                                                // document.getElementById("others{{$emp->id}}").style.display = "none";

                                                                // function others_check{{$emp->id}}() {
                                                                //     report_id = document.getElementById('report_id{{$emp->id}}').value;
                                                                //     alert(report_id);
                                                                //     if (report_id == '0') {
                                                                //         document.getElementById('region').style.display = "none";
                                                                //         document.getElementById('orderby').style.display = "block";
                                                                //         document.getElementById('from').style.display = "none";
                                                                //         document.getElementById('to').style.display = "none";

                                                                //         // document.getElementById('year').style.display = "none";
                                                                //         // document.getElementById('month').style.display = "none";
                                                                //     }
                                                                // }

                                                            </script>
                                                            
                                                            <div class="filter_div" id="orderby">
                                                                <i class="fa fa-suitcase"></i>&nbsp;&nbsp; Payment
                                                                <select name="payment">
                                                                    <option value="1" selected>With Pay</option>
                                                                    <option value="0">Without Pay</option>
                                                                </select>
                                                            </div> 

                                                            <p class="small_p">&nbsp;</p>
                                                            <p class="small_p">Use section below if Leave Type is `Others`</p>
                                                            <div class="filter_div" id="others{{$emp->id}}">
                                                                <i class="fa fa-black-tie"></i>&nbsp;&nbsp; Others
                                                                <input type="text" placeholder="Define no. of days" name="others">
                                                            </div>
                                                            
                                                            <div class="form-group modal_footer">
                                                                <button type="submit" name="update_action" value="add_leave" class="load_btn" onclick="return confirm('Are you sure you want to grant leave..?')">&nbsp;<i class="fa fa-save"></i>&nbsp; Grant Leave &nbsp;</button>
                                                            </div>
                                                        </div>
                                                        
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Update Employee -->
                                        <div class="modal fade" id="edit{{$emp->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                                            Edit Employer Here
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ action('EmployeeController@update', $emp->id) }}" method="POST">
                                                        <input type="hidden" name="_method" value="PUT">
                                                        @csrf
                                                        <div class="modal-body">
                                                            
                                                            <div class="filter_div" id="">
                                                                <i class="fa fa-building"></i>&nbsp;&nbsp; AFIS No.
                                                                <input name="afis_no" type="text" class="form-control" placeholder="AFIS No." id="first-name-icon" value="{{ $emp->afis_no }}">
                                                            </div>
                                                            
                                                            <div class="filter_div" id="">
                                                                <i class="fa fa-user"></i>&nbsp;&nbsp; First Name
                                                                <input name="fname" type="text" class="form-control" placeholder="First Name" id="first-name-icon" value="{{ $emp->fname }}" required>
                                                            </div>
                                                            
                                                            <div class="filter_div" id="">
                                                                <i class="fa fa-user"></i>&nbsp;&nbsp; Surname
                                                                <input name="sname" type="text" class="form-control" placeholder="Surname" id="first-name-icon" value="{{ $emp->sname }}" required>
                                                            </div>
                                                            
                                                            <div class="filter_div" id="">
                                                                <i class="fa fa-user"></i>&nbsp;&nbsp; Other Names
                                                                <input name="oname" type="text" class="form-control" placeholder="Other Names" id="first-name-icon" value="{{ $emp->oname }}">
                                                            </div>
                                                            
                                                            <div class="filter_div" id="">
                                                                <i class="fa fa-phone"></i>&nbsp;&nbsp; Contact
                                                                <input name="contact" type="number" min="0" class="form-control" placeholder="Contact" id="first-name-icon" value="{{ $emp->contact }}" required>
                                                            </div>

                                                            <div class="filter_div">
                                                                <i class="fa fa-dot-circle-o"></i> &nbsp; Position
                                                                <select name="position">
                                                                    <option value="all" selected>Choose Position</option>
                                                                    @foreach ($position as $post)
                                                                        @if ($emp->cur_pos == $post->position)    
                                                                            <option selected>{{$post->position}}</option>
                                                                        @else
                                                                            <option>{{$post->position}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="filter_div" id="region">
                                                                <i class="fa fa-globe"></i> &nbsp; Region
                                                                <select name="region">
                                                                    <option value="all" selected>Select Region</option>
                                                                    @foreach ($regions as $reg)
                                                                        @if ($emp->region == $reg->region)    
                                                                            <option selected>{{$reg->region}}</option>
                                                                        @else
                                                                            <option>{{$reg->region}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    @foreach ($main_regions as $mreg)
                                                                        @if ($emp->region == $mreg->region)    
                                                                            <option selected>{{$mreg->reg_name}}</option>
                                                                        @else
                                                                            <option>{{$mreg->reg_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="filter_div">
                                                                <i class="fa fa-dot-circle-o"></i> &nbsp; Access
                                                                <select name="reg_mgr">
                                                                    @if ($emp->reg_mgr == 'no')    
                                                                        <option value="yes">Regional Mgr.</option>
                                                                        <option value="FA" selected>Finance Mgr.</option>
                                                                        <option value="no" selected>No</option>
                                                                    @else
                                                                        <option value="yes" selected>Yes</option>
                                                                        <option value="no">No</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            
                                                        </div> 
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                <i class="bx bx-x d-block d-sm-none"></i><span class="d-none d-sm-block">Close</span>
                                                            </button>
                                                            <button type="submit" name="update_action" value="update_employee" class="btn btn-primary me-1 mb-1">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>
                            </table>
                            {{ $employees->appends(['search_emp' => request()->query('search_emp')])->links() }}
                            
                        @else
                            <div class="alert alert-danger">
                                No Records Found on Employees
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="search_div">
        <form action="">
            <input id="search_fd" type="text" class="search_field" placeholder="Search...">
            <button type="button" onclick="showsearch()"><i class="fa fa-search"></i></button>
        </form>
        <script>
            function showsearch() {
                if (document.getElementById('search_fd').style.opacity != 1) {
                    document.getElementById('search_fd').style.opacity = 1;
                    // document.getElementById('search_fd').style.display = "none";
                } else {
                    document.getElementById('search_fd').style.opacity = 0;
                }
            }
        </script>
    </div>
        

@endsection

 