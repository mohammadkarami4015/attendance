@extends('layouts.master')
@section('title')
    تعریف تعطیلی
@endsection
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"> ویرایش تعطیلی  {{$holiday->title}}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('holidays.update',$holiday->id)}}">
            @csrf
            {{method_field('patch')}}
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">عنوان تعطیلی</label>
                        <input type="text" class="form-control" id="title" value="{{$holiday->title}}" name="title">
                    </div>
                    <div class="form-group">
                        <label for="name">توضیحات </label>
                        <textarea type="text" class="form-control" id="description" placeholder="توضیحات"
                                  name="description">{{$holiday->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="nationalCode">نوع تعطیلی </label>

                        <input @if($holiday->is_daily == 1 ) checked @endif readonly  name="is_daily" type="radio"
                               value="1"> روزانه

                        <input @if($holiday->is_daily == 0 ) checked @endif name="is_daily" type="radio"
                               value="0"> ساعتی
                        <br>

                    </div>
                    <div class="">
                        <label for="family"> تاریخ شروع</label>
                        <input required type="text" readonly class="form-control tarikh"  value="{{$holiday->start}}" id="start" name="start">

                    </div>
                    <div class="">
                        <label for="family"> زمان پایان</label>
                        <input style="width: 30%"  required type="time" class="form-control " id="end" value="{{$holiday->end}}" name="end">
                        <hr>
                    </div>


                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ثبت</button>
                <a href="{{route('holidays.index')}}" class="btn btn-danger">بازگشت</a>
            </div>
        </form>
    </div>
    <script>
        function hourlyDaily($var) {

            if ($var == 1) {
                document.getElementById("end").disabled = true;
            } else {
                document.getElementById("end").disabled = false;
                document.getElementById("end").required = true;
            }

        }

    </script>

@endsection
