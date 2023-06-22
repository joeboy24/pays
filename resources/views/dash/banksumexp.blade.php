{{-- <table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Salary</th>
    </tr>
    </thead>
    <tbody>
    @foreach($salaries as $invoice)
        <tr>
            <td>{{ $invoice->employee->fname }}</td>
            <td>{{ $invoice->salary }}</td>
        </tr>
    @endforeach
    </tbody>
</table> --}}
<style>
    .mytable {
        font-size: 1.4em;
        font-weight: 600
    }
</style>

<div class="table-responsive">
    @if (count($salaries) > 0)
        @for ($i = 1; $i <= count($banks); $i++)
            <table class="table mb-0 table-lg mytable">

                @if ($c == 1)
                    <thead>
                        <tr><th></th></tr>
                        <tr><th></th></tr>
                        <tr><th><b>{{$banks[$i-1]->bank_fullname}}</b></th></tr>
                        <tr><th><b>PAYROLL FOR MASLOC</b></th></tr>
                        <tr><th><b>PMB CT 261, CANTONMENTS, ACCRA</b></th></tr>
                        <tr><th><b>Salary for {{date('F Y')}}</b></th></tr>
                        <tr><th></th></tr>
                    </thead> 
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><b>Employee Name</b></th>
                            <th><b>Account No.</b></th>
                            <th><b>Bank Name</b></th>
                            <th><b>Branch</b></th>
                            <th><b>Net Pay (GhC)</b></th>
                        </tr>
                    </thead>   
                @endif
                        
                <tbody>
                    <input type="hidden" value="{{$sum = 0}}">
                    @foreach ($salaries as $sal)
                        @if ($sal->employee->bank_id == $banks[$i-1]->id)
                            @if ($c % 2 == 1)
                                <tr class="bg9">
                            @else
                                <tr>
                            @endif
                                <td>&nbsp;&nbsp;{{$c++}}&nbsp;&nbsp;</td>
                                <td class="text-bold-500">{{ $sal->employee->fname.' '.$sal->employee->sname.' '.$sal->employee->oname }}</td>
                                <td class="text-bold-500">'{{$sal->employee->acc_no}}</td>
                                <td class="text-bold-500">{{$sal->employee->bank}}</td>
                                <td class="text-bold-500">{{$sal->employee->branch}}</td>
                                <td class="text-bold-500">{{number_format($sal->net_aft_ded, 6)}}</td>
                            </tr>
                            <input type="hidden" value="{{$sum = $sum + $sal->net_aft_ded}}">
                        @endif
                    @endforeach
                    <tr>
                        <td></td><td><b>{{$banks[$i-1]->bank_fullname}} Total</b></td><td></td><td></td><td></td>
                        <td class="text-bold-500"><b>{{number_format($sum, 6)}}</b></td>
                    </tr>
                    <input type="hidden" value="{{$c = 1}}">
                </tbody>

            </table>
            <p>&nbsp;</p>
        @endfor
    @else
        <div class="alert alert-danger">
            No Records Found
        </div>
    @endif
</div>