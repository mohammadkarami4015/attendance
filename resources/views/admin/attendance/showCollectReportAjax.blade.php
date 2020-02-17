<div class="box">
    <div style="text-align: center" class="box-header">
        <label for="">  مجموع کارکرد از تاریخ {{$start_date}} تا  {{$end_date}}</label>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
                           aria-describedby="example2_info">
                        <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1"
                                colspan="1"
                                aria-sort="ascending"
                                aria-label=" activate to sort column descending">
                                نام کاربری
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="امتیاز راننده: activate to sort column ascending">کارکرد
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="سیستم عامل: activate to sort column ascending">غیبت
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="ورژن: activate to sort column ascending">مرخصی
                            </th>
                            <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                aria-label="امتیاز: activate to sort column ascending">اضافه کاری
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($collectList as $list)
                            <tr role="row" class="odd">
                                <td class="sorting_1"><b>{{\App\Helpers\Name::userFullName($list['user'])}}</b></td>
                                <td>{{\Carbon\CarbonInterval::minute($list['finalList']['کارکرد'])->cascade()->forHumans()}}</td>
                                <td>{{\Carbon\CarbonInterval::minute($list['finalList']['غیبت'])->cascade()->forHumans()}}</td>
                                <td>{{\Carbon\CarbonInterval::minute($list['finalList']['مرخصی'])->cascade()->forHumans()}}</td>
                                <td>{{\Carbon\CarbonInterval::minute($list['finalList']['اضافه کاری'])->cascade()->forHumans()}}</td>
                            </tr>

                        @endforeach
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
