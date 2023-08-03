
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
                    <li class="submenu-item">
                        <a href="/view_employee">View/Edit Data</a>
                    </li>
                    <li class="submenu-item active">
                        <a href="">Allowances</a>
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
        <h3><i class="fa fa-file-text color6"></i>&nbsp;&nbsp;Manage Emp. Allowance</h3>
        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back to Home</p></a>
            {{-- <a data-bs-toggle="modal" data-bs-target="#allow_overview"><p class="print_report">&nbsp;<i class="fa fa-file-text"></i>&nbsp; Allowance Overview</p></a> --}}
            <a data-bs-toggle="modal" data-bs-target="#allow_overview"><p class="view_daily_report">&nbsp;<i class="fa fa-file-text color5"></i>&nbsp; Allowance/SSNIT Overview</p></a>
            {{-- <button type="submit" name="store_action" value="insert_allowances" class="print_btn_small"><i class="fa fa-refresh"></i></button> --}}
            <a href="/allowance_exp"><p class="print_report">&nbsp;<i class="fa fa-warning"></i>&nbsp; EXP</p></a>
            <a href="/allowance"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        </form>

        <div class="row">
            <div class="col-12 col-md-8">
                <form action="{{ url('/allowance') }}">
                    @csrf
                    <input type="hidden" name="check" value="allowance">
                    <input type="text" name="search_alw" class="search_emp" placeholder="Search">
                    <button class="search_btn" name="store_action" value="search_alw"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
    </div>

    {{-- {{ $allowances->links() }} --}}
    {{ $allowances->appends(['search_alw' => request()->query('search_alw')])->links() }}

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 
            <div class="card">
                <div class="card-body">

                    <!-- Allowances View -->
                    <div class="table-responsive">
                        @if (count($allowances) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>Fullname</th>
                                        <th>Allowances</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    {{-- <input type="text" id="state_tf" name="state_tf">
                                    <input type="text" id="allow_tf" name="allow_tf"> --}}
                                    @foreach ($allowances as $alw)
                                        <tr>
                                            <td class="text-bold-500">{{ $alw->employee->fname.' '.$alw->employee->sname.' '.$alw->employee->oname }}</td>

                                            <form action="{{ action('EmployeeController@update', $alw->id) }}" method="POST">
                                                {{-- <input type="hidden" name="_method" value="DELETE"> --}}
                                                <input type="hidden" name="_method" value="PUT">
                                                @csrf

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

                                                {{-- @if ($alw->del == 'yes')
                                                    <td class="text-bold-500 align_right action_size">
                                                        <button type="submit" name="update_action" value="restore_employee" class="my_trash" onclick="return confirm('Do you want to restore this record?')"><i class="fa fa-reply"></i></button>
                                                    </td>
                                                @else
                                                    <td class="text-bold-500 align_right action_size">
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#edit{{$alw->id}}" class="my_trash"><i class="fa fa-pencil"></i></button>
                                                        <button type="submit" name="update_action" value="del_employee" class="my_trash" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                @endif --}}

                                            </form>

                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            {{ $allowances->appends(['search_alw' => request()->query('search_alw')])->links() }}
                        @else
                            <div class="alert alert-danger">
                                No Records Found on Allowances
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
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->rent}}" @endif min="0" max="100" placeholder="Rent Allowance eg. 15" name="rent" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-check-square"></i>&nbsp;&nbsp;&nbsp; Prof.
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->prof}}" @endif min="0" max="100" name="prof" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-briefcase"></i>&nbsp;&nbsp; Resp.
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->resp}}" @endif min="0" max="100" name="resp" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;&nbsp;Risk
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->risk}}" @endif min="0" max="100" name="risk" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-car"></i>&nbsp;&nbsp;&nbsp;VMA
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->vma}}" @endif min="0" max="100" name="vma" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-headphones"></i>&nbsp;&nbsp;&nbsp;&nbsp;Ent.
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->ent}}" @endif min="0" max="100" name="ent" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-bed"></i>&nbsp;&nbsp;&nbsp;Dom.
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->dom}}" @endif min="0" max="100" name="dom" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-money"></i>&nbsp;&nbsp;&nbsp;Cola
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->cola}}" @endif min="0" max="100" name="cola" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-internet-explorer"></i>&nbsp;&nbsp;&nbsp;Int/Ut (GhC)
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->intr}}" @endif min="0" name="intr" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-taxi"></i>&nbsp;&nbsp;&nbsp;T&T (GhC)
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->tnt}}" @endif min="0" name="tnt" required>
                    </div>
            
                    @if (count($new_allows) > 0)
                        <p class="small_p">&nbsp; New Allowances</p>
                        @foreach ($new_allows as $new_alw)
                            <div class="filter_div">
                                <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;{{ substr($new_alw->allow_name, 0, 5) }}... @if ($new_alw->allow_amt!=0) (Ghc) @endif
                                <input type="number" step="any" @if ($new_alw->allow_perc==0)value="{{$new_alw->allow_amt}}" @else value="{{$new_alw->allow_perc}}" @endif min="0" @if ($new_alw->allow_perc!=0) max="100" @endif name="{{'new'.$new_alw->id}}" required>
                            </div>
                        @endforeach
                    @endif
                    {{-- <div class="filter_div">
                        <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;&nbsp;Cola 
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->cola}}" @endif min="0" max="100" name="tnt" required>
                    </div> --}}

                    <p class="">&nbsp;</p>
            
                    <div class="filter_div">
                        <i class="fa fa-credit-card-alt"></i>&nbsp;&nbsp;&nbsp;SSF
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->ssf}}" @endif min="0" max="100" name="ssf" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-credit-card"></i>&nbsp;&nbsp;&nbsp;&nbsp;SSF 1T
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->ssf1}}" @endif min="0" max="100" name="ssf1" required>
                    </div>
            
                    <div class="filter_div">
                        <i class="fa fa-credit-card-alt"></i>&nbsp;&nbsp;&nbsp;SSF 2T
                        <input type="number" step="any" @if ($allowoverview!='')value="{{$allowoverview->ssf2}}" @endif min="0" max="100" name="ssf2" required>
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

 