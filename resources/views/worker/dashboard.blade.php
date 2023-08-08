
@extends('layouts.stafflay')

@section('header_nav')
    @include('inc.header_nav')  
@endsection

@section('sidebar_menu')
    
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item active">
                <a href="/mydashboard" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/myprofile" class='sidebar-link'>
                    <i class="fa fa-address-book"></i>
                    <span>Profile</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/staff-loans" class='sidebar-link'>
                    <i class="fa fa-suitcase"></i>
                    <span>Loan</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/staff-leave" class='sidebar-link'>
                    <i class="fa fa-clipboard"></i>
                    <span>Manage Leave</span><b class="menu_figure yellow_bg"><i class="fa fa-warning"></i></b>
                </a>
            </li>

            <li class="sidebar-item">
                <a href="/mydashboard" class='sidebar-link'>
                    <i class="fa fa-credit-card-alt"></i>
                    <span>Pay Status</span><b class="menu_figure green_bg"><i class="fa fa-check"></i></b>
                </a>
            </li>

            {{-- <li class="sidebar-item">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-envelope"></i>
                    <span>Inbox</span><b class="menu_figure green_bg">&nbsp;73&nbsp;</b>
                </a>
            </li> --}}

            {{-- <li class="sidebar-item">
                <a href="#" class='sidebar-link'>
                    <i class="fa fa-file-text"></i>
                    <span>Report</span>
                </a>
            </li> --}}

        </ul>
    </div>
    
@endsection

