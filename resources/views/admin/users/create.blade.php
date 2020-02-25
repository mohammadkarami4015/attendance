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
                <div class="row">
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
                            <input type="" class="form-control" id="nationalCode" placeholder="کد ملی"
                                   name="national_code">
                        </div>
                        <div class="form-group">
                            <label for="personalCode">کد پرسنلی</label>
                            <input type="" class="form-control" id="personalCode" placeholder="کد پرسنلی"
                                   name="personal_code">
                        </div>

                    </div>

                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="unit_id">گروه کاری </label>
                            <br>
                            <select required id="unit_id" name="unit_id"
                                    class="form-control select2 select2-hidden-accessible"
                                    data-placeholder="انتخاب کاربر" style="width: 40%;" tabindex="-1"
                                    aria-hidden="true">

                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}">{{$unit->title}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">

                        </div>
                    </div>

                    <div class="col-sm-1"></div>
                </div>
            </div>


            <div class="flex-checkbox">

            </div>

            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ثبت</button>
                <a href="{{route('users.index')}}" class="btn btn-danger">بازگشت</a>
            </div>
        </form>
    </div>

@endsection
