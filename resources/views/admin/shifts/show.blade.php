@extends('layouts.master')
@section('title')
    جزئیات شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <div style="direction: ltr" class="box-header">
                    <a style="padding: 1% 14% 1% 14% ;float: right" href="{{route('shifts.editTime',$shift)}}"
                       class="btn btn-default">تغییر زمان های کاری</a>
                    <a style="padding: 1% 14% 1% 14%" href="{{route('shifts.editDays',$shift)}}"
                       class="btn btn-default">تغییر روز های کاری</a>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-blue"><span>عنوان شیفت</span></label>
                        &nbsp;<b>{{$shift->title}}</b>
                    </div>

                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-blue"><span>گروه های کاری </span></label>&nbsp;
                        @foreach($shift->unit as $unit)
                            <b>{{$unit->title}}</b>&nbsp;&nbsp;
                        @endforeach
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-blue"><span>روزهای کاری </span></label>
                        <br>
                        <br>
                        @foreach($days as $day)
                            <b>{{$day->label}}</b>
                            @foreach($day->getWorkTimes() as $time)
                                {{$time->start}}تا {{ $time->end }}&nbsp; &nbsp;
                            @endforeach

                            <hr>
                        @endforeach


                    </div>
                </div>

                <div style="direction: ltr" class="box-header">
                    <a href="{{route('shifts.index')}}" class="btn btn-danger">بازگشت</a>
                </div>

            </div>
        </div>
    </div>



@endsection

