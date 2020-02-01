@extends('layouts.master')
@section('title')
    ایجاد گروه کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form method="post"
                      action="{{route('units.update',$unit->id)}}">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title"><span class="text-danger">عنوان</span></label>
                            <input name="title" type="text" class="form-control" id="title" value="{{$unit->title}}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{route('units.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

