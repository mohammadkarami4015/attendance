@extends('layouts.master')
@section('title')
    ایجاد گروه کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form method="post"

                      action="{{route('units.store')}}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title"><span class="text-danger">عنوان</span></label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ایجاد</button>
                        <a href="{{route('units.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

