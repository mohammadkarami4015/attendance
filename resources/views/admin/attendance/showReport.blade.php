@extends('layouts.master')

@section('title')
    گزارش گیری
@endsection

@section('description')

@endsection

@section('content')


    <div class="box-header" style="text-align: center">
        <h4><b class="">
                گزارش کارکرد {{\App\Helpers\Name::userFullName($user)}}
            </b>
        </h4>
    </div>
    @foreach($collectList as $List )
        <div class="box">
            <div class="box-header">
                <b class="box">{{$List['day']}}
                    {{\App\Helpers\DateFormat::convertToJalali($List['date'])->formatJalaliDate()}}
                </b>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                                   aria-describedby="example1_info">
                                <thead>

                                <tr role="row">
                                    @foreach($List['report'] as $list)
                                        <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1"
                                            colspan="1"
                                            aria-sort="ascending"
                                            style="width: 172.548px;">{{$list['item1'] }} تا {{$list['item2']}}
                                        </th>
                                    @endforeach
                                </tr>

                                </thead>
                                <tbody>
                                <tr role="row" class="odd">
                                    @foreach($List['report'] as $list)
                                        <td class="sorting_1">  {{date('H:i', mktime(0,$list['value'] ))}}   {{$list['status']}}
                                        </td>
                                    @endforeach
                                </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            @if($List['sumOfStatus'] != [])
                                <div class="dataTables_info" id="example1_info" role="status" aria-live="polite"> کارکرد
                                    : <i
                                        class="text-danger">{{date('H:i', mktime(0,$List['sumOfStatus']['کارکرد'] ))}}</i>
                                    &nbsp;
                                    غیبت : <i
                                        class="text-danger">{{date('H:i', mktime(0,$List['sumOfStatus']['غیبت'] ))}} </i>
                                    &nbsp;
                                    اضافه کاری : <i
                                        class="text-danger">{{date('H:i', mktime(0,$List['sumOfStatus']['اضافه کاری'] ))}} </i>&nbsp;
                                    تعطیلی : <i
                                        class="text-danger">{{date('H:i', mktime(0,$List['sumOfStatus']['تعطیلی'] ))}}</i>
                                    مرخصی : <i
                                        class="text-danger">{{date('H:i', mktime(0,$List['sumOfStatus']['مرخصی'] ))}}</i>
                                </div>
                                {{$user->setSum($List['sumOfStatus'])}}

                            @endif

                        </div>

                    </div>
                </div>

            </div>
            <!-- /.box-body -->
        </div>
    @endforeach

    <div class="box">
        <div class="box-header">
            <h4><b class="box">مجموع</b></h4>
        </div>

        <!-- /.box-header -->
        <div class="box-body">
            <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable" role="grid"
                               aria-describedby="example1_info">
                            <thead>

                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending"
                                    style="width: 172.548px;">جمع کارکرد
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending"
                                    style="width: 172.548px;">جمع غیبت
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending"
                                    style="width: 172.548px;">جمع مرخصی
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"
                                    aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending"
                                    style="width: 172.548px;">جمع اضافه کاری
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr role="row" class="odd">
                                <td class="sorting_1">
                                    {{\Carbon\CarbonInterval::minute($user->getSum()['کارکرد'])->cascade()->forHumans()}}
                                </td>
                                <td class="sorting_1">
                                    {{\Carbon\CarbonInterval::minute($user->getSum()['غیبت'])->cascade()->forHumans()}}
                                </td>
                                <td class="sorting_1">
                                    {{\Carbon\CarbonInterval::minute($user->getSum()['مرخصی'])->cascade()->forHumans()}}
                                </td>
                                <td class="sorting_1">
                                    {{\Carbon\CarbonInterval::minute($user->getSum()['اضافه کاری'])->cascade()->forHumans()}}
                                </td>
                            </tr>


                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.box-body -->
    </div>








@endsection
