@extends('layouts.master')
@section('title')
    شیفت کاری کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="box box-primary">
                <form method="post"
                      action="{{route('units.addShift',$unit->id)}}">
                    {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group">

                            <label> انتخاب شیفت کاری مربوط به گروه {{$unit->title}}</label>
                            <select required name="shift" class="input-group" style="width: 50%"
                                    data-placeholder="انتخاب گروه کاری"
                            >
                                <option selected disabled>انتخاب شیفت</option>

                                @foreach($shifts as $shift)
                                    <option @if($unit->getCurrentShift() != null)
                                            {{ $shift->id == $unit->getCurrentShift()->id ? 'selected' : ''}}
                                            @endif
                                            value="{{$shift->id}}">{{$shift->title}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ثبت نهایی</button>
                        <a href="{{route('units.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>

        function add() {
            var count = document.getElementsByClassName('count').length + 1;
            var txt = '  <div class="count input-group date" style="margin-bottom:5px;margin-top: 10%;">\n' +
                ' <input type="time" required  name="ws[' + count + ']"  placeholder=" زمان شروع ">\n' +
                ' <input type="time" required  name="we[' + count + ']"  placeholder="زمان پایان"  >\n' +
                ' </div> '
            $("#workTime_add").append(txt);
        }

    </script>


@endsection



