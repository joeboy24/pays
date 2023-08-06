<html>
<head>
    <title>PivoApps Mail Test 02</title>
</head>

<style>

    /* Invoice Section */


    /* @import url('http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,700,100');
    @import url('http://fonts.googleapis.com/css?family=Open+Sans:400,800,300,600,700');
    @import url('http://fonts.googleapis.com/css?family=Abel'); */

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
    }

    .contactInfo {
    margin: -10px 0 0 0;
    color: #1e262e;
    font-weight: 500;
    font-size: 0.8em;
    text-transform: uppercase;
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
        background-image: url(https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/Coat_of_arms_of_Ghana.svg/250px-Coat_of_arms_of_Ghana.svg.png);
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
                {{-- <div class="long_title">
                    <h1><img src="data:image/png;base64,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" alt=""> &nbsp; 
                        MicroFinance And Small Loans Centre <img class="logo2" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/Coat_of_arms_of_Ghana.svg/250px-Coat_of_arms_of_Ghana.svg.png" alt=""></h1>
                </div>
                <div class="short_title">
                    <h1><img src="data:image/png;base64,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" alt=""> &nbsp; 
                        MicroFinance And Small <img class="logo2" src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/Coat_of_arms_of_Ghana.svg/250px-Coat_of_arms_of_Ghana.svg.png" alt="">
                    </h1>
                    <h1 class="ext">Loans Centre</h1>
                </div> --}}
                <h1 class="ext">MicroFinance And Small Loans Centre</h1>
                <P class="locInfo">MASLOC, Office of the President</P>
                <P class="locInfo">Box AH811, Accra - Ghana</P>
                <P class="contactInfo">Pay Slip - {{session('month')}}</P>
            </div>

            {{-- <div class="header1">
                <div class="bio">
                    <table class="slip_tbl1">
                        <tbody>
                            <tr>
                                <td class="td_heading pl">Date:</td>
                                <td class="td_data">{{date('d-m-Y')}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">Employee&nbsp;Name:</td>
                                <td class="td_data">{{session('payslip')->employee->fname.' '.session('payslip')->employee->sname.' '.session('payslip')->employee->oname}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">AFIS NO:</td>
                                <td class="td_data">{{session('payslip')->employee->afis_no}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">Region:</td>
                                <td class="td_data">{{session('employee')->region}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">Department:</td>
                                <td class="td_data">{{session('payslip')->employee->dept}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">Position:</td>
                                <td class="td_data">{{session('payslip')->employee->cur_pos}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">Bank:</td>
                                <td class="td_data">{{session('payslip')->employee->bank}}</td>
                            </tr>
                            <tr>
                                <td class="td_heading pl">Account No.:</td>
                                <td class="td_data">{{session('payslip')->employee->acc_no}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="qq">
                    <img src="/maindir/images/qq1.png" alt="">
                </div>
            </div> --}}
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
                            <td class="col-sm-2 pr">{{number_format(session('payslip')->salary, 2)}}</td>
                        </tr>
                        <tr class="my_focus">
                            <td class="col-sm-5 pl">Less 5.5% SSF Deduction</td>
                            <td class="col-sm-3 pl">&nbsp;</td>
                            <td class="col-sm-2 pl">{{ number_format(session('payslip')->ssf, 2)}}</td>
                            <td class="col-sm-2 pr">&nbsp;</td>
                        </tr>
                        <td>&nbsp;</td><td></td><td></td><td></td>
                        <tr class="my_focus">
                            <td class="col-sm-5 pl">OTHER ALLOWANCES:</td>
                            <td class="col-sm-3 pl">&nbsp;</td>
                            <td class="col-sm-2 pl"></td>
                            <td class="col-sm-2 pr"></td>
                        </tr>
                        @if (session('payslip')->rent != 0)
                            <tr>
                                <td class="col-sm-5 pl">Rent Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->rent, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->prof != 0)
                            <tr>
                                <td class="col-sm-5 pl">Professional Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->prof, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->resp != 0)
                            <tr>
                                <td class="col-sm-5 pl">Responsibility Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->resp, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->risk != 0)
                            <tr>
                                <td class="col-sm-5 pl">Risk Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->risk, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->vma != 0)
                            <tr>
                                <td class="col-sm-5 pl">Vehicle Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->vma, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->ent != 0)
                            <tr>
                                <td class="col-sm-5 pl">Entertainment Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->ent, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->dom != 0)
                            <tr>
                                <td class="col-sm-5 pl">Domestic Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->dom, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->intr != 0)
                            <tr>
                                <td class="col-sm-5 pl">Internet & Other Utility</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->intr, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->tnt != 0)
                            <tr>
                                <td class="col-sm-5 pl">T & T Allowance</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->tnt, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->cola != 0)
                            <tr>
                                <td class="col-sm-5 pl">COLA</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->cola, 2)}}</td>
                            </tr>
                        @endif
                        @if (session('payslip')->back_pay != 0)
                            <tr>
                                <td class="col-sm-5 pl">Back Pay</td>
                                <td class="col-sm-3 pl">&nbsp;</td>
                                <td class="col-sm-2 pl">&nbsp;</td>
                                <td class="col-sm-2 pr">{{number_format(session('payslip')->back_pay, 2)}}</td>
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
                            <td class="col-sm-2 pl">{{number_format(session('payslip')->income_tax, 2)}}</td>
                            <td class="col-sm-2 pr">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="col-sm-5 pl">Staff Loan</td>
                            <td class="col-sm-3 pl">&nbsp;</td>
                            <td class="col-sm-2 pl">{{number_format(session('payslip')->staff_loan, 2)}}</td>
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
                            <td class="col-sm-2 pr">{{number_format((session('payslip')->income_tax + session('payslip')->staff_loan + session('payslip')->ssf), 2)}}</td>
                        </tr>
                        <tr class="my_focus">
                            <td class="col-sm-5 pl">Net Pay</td>
                            <td class="col-sm-3 pl">&nbsp;</td>
                            <td class="col-sm-2 pl">&nbsp;</td>
                            <td class="col-sm-2 pr">{{number_format(session('payslip')->net_aft_ded, 2)}}</td>
                        </tr>
                        <tr class="">
                            <td class="col-sm-5 pl">EMPLOYER SSF CONTRIBUTION(13%)</td>
                            <td class="col-sm-3 pl">&nbsp;</td>
                            <td class="col-sm-2 pl">&nbsp;</td>
                            <td class="col-sm-2 pr">{{number_format(session('payslip')->ssf_emp_cont, 2)}}</td>
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