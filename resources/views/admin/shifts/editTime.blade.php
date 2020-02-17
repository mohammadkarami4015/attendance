@extends('layouts.master')
@section('title')
    شیفت کاری کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <h4 style="margin-right: 42%"><label > فرم افزودن زمان کاری</label></h4>
                <form method="post"
                      action="{{route('shifts.addWorkTime',$shift)}}">
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="form-group">
                            <label> انتخاب روزهای کاری شیفت {{$shift->title}} </label>
                            <select required name="days[]" class="form-control select2 select2-hidden-accessible"
                                    multiple=""
                                    data-placeholder="انتخاب روز" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($days as $day)
                                    <option value="{{$day->id}}">{{$day->label}} </option>
                                @endforeach
                            </select>
                            <a onclick="selectAll()" class="selectAll btn-sm btn-primary ">انتخاب همه</a>
                            <a onclick="Clear()" class="clear btn-sm btn-primary">حذف همه</a>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="box-body">

                            <label>زمان شروع و پایان شیفت های کاری را مشخص کنید</label>
                            <br>
                            <br>
                            <div class="form-group">
                                <label style="margin-right: 23%"> شروع </label>
                                <label style="margin-right: 5%"> پایان </label>

                            </div>

                            <div style="background: green;margin-top: -5%" class="form-group">
                                <span style=" width: 110px; " class="btn btn-success col-sm-2 "
                                      onclick="add()">افزودن زمان کاری</span>
                                <div style=" margin-right: 10px; width: 50%;" class="col-sm-10" id="workTime_add">


                                </div>

                            </div>
                        </div>
                    </div>


                    <div style="direction: ltr" class="box-footer">
                        <a href="{{ URL::previous()}}" class="btn btn-danger">بازگشت</a>
                        <button type="submit" class="btn btn-primary"> تایید</button>
                    </div>

                </form>
            </div>
        </div>

{{--        //***********************************--}}
        <div class="col-md-9">
            <div class="box box-primary">
                <h4 style="margin-right: 42%"><label > فرم حذف زمان کاری</label></h4>
                <form method="post"
                      action="{{route('shifts.removeWorkTime')}}">
                    {{csrf_field()}}

                    <div class="box-body">
                        <div class="form-group">
                            <label> انتخاب روزهای کاری شیفت {{$shift->title}} </label>
                            <select required name="day" class="form-control "
                                  onchange="getWorkTimes(this.value)">
                                <option selected disabled value=> انتخاب روز کاری</option>
                            @foreach($days as $day)
                                    <option value="{{$day->id}}">{{$day->label}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="test"></div>
                    </div>
                    <div style="direction: ltr" class="box-footer">
                        <a href="{{ route('shifts.show',$shift->id)}}" class="btn btn-danger">بازگشت</a>
                        <button type="submit" class="btn btn-primary">تایید </button>
                    </div>

                </form>
            </div>
        </div>
    </div>





    <script>

        function selectAll() {
            $exampleMulti = $(".select2").select2();
            $exampleMulti.val([{{$dayIndex}}]).trigger("change");

        }

        function Clear() {
            $exampleMulti = $(".select2").select2();
            $exampleMulti.val(null).trigger("change");
        }


        function getWorkTimes(id) {
            var url = '{{URL::asset('admin/shift/getWorkTime')}}';
            var shift = '{{$shift->id}}';
            // alert(sub_url);
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('test').innerHTML = this.responseText;

                }
            };
            // xhttp.open("GET", url + 'day=' + id, true);
            xhttp.open("GET", url + '/' + shift + '?day=' + id, true);
            xhttp.send();
        }

        function add() {
            var count = document.getElementsByClassName('count').length + 1;
            var txt = '  <div class="count input-group date" style="margin-bottom:5px;margin-top: 10%;">\n' +
                ' <input type="time" required  name="start[' + count + ']"  placeholder=" زمان شروع ">\n' +
                ' <input type="time" required  name="end[' + count + ']"  placeholder="زمان پایان"  >\n' +
                ' </div> '
            $("#workTime_add").append(txt);
        }

    </script>


@endsection



