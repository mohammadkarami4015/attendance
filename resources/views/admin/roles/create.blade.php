@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ایجاد کاربر جدید</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('users.store')}}">
            @csrf
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">نام</label>
                        <input type="" class="form-control" id="name" placeholder="نام" name="name">
                    </div>
                    <div class="form-group">
                        <label for="family">نام خانوادگی</label>
                        <input type="" class="form-control" id="family" placeholder="نام خانوادگی" name="family">
                    </div>
                    <div class="form-group">
                        <label for="nationalCode">کد ملی</label>
                        <input type="" class="form-control" id="nationalCode" placeholder="کد ملی" name="national_code">
                    </div>
                    <div class="form-group">
                        <label for="personalCode">کد پرسنلی</label>
                        <input type="" class="form-control" id="personalCode" placeholder="کد پرسنلی" name="personal_code">
                    </div>
                    <div class="form-group">
                        <label for="personalCode">تاریخ استخدام</label>
                        <input type="" class="form-control" id="personalCode" placeholder="تاریخ استخدام" name="date_of_employment">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ایمیل</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="ایمیل" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">رمز عبور</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="رمز عبور" name="password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">ارسال فایل</label>
                        <input type="file" id="exampleInputFile">

                        <p class="help-block">متن راهنما</p>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> مرا به خاطر بسپار
                        </label>
                    </div>
                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ثبت</button>
            </div>
        </form>
    </div>

@endsection