@section('content')


    <div class="page-heading">
        <h3><i class="fa fa-th color2"></i>&nbsp;&nbsp;My Dashboard</h3>
    </div>

    <section class="menu_content1">
        <div class="row">

            <div class="col-md-11">
                <p class="gen_notice"><i class="fa fa-warning"></i>&nbsp;&nbsp; NOTE: General / Personalised information will pe posted via this platform so do not share login credentials</p>
            </div>

            {{-- <div class="row r1">
                <div class="col-md-6 c1">1</div>
                <div class="col-md-6 c2">2</div>
                gfgsdf
            </div> --}}
            @include('inc.messages') 
            <div class="col-md-4 profile_col">
                {{-- <button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Inactive</button>
                <a><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Active</button></a>
                <button type="submit" name="update_action" value="change_val_status" class="my_trash2 color8 black_bg genhover"><i class="fa fa-trash"></i></button> --}}
            
                <div class="profile_img_cont">
                    <img src="/dashdir/images/faces/user3.png">
                    <div class="profile_cover">
                        
                    </div>
                </div>
                <h2>{{auth()->user()->employee->fname}}</h2>
                <p class="gray">{{auth()->user()->employee->sname.' '.auth()->user()->employee->oname}}</p>
                <h6>{{auth()->user()->employee->position}}</h6>
            </div>
            
            <div class="col-md-7 pay_stubs">
                <div class="pay_stub_header">
                    <i class="fa fa-credit-card color1"></i>
                    <div class="ps_txt_cont">
                        <h4 class="psh">Payment</h4>
                        <p class="psp gray">Notification / Payslip</p>
                    </div>
                </div>
                <div id="ps_tbl1">
                    <table class="mytable mb-0 table-lg">
                        <tbody>
                            @foreach ($pay_stubs as $pay)
                                @if ($pay->status == 'Paid')
                                    <tr>
                                        <td class="td_left"><i class="fa fa-calendar-check-o color4"></i></td>
                                        <td class="td_right">{{date('M, Y', strtotime('01-'.$pay->month))}}
                                            <p>Paid | Gh₵{{number_format($pay->net_aft_ded, 2)}}</p>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="td_left"><i class="fa fa-calendar-times-o color6"></i></td>
                                        <td class="td_right">{{date('M, Y')}}
                                            <p>Not Paid</p>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div id="ps_tbl2">
                    <table class="mytable mb-0 table-lg">
                        <tbody>
                            @foreach ($pay_stubs as $pay)
                                @if ($pay->status == 'Paid')
                                    <tr>
                                        <td class="">
                                            <a href="/staff/{{$pay->id}}"><button class="ps_print"><i class="fa fa-print"></i></button></a>
                                            {{-- <a href="/staff_portal/{{$pay->id}}"><button class="ps_print"><i class="fa fa-print"></i></button></a> --}}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="">
                                            <button class="ps_print"><i class="fa fa-warning color7"></i></button>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="col-md-7 pay_stubs">
                <div class="pay_stub_header">
                    <i class="fa fa-clipboard color2"></i>
                    <div class="ps_txt_cont2">
                        <a class="add_leave" data-bs-toggle="modal" data-bs-target="#applyleave" class="my_trash_small">+</a>
                        <h4 class="psh">Leave</h4>
                        <p class="psp gray">Application</p>
                    </div>
                </div>
                <div id="ps_tbl3">
                    @if (count($leaves)>0)
                        <table class="mytable mb-0 table-lg">
                            <tbody>
                                @foreach ($leaves as $item)
                                    <tr>
                                        @if ($item->status == 'Pending')
                                            <td class="td_left"><i class="fa fa-calendar-times-o color7"></i></td>
                                            <td class="td_right">{{$item->leave_type.' Leave / '.$item->days.' days'}}<p>Pending</p></td>
                                        @else
                                            <td class="td_left"><i class="fa fa-calendar-check-o color4"></i></td>
                                            <td class="td_right">{{$item->leave_type.' Leave / '.$item->days.' days'}}<p>Approved</p></td>
                                        @endif
                                        <td class="td_right align_right"><p>From: {{date('D, M d, Y', strtotime($item->start_date))}}</p><p class="color3">To: {{date('D, M d, Y', strtotime($item->end_date))}}</p></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="small_p gray">No Leave Records Found</p> 
                    @endif
                </div>
            </div>

            <div class="col-md-4 apps_col">

                <a href="/myprofile">
                    <div class="single_app">
                        <i class="fa fa-address-book-o color5"></i>
                        <p class="">Profile</p>
                    </div>
                </a>

                <a href="/staff-loans">
                    <div class="single_app">
                        <i class="fa fa-suitcase color3"></i>
                        <p class="">Loan</p>
                    </div>
                </a>

                <a href="/staff-leave">
                    <div class="single_app">
                        <i class="fa fa-clipboard color2"></i>
                        <p class="">Leave</p>
                    </div>
                </a>

                {{-- <a href="">
                    <div class="single_app">
                        <i class="fa fa-credit-card color1"></i>
                        <p class="">Payment</p>
                    </div>
                </a>

                <a href="">
                    <div class="single_app">
                        <i class="fa fa-envelope-o color7"></i>
                        <p class="">Mail</p>
                    </div>
                </a> --}}
            </div>

        </div>
        {{-- <div class="menus">
            <a href="#"><button class="menu_btn"><i class="fa fa-address-card color5"></i><p>Profile</p></button></a>
            <a href="#"><button class="menu_btn"><i class="fa fa-clipboard color2"></i><p>Apply Leave</p></button></a>
            <a href="#"><button class="menu_btn"><i class="fa fa-suitcase color3"></i><p>Apply Loan</p></button></a>
            <a href="#"><button class="menu_btn"><i class="fa fa-envelope-o color7"></i><p>Inbox</p></button></a>
            <a href="#"><button class="menu_btn"><i class="fa fa-credit-card-alt"></i><p>Pay Status</p></button></a>
            <a href="#"><button class="menu_btn"><i class="fa fa-file-text color6"></i><p>Reports</p></button></a>
        </div> --}}


        <!-- Add Leave -->
        <div class="modal fade" id="applyleave" tabindex="-1" role="dialog"
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
                    <form action="{{ action('HrdashController@store') }}" method="POST" enctype="multipart/form-data">
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
                                <i class="fa fa-clipboard"></i>&nbsp;&nbsp; Type
                                <select name="leave_type" id="leave_type" onchange="others_check()">
                                    <option value="casual" selected>Casual</option>
                                    <option value="annual">Annual</option>
                                    <option value="study">Study</option>
                                    <option value="maternity">Maternity</option>
                                    <option value="compassionate">Compassionate</option>
                                    <option value="examamination">Examamination</option>
                                </select>
                            </div>
                            
                            <div class="filter_div" id="orderby">
                                <i class="fa fa-credit-card"></i>&nbsp;&nbsp; Payment
                                <select name="with_pay">
                                    <option value="1" selected>With Pay</option>
                                    <option value="0">Without Pay</option>
                                </select>
                            </div> 

                            <div class="filter_div" id="others">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp; From
                                <input type="date" id="lfrom" name="from" onchange="datecount()" required>
                            </div>

                            <div class="filter_div" id="others">
                                <i class="fa fa-calendar"></i>&nbsp;&nbsp; To
                                <input type="date" id="lto" name="to" onchange="datecount()" required>
                            </div>

                            <div class="filter_div" id="others">
                                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp; Days
                                <input type="number" min="0" id="days" name="days" readonly>
                            </div>
                            
                            <div class="filter_div" id="orderby">
                                <i class="fa fa-suitcase"></i>&nbsp;&nbsp; Select
                                <select name="hand_over">
                                    <option value="none" selected>Hand over to</option>
                                    @foreach ($coworkers as $item)
                                        @if ($item->id != auth()->user()->employee_id)
                                            <option>{{$item->fname.' '.$item->sname}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div> 
                    
                            <div class="filter_div">
                                <i class="fa fa-upload"></i> &nbsp; Scan&nbsp;Copy
                                <input type="file" name="file_scan" placeholder="Upload Scan Copy" required>
                            </div>

                            <div class="filter_div" id="others">
                                <i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp; Leave&nbsp;Bal.
                                <input value="{{auth()->user()->employee->extend->leave_bal}}" min="0" id="bal" name="bal" readonly>
                            </div>

                            <p class="small_p">&nbsp;</p>
                            <p class="small_p">Leave notes here</p>
                            <textarea class="mytextarea" name="leave_notes" id="" cols="30" rows="3"></textarea>
                            
                            <div class="form-group modal_footer">
                                <button type="submit" name="store_action" value="staff_add_leave" class="load_btn" onclick="return confirm('Are you sure you want to continue with leave application..?')">&nbsp;<i class="fa fa-share-square-o"></i>&nbsp; Apply &nbsp;</button>
                            </div>
                        </div>

                        <script>
                            function datecount() {
                                var startdate = $('#lfrom').val();
                                var enddate = document.getElementById('lto').value;

                                if (startdate && enddate) {
                                    // alert('Both are set..!');
                                    if (Date.parse(startdate) < Date.parse(enddate)) {
                                        // Give days in milliseconds
                                        var ndays = Math.floor((Date.parse(enddate) - Date.parse(startdate)) / 86400000);
                                        document.getElementById('days').value = ndays;
                                        // Converts milliseconds to days, month etc...!
                                        // function dateDiff( str1, str2 ) {
                                        // var diff = Date.parse( str2 ) - Date.parse( str1 ); 
                                        //     return isNaN( diff ) ? NaN : {
                                                // diff : diff,
                                                // ms : Math.floor( diff            % 1000 ),
                                                // s  : Math.floor( diff /     1000 %   60 ),
                                                // m  : Math.floor( diff /    60000 %   60 ),
                                                // h  : Math.floor( diff /  3600000 %   24 ),
                                                // d  : Math.floor( diff / 86400000        )
                                            // };
                                        // }
                                    } else {
                                        alert("Oops...! 'Start Date' cannot be ahead of 'End Date'");
                                    }
                                }
                            }
                        </script>
                        
                    </form>
                </div>
            </div>
        </div>

    </section>
        

@endsection

 