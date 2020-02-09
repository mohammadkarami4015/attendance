@extends('layouts.master')

@section('title')
    گزارش گیری
@endsection

@section('description')

@endsection

@section('content')


    {{--    <div class="col-md-12">--}}
    {{--        <div class="input-group">--}}
    {{--            <b>  گزارش کارکرد روز {{$day}} تاریخ {{$date}} {{\App\Helpers\Name::userFullName($user)}} </b>--}}

    {{--        </div>--}}
    {{--        <div class="box col-md-12">--}}
    {{--            --}}{{--        <input onkeyup="Search()" type="text" name="search" id="text" class="form-control col-md-8"--}}
    {{--            --}}{{--               style="margin:1% 79% 1% 1%; width: 20%"--}}
    {{--            --}}{{--               placeholder="جستجو ">--}}
    {{--            <div class="box table-responsive no-padding ">--}}
    {{--                <table class="table table-hover">--}}

    {{--                    <tr>--}}

    {{--                        @foreach($reportList as $list)--}}
    {{--                            <th class="text-danger">  {{$list['item1'] }} تا {{$list['item2']}}--}}
    {{--                            </th>--}}
    {{--                        @endforeach--}}
    {{--                    </tr>--}}
    {{--                    <tr>--}}

    {{--                        @foreach($reportList as $list)--}}
    {{--                            <td>  {{$list['value'] }} دقیقه {{$list['status']}}--}}
    {{--                            </td>--}}
    {{--                        @endforeach--}}
    {{--                    </tr>--}}


    {{--                </table>--}}
    {{--                <div style="margin-right: 40%">--}}
    {{--                     <p> مجموع کارکرد :    <b>{{$sumList['کارکرد']}}</b> دقیقه&nbsp;</p>--}}
    {{--                    <p>مجموع  غیبت :   <b>{{$sumList['غیبت']}}</b> دقیقه&nbsp;</p>--}}
    {{--                    <p>مجموع  اضافه کاری :   <b>{{$sumList['اضافه کاری']}}</b> دقیقه&nbsp;</p>--}}
    {{--                    <p>مجموع  تعطیلی  :   <b>{{$sumList['تعطیلی']}}</b> دقیقه&nbsp;</p>--}}
    {{--                    <p>مجموع  مرخصی  :   <b>{{$sumList['مرخصی']}}</b> دقیقه&nbsp;</p>--}}


    {{--                </div>--}}
    {{--            </div>--}}


    {{--        </div>--}}
    {{--    </div>--}}
    {{\App\Helpers\Name::userFullName($user)}}
    @foreach($collectList as $List )
        <div class="col-md-12">
            <div class="input-group">
                <b> گزارش کارکرد روز {{$List['day']}}
                    تاریخ {{\App\Helpers\DateFormat::convertToJalali($List['date'])->formatJalaliDate()}}


            </div>
            <div class="box col-md-12">
                {{--        <input onkeyup="Search()" type="text" name="search" id="text" class="form-control col-md-8"--}}
                {{--               style="margin:1% 79% 1% 1%; width: 20%"--}}
                {{--               placeholder="جستجو ">--}}
                <div class="box table-responsive no-padding ">
                    <table class="table table-hover">

                        <tr>

                            @foreach($List['report'] as $list)
                                <th class="text-danger">  {{$list['item1'] }} تا {{$list['item2']}}
                                </th>
                            @endforeach
                        </tr>
                        <tr>

                            @foreach($List['report'] as $list)
                                <td>  {{$list['value'] }} دقیقه {{$list['status']}}
                                </td>
                            @endforeach
                        </tr>


                    </table>
                    <div>

                        <b> مجموع کارکرد : <i class="text-danger">{{$List['sum']['کارکرد']}}</i> دقیقه&nbsp;</b>
                        <b>مجموع غیبت : <i class="text-danger">{{$List['sum']['غیبت']}}</i> دقیقه&nbsp;</b>
                        <b>مجموع اضافه کاری : <i class="text-danger">{{$List['sum']['اضافه کاری']}}</i> دقیقه&nbsp;</b>
                        <b>مجموع تعطیلی : <i class="text-danger">{{$List['sum']['تعطیلی']}}</i> دقیقه&nbsp;</b>
                        <b>مجموع مرخصی : <i class="text-danger">{{$List['sum']['مرخصی']}}</i> دقیقه&nbsp;</b>

                    </div>


                </div>
            </div>
    @endforeach

@endsection
