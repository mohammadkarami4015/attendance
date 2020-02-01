@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">مرخصی {{$vacationType->title}}</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('vacationType.update',$vacationType->id)}}">
            @csrf
            @method('PATCH')
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name">عنوان مرخصی</label>
                            <input value="{{$vacationType->title}}"  type="" class="form-control" id="name" placeholder="عنوان مرخصی" name="title">
                        </div>
                        <div class="form-group">
                            <label for="name"> مقدار مجاز</label>
                            <input value="{{$vacationType->default_amount}}" type="" class="form-control" id="name" placeholder="مقدار مجاز"
                                   name="default_amount">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group"><label for="vacation">تعیین دوره زمانی</label>
                            <select class="form-control" size="1" name="vacation_period_time_id"
                                    id="vacation">
                                <option value="" disabled selected>{{ $vacationType->vacationPeriodTime->title }}</option>
                                @foreach($vacation_period_time as $item)
                                    <option value="{{ $item->id }} ">
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group"><label for="vacation">برحسب</label>
                            <select class="form-control" size="1" name="vacation_measurement_id"
                                    id="vacation">
                                <option value="" disabled selected>{{$vacationType->vacationMeasurement->title}}</option>
                                @foreach($vacation_measurement as $item)
                                    <option value="{{ $item->id }} ">
                                        {{ $item->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                    <a href="{{route('vacationType.index')}}" class="btn btn-danger">بازگشت</a>
                </div>
            </div>
        </form>
    </div>
@endsection
