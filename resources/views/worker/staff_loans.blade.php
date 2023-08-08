
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

            <li class="sidebar-item active">
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
        <h3><i class="fa fa-suitcase color3"></i>&nbsp;&nbsp;Loans</h3>
        <a href="/mydashboard"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Dashboard</p></a>
        <p>&nbsp;</p>
    </div>

    <section class="menu_content1">
        <div class="row">
            @include('inc.messages') 
            
            <div class="col-md-10 pay_stubs_clone">
                <div class="pay_stub_header">
                    <i class="fa fa-suitcase color3"></i>
                    <div class="ps_txt_cont2">
                        {{-- <a class="add_leave" data-bs-toggle="modal" data-bs-target="#applyleave" class="my_trash_small">+</a> --}}
                        <h4 class="psh">Loans</h4>
                        <p class="psp gray">Payment History (Gh₵)</p>
                    </div>
                </div>
                <div id="ps_tbl3">
                    @if (count($directpay) > 0)
                        <table class="mytable mb-0 table-lg tbl_scroll">
                            <tbody>
                                <tr>
                                    <th></th>
                                    <th class="td_right">Amt.&nbsp;Paid</th>
                                    <th class="td_right">Amt.&nbsp;Rem</th>
                                    <th class="td_right">Description</th>
                                    <th class="td_right">Mth.&nbsp;Deduction</th>
                                    <th class="td_right align_right">Date</th>
                                </tr>
                                @foreach ($directpay as $dpay)
                                    <tr>
                                        {{-- @if ($lv->status == 'Pending')
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
                                        @endif --}}
                                        <td class="td_left"><p><i class="fa fa-check color4"></i></p></td>
                                        <td class="td_right">{{number_format($dpay->amt_paid, 2)}}</td>
                                        <td class="td_right"><p>{{number_format($dpay->amt_rem, 2)}}</p></td>
                                        <td class="td_right"><p>{{$dpay->desc}}</p></td>
                                        <td class="td_right"><p>{{number_format($dpay->monthly_dud, 2)}}</p></td>
                                        <td class="td_right align_right"><p>{{date('M d, Y', strtotime($dpay->created_at))}}</p></td>
                                        {{-- <td class="td_right align_right"><p>From: {{date('D, M d, Y', strtotime($dpay->start_date))}}</p><p class="color3">To: {{date('D, M d, Y', strtotime($dpay->end_date))}}</p></td> --}}
                                        
                                        {{-- <form action="{{ action('EmployeeController@update', $lv->id) }}" method="POST">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_method" value="PUT">
                                            @csrf
                                            <td class="td_right align_right">
                                                @if ($lv->status == 'Approved')
                                                    <button type="button" class="my_trash_small"><i class="fa fa-ban"></i></button>
                                                @else
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#edit_leave{{$lv->id}}" class="my_trash_small bg7"><i class="fa fa-pencil"></i></button>
                                                    <button type="submit" name="update_action" value="staff_del_leave" class="my_trash_small" onclick="return confirm('Are you sure you want to delete this record?')"><i class="fa fa-trash"></i></button>
                                                @endif
                                            </td>

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
                                                                <input type="date" id="lfrom{{$lv->id}}" name="from" onchange="datecount{{$lv->id}}()" required>
                                                            </div>

                                                            <div class="filter_div" id="others">
                                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp; To
                                                                <input type="date" id="lto{{$lv->id}}" name="to" onchange="datecount{{$lv->id}}()" required>
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
                                                                <button type="submit" name="update_action" value="staff_update_leave" class="load_btn" onclick="return confirm('Are you sure you want to continue with leave update..?')">&nbsp;<i class="fa fa-share-square-o"></i>&nbsp; Apply &nbsp;</button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </form> --}}
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="td_left"><p><i class="fa fa-check color4"></i></p></td>
                                    <td class="td_right">{{number_format($sal_sum->sum('staff_loan'), 2)}}</td>
                                    <td class="td_right"><p>{{number_format($directpay[count($directpay)-1]->amt_rem, 2)}}</p></td>
                                    <td class="td_right"><p>monthly deduction from salary</p></td>
                                    <td class="td_right"><p>{{number_format($sal_sum[count($sal_sum)-1]->staff_loan, 2)}}</p></td>
                                    <td class="td_right align_right"><p>From: {{date('D, M d, Y', strtotime($sal_sum[0]->created_at))}}</p><p class="color3">To: {{date('D, M d, Y', strtotime($sal_sum[count($sal_sum)-1]->created_at))}}</p></td>
                                </tr>
                                <tr>
                                    <td class="td_left"><p><i class="fa fa-check color4"></i></p></td>
                                    <td class="td_right"><p class="color3">Total (Gh₵)</p><h6>{{number_format($sal_sum->sum('staff_loan') + $directpay->sum('amt_paid'), 2)}}</h6></td>
                                    <td class="td_right"><p>&nbsp;</p><h6>{{number_format($directpay[count($directpay)-1]->amt_rem, 2)}}</h6></td>
                                    <td class="td_right"></td>
                                    <td class="td_right"></td>
                                    <td class="td_right align_right"></td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="small_p gray">No records found</p> 
                    @endif
                </div>
            </div>

        </div>

        <!-- Add Leave -->
        {{-- <div class="modal fade" id="applyleave" tabindex="-1" role="dialog"
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
                    <form action="{{ action('HrdashController@store') }}" method="POST">
                        @csrf

                        <div class="modal-body">
                            
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
                                    @foreach ($coworkers as $cw)
                                        @if ($cw->id != auth()->user()->employee_id)
                                            <option>{{$cw->fname.' '.$cw->sname}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div> 

                            <p class="small_p">&nbsp;</p>
                            <p class="small_p">Leave notes here</p>
                            <textarea class="mytextarea" name="leave_notes" id="" cols="30" rows="3"></textarea>
                            
                            <div class="form-group modal_footer">
                                <button type="submit" name="store_action" value="staff_add_leave" class="load_btn" onclick="return confirm('Are you sure you want to continue with leave application..?')">&nbsp;<i class="fa fa-share-square-o"></i>&nbsp; Apply &nbsp;</button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div> --}}

    </section>
        

@endsection

 