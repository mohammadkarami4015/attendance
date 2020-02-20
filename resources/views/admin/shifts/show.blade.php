@extends('layouts.master')
@section('title')
    جزئیات شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div style="direction: ltr" class="box-header">
                    <a style="padding: 1% 14% 1% 14%" href="{{route('shifts.editTime',$shift)}}" class="btn btn-default">تغییر زمان های کاری</a>
                    <a style="padding: 1% 14% 1% 14%" href="{{route('shifts.editDays',$shift)}}" class="btn btn-default">تغییر روز های کاری</a>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-danger"><span>عنوان شیفت</span></label>
                        <p>{{$shift->title}}</p>
                    </div>

                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-danger"><span>گروه های کاری </span></label>
                        <br>
                        @foreach($shift->unit as $unit)
                            <p>{{$unit->title}}</p>
                        @endforeach
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="text-danger"><span>روزهای کاری </span></label>
                        <br>
                        <br>
                        @foreach($days as $day)
                            <b>{{$day->label}}</b><br>
                            @foreach($day->getWorkTimes() as $time)
                                   شروع :{{$time->start}}
                                <br>
                                  پایان: {{ $time->end }}
                                <br>
                                <br>
                            @endforeach
                            <hr>
                        @endforeach


                    </div>
                </div>

                    <div style="direction: ltr" class="box-header">
                        <a href="{{route('shifts.index')}}"  class="btn btn-danger">بازگشت</a>
                    </div>

            </div>
        </div>
    </div>
@endsection

