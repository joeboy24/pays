
@extends('layouts.validate')

@section('content')


    <div class="page-heading">
        <h3>&nbsp;&nbsp;<i class="fa fa-address-book color6"></i>&nbsp;&nbsp;Validate Employees</h3>

        <div class="row validate_cont">
            <div class="col-md-6 validate_hleft">
                <form>
                    @csrf
                    <a href="/"><button type="button" class="my_trash2 color8 blue_bg genhover"><i class="fa fa-chevron-left"></i>&nbsp; Dashboard</button></a>
                    <a href="/validation"><button type="button" class="my_trash2 black_bg color8 genhover"><i class="fa fa-refresh"></i></button></a>
                </form>
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
            <div class="card">
                <div class="card-body">

                    <!-- Employee View -->
                    <div class="table-responsive">
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
                                                    <textarea class="valid_comments" name="comments" cols="30" rows="2">{{ $emp->valid_comment }}</textarea>
                                                </td>

                                                <td class="text-bold-500 align_right action_size">
                                                    @if ($emp->del == 'yes')
                                                        <button type="submit" name="update_action" value="restore_employee" class="my_trash2 color8 black_bg genhover" onclick="return confirm('Do you want to restore this record?')"><i class="fa fa-reply"></i></button>
                                                    @else
                                                        @if ($emp->status == 'inactive')
                                                            <a href="#"><button type="button" class="my_trash2 bg7 color9"><i class="fa fa-warning"></i>&nbsp; Inactive</button></a>
                                                        @else
                                                            <a href="#"><button type="button" class="my_trash2 green_bg color8"><i class="fa fa-check"></i>&nbsp; Active</button></a>
                                                        @endif
                                                        {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#edit{{$emp->id}}" class="my_trash_small"><i class="fa fa-pencil"></i></button> --}}
                                                        <button type="submit" name="update_action" value="change_status_del" class="my_trash2 color8 black_bg genhover" onclick="return confirm('This action will hold payment for current and subsequent months, Are you sure you want to proceed?')"><i class="fa fa-trash"></i></button>
                                                    @endif
                                                </td>
                                            </form>

                                        </tr>


                                    @endforeach
                                </tbody>
                            </table>
                            {{ $employees->appends(['search_emp' => request()->query('search_emp')])->links() }}
                            
                        @else
                            <div class="alert alert-danger">
                                No Records Found on Employees
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="search_div">
        <form action="">
            <input id="search_fd" type="text" class="search_field" placeholder="Search...">
            <button type="button" onclick="showsearch()"><i class="fa fa-search"></i></button>
        </form>
        <script>
            function showsearch() {
                if (document.getElementById('search_fd').style.opacity != 1) {
                    document.getElementById('search_fd').style.opacity = 1;
                    // document.getElementById('search_fd').style.display = "none";
                } else {
                    document.getElementById('search_fd').style.opacity = 0;
                }
            }
        </script>
    </div>
        

@endsection

 