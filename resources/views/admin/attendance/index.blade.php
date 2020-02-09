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
                <form action="{{route('attendance.getReport')}}" method="post"
                      style="    justify-content: space-between; display: inline-flex; align-items: baseline;">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label style="margin-left: 5px;width: 300px"> انتخاب کاربر </label>
                            <select required name="user_id" class="form-control select2 select2-hidden-accessible"

                                    data-placeholder="انتخاب کاربر" style="width: 50%;" tabindex="-1"
                                    aria-hidden="true">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{\App\Helpers\Name::userFullName($user)}} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label style="width: 300px"> انتخاب تاریخ شروع </label>
                            <input type="text" readonly name="start_date" class="form-control filter">

                            <label style="width: 300px"> انتخاب تاریخ پایان </label>
                            <input type="text" readonly name="end_date" class="form-control filter">
                            <input type="submit" style="direction: ltr; margin-right:250px; padding-right: 20px;"
                                   class="btn btn-primary btn-sm pr-1"
                                   value=" فیلتر ">
                        </div>
                    </div>

                </form>
            </div>

@endsection
