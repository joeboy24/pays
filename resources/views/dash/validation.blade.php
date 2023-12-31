
@extends('layouts.validate_lay')

@section('content')


    <div class="page-heading">
        <h3>&nbsp;&nbsp;<i class="fa fa-address-book color6"></i>&nbsp;&nbsp;Validate Employees</h3>

        <div class="row validate_cont">
            <div class="col-md-6 validate_hleft">
                <a href="/"><button type="button" class="my_trash2 color8 blue_bg genhover"><i class="fa fa-chevron-left"></i>&nbsp; Dashboard</button></a>
                <a href="/validation"><button title="Refresh" type="button" class="my_trash2 black_bg color8 genhover"><i class="fa fa-refresh"></i></button></a>
                
                <p class="vname">{{auth()->user()->employee->sname.' '.auth()->user()->employee->fname}}</p>
                <p class="small_p">{{auth()->user()->employee->cur_pos}}</p>
            </div>
            <div class="col-md-6 validate_hright">
                <form action="{{ url('/validation') }}">
                    @csrf
                    <input type="hidden" name="check" value="employee">
                    <input type="text" name="search_emp" class="search_emp" placeholder="Search">
                    <button class="search_btn" name="store_action" value="search_emp"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </div>
 
    </div>

    <div class="row">
        <div class="col-12 col-xl-12">
            @include('inc.messages') 

            <!-- Checked List View -->
            @if (count($validation) > 0)
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <h6><i class="fa fa-th-large"></i> &nbsp; Checked List View | @if ($mth == 'All') All @else {{date('M, Y', strtotime($mth))}} @endif</h6>
                            <form action="{{ url('/validation') }}">
                                @csrf
                                <select name="change_view" class="print_report">
                                    <option value="{{date('01-m-Y')}}" selected>Select Month</option>
                                    @for ($i = 1; $i <= date('m'); $i++)
                                        @if ($i < 10)
                                            {{$i='0'.$i}}
                                        @endif
                                        <option value="{{date('01-'.$i.'-Y')}}">{{date('M, Y', strtotime(date('01-'.$i.'-Y')))}}</option>
                                    @endfor
                                    <option value="all">All</option>
                                </select>
                                <button type="submit" class="gen_btn bg9 genhover color5">&nbsp;<i class="fa fa-filter color5"></i>&nbsp;Load</button>
                            </form>

                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Comments/Date</th>
                                        <th class="align_right">Status/Actions</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($validation as $val)
                                        {{-- @if ($val->del == 'yes')
                                            <tr class="del_danger">
                                        @else
                                            @if ($c % 2 == 1)
                                                <tr class="bg9">
                                            @else
                                                <tr>
                                            @endif
                                        @endif --}}
                                        <tr class="del_danger2">
                                            <td class="text-bold-500">{{$c++}}</td>
                                            <td class="text-bold-500"><a href="/employee/{{$val->employee->id}}" class="color10">{{ $val->employee->fname.' '.$val->employee->sname.' '.$val->employee->oname }}</a>
                                                <p class="small_p">SSN: {{ $val->employee->ssn }}</p>
                                                {{-- <p class="small_p_black">Phone: {{ $val->employee->contact }}</p> --}}
                                            </td>
                                            <td class="text-bold-500">{{ $val->employee->cur_pos }}
                                                <p class="small_p">Dept.: {{ $val->employee->dept }}</p>
                                            </td>

                                            <form action="{{ action('EmployeeController@update', $val->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_method" value="PUT">
                                                @csrf

                                                <td class="text-bold-500">{{ $val->comments }}
                                                    <p class="small_p">{{ date('F, Y', strtotime($val->created_at)) }}</p>
                                                </td>

                                                <td class="text-bold-500 align_right action_size">
                                                    @if ($val->status == 'Pending')
                                                        <a><button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Pending</button></a>
                                                        <button type="submit" name="update_action" value="restore_validation" class="my_trash2 color8 black_bg genhover" onclick="return confirm('Do you want to remove this record from withheld list?')"><i class="fa fa-reply"></i></button>
                                                    @elseif ($val->status == 'Pay')
                                                        <a><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Pay</button></a>
                                                    @else
                                                        <a><button type="button" class="my_trash2 bg6 color8"><i class="fa fa-times"></i>&nbsp; Withheld</button></a>
                                                    @endif
                                                    {{-- @if ($emp->del == 'yes')
                                                        <button type="submit" name="update_action" value="restore_employee" class="my_trash2 color8 black_bg genhover" onclick="return confirm('Do you want to remove this record from withheld list?')"><i class="fa fa-reply"></i></button>
                                                    @else
                                                        @if ($emp->status == 'inactive')
                                                            <a href="#"><button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Inactive</button></a>
                                                        @else
                                                            <a href="#"><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Active</button></a>
                                                        @endif
                                                        <button type="submit" name="update_action" value="change_val_status" class="my_trash2 color8 black_bg genhover" onclick="return confirm('This action will hold payment for current and subsequent months, Are you sure you want to proceed?')"><i class="fa fa-trash"></i></button>
                                                    @endif --}}
                                                </td>
                                            </form>

                                        </tr>
                                    @endforeach
                                    <input type="hidden" value="{{$c = 1}}">
                                </tbody>
                                    {{ $validation->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    No Records Found on Checked List
                </div>
            @endif

            <!-- General List View -->
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <h6><i class="fa fa-th"></i> &nbsp; General List View</h6>
                        @if (count($employees) > 0)
                            <table class="table mb-0 table-lg">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fullname</th>
                                        <th>Position</th>
                                        <th>Comments</th>
                                        <th class="align_right">Status/Actions</th>
                                    </tr>
                                </thead>   
                                <tbody>
                                    @foreach ($employees as $emp)
                                        {{-- @foreach ($val_check as $vc)
                                            @if ($emp->id != $vc->employee_id)
                                                
                                            @endif
                                        @endforeach --}}

                                        @if ($val_check->contains('employee_id', $emp->id) == false and $emp->region_id == auth()->user()->employee->region_id)
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
                                                </td>

                                                <form action="{{ action('EmployeeController@update', $emp->id) }}" method="POST">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_method" value="PUT">
                                                    @csrf

                                                    <td class="text-bold-500">
                                                        <textarea class="valid_comments" name="comments" cols="30" rows="2" required>{{ $emp->valid_comment }}</textarea>
                                                    </td>

                                                    <td class="text-bold-500 align_right action_size">
                                                        {{-- @if ($emp->del == 'yes')
                                                            <button type="submit" name="update_action" value="restore_employee" class="my_trash2 color8 black_bg genhover" onclick="return confirm('Do you want to restore this record?')"><i class="fa fa-reply"></i></button>
                                                        @else --}}
                                                            @if ($emp->status == 'inactive')
                                                                <a><button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Inactive</button></a>
                                                            @else
                                                                <a><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Active</button></a>
                                                            @endif
                                                            <button type="submit" name="update_action" value="change_val_status" class="my_trash2 color8 black_bg genhover" onclick="return confirm('This action will hold payment for current and subsequent months, Are you sure you want to proceed?')"><i class="fa fa-trash"></i></button>
                                                        {{-- @endif --}}
                                                    </td>
                                                </form>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            @if ($c > 20)
                                {{ $employees->appends(['search_emp' => request()->query('search_emp')])->links() }}
                            @endif
                            
                        @else
                            <div class="alert alert-danger">
                                No Records Found
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection

 