@extends('layouts.master')
@section('title')
    ایجاد شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form method="post"

                      action="{{route('shifts.store')}}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title"><span class="text-danger">عنوان</span></label>
                            <input name="title" type="text" class="form-control" id="title" placeholder="عنوان">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <hr>
                            <h4 class="box-title text-danger">انتخاب روزهای کاری</h4>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="form-group">

                            <select required name="days[]" class="test select2 select2-hidden-accessible"
                                    multiple=""
                                    data-placeholder="انتخاب روز" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($days as $day)
                                    <option  value="{{$day->id}}">{{$day->label}} </option>
                                @endforeach
                            </select>
                            <a onclick="selectAll()" class="selectAll btn-sm btn-primary ">انتخاب همه</a>
                            <a onclick="Clear()" class="clear btn-sm btn-primary">حذف همه</a>

                        </div>
                    </div>
                    <br>
                    <div >
                        <label style="width: 100px" class="text-danger">تاریخ اجرا </label>
                        <input type="text" id="from" readonly name="from" class="apply">

                    </div>
                    <br>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ایجاد</button>
                        <a href="{{route('shifts.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <script >
        function selectAll() {
            $exampleMulti = $(".select2").select2();
            $exampleMulti.val([0,1,2,3,4,5,6]).trigger("change");

        }

        function Clear() {
            $exampleMulti = $(".select2").select2();
            $exampleMulti.val(null).trigger("change");
        }

    </script>
@endsection

