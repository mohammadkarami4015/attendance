@extends('layouts.master')
@section('title')
    ثبت ورود و خروج
@endsection
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">  ویرایش اطلاعات ورود و خروج   {{\App\Helpers\Name::userFullName($timeSheet->user)}}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('timeSheets.update',$timeSheet->id)}}">
            @csrf
            {{method_field('patch')}}
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">مشخصات کاربری</label>
                        <select id="title" placeholder="انتخاب کاربر" name="user_id"
                                required class="form-control select2 select2-hidden-accessible"
                                data-placeholder="انتخاب کاربر" style="width: 100%;" tabindex="-1"
                                aria-hidden="true">
                            <option value=""></option>
                            @foreach($users as $user)
                                <option
                                    {{ $timeSheet->user->id == $user->id ? 'selected' : '' }} value="{{$user->id}}">{{\App\Helpers\Name::userFullName($user)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="">
                        <label for="family"> انتخاب زمان</label>
                        <input type="text" class="form-control tarikh" id="start"
                               value="{{$timeSheet->finger_print_time}}" name="finger_print_time">
                    </div>

                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ویرایش</button>
                <a href="{{route('timeSheets.index')}}" class="btn btn-danger">بازگشت</a>
            </div>
        </form>
    </div>

@endsection
