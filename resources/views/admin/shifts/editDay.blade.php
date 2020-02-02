@extends('layouts.master')
@section('title')
    شیفت کاری کاری
@endsection

@section('content')
    <div class="row">

        <div class="col-md-8">
            <div class="box box-primary">
                <form method="post"
                      action="{{route('shifts.updateDays',$shift)}}">
                    {{csrf_field()}}
                    {{method_field('patch')}}

                    <div class="box-body">
                        <div class="form-group">
                            <label> انتخاب روزهای کاری  شیفت  {{  $shift->title }} </label>
                            <select required name="days[]" class="form-control select2 select2-hidden-accessible"
                                    multiple=""
                                    data-placeholder="انتخاب روز" style="width: 100%;" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($days as $day)
                                    <option {{in_array($day->id,$currentDays->pluck('id')->toArray()) ? 'selected' : ''}} value="{{$day->id}}">{{$day->label}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div  class="box-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{ route('shifts.show',$shift->id)}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>



@endsection



