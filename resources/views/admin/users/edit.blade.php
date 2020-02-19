@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ویرایش کاربران </h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('users.update',$user->id)}}">
            @csrf
            {{method_field('patch')}}
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="name">نام</label>
                            <input type="text" class="form-control" id="name" value="{{$user->name}}" name="name">
                        </div>
                        <div class="form-group">
                            <label for="family">نام خانوادگی</label>
                            <input type="text" class="form-control" id="family" value="{{$user->family}}" name="family" >
                        </div>
                        <div class="form-group">
                            <label for="nationalCode">کد ملی</label>
                            <input type="text" class="form-control" id="nationalCode" value="{{$user->national_code}}" name="national_code"  >
                        </div>
                        <div class="form-group">
                            <label for="personalCode">کد پرسنلی</label>
                            <input type="text" class="form-control" id="personalCode"  value="{{$user->personal_code}}"
                                   name="personal_code">
                        </div>

                    </div>
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label  for="unit_id">گروه کاری </label>
                            <br>
                            <select required id="unit_id" name="unit_id" class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="انتخاب کاربر" style="width: 60%;" tabindex="-1"
                                    aria-hidden="true">

                                @foreach($units as $unit)
                                    @dump($unit->id)
                                    <option {{$unit->id == $user->unit->id ? 'selected' : ''}} value="{{$unit->id}}">{{$unit->title}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

{{--                            <label  for="role_id">نقش </label>--}}
{{--                            <br>--}}
{{--                            <select required id="role_id" name="role_id" class="form-control select2 select2-hidden-accessible"--}}
{{--                                    data-placeholder="انتخاب کاربر" style="width: 60%;" tabindex="-1"--}}
{{--                                    multiple--}}
{{--                                    aria-hidden="true">--}}

{{--                                @foreach($units as $unit)--}}
{{--                                    <option {{$unit->id == $user->unit->id ? 'selected' : ''}} value="{{$unit->id}}">{{$unit->title}} </option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
                        </div>
                    </div>

                    <div class="col-sm-1"></div>
                </div>
            </div>


            <div class="flex-checkbox">

            </div>

    <!-- /.box-body -->

    <div class="box-footer">
        <button type="submit" class="btn btn-primary"> ویرایش</button>
        <a href="{{route('users.index')}}" class="btn btn-danger">بازگشت</a>
    </div>
    </form>
    </div>

@endsection
