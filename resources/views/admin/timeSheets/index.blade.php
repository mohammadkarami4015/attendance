@extends('layouts.master')

@section('title')
    ورود و خروج
@endsection

@section('description')

@endsection

@section('content')
    <div class="box box-primary">
        <div class="box box-pane-right " style="float: left; width: 39%;">
            <div class="box-header with-border" style=" text-align: center">
                <label class="box-title">ثبت اطلاعات ورود و خروج</label>
            </div>
            <form role="form" action="{{route('timeSheet.upload')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputFile">انتخاب فایل</label>
                        <input required type="file" name="file" accept=".csv" id="exampleInputFile">
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">آپلود فایل</button>
                    <a href="{{route('timeSheets.create')}}" class="btn btn-primary">ثبت دستی اطلاعات</a>

                </div>
            </form>
        </div>

        <div class="box box-pane-left" style="width: 60%;">
            <div style="text-align: center">
                <label class="box-title">بررسی اطلاعات ورود و حروج</label>
            </div>
            <div class="box table-responsive no-padding ">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>تاریخ</th>
                        <th>مشخصات کاربران</th>
                    </tr>
                    </thead>

                    <tbody id="checkDouble">


                    </tbody>
                </table>

            </div>
            <button onclick="CheckDouble()" class="btn btn-primary">بررسی اطلاعات</button>

        </div>
    </div>


    <div class="box box-primary col-md-5">

        <label class="label label-default">انتخاب کاربر </label>
        <select required id="user_id" name="user_id" class="input-group select2 select2-hidden-accessible"
                data-placeholder="انتخاب کاربر" style="width: 80%;" tabindex="-1"
                aria-hidden="true">
            @foreach($users as $user)
                <option value="{{$user->id}}">{{\App\Helpers\Name::userFullName($user)}} </option>
            @endforeach
        </select>
        <label style="margin-left: 5px;margin-right: 10%"> از </label>
        <input id="from" type="text" readonly name="from" class="input-group filter">
        <label style="margin-left: 5px ; margin-right: 5px"> تا </label>
        <input id="to" type="text" readonly name="to" class="input-group filter">


        <input onclick="filter()" style="margin-right:1px; padding-right: 20px;"
               class="btn btn-primary btn-sm pr-1"
               value=" فیلتر ">


        <div class="box table-responsive no-padding ">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>مشخصات کاربری</th>
                    <th>تاریخ</th>
                    <th>زمان</th>
                    <th> تنظیمات</th>
                </tr>
                </thead>
                <tbody id="filter">
                @foreach($timeSheets as $timeSheet)
                    <tr>
                        <td>
                            {{\App\Helpers\Name::userFullName($timeSheet->user)}}
                        </td>
                        <td>
                            {{\App\Helpers\DateFormat::toJalali($timeSheet->finger_print_time)->formatJalaliDate()}}
                        </td>

                        <td>
                            {{\App\Helpers\DateFormat::toJalali($timeSheet->finger_print_time)->formatTime()}}
                        </td>

                        <td>
                            <form onsubmit="return confirm('آیا مایل به حذف این اطلاعات می باشید؟');"
                                  method="post"
                                  action="{{route('timeSheets.destroy',$timeSheet->id)}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                                <div class="btn-group btn-group">
                                    <a href="{{route('timeSheets.edit',$timeSheet->id)}}"
                                       class="btn btn-primary">ویرایش</a>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div style="margin-right: 40%">
                {{$timeSheets->appends(request()->all())->links()}}
            </div>
        </div>


    </div>


    <script>
        function filter() {

            var user_id = document.getElementById('user_id').value;
            var From = document.getElementById('from').value;
            var to = document.getElementById('to').value;

            var url = '{{URL::asset('admin/timeSheetFilter')}}' + '?';
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('filter').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url + 'user_id=' + user_id + '&from=' + From + '&to=' + to, true);
            xhttp.send();
        }


        function CheckDouble() {
            var url = '{{URL::asset('admin/timeSheet/checkDouble')}}';
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('checkDouble').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }
    </script>

@endsection
