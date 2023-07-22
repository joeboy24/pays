
@extends('layouts.stafflay')

@section('header_nav')
    @include('inc.header_nav')  
@endsection

@section('sidebar_menu')
    
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-title">Menu</li>

            <li class="sidebar-item">
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

            <li class="sidebar-item active">
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
        <h3><i class="fa fa-clipboard color2"></i>&nbsp;&nbsp;Leave</h3>
        <a href="/mydashboard"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Dashboard</p></a>
        <p>&nbsp;</p>
    </div>

    <section class="menu_content1">
        <div class="row">
            @include('inc.messages') 
            
            <div class="col-md-10 pay_stubs_clone">
                <div class="pay_stub_header">
                    <i class="fa fa-clipboard color2"></i>
                    <div class="ps_txt_cont2">
                        <a class="add_leave" data-bs-toggle="modal" data-bs-target="#applyleave" class="my_trash_small">+</a>
                        <h4 class="psh">Leave</h4>
                        <p class="psp gray">Application</p>
                    </div>
                </div>
                <div id="ps_tbl3">
                    @if (count($leaves) > 0)
                        <table class="mytable mb-0 table-lg tbl_scroll">
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th class="td_right">Leave Type</th>
                                    <th class="td_right">Hand over to</th>
                                    <th class="td_right">Notes</th>
                                    <th class="td_right align_right">Dates</th>
                                    <th class="td_right align_right">Actions</th>
                                </tr>
                                @foreach ($leaves as $lv)
                                    <tr>
                                        @if ($lv->status == 'Pending')
                                            <td class="td_left"><i class="fa fa-calendar-times-o color7"></i></td>
                                            <td class="td_right">{{$lv->leave_type.' Leave / '.$lv->days.' days'}}<p>Pending</p></td>
                                        @else
                                            <td class="td_left"><i class="fa fa-calendar-check-o color4"></i></td>
                                            <td class="td_right">{{$lv->leave_type.' Leave / '.$lv->days.' days'}}<p>Approved 
                                                @if ($lv->with_pay == 1)
                                                    with Pay
                                                @else
                                                    without Pay
                                                @endif</p>
                                            </td>
                                        @endif
                                        <td class="td_right"><p>{{$lv->hand_over}}</p></td>
                                        <td class="td_right"><p>{{$lv->leave_notes}}</p><p class="gray_p">Leave Bal.: {{rand(100, 2)}} days</p></td>
                                        <td class="td_right align_right"><p>From: {{date('D, M d, Y', strtotime($lv->start_date))}}</p><p class="color3">To: {{date('D, M d, Y', strtotime($lv->end_date))}}</p></td>
                                        

                                        <form action="{{ action('EmployeeController@update', $lv->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_method" value="PUT">
                                            @csrf
                                            <td class="td_right align_right">
                                                <button type="button" class="my_trash_small" title="View scan" data-bs-toggle="modal" data-bs-target="#scan{{$lv->id}}"><i class="fa fa-picture-o"></i></button>
                                                @if ($lv->status == 'Approved')
                                                    <button type="button" class="my_trash_small"><i class="fa fa-ban"></i></button>
                                                @else
                                                    <button type="button" title="Edit" data-bs-toggle="modal" data-bs-target="#edit_leave{{$lv->id}}" class="my_trash_small bg7"><i class="fa fa-pencil"></i></button>
                                                    {{-- <button type="submit" name="update_action" value="staff_del_leave" class="my_trash_small bg7"onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-times"></i></button> --}}
                                                    <button type="submit" title="Delete" name="update_action" value="staff_del_leave" class="my_trash_small" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </td>
                                            
                                            <!-- Scan File -->
                                            <div class="modal fade" id="scan{{$lv->id}}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                    role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">
                                                                {{' Leave : '.$lv->leave_type.' / '.$lv->days.' days'}}
                                                            </h5>
                                                            <button type="button" class="close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div> 

                                                        <div class="modal-body">
                                                            <div class="scan_div">
                                                                <img src="/storage/classified/leaves/{{$lv->file_scan}}" class="scan_img" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Update Leave -->
                                            <div class="modal fade" id="edit_leave{{$lv->id}}" tabindex="-1" role="dialog"
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

                                                        <div class="modal-body">
                                                            
                                                            <div class="filter_div" id="orderby">
                                                                <i class="fa fa-clipboard"></i>&nbsp;&nbsp; Type
                                                                <select name="leave_type" id="leave_type" onchange="others_check()">
                                                                    <option value="maternity">Maternity</option>
                                                                    <option value="casual" selected>Casual</option>
                                                                    <option value="annual">Annual</option>
                                                                    <option value="study">Study</option>
                                                                    <option value="sick">Sick</option>
                                                                    <option value="others">Others</option>
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="filter_div" id="orderby">
                                                                <i class="fa fa-credit-card"></i>&nbsp;&nbsp; Payment
                                                                <select name="with_pay">
                                                                    @if ($lv->with_pay == 1)
                                                                        <option value="1" selected>With Pay</option>
                                                                        <option value="0">Without Pay</option>
                                                                    @else
                                                                        <option value="1">With Pay</option>
                                                                        <option value="0" selected>Without Pay</option>
                                                                    @endif
                                                                </select>
                                                            </div> 

                                                            <div class="filter_div" id="others">
                                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp; From
                                                                <input type="date" id="lfrom{{$lv->id}}" name="from" onchange="datecount{{$lv->id}}()">
                                                            </div>

                                                            <div class="filter_div" id="others">
                                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp; To
                                                                <input type="date" id="lto{{$lv->id}}" name="to" onchange="datecount{{$lv->id}}()">
                                                            </div>
                                                            
                                                            <div class="filter_div" id="orderby">
                                                                <i class="fa fa-suitcase"></i>&nbsp;&nbsp; Select
                                                                <select name="hand_over">
                                                                    <option value="none" selected>Hand over to</option>
                                                                    @foreach ($coworkers as $cw)
                                                                        @if ($cw->id != auth()->user()->employee_id)
                                                                            <option>{{$cw->fname.' '.$cw->sname}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            </div> 

                                                            <p class="small_p">&nbsp;</p>
                                                            <p class="small_p">Leave notes here</p>
                                                            <textarea class="mytextarea" name="leave_notes" id="" cols="30" rows="3">{{$lv->leave_notes}}</textarea>
                                                            
                                                            <div class="form-group modal_footer">
                                                                {{-- <button type="submit" name="update_action" value="any_value">jkljkl</button> --}}
                                                                <button type="submit" name="update_action" value="staff_update_leave" class="load_btn" onclick="return confirm('Are you sure you want to continue with leave update..?')">&nbsp;<i class="fa fa-share-square-o"></i>&nbsp; Apply &nbsp;</button>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            function datecount{{$lv->id}}() {
                                                                // alert('Both are set..!')
                                                                // var startdate = document.getElementById('lfrom{{$lv->id}}').value;
                                                                // var enddate = document.getElementById('lto{{$lv->id}}').value;

                                                                // if (startdate && enddate) {
                                                                //     if (Date.parse(startdate) < Date.parse(enddate)) {
                                                                //         // Give days in milliseconds
                                                                //         var ndays = Math.floor((Date.parse(enddate) - Date.parse(startdate)) / 86400000);
                                                                //         document.getElementById('days{{$lv->id}}').value = ndays;
                                                                //         // Converts milliseconds to days, month etc...!
                                                                //         // function dateDiff( str1, str2 ) {
                                                                //         // var diff = Date.parse( str2 ) - Date.parse( str1 ); 
                                                                //         //     return isNaN( diff ) ? NaN : {
                                                                //                 // diff : diff,
                                                                //                 // ms : Math.floor( diff            % 1000 ),
                                                                //                 // s  : Math.floor( diff /     1000 %   60 ),
                                                                //                 // m  : Math.floor( diff /    60000 %   60 ),
                                                                //                 // h  : Math.floor( diff /  3600000 %   24 ),
                                                                //                 // d  : Math.floor( diff / 86400000        )
                                                                //             // };
                                                                //         // }
                                                                //     } else {
                                                                //         alert("Oops...! 'Start Date' cannot be ahead of 'End Date'");
                                                                //     }
                                                                // }
                                                            }
                                                        </script>
                                                            
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="small_p gray">No records found</p> 
                    @endif
                </div>
            </div>

        </div>

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
                            
                            <div class="filter_div" id="orderby">
                                <i class="fa fa-clipboard"></i>&nbsp;&nbsp; Type
                                <select name="leave_type" id="leave_type" onchange="others_check()">
                                    <option value="maternity">Maternity</option>
                                    <option value="casual" selected>Casual</option>
                                    <option value="annual">Annual</option>
                                    <option value="study">Study</option>
                                    <option value="sick">Sick</option>
                                    <option value="others">Others</option>
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
                                    @foreach ($coworkers as $cw)
                                        @if ($cw->id != auth()->user()->employee_id)
                                            <option>{{$cw->fname.' '.$cw->sname}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div> 
                    
                            <div class="filter_div">
                                <i class="fa fa-upload"></i> &nbsp; Scan&nbsp;Copy
                                <input type="file" name="file_scan" placeholder="Upload Scan Copy" required>
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

 