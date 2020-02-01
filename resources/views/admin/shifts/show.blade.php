@extends('layouts.master')
@section('title')
    جزئیات شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
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
                        <br>


                    </div>
                </div>

                    <div class="box-footer">
                        <a href="{{route('shifts.addTimeForm',$shift->id)}}" class="btn btn-success">تنظیمات زمان های کاری</a>
                        <a href="{{route('shifts.editDays',$shift->id)}}" class="btn btn-success">ویرایش روز های کاری</a>
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{route('shifts.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

            </div>
        </div>
    </div>
@endsection

