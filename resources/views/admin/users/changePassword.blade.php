@extends('layouts.master')
@section('title')
    تغییر رمز عبور کاربران
@endsection

@section('content')
    <div class="row">

        <div class="col-sm-6">
            <div class="box box-primary">
                <form method="post"
                      enctype="multipart/form-data"
                      action="{{ route('users.changePassword')}}">
                    @csrf
                    @method('PATCH')
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user_id" class="control-label"><span
                                    class="text-danger">اتنخاب کاربر</span></label>
                            <select name="user_id" class="form-control select2 select2-container" type="text" required id="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{\App\Helpers\Name::userFullName($user)}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="newPassword" class="control-label text-danger">رمز عبور جدید </label>
                                    <input name="password"  class="form-control" required
                                           id="newPassword"
                                           placeholder="رمز عبور جدید">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="box-footer">
                        <div class="form-group">
                            <button type="submit" value="ویرایش" class="btn btn-primary">ویرایش</button>
                            <a href="{{route('users.index')}}" class="btn btn-danger">بازگشت</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

