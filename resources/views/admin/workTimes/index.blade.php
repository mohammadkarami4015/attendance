@extends('layouts.master')

@section('title')
    ساعت کاری
@endsection

@section('description')

@endsection

@section('content')
    <div class="col-md-12">

        <div class="box">
            {{--        <input onkeyup="Search()" type="text" name="search" id="text" class="form-control col-md-8"--}}
            {{--               style="margin:1% 79% 1% 1%; width: 20%"--}}
            {{--               placeholder="جستجو ">--}}
            <div class="box table-responsive no-padding ">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>عنوان شیفت</th>
                        <th>روز</th>
                        <th>زمان شروع</th>
                        <th>زمان پایان</th>
                        <th>از تاریخ</th>
                        <th>تا تاریخ</th>
                        <th style="text-align: center"> تنظیمات</th>
                    </tr>
                    </thead>
                    @foreach($workTimes as $workTime)
                        <tr>
                            <td>
                                {{$workTime->dayShift->shift->title}}
                            </td>
                            <td>
                                {{$workTime->dayShift->day->label}}
                            </td>
                            <td>
                                {{$workTime->start}}
                            </td>
                            <td>
                                {{$workTime->end}}
                            </td>
                            <td>
                                {{\App\Helpers\DateFormat::toJalali($workTime->from)->formatJalaliDate()}}
                            </td>
                            <td>
                                @if($workTime->to != null)
                                    {{\App\Helpers\DateFormat::toJalali($workTime->to)->formatJalaliDate()}}
                                @else
                                    تعیین نشده
                                @endif

                            </td>

                            <td>
                                <form onsubmit="return confirm('آیا مایل به حذف این زمان کاری می باشید؟');"
                                      method="post"
                                      action="{{route('workTimes.destroy',$workTime->id)}}">
                                    {{csrf_field()}}
                                    {{method_field('delete')}}
                                    <div class="btn-group btn-group">
                                        <a href="{{route('workTimes.edit',$workTime->id)}}" class="btn btn-primary">ویرایش</a>
                                        <button type="submit" class="btn btn-danger">حذف</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </table>
                <div style="margin-right: 40%">
                    {{--                    {{$workTimes->appends(request()->all())->links()}}--}}
                </div>
            </div>


        </div>
    </div>

@endsection
