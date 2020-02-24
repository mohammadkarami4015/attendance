@extends('layouts.master')
@section('title')
    جزئیات نقش
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">

                <br>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-blue"><span>عنوان نقش</span></label>
                        <br>
                        <label for="">{{$role->title}}</label>

                    </div>

                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-blue"><span>سطوح دسترسی </span></label>
                        <br>
                        @foreach($role->permissions as $permission)
                            <label>{{$permission->label}}</label>
                            ,
                        @endforeach
                    </div>
                </div>


                    <div style="direction: ltr" class="box-footer">
                        <a href="{{route('roles.index')}}"  class="btn btn-danger">بازگشت</a>
                        <a  href="{{route('roles.edit',$role)}}" class="btn btn-primary">ویرایش</a>
                    </div>

            </div>
        </div>
    </div>
@endsection

