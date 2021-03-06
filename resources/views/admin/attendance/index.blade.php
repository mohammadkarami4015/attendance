@extends('layouts.master')

@section('title')
    گزارش گیری
@endsection

@section('description')

@endsection

@section('content')
    <div class="col-md-12">
        <div class="box box-primary">
            <h4 style="margin-right: 42%"><label>کارکرد </label></h4>
{{--            <form action="{{route('attendance.getReport')}}" method="post"--}}
{{--                  style="    justify-content: space-between; display: inline-flex; align-items: baseline;">--}}
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label style="margin-left: 5px;width: 100px">  کاربر </label>
                        <select required id="user_id" name="user_id" class=" select2 select2-hidden-accessible"

                                data-placeholder="انتخاب کاربر" style="width: 30%;" tabindex="-1"
                                aria-hidden="true">

                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{\App\Helpers\Name::userFullName($user)}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="box-body">
                    <div class="form-group">
                        <label style="width: 150px">  تاریخ شروع </label>
                        <input type="text" id="from" readonly name="start_date" class=" filter">
                        <br>
                        <br>

                        <label style="width: 150px">  تاریخ پایان </label>
                        <input type="text" id="to" readonly name="end_date" class="filter">
                        <br>
                        <br>

                        <div class="footer-a">
                        <input onclick="getReport()"  style=" "
                               class="btn btn-primary btn-sm pr-1"
                               value=" نمایش ">
                        </div>
                    </div>
                </div>

{{--            </form>--}}
        </div>
        <div id="filter">


        </div>


        <script>

            function getReport() {

                var user_id = document.getElementById('user_id').value;
                var From = document.getElementById('from').value;
                var to = document.getElementById('to').value;

                axios.get('{{route('attendance.report')}}'+ '?'+ 'user_id=' + user_id + '&start_date=' + From + '&end_date=' + to).then(res => {
                    document.getElementById('filter').innerHTML = res.data;
                }).catch(console.error);


                {{--var url = '{{route('attendance.report')}}' + '?';--}}
                {{--var xhttp = new XMLHttpRequest();--}}

                {{--xhttp.onreadystatechange = function () {--}}
                {{--    if (this.readyState == 4 && this.status == 200) {--}}
                {{--        document.getElementById('filter').innerHTML = this.responseText;--}}
                {{--    }--}}
                {{--};--}}
                {{--xhttp.open("GET", url + 'user_id=' + user_id + '&start_date=' + From + '&end_date=' + to, true);--}}
                {{--xhttp.send();--}}
            }
        </script>

@endsection
