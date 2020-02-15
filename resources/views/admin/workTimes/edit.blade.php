@extends('layouts.master')
@section('title')
    تعریف تعطیلی
@endsection
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"> ویرایش زمان کاری  {{$workTime->start}} تا  {{$workTime->end}}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('workTimes.update',$workTime->id)}}">
            @csrf
            {{method_field('patch')}}
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">عنوان  شیفت :</label>
                        <label   id="title" >{{$workTime->dayShift->shift->title}}</label>
                    </div>
                    <div class="form-group">
                        <label for="name">روز :</label>
                        <label   id="title" >{{$workTime->dayShift->day->label}}</label>
                    </div>

                    <div class="">
                        <label for="family">زمان شروع:</label>
                        <input type="time" value="{{$workTime->start}}"  name="start">

                    </div>
                    <div class="">
                        <label for="family"> زمان پایان : </label>
                        <input  type="time"  value="{{$workTime->end}}" name="end">
                        <hr>
                    </div>


                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ثبت</button>
                <a href="{{route('workTimes.index')}}" class="btn btn-danger">بازگشت</a>
            </div>
        </form>
    </div>


@endsection
