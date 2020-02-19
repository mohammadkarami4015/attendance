@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="personal_code">کد پرسنلی یا کد ملی:</label>
                        <input type="text" name="personal_code" id="personal_code" class="form-control"
                               onkeyup="search()">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="section_id">بخش</label>
                        <select type="text" name="section_id" id="section_id" class="form-control" onchange="">
                            <option value="" selected>همه بخش ها</option>

                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="orderBy">مرتب سازی بر اساس</label>
                        <select name="orderBy" id="orderBy" class="form-control" onchange="">
                            <option value="personal_code">کد پرسنلی</option>
                            <option value="family">نام خانوادگی</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th class="text-danger"> نام و نام خانوادگی</th>
                    <th class="text-danger">کد پرسنلی</th>
                    <th class="text-danger">کد ملی</th>
                    <th class="text-danger">گروه کاری</th>
                    <th class="text-danger">شیفت مربوطه</th>
                    <th class="text-danger">نقش</th>
                    <th class="text-danger">تنظیمات</th>
                </tr>
                </tbody>
                <tbody id="users">
                     @foreach($users as $user)
                    <tr>
                        <td>
                            <a title="نمایش جزيیات"
                               href="{{route('users.show',$user->id)}}"> {{\App\Helpers\Name::userFullName($user)}}</a>
                        </td>
                        <td>{{$user->personal_code}}</td>
                        <td>{{$user->national_code}}</td>
                        <td>{{$user->unit->title}}</td>
                        <td> {{($user->unit->getCurrentShift()->title)}}</td>
                        <td> {{($user->unit->getCurrentShift()->title)}}</td>
                        <td>
                            <form onsubmit="return confirm('آیا مایل به حذف این کاربر هستید؟');"
                                  method="POST" action="{{route('users.destroy',$user->id)}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}

                                <a href="{{route('users.edit',$user->id)}}" class="btn btn-primary">ویرایش</a>
                                <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
        <div style="margin-right: 40%">
            {{$users->appends(request()->all())->links()}}
        </div>
    </div>
    <script>
        function search() {

            var personal_code = document.getElementById('personal_code').value;

            var url = '{{URL::asset('admin/usersSearch')}}' + '?';
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('users').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url + 'personal_code=' + personal_code, true);
            xhttp.send();
        }
    </script>

@endsection
