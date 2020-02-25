@extends('layouts.master')

@section('title')
    ورود و خروج
@endsection

@section('description')

@endsection

@section('content')

    <div class="box box-pane-right " style=" ">
        <div class="box-header with-border" style=" text-align: center">
            <label class="box-title">ثبت اطلاعات ورود و خروج</label>
        </div>
        <form role="form" action="{{route('timeSheets.upload')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="box-body">
                <div class="">
                    <label for="exampleInputFile">انتخاب فایل (csv.)</label>
                    <input required type="file" name="file" accept=".csv" id="exampleInputFile">
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">آپلود فایل</button>
                <a href="{{route('timeSheets.create')}}" class="btn btn-primary">ثبت دستی اطلاعات</a>

            </div>
        </form>
    </div>

    <div class="box box-pane-left" style="">
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
        <div class="box-footer">
            <button onclick="CheckDouble()" class="btn btn-primary">بررسی اطلاعات</button>
        </div>

    </div>



    <div class="box box-primary ">

        <div class="box box-body">
            <label class="">انتخاب کاربر </label>
            <select required id="user_id" name="user_id" class="input-group select2 select2-hidden-accessible"
                    data-placeholder="انتخاب کاربر" style="width: 30%" tabindex="-1"
                    aria-hidden="true">
                <option value="0">همه کاربران</option>
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{\App\Helpers\Name::userFullName($user)}} </option>
                @endforeach
            </select>
            <label class="control-label"> از </label>
            <input id="from" type="text" readonly name="from" class="filter">
            <label style="margin-left: 5px ; margin-right: 5px"> تا </label>
            <input id="to" type="text" readonly name="to" class=" filter">


            <input onclick="filter()" style="margin-right:1px; padding-right: 20px;"
                   class="btn btn-primary btn-sm pr-1"
                   value=" فیلتر ">
        </div>

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

            axios.get('{{route('timeSheets.filter')}}'+ '?'+ 'user_id=' + user_id + '&from=' + From + '&to=' + to).then(res => {
                document.getElementById('filter').innerHTML = res.data;
            }).catch(console.error);




            //
            // var user_id = document.getElementById('user_id').value;
            // var From = document.getElementById('from').value;
            // var to = document.getElementById('to').value;

            {{--var url = '{{route('timeSheets.filter')}}' + '?';--}}
            {{--var xhttp = new XMLHttpRequest();--}}

            {{--xhttp.onreadystatechange = function () {--}}
            {{--    if (this.readyState == 4 && this.status == 200) {--}}
            {{--        document.getElementById('filter').innerHTML = this.responseText;--}}
            {{--    }--}}
            {{--};--}}
            {{--xhttp.open("GET", url + 'user_id=' + user_id + '&from=' + From + '&to=' + to, true);--}}
            {{--xhttp.send();--}}
        }


        function CheckDouble() {

                axios.get('{{route('timeSheets.checkDouble')}}').then(res => {
                    document.getElementById('checkDouble').innerHTML = res.data;
                }).catch(console.error);


            {{--var url = '{{route('timeSheets.checkDouble')}}';--}}
            {{--var xhttp = new XMLHttpRequest();--}}


            {{--xhttp.onreadystatechange = function () {--}}
            {{--    if (this.readyState == 4 && this.status == 200) {--}}
            {{--        document.getElementById('checkDouble').innerHTML = this.responseText;--}}
            {{--    }--}}
            {{--};--}}
            {{--xhttp.open("GET", url, true);--}}
            {{--xhttp.send();--}}
        }
    </script>

@endsection
