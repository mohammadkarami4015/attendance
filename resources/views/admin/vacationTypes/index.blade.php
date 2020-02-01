@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">تعریف نوع مرخصی جدید</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('vacationType.store')}}">
            @csrf
            <div class="box-body">

                <div class="row">

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="name">عنوان مرخصی</label>
                            <input type="" class="form-control" id="name" placeholder="عنوان مرخصی" name="title">
                        </div>
                        <div class="form-group">
                            <label for="name"> مقدار مجاز</label>
                            <input type="" class="form-control" id="name" placeholder="مقدار مجاز"
                                   name="default_amount">
                        </div>
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group"><label for="vacation">تعیین دوره زمانی</label>
                            <select class="form-control" size="1" name="vacation_period_time_id"
                                    id="vacation">
                                <option value="" disabled selected>ماهانه یا سالانه</option>
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
                                <option value="" disabled selected>روز، ساعت، دقیقه</option>
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
                </div>
            </div>
        </form>

        <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th class="text-danger">نوع مرخصی</th>
                    <th class="text-danger">مقدار مجاز</th>
                    <th class="text-danger">برحسب</th>
                    <th class="text-danger"> بازه زمانی</th>
                </tr>
                </tbody>
                <tbody id="users">
                @foreach($vacationTypes as $vacationType)
                    <tr>
                        <td>
                            <a href="/vacationType/{{$vacationType->id}}">{{$vacationType->title}}</a>
                        </td>
                        <td>{{$vacationType->default_amount}}</td>
                        <td>{{$vacationType->vacationMeasurement->title }}</td>
                        <td>{{$vacationType->vacationPeriodTime->title  }}</td>
                        <td>
                            <form onsubmit="return confirm('آیا مایل به حذف این نوع مرخصی هستید؟');"
                                  method="POST" action="/vacationType/{{$vacationType->id}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}

                                <a href="{{route('vacationType.edit',$vacationType->id)}}" class="btn btn-primary">ویرایش</a>
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
@endsection
