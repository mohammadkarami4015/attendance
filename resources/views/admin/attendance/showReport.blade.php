@extends('layouts.master')

@section('title')
    گزارش گیری
@endsection

@section('description')

@endsection

@section('content')
    <?php
    $sumAttendance = 0;$sumAbsence = 0;$sumOverTime = 0;$sumVacation = 0;
    ?>
    @foreach($collectList as $List )
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"> گزارش کارکرد {{\App\Helpers\Name::userFullName($user)}} در روز {{$List['day']}}
                    تاریخ {{\App\Helpers\DateFormat::convertToJalali($List['date'])->formatJalaliDate()}}
                </h3>
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
                                        <td class="sorting_1">  {{$list['value'] }} دقیقه {{$list['status']}}
                                        </td>
                                    @endforeach
                                </tr>


                                </tbody>

                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="dataTables_info" id="example1_info" role="status" aria-live="polite"> کارکرد
                                    : <i class="text-danger">{{$List['sumOfStatus']['کارکرد']}}</i> دقیقه&nbsp;
                                 غیبت : <i class="text-danger">{{$List['sumOfStatus']['غیبت']}}</i> دقیقه&nbsp;
                                 اضافه کاری : <i class="text-danger">{{$List['sumOfStatus']['اضافه کاری']}}</i>
                                    دقیقه&nbsp;
                                 تعطیلی : <i class="text-danger">{{$List['sumOfStatus']['تعطیلی']}}</i>
                                    دقیقه&nbsp;
                                 مرخصی : <i class="text-danger">{{$List['sumOfStatus']['مرخصی']}}</i> دقیقه&nbsp;
                            </div>
                        </div>

                    </div>
                </div>
                <?php
                $sumAttendance += $List['sumOfStatus']['کارکرد'];
                $sumAbsence += $List['sumOfStatus']['غیبت'];
                $sumOverTime += $List['sumOfStatus']['اضافه کاری'];
                $sumVacation += $List['sumOfStatus']['مرخصی'];
                ?>
            </div>
            <!-- /.box-body -->
        </div>
    @endforeach

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">مجموع</h3>
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
                                    {{date('H:i', mktime(0,$sumAttendance))}}
                                </td>
                                <td class="sorting_1">
                                    {{date('H:i', mktime(0,$sumAbsence))}}
                                </td>
                                <td class="sorting_1">
                                    {{date('H:i', mktime(0,$sumVacation))}}
                                </td>
                                <td class="sorting_1">
                                    {{date('H:i', mktime(0,$sumOverTime))}}
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
