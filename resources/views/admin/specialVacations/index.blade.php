@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">تعیین سقف مرخصی بصورت خاص</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('specialVacation.store')}}">
            @csrf
            <div class="box-body">
                <div class="form-group row">
                    <div class="col-sm-2">
                        <label for="employment">انتخاب کارمند</label>
                        <select class="form-control" size="1" name="user_id" id="employment">
                            <option value="" disabled selected>انتخاب کارمند</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }} ">
                                    {{ $user->name. ' '.$user->family }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2"><label for="vacation">نوع مرخصی</label>
                        <select class="form-control" size="1" name="vacation_id"
                                id="vacation">
                            <option value="" disabled selected>نوع مرخصی</option>
                            @foreach($vacationTypes as $vacationType)
                                <option value="{{ $vacationType->id }} ">
                                    {{ $vacationType->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <label for="amount">مقدار</label>
                        <input type="" class="form-control" id="amount" placeholder="مقدار مجاز" name="amount">
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
            </div>
        </form>

        <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th class="text-danger col-sm-1 ">ردیف</th>
                    <th class="text-danger ">نام</th>
                    <th class="text-danger ">نام خانوادگی</th>
                    <th></th>
                    <th class="text-danger">مقدار مجاز تعریف شده</th>
                </tr>
                </tbody>
                <tbody id="users">
                @foreach($users as $user)
                    <tr>
                        <td>{{$index}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->family}}</td>
                        <td>
                        </td>
                        <td>
                            @foreach($user->vacationTypes()->get() as $userVacation)
                                {{$userVacation->title.' = '.$userVacation->pivot->amount.' | '}}
                            @endforeach
                        </td>
                        <td>
                            <form onsubmit="return confirm('آیا مایل به حذف مرخصی اختصاص داده شده، هستید؟');"
                                  method="POST" action="/vacationType/{{$vacationType->id}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}

                                <a href="/vacationType/edit/{{$vacationType->id}}" class="btn btn-primary">ویرایش</a>
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                    <input type="hidden" {{$index+=1}}>
                @endforeach
                </tbody>

                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
@endsection
