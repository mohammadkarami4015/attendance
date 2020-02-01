@extends('layouts.master')
@section('title')
    ایجاد شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form method="post"

                      action="{{route('shifts.store')}}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title"><span class="text-danger">عنوان</span></label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h4 class="box-title">انتخاب روزهای کاری</h4>
                        </div>
                    </div>
                    <div class="flex-checkbox">
                        @foreach($days as $day)
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input name="days[]" value="{{$day->id}}" type="checkbox"
                                               id="day">
                                        {{$day->label}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ایجاد</button>
                        <a href="{{route('shifts.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

