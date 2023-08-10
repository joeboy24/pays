
<html>

    <head>
        <meta charset="utf-8">
    
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    
        <title>{{ config('app.name', 'GSFP') }}</title>
    
        {{-- <link href="/maindir/css/inv_style.css" rel="stylesheet"> --}}
        <link href="/maindir/css/responsive.css" rel="stylesheet">
        {{-- <link href="/maindir/css/bootstrap2.min.css" rel="stylesheet">
        <link href="/maindir/css/font-awesome.min.css" rel="stylesheet"> --}}
        <link rel="stylesheet" href="/maindir/css/bootstrap.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,600,700" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    </head>

    <style>

        /* Invoice Section */


        @import url(http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,700,100);
        @import url(http://fonts.googleapis.com/css?family=Open+Sans:400,800,300,600,700);
        @import url(http://fonts.googleapis.com/css?family=Abel);

        body {
        font-family: 'Roboto', sans-serif;
        background: none;
        position: relative;
        font-weight:400px;
        width: 100%;
        margin: 0;
        background: #1e262e;
        }

        #invoice {
        width: 80%;
        margin: 0 auto;
        background: #1e262e;
        }

        .invoiceContent {
        width: calc(100% - 100px);
        padding: 30px 50px;
        margin: 70px 0;
        background: #fff;
        /* background-size: 100%;
        background-image: url(/maindir/images/coat3.png); */
        }

        .invHeaderTop {
        width: 500px;
        margin: 0 auto;
        text-align: center;
        padding: 30px 10px;
        }

        .invHeaderTop h1 {
        text-transform: uppercase;
        font-size: 2.7em;
        color: rgb(255, 0, 76);
        margin-bottom: 0;
        padding-bottom: 0;
        letter-spacing: -2px;
        }

        .invHeaderTop h4 {
        font-size: 1.1em;
        color: #1e262e;
        font-weight: 500;
        margin: 10px 0;
        letter-spacing: 2px;
        }

        .invHeaderTop img {
            width: 62px;
            margin: 0 -20px -15px 0;
            /* background: #f1b0b7;
            display: none; */
        }

        .logo2 {
            width: 70px!important;
            padding-top: -20px!important;
        }

        .invHeaderMid {
            width: 100%;
            min-height: 20px;
            padding: 0 10px;
            margin: 0 0 10px 0;
            /* background: #1e262e; */
        }

        /* .invHeaderMid div {
            width: 25%;
            background: #1e262e;
            margin: 10px;
        } */

        .invHeaderMid p {
            margin: 0;
            padding: 3px 0;
            font-size: 0.9em;
            font-weight: 300;
        }

        .invHeaderMid p span {
            color: rgb(160, 160, 160);
        }

        .mid_left {
            width: calc(100% - 40px);
            float: left;
            /* margin-right: 2%; */
            padding: 10px 20px;
            border: 0.5px solid #ccc;
            border-radius: 7px;
            /* background: #1e262e; */
        }

        .mid_left p {
            float: left;
        }

        .mid_right {
            width: 45%;
            float: right;
            text-align: right;
            /* margin-right: 2%; */
            padding: 10px 20px;
            /* background: #1e262e; */
        }

        .locInfo {
            font-size: 0.9em;
            font-weight: 300;
            color: #363432;
            clear: both;
            text-align: center;
        }

        .contactInfo {
        margin: -10px 0 0 0;
        color: #1e262e;
        font-weight: 500;
        font-size: 0.8em;
        }

        .invCenter {
        width: 100%;
        margin: 0;
        padding: 10px;
        border: 2px solid #1e262e;
        }

        .invBottom {
        width: 100%;
        padding: 20px;
        }

        .invBottomTbl {
        width: 100%;
        overflow-x: auto!important;
        }

        .invBottomTbl tr {
        width: 100%;
        overflow-x: auto;
        }

        .invBottomTbl th {
        color: #1e262e;
        padding: 0 10px 5px 10px;
        border-bottom: 1px solid #eee;
        }

        .invBottomTbl td {
        margin: 0;
        color: #666663;
        font-size: 0.8em;
        font-weight: 400;
        /* line-height: 15px; */
        border-bottom: 1px solid #eee;
        padding: 5px 10px 10px 10px;
        }

        .invBottomTbl h4 {
        margin: 0 0 -7px 0;
        padding: 0;
        color: #1e262e;
        font-size: 1.2em;
        font-weight: 500;
        }

        .plwide {
            width: 500px!important;
        }

        .chrg_col {
            line-height: -15px;
            /* font-style: italic; */
            color: #898989!important;
            /* color: #1e262e; */
        }

        .chrg_col p {
            width: 135px;
            /* line-height: -15px; */
            margin: 0;
            font-style: normal;
            border-bottom: 1px solid #eee;
        }

        .chrg_col span {
            /* line-height: -15px; */
            float: right!important;
            font-style: normal;
            color: #1e262e!important;
        }

        .total_chrg {
            padding: 5px;
            background: #ffd9dc;
        }

        .sch_double {
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .pl {
        text-align: left;
        }

        .pr {
        text-align: right;
        }

        .invTot {
        border-top: #ccc!important;
        }

        .invBottomTbl .invTot td {
        border-top: 1px solid #eee;
        }

        .no_count {
            width: 10px;
        }

        .cap1 {
            text-transform: capitalize; 
        }

        .color1 { color: rgb(255, 0, 106)!important; }
        .color2 { color: rgb(234, 0, 255)!important; }
        .color3 { color: rgb(35, 137, 255)!important; }
        .color4 { color: rgb(15, 190, 173)!important; }
        .color5 { color: rgb(111, 0, 255)!important; }
        .color6 { color: rgb(255, 0, 76)!important; }
        .color7 { color: rgb(255, 196, 0)!important; }

 
        .alert {
            font-weight: 300;
            text-transform: uppercase;
            text-align: center;
            font-size: 0.8em;
            letter-spacing: 2px;
        position: relative;
        padding: 0.75rem 1.25rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.25rem; }

        .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb; }
        .alert-danger hr {
            border-top-color: #f1b0b7; }
        .alert-danger .alert-link {
            color: #491217; }



        .invoice_overlay {
            position: absolute;
            top: 0;
            left: 10%;
            width: 80%;
            height: 100%;
            margin: 0 auto;
            background-size: 100%;
            background-image: url(/maindir/images/coat2.png);
            -webkit-print-color-adjust: exact !important;
            color-adjust: exact !important;
            opacity: 0.05;
        }

        .invoice_overlay img {
            opacity: 0.04;
            width: 70%;
            margin: 35vh 15%;
            background: none;
            /* border-radius: 50%; */
        }

        .small_p {
            margin: 7px 0 0 0;
            font-size: 0.9em;
            color: #4486e9;
        }

        .banksum p {
            text-transform: uppercase;
            text-align: center;
            margin: 0;
        }

        .banksum h4 {
            text-transform: uppercase;
            text-align: center;
            margin: 10px;
        }


        @media print {
            #invoice {
                width: 100%;
                /* display: block !important;  */
            }

            .invoiceContent {
                width: calc(100% - 100px);
                padding: 30px 50px;
                margin: 0;
                background: #fff;
            }
        }


    </style>
     
    <body style="background: #eee">

        <section id="invoice">
            <div class="invoiceContent">
                <div class="invoice_overlay">
                    <img src="/maindir/images/sgmall.png" alt="">
                </div>
    
                <div class="invHeaderTop">
                    <h1><img src="/maindir/images/masloc.png" alt=""> &nbsp;{{session('company')->abrv}}<img class="logo2" src="/maindir/images/coat2.png" alt=""></h1>
                    <P class="locInfo">{{session('company')->name}}</P>
                    <P class="locInfo">&nbsp;&nbsp;{{session('company')->comp_add}}&nbsp;&nbsp;</P>
                    <P class="contactInfo">{{session('company')->contact}}</P>
                    {{-- <h4>___________</h4> --}}
                </div>
    
                <!--div style="height: 150px">
                </div-->

                @if ($report_type == 'billing')
                
            
                    @foreach ($tarifs as $tarif)
                        <div style="height: 20px"></div>

                        <div class="invCenter">
                            <table class="invCenterTbl">
                                <tbody>
                                    <tr>
                                        <td class="col-sm-5">Issued By :</td>
                                        <td class="col-sm-3">{{'User'.date('hi').auth()->user()->id}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td class="col-sm-2">&nbsp;&nbsp;&nbsp; Total Kws. : <b>{{number_format($tarif->kcons)}}</b></td>
                                        <td class="col-sm-2">&nbsp;&nbsp;&nbsp; Total Amt. : GhC <b>{{number_format($tarif->total_chrg, 2)}}</b></td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-5">Date Printed :</td>
                                        <td class="col-sm-3">{{$cur_date}}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-5">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td class="col-sm-5">Month :</td>
                                        <td class="col-sm-3">{{$month}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            
                    @endforeach

                @else
                
                    @if ($report_type != 'employees')
                        <div class="invHeaderMid">
                            <div class="row">
                                <div class="mid_left">
                                    <p><span>From:</span>&nbsp; 
                                        @if ($from != '')
                                            {{date('d M, Y', strtotime($from))}}
                                        @else-@endif
                                        &nbsp;&nbsp;&nbsp;&nbsp;</p>
                                    <p><span>To:</span>&nbsp; 
                                        @if ($to != '')
                                            {{date('d M, Y', strtotime($to))}}
                                        @else-@endif
                                    </p>
                                </div>
                            </div>
                        </div>

                    @endif
            
                    <div style="height: 20px"></div>

                    <div class="invCenter">
                        <table class="invCenterTbl">
                            <tbody>

                                <tr>
                                    <td class="col-sm-5 cap1">{{$report_type}}<br><br></td>
                                </tr>
                                @if ($report_type == 'payment')
                                    <tr>
                                        <td class="col-sm-5">Total Bill. :<br><br></td>
                                        <td class="col-sm-3 color6">GhC {{number_format($payments->sum('bill'), 2)}}<br><br></td>
                                        <td class="col-sm-5">&nbsp;&nbsp;&nbsp;&nbsp;Total Amt. Paid : <b>GhC {{number_format($payments->sum('amt_paid'), 2)}}</b><br><br></td>
                                        {{-- <td class="col-sm-5">&nbsp;&nbsp;&nbsp;&nbsp;Tax : GhC {{number_format($tax, 2)}}<br><br></td> --}}
                                    </tr>
                                @endif
                                <tr>
                                    <td class="col-sm-5">Issued By :</td>
                                    <td class="col-sm-3">{{'User'.date('hi').auth()->user()->id}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    
                                        @if ($report_type == 'Loanpays')
                                            <td class="col-sm-2">&nbsp;&nbsp;&nbsp;&nbsp;No. of Records : <b>{{count($dpays)}} </b></td>
                                            <td class="col-sm-2">&nbsp;&nbsp;&nbsp;</td>
                                            <td class="col-sm-2">&nbsp;&nbsp;&nbsp; Total Amount Paid : GhC <b>{{number_format($dpays->sum('amt_paid'), 2)}}</b></td>
                                            {{-- <td class="col-sm-2">&nbsp;&nbsp;&nbsp; Total Amount Rem. : GhC <b>{{number_format($dpays->sum('amt_rem'), 2)}}</b></td> --}}
                                        @endif
                                </tr>
                                <tr>
                                    <td class="col-sm-5">Date Printed :</td>
                                    <td class="col-sm-3">{{$cur_date}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
        
                    <div class="invBottom">

                        @if ($report_type == 'Loanpays')

                            <!-- Employee Tbl -->
                            @if(count($dpays) > 0)
                                <table class="invBottomTbl">
                                    <thead>
                                        <th class="col-sm-6 pl no_count">#</th>
                                        <th class="pl">Fullname</th>
                                        <th class="pl">Amt. Paid(GhC)</th>
                                        <th class="pl">Amt. Rem.(GhC)</th>
                                        <th class="pl">Description</th>
                                        <th class="pr">Date Paid</th>
                                    </thead>

                                    <tbody>

                                        @foreach ($dpays as $dp) 
                                        
                                            <tr>

                                                <td class="col-sm-1 pl">{{$c++}}</td>
                                                <td class="col-sm-3 pl"><h4>{{ $dp->employee->fname.' '.$dp->employee->sname.' '.$dp->employee->oname }}</h4>
                                                    <p class="small_p">SSN: {{ $dp->employee->cur_pos }}</p>
                                                </td>
                                                <td class="col-sm-3 pl"><h4>{{ number_format($dp->amt_paid, 2) }}</h4></td>
                                                <td class="col-sm-3 pl"><h4>{{ number_format($dp->amt_rem, 2) }}</h4></td>
                                                <td class="col-sm-3 pl"><p>{{ $dp->desc }}</p></td>
                                                <td class="col-sm-1 pr cap1">{{$dp->created_at}}</td>
                                            
                                            </tr>
                                                
                                        @endforeach

                                    </tbody>

                                </table>
                            @else
                                <div class="alert alert-danger">
                                    No records to display
                                </div>
                            @endif

                        @endif
                        
                    </div>
        
                    
                @endif
    
            </div> 
        </section>
    
    </body>
    
    </html>