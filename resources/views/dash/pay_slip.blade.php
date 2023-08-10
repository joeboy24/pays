
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
        width: 90%;
        margin: 0 auto;
        text-align: center;
        padding: 30px 10px;
        }

        .invHeaderTop h1 {
        text-transform: uppercase;
        font-size: 1.7em;
        /* color: rgb(255, 0, 76); */
        margin-bottom: 0;
        padding-bottom: 0;
        font-weight: 400;
        letter-spacing: 1px;
        }

        .invHeaderTop h4 {
        font-size: 1.1em;
        color: #1e262e;
        font-weight: 500;
        margin: 10px 0;
        letter-spacing: 2px;
        }

        .invHeaderTop img {
            width: 100px;
            margin: 0 -20px -35px 0;
            /* background: #f1b0b7;
            display: none; */
        }

        .logo2 {
            /* width: 70px!important; */
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
            line-height: 10px;
            padding: 0;
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
        .color9 { color: rgb(92, 92, 92)!important; }
        .color10 { color: rgb(21, 21, 21)!important; }

 
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
            margin: 5px 0 0 0;
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

        .header1 {
            width: 90%;
            min-height: 200px;
            margin: 0 auto;
            border-bottom: 1px solid #eee;
        }

        .header2 {
            width: 90%;
            margin: 0 auto;
        }

        .bio {
            width: 60%;
            float: left;
        }

        .qq {
            width: 40%;
            float: right;
            /* background: #4486e9 */
        }

        .qq img {
            width: 50%;
            float: right;
        }

        .qq p {
        }

        .slip_tbl1 {
            text-transform: uppercase
        }

        .slip_tbl1 tr {
            line-height: 20px;
            font-weight: 300;
            font-size: 0.9em;
        }
        
        .td_heading {
            color: rgb(75, 75, 75);
        }

        .td_data {
            padding: 0 0 0 25px;
            color: rgb(122, 122, 122);
        }

        .my_focus td{
            text-transform: uppercase;
            color: #1e262e;
            font-weight: 700;
            font-size: 1em;
        }

        .ext {
            margin-top: -1px!important;
        }

        .TsCont {
            width: 100%;
            /* display: table; */
            /* background: #4486e9; */
        }

        .T_img {
            width: 100%;
        }
        
        .T1, .T3 {
            width: 15%;
            float: left;
            /* display: table-cell; */
            /* background: #721c24; */
        }

        .T2 {
            float: left;
            text-transform: uppercase;
            width: calc(70% - 20px);
            padding: 0 10px 10px 10px;
            text-align: center;
            font-size: 2.5vw;
            /* background: #f1b0b7; */
        }

        .Tfr { width: 90%; float: right; margin: 5%; }
        .Tfl { width: 90%;  float: left; margin: 5%; }

        .long_title {
            display: block;
        }

        .short_title {
            display: none;
        }



        @media (max-width: 1200px) {

            .long_title {
                display: none;
            }

            .short_title {
                display: block;
            }

        }




        @media print {
            #invoice {
                width: 100%;
                /* display: block !important;  */
            }

            .invHeaderTop {
                width: 100%;
            }

            .invoiceContent {
                width: calc(100% - 100px);
                padding: 30px 50px;
                margin: 0;
                background: #fff;
            }

            .header1, .header2 {
                width: 100%;
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
                    <div class="long_title">
                        <h1><img src="/maindir/images/masloc.png" alt=""> &nbsp; {{session('company')->name}} <img class="logo2" src="/maindir/images/coat2.png" alt=""></h1>
                    </div>
                    <div class="short_title">
                        <h1><img src="/maindir/images/masloc.png" alt=""> &nbsp; MicroFinance And Small <img class="logo2" src="/maindir/images/coat2.png" alt=""></h1>
                        <h1 class="ext">Loans Centre</h1>
                    </div>
                    <P class="locInfo">&nbsp;&nbsp;{{session('company')->comp_add}}&nbsp;&nbsp;</P>
                    {{-- <P class="locInfo">&nbsp;&nbsp;{{session('company')->comp_add}}&nbsp;&nbsp;</P> --}}
                    <P class="contactInfo">Pay Slip - {{session('month')}}</P>
                    {{-- <h4>___________</h4> --}}
                </div>

                <div class="header1">
                    <div class="bio">
                        <table class="slip_tbl1">
                            <tbody>
                                <tr>
                                    <td class="td_heading">Date:</td>
                                    <td class="td_data">{{date('d-m-Y')}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">Employee&nbsp;Name:</td>
                                    <td class="td_data">{{$payslip->employee->fname.' '.$payslip->employee->sname.' '.$payslip->employee->oname}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">AFIS NO:</td>
                                    <td class="td_data">{{$payslip->employee->afis_no}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">Region:</td>
                                    <td class="td_data">{{$employee->region}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">Department:</td>
                                    <td class="td_data">{{$payslip->employee->dept}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">Position:</td>
                                    <td class="td_data">{{$payslip->employee->cur_pos}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">Bank:</td>
                                    <td class="td_data">{{$payslip->employee->bank}}</td>
                                </tr>
                                <tr>
                                    <td class="td_heading">Account No.:</td>
                                    <td class="td_data">{{$payslip->employee->acc_no}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="qq">
                        <img src="/maindir/images/qq1.png" alt="">
                        {{-- <p>7345129</p> --}}
                    </div>
                </div>
                <p>&nbsp;</p>

                <div class="header2">
                    {{-- <table class="slip_tbl1"></table> --}}
                    <table class="invBottomTbl">

                        <thead>
                            {{-- <th class="col-sm-6 pl no_count">#</th> --}}
                            <th class="pl"></th>
                            <th class="pl">&nbsp;</th>
                            <th class="pl">DEDUCTION (GH₵)</th>
                            <th class="pr">PAYMENT (GH₵)</th>
                        </thead>
                        <tbody>
                            <tr class="my_focus">
                                <td class="col-sm-5 pl">Basic Salary</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format($payslip->salary, 2)}}</td>
                            </tr>
                            <tr class="my_focus">
                                <td class="col-sm-5 pl">Less 5.5% SSF Deduction</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">{{number_format($payslip->ssf, 2)}}</td>
                                <td class="col-sm-2 pr">&nbsp;</td>
                            </tr>
                            <td>&nbsp;</td><td></td><td></td><td></td>
                            <tr class="my_focus">
                                <td class="col-sm-5 pl">OTHER ALLOWANCES:</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl"></td>
                                <td class="col-sm-2 pr"></td>
                            </tr>
                            @if ($payslip->rent != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Rent Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->rent, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->prof != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Professional Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->prof, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->resp != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Responsibility Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->resp, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->risk != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Risk Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->risk, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->vma != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Vehicle Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->vma, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->ent != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Entertainment Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->ent, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->dom != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Domestic Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->dom, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->intr != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Internet & Other Utility</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->intr, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->tnt != 0)
                                <tr>
                                    <td class="col-sm-5 pl">T & T Allowance</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->tnt, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->cola != 0)
                                <tr>
                                    <td class="col-sm-5 pl">COLA</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->cola, 2)}}</td>
                                </tr>
                            @endif
                            @if ($payslip->back_pay != 0)
                                <tr>
                                    <td class="col-sm-5 pl">Back Pay</td>
                                    <td class="col-sm-3 pl">&nbsp;</td>
                                    <td class="col-sm-2 pl">&nbsp;</td>
                                    <td class="col-sm-2 pr">{{number_format($payslip->back_pay, 2)}}</td>
                                </tr>
                            @endif
                            <tr class="my_focus">
                                <td class="col-sm-5 pl">LESS OTHER DEDUCTIONS:</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl"></td>
                                <td class="col-sm-2 pr"></td>
                            </tr>
                            <tr>
                                <td class="col-sm-5 pl">Income Tax (PAYE)</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">{{number_format($payslip->income_tax, 2)}}</td>
                                <td class="col-sm-2 pr">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="col-sm-5 pl">Staff Loan</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">{{number_format($payslip->staff_loan, 2)}}</td>
                                <td class="col-sm-2 pr">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="col-sm-5 pl">Salary Advance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">-</td>
                                <td class="col-sm-2 pr">-</td>
                            </tr>
                            <tr class="my_focus">
                                <td class="col-sm-5 pl">Total Deduction</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(($payslip->income_tax + $payslip->staff_loan + $payslip->ssf), 2)}}</td>
                            </tr>
                            <tr class="my_focus">
                                <td class="col-sm-5 pl">Net Pay</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format($payslip->net_aft_ded, 2)}}</td>
                            </tr>
                            <tr class="">
                                <td class="col-sm-5 pl">EMPLOYER SSF CONTRIBUTION(13%)</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format($payslip->ssf_emp_cont, 2)}}</td>
                            </tr>
                        </tbody>

                    </table>
                </div>
    
                <div style="height: 100px">
                </div>
    
            </div> 
        </section>
    
    </body>
    
    </html>