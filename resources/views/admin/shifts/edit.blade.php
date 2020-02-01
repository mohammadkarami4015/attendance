@extends('layouts.master')
@section('title')
    ویرایش عنوان شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form method="post"
                      action="{{route('shifts.update',$shift->id)}}">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title"><span class="text-danger">عنوان</span></label>
                            <input name="title" type="text" class="form-control" id="title" value="{{$shift->title}}">
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{route('shifts.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

