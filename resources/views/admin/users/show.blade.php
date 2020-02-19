@extends('layouts.master')
@section('title')
    کاربران
@endsection
@section('content')
    <style>
        .form-group li {
            list-style: none;
            padding: 15px;
        }
    </style>
    <div class="row">
        <div class="col-sm-5">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="نام" class="control-label text-danger"> نام و نام خانوادگی</label>
                                <li><b>{{\App\Helpers\Name::userFullName($user) }}</b></li>
                            </div>

                            <div class="form-group">
                                <label for="personal_code" class="control-label text-danger">کد پرسنلی</label>
                                <li><b>{{$user->personal_code}}</b></li>
                            </div>

                            <div class="form-group">
                                <label for="national_code" class="control-label"><span class="text-danger">کد ملی</span></label>
                                <li><b>{{$user->national_code}}</b></li>
                            </div>


                        </div>

                        <div class="col-sm-1">

                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="insurance_start" class="control-label"><span class="text-danger">گروه کاری</span></label>
                                <li><b>{{$user->unit->title }}</b></li>
                            </div>

                            <div class="form-group">
                                <label for="insurance_start" class="control-label"><span class="text-danger">شیفت کاری</span></label>
                                <li><b>{{($user->unit->getCurrentShift()->title)}}</b></li>
                            </div>

                            <div class="form-group">
                                <label for="insurance_start" class="control-label"><span class="text-danger"> نقش</span></label>
                                <li><b>نام نقش</b></li>
                            </div>
                        </div>

                        <div class="col-sm-1"></div>
                    </div>


                    <div class="flex-checkbox">

                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <input type="submit" value="ویرایش " class="btn btn-success"/>
                            <a href="" class="btn btn-danger">بازگشت</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
