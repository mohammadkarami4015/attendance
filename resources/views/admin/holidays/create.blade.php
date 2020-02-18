@extends('layouts.master')
@section('title')
    تعریف تعطیلی
@endsection
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">تعریف تعطیلی</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('holidays.store')}}">
            @csrf
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">عنوان تعطیلی</label>
                        <input type="text" class="form-control" id="title" placeholder="عنوان" name="title">
                    </div>
                    <div class="form-group">
                        <label for="name">توضیحات </label>
                        <textarea type="text" class="form-control" id="description" placeholder="توضیحات"
                                  name="description"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="nationalCode">نوع تعطیلی </label>

                        <input readonly  name="is_daily" type="radio"
                               value="1"> روزانه

                        <input checked readonly  name="is_daily" type="radio"
                               value="0"> ساعتی
                        <br>

                    </div>
                    <div class="">
                        <label for="family"> تاریخ شروع</label>
                        <input required   style="width: 60%"type="text" readonly class="form-control tarikh" id="start" name="start">

                    </div>
                    <div class="">
                        <label for="family"> زمان پایان</label>
                        <input style="width: 40%"  type="time"  class="form-control timeOnly" id="end" name="end">
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
