@extends('layouts.master')

@section('title')
    تعطیلات
@endsection

@section('description')

@endsection

@section('content')
    <div class="col-md-12">

        <a href="{{route('holidays.create')}}" class="btn btn-primary">تعریف تعطیلی جدید</a>
        <div class="box">
            {{--        <input onkeyup="Search()" type="text" name="search" id="text" class="form-control col-md-8"--}}
            {{--               style="margin:1% 79% 1% 1%; width: 20%"--}}
            {{--               placeholder="جستجو ">--}}
            <div class="box table-responsive no-padding ">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>عنوان تعطیلی</th>
                        <th>توضیحات</th>
                        <th>تاریخ </th>
                        <th>زمان شروع</th>
                        <th>زمان پایان</th>
                        <th>نوع تعطیلی</th>
                        <th style="text-align: center"> تنظیمات</th>
                    </tr>
                    </thead>
                    @foreach($holidays as $holiday)
                        <tr>
                            <td>
                                {{$holiday->title}}
                            </td>
                            <td>
                                {{$holiday->description}}
                            </td>
                            <td>
                                {{\App\Helpers\DateFormat::toJalali($holiday->start)->formatJalaliDate()}}
                            </td>
                            <td>
                                {{\App\Helpers\DateFormat::toJalali($holiday->start)->formatTime()}}
                            </td>
                            <td>
                                {{\App\Helpers\DateFormat::toJalali($holiday->end)->formatTime()}}
                            </td>
                            <td>
                                {{$holiday->isDaily() ? 'روزانه' : 'ساعتی'}}
                            </td>
                            <td>
                                <form onsubmit="return confirm('آیا مایل به حذف این تعطیلی می باشید؟');"
                                      method="post"
                                      action="{{route('holidays.destroy',$holiday->id)}}">
                                    {{csrf_field()}}
                                    {{method_field('delete')}}
                                    <div class="btn-group btn-group">
                                        <a href="{{route('holidays.edit',$holiday->id)}}" class="btn btn-primary">ویرایش</a>
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
                <div style="margin-right: 40%">
                    {{$holidays->appends(request()->all())->links()}}
                </div>
            </div>


        </div>
    </div>

@endsection
