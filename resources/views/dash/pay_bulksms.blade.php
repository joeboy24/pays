
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
        <h3><i class="fa fa-envelope color2"></i>&nbsp;&nbsp;Bulk SMS</h3>

        <form action="{{ action('EmployeeController@store') }}" method="POST">
            @csrf
            @if (auth()->user()->status == 'HR')
                <a href="/view_employee"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; View Employee</p></a>
            @elseif (auth()->user()->status == 'Finance')
                <a href="/"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Home</p></a>
            @else
                <a href="/adduser"><p class="print_report">&nbsp;<i class="fa fa-chevron-left"></i>&nbsp; Back</p></a>
            @endif
            <a href="/bulksms"><button type="button" class="print_btn_small"><i class="fa fa-refresh"></i></button></a>
        </form>
    </div>

    <div class="row">
        <div class="col-md-7">
            @include('inc.messages') 
            @if (session('send01') == 1)
                <div class="alert alert-success">
                    Message successfully sent to all contacts in queue
                </div>
            @endif
            <form action="{{ action('EmployeeController@store') }}" method="POST">
                @csrf

                <div class="filter_div">
                    <i class="fa fa-question-circle-o"></i> &nbsp; Precedent
                    <select id="precedent" name="precedent" onchange="replacePrecedent()">
                        <option selected>Hi *FULLNAME* </option>
                        <option>Dear *FULLNAME* </option>
                        <option>Hello *FULLNAME* </option>
                        <option>Welcome *FULLNAME* </option>
                        <option>None</option>
                    </select>
                </div>
                <div class="filter_div">
                    <i class="fa fa-envelope-o"></i> &nbsp; Send&nbsp;To
                    <select name="sms_action">
                        @if (count($sms) != 0)
                            <option selected>Selected Contacts</option>
                            <option>All</option>
                        @else
                            <option>Selected Contacts</option>
                            <option selected>All</option>
                        @endif
                        @foreach ($department as $dept)
                            <option value="{{$dept->id}}">{{$dept->dept_name}} Department</option>
                        @endforeach
                    </select>
                </div>

                <div class="attachments_cont">
                    <button type="button" class="sms_contact_view" onclick="attach('*EMAIL*')">&nbsp;
                        <i class="fa fa-paperclip color5"></i>&nbsp; Attach Email
                    </button>
                    <button type="button" class="sms_contact_view" onclick="attach('*PASSWORD*')">&nbsp;
                        <i class="fa fa-paperclip color5"></i>&nbsp; Attach Password
                    </button>
                    <button type="button" class="sms_contact_view" onclick="attach('*CONTACT*')">&nbsp;
                        <i class="fa fa-paperclip color5"></i>&nbsp; Attach Contact
                    </button>
                </div>
                <br>
                <textarea id="txtmsg" class="sms_message" name="message" id="" cols="30" rows="4" maxlength="300" placeholder="Type Here... Avoid use of special characters like: '!@#$%^&*()_+"></textarea>
                {{-- <p class="small_p">Avoid use of special characters like: '!@#$%^&*()_+</p> --}}

                <div class="form-group modal_footer">
                    {{-- <button id="checks" type="button" class="load_btn"><i class="fa fa-send"></i>&nbsp; Check</button> --}}
                    <button type="submit" name="store_action" value="send_sms" class="load_btn"><i class="fa fa-send"></i>&nbsp; Send</button>
                    <button type="submit" name="store_action" value="clear_sms_contacts" class="load_btn_inv"
                        onclick="return confirm('This action will clear queued contacts. Click `OK` to proceed')"><i class="fa fa-refresh" ></i>&nbsp; Clear
                    </button>
                </div>
            </form>
            <p class="small_p">Selected Contacts</p>
            @foreach ($sms as $item)
                <form action="{{ action('EmployeeController@update', $item->id) }}" method="POST">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <button type="submit" name="update_action" value="remove_sms_contact" class="sms_contact_view bg8" 
                        onclick="return confirm('Are you sure you want to delete {{$item->employee->fname}}`s contact?')">
                        &nbsp;<i class="fa fa-phone color5"></i>&nbsp; {{$item->employee->fname.': '.$item->contact}}
                    </button>
                </form>
            @endforeach
        </div>

        <p>&nbsp;</p>
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-body">

                    <!-- SMS History View -->
                    <div class="table-responsive">
                        @if (count($sms_history) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Message</th>
                                        <th class="align_right action_size2">Actions</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($sms_history as $smh)
                                        @if ($smh->pin == 'yes')
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif
                                                <td class="text-bold-500"><p class="small_p">Sent By:</p>{{$smh->user->name}}</td>
                                                <td class="text-bold-500">{{$smh->message}} <p class="small_p">Status: {{$smh->status}}</p>
                                                    <p class="gray_p">&nbsp;</p><p class="gray_p">Sent To:</p>
                                                    @if (count(explode(',', $smh->sent_to)) > 7)
                                                        @for ($i = 0; $i < count(explode(',', $smh->sent_to))-1; $i++)
                                                            <button type="button" class="sms_contact_view bg8">&nbsp;<i class="fa fa-phone color5"></i>&nbsp; 
                                                                {{explode(',', $smh->sent_to)[$i]}}
                                                            </button>
                                                        @endfor
                                                        <button data-bs-toggle="modal" data-bs-target="#view_more{{$smh->id}}" type="button" class="sms_contact_view">&nbsp;View More...</button>
                                                    @else
                                                        @for ($i = 0; $i < count(explode(',', $smh->sent_to))-1; $i++)
                                                            <button type="button" class="sms_contact_view bg8">&nbsp;<i class="fa fa-phone color5"></i>&nbsp; 
                                                                {{explode(',', $smh->sent_to)[$i]}}
                                                            </button>
                                                        @endfor
                                                    @endif
                                                </td>

                                                <form action="{{ action('EmployeeController@update', $smh->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf

                                                    <td class="text-bold-500 align_right">
                                                        <button type="submit" name="update_action" value="unpin_sms" class="my_trash2 bg7 genhover" onclick="return confirm('Do you want to unpin this record?')"><i class="fa fa-thumb-tack"></i></button>
                                                        <button type="button" class="my_trash2 genhover bg3 color8" onclick="UseAsTemplate{{$smh->id}}()"><i class="fa fa-check"></i>&nbsp;Use&nbsp;Template</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @endif
                                    @endforeach

                                    @foreach ($sms_history as $smh)
                                        @if ($smh->pin == 'no')
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif
                                                <td class="text-bold-500"><p class="small_p">Sent By:</p>{{$smh->user->name}}</td>
                                                <td class="text-bold-500">{{$smh->message}} <p class="small_p">Status: {{$smh->status}}</p>
                                                    <p class="gray_p">&nbsp;</p><p class="gray_p">Sent To:</p>
                                                    @if (str_contains($smh->sent_to, ','))
                                                        @if (count(explode(',', $smh->sent_to)) > 7)
                                                            @for ($i = 0; $i < count(explode(',', $smh->sent_to))-1; $i++)
                                                                <button type="button" class="sms_contact_view bg8">&nbsp;<i class="fa fa-phone color5"></i>&nbsp; 
                                                                    {{explode(',', $smh->sent_to)[$i]}}
                                                                </button>
                                                            @endfor
                                                            <button data-bs-toggle="modal" data-bs-target="#view_more{{$smh->id}}" type="button" class="sms_contact_view">&nbsp;View More...</button>
                                                        @else
                                                            @for ($i = 0; $i < count(explode(',', $smh->sent_to))-1; $i++)
                                                                <button type="button" class="sms_contact_view bg8">&nbsp;<i class="fa fa-phone color5"></i>&nbsp; 
                                                                    {{explode(',', $smh->sent_to)[$i]}}
                                                                </button>
                                                            @endfor
                                                        @endif
                                                    @else
                                                        {{$smh->sent_to}}
                                                    @endif
                                                </td>

                                                <form action="{{ action('EmployeeController@update', $smh->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf

                                                    <td class="text-bold-500 align_right">
                                                        <button type="submit" name="update_action" value="pin_sms" class="my_trash2 genhover" onclick="return confirm('Do you want to pin this record?')"><i class="fa fa-thumb-tack"></i></button>
                                                        <button type="button" class="my_trash2 genhover bg3 color8" onclick="UseAsTemplate{{$smh->id}}()"><i class="fa fa-check"></i>&nbsp;Use&nbsp;Template</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @endif
                                        <script>
                                            function UseAsTemplate{{$smh->id}}() {
                                                precedent = document.getElementById('precedent').value;
                                                // if (precedent == 'None') {
                                                    sessionStorage.setItem('msg_template', '{{$smh->message}}');
                                                    document.getElementById('txtmsg').value = '{{$smh->message}}';
                                                // } else {
                                                //     sessionStorage.setItem('msg_template', ', {{$smh->message}}');
                                                //     document.getElementById('txtmsg').value = precedent + ', {{$smh->message}}';
                                                // }
                                            }
                                        </script>

                                        <!-- View More Modal -->
                                        <div class="modal fade" id="view_more{{$smh->id}}" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalCenterTitle">
                                                            All Receipients
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>
                                                    <form action="{{ action('EmployeeController@store') }}" method="POST">
                                                        @csrf
                                                        <div class="modal-body">

                                                            @for ($i = 0; $i < count(explode(',', $smh->sent_to))-1; $i++)
                                                                <button type="button" class="sms_contact_view bg8">&nbsp;<i class="fa fa-phone color5"></i>&nbsp; 
                                                                    {{explode(',', $smh->sent_to)[$i]}}
                                                                </button>
                                                            @endfor
                                                            
                                                        </div> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>
                            </table>
                            
                        @else
                            <div class="alert alert-danger">
                                No SMS History Found
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>

        <script>
            // txt = " Hi :/ ";
            // txt = txt.replace(/:\//g,"<img src='img/smiley.gif'>");
            // alert(txt)

            function attach(shat) {
                
                txtarea = document.getElementById('txtmsg').value;
                const result = txtarea.split('*').join('xx');
                // document.getElementById('txtmsg').value = result;
                document.getElementById('txtmsg').value = txtarea + ' ' + shat + ' ';
                // txtarea = txtarea.replaceAll('*', '--');
                // txtarea = txtarea.replaceAll('FULLNAME', 'JAY');
                // alert(txtarea);


                // alert(shat);
            }

            // Set msg_template to '' on load || on page refresh
            sessionStorage.setItem('msg_template', '');

            function replacePrecedent() {
                // alert('Yh');
                precedent = document.getElementById('precedent').value;
                txtmsg = sessionStorage.getItem('msg_template');
                txtarea = document.getElementById('txtmsg').value
                // document.getElementById('txtmsg').value = precedent + ' ' + txtmsg;
                if (precedent == 'None') {
                    document.getElementById('txtmsg').value = txtmsg;
                } else {
                    // alert(txtarea);
                    txtarea = txtarea.replaceAll('Hi *FULLNAME*', precedent);
                    txtarea = txtarea.replaceAll('Dear *FULLNAME*', precedent);
                    txtarea = txtarea.replaceAll('Hello *FULLNAME*', precedent);
                    txtarea = txtarea.replaceAll('Welcome *FULLNAME*', precedent);
                    document.getElementById('txtmsg').value = txtarea;
                    // document.getElementById('txtmsg').value = precedent + ' ' + txtmsg;
                }
            }
            // function checRuns() {
            //     var text = document.getElementById("text-goodbye").value;
            //     setTextarea(text);
            // }

            // function setTextarea(text) {
            //     document.getElementById("myTextarea").value = text;
            // }

            // document.queryselector("#checks")
            //     .addEventListener("click", function() {    
            //     alert("User has clicked on the button!");
            // });
        </script>
        
        @if (session('send01') == 1)
            @foreach (session('smss') as $item)
            <script language="JavaScript" type="text/JavaScript" >
                function send_with_ajax( the_url ){
                    var httpRequest = new XMLHttpRequest();
                    httpRequest.onreadystatechange = function() { alertContents(httpRequest); };  
                    httpRequest.open("GET", the_url, true);
                    httpRequest.send(null);
                }
            </script>

            <script language="javascript" type="text/javascript">   
                // alert ('sent')
                msg = '{{$msg}}';
                contact = '{{$item->contact}}';
                cname = '{{$item->employee->fullname}}';
                email = '{{$item->user->email}}';
                pass = '{{$item->user->entry_code}}';
                contact = '{{$item->user->contact}}';
                cmsg = msg.replaceAll('*FULLNAME*', cname);
                cmsg = cmsg.replaceAll('*EMAIL*', email);
                cmsg = cmsg.replaceAll('*PASSWORD*', pass);
                cmsg = cmsg.replaceAll('*CONTACT*', contact);
                cmsg = escape(cmsg);
                // const final_txt = msg.split('*').join('xx');
                // cmsg = msg.replace(/xxFULLNAMExx/g, cname);
                // alert(pass+' - '+contact+' - '+cmsg);
                send_with_ajax("https://apps.mnotify.net/smsapi?key=EDjbRLUSSIfwfGV9gar4kmi8n&to="+contact+"&msg="+cmsg+"&sender_id=MASLOCGH");
            </script>
            @endforeach
        @endif
    </div>

@endsection


@section('scripts')
    <script>
        ClassicEditor
            .create( document.querySelector( '#none_yet' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection

 