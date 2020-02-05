@extends('layouts.master')

@section('title')
    گزارش گیری
@endsection

@section('description')

@endsection

@section('content')
    <div class="col-md-12">
        <form action="{{route('attendance.getReport')}}" method="post"
              style="    justify-content: space-between; display: inline-flex; align-items: baseline;">
            @csrf
            <label style="margin-left: 5px;width: 300px"> انتخاب کابر </label>
            <select required name="user_id" class="form-control select2 select2-hidden-accessible"

                    data-placeholder="انتخاب کاربر" style="width: 100%;" tabindex="-1"
                    aria-hidden="true">
                @foreach($users as $user)
                    <option value="{{$user->id}}">{{\App\Helpers\Name::userFullName($user)}} </option>
                @endforeach
            </select>


            <label  style="width: 300px;direction: ltr" > انتخاب زمان </label>
            <input  type="text" readonly name="date"  class="form-control filter">


            <input type="submit" style="margin-right:1px; padding-right: 20px;" class="btn btn-primary btn-sm pr-1"
                   value=" فیلتر ">

        </form>

@endsection
