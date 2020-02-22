@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="personal_code">جستجو </label>
                        <input type="text" name="personal_code" id="code" class="form-control"
                               onkeyup="search()" placeholder="نام،نام خانوادگی،کدملی،کدپرسنلی">
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="section_id">گروه کاری</label>
                        <select type="text" name="unit_id" id="unit_id" multiple
                                class="form-control select2 select2-container"
                                onchange="filterByUnit(this.value)">
                            <option value="0"> همه گروه ها</option>
                            @foreach($units as $unit)
                                <option value="{{$unit->id}}">{{$unit->title}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label for="section_id">شیفت کاری</label>
                        <select type="text" name="shift_id" id="shift_id" multiple
                                class="form-control select2 select2-container"
                                onchange="filterByShift(this.value)">
                            @foreach($shifts as $shift)
                                <option value="{{$shift->id}}">{{$shift->title}}</option>
                            @endforeach

                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
                    <label for="">تعداد کل کاربران : </label>
                    <label for="">{{$users->total()}}</label>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th class="text-danger"> ردیف</th>
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
                               href="{{route('users.show',$user)}}"> {{\App\Helpers\Name::userFullName($user)}}</a>
                        </td>
                        <td>{{$user->personal_code}}</td>
                        <td>{{$user->national_code}}</td>
                        <td> {{optional($user->unit)->title}}</td>
                        <td> {{optional(optional($user->unit)->getCurrentShift())->title}}</td>
                        <td> تعیین نشده</td>
                        <td>
                            <form onsubmit="return confirm('آیا مایل به حذف این کاربر هستید؟');"
                                  method="POST" action="{{route('users.destroy',$user)}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}

                                <a href="{{route('users.edit',$user)}}" class="btn btn-primary">ویرایش</a>
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
            var data = document.getElementById('code').value;
            var url = '{{route('users.searchByCode')}}' + '?';
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('users').innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url + 'data=' + data, true);
            xhttp.send();
        }


        function filterByUnit() {
            var values = $('#unit_id').val();
            var url = '{{route('users.filterByUnit')}}' + '?';
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('users').innerHTML = this.responseText;
                }
            };

            xhttp.open("GET", url + 'unit_id=' + values, true);
            xhttp.send();
        }

        function filterByShift() {
            var values = $('#shift_id').val();
            var url = '{{route('users.filterByShift')}}' + '?';
            var xhttp = new XMLHttpRequest();

            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('users').innerHTML = this.responseText;
                }
            };

            xhttp.open("GET", url + 'shift_id=' + values, true);
            xhttp.send();
        }
    </script>

@endsection
