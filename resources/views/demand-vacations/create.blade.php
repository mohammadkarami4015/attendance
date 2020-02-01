@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">ثبت درخواست جدید</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('demandVacation.store')}}">
            @csrf
            <div class="box-body">

                <div class="row">
                    <div class="form-group">
                        <div class="form-group col-sm-3"><label for="justification_type">نوع مجوز</label>
                            <select class="form-control" size="1" name="justification_type_id"
                                    id="justification_type">
                                <option value="" disabled selected>مرخصی / ماموریت</option>
                                @foreach($justification_types as $justification_type)
                                    <option value="{{ $justification_type->id }} ">
                                        {{ $justification_type->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group col-sm-3"><label for="hourly_daily">نوع تردد</label>
                            <select class="form-control" size="1" name="hourly_daily_id"
                                    id="hourly_daily" onchange="hourlyDaily(this.value)">
                                <option value="" disabled selected>ساعتی / روزانه</option>
                                @foreach($hourly_daily as $item)
                                    <option value="{{ $item->id }} ">
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-sm-3"><label for="vacationType">نوع مرخصی</label>
                            <select class="form-control" size="1" name="vacation_type_id"
                                    id="vacationType">
                                <option value="" disabled selected>انتخاب نوع مرخصی</option>
                                @foreach($vacation_types as $vacation_type)
                                    <option value="{{ $vacation_type->id }} ">
                                        {{ $vacation_type->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-2">
                        <label for="from_date">از تاریخ</label>
                        <input type="date" class="form-control" id="from_date" placeholder="از تاریخ"
                               name="from_date">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="to_date">تا تاریخ</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" placeholder="تا تاریخ"
                               name="to_date">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="from_time">از زمان</label>
                        <input type="time" class="form-control" id="from_time" placeholder="از زمان"
                               name="from_time">
                    </div>
                    <div class="form-group col-sm-2">
                        <label for="to_time">تا زمان</label>
                        <input type="time" class="form-control" id="to_time" placeholder="تا زمان"
                               name="to_time">
                    </div>
                </div>

                <div class="form-group col-sm-5">
                    <div class="form-group ">
                        <label for="description">توضیحات</label>
                        <textarea class="form-control" id="description" rows="3"
                                  name="description"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">ارسال فایل</label>
                        <input type="file" id="exampleInputFile">
                        <p class="help-block">متن راهنما</p>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary col-lg-2" >ثبت</button>
            </div>
        </form>
    </div>
    <script>
        function hourlyDaily(state) {
            const e = document.getElementById("hourly_daily");
            const strUser = e.options[e.selectedIndex].text;

           if(strUser == 'روزانه') {
               document.getElementById("from_time").disabled = true;
               document.getElementById("to_time").disabled = true;
           }else if(strUser == 'ساعتی') {
               document.getElementById("from_time").disabled = false;
               document.getElementById("to_time").disabled = false;
           }
          //  confirm('hourly or daily ' + strUser);
        }

    </script>
@endsection
