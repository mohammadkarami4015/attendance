@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header">
            <div class="box-body">
                <div class="row">

                    <form role="form" method="post" action="{{route('roles.store')}}">
                        @csrf

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="name" class="col-sm-12 col-sm-offset-0 ">عنوان نقش</label>
                                    <input type="" class="form-control col-sm-12 col-sm-offset-0" id="name" placeholder="عنوان نقش" name="title">
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" id="save" name="save">ذخیره</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="box-body">
            <table id="example2" class="table table-bordered table-hover">
                <tbody>
                <tr>
                    <th class="text-danger col-sm-1">ردیف</th>
                    <th class="text-danger col-sm-5">عنوان نقش</th>
                    <th class="text-danger"> حذف</th>
                </tr>
                </tbody>
                <tbody id="users">
                @foreach($roles as $role)
                    <tr>
                        <td>{{$index}}</td>
                        <td>
                            <form action="{{route('roles.update',$role->id)}}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="text" class="form-control col-sm-9" name="title"
                                       value="{{ $role->title }}"
                                       onchange="updateRoleTitle(this.value, {{ $role->id }})">
                                <button type="submit" class="btn btn-info btn-sm col-sm-3" id="update" name="update">ویرایش</button>
                            </form>
                        </td>
                        <td>
                            <form onsubmit="return confirm('آیا مایل به حذف این نقش هستید؟');"
                                  method="POST" action="/roles/{{$role->id}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                                <button type="submit" class="btn btn-danger btn-sm" id="delete" name="delete">حذف</button>
                            </form>
                        </td>
                    </tr>
                    <input type="hidden" {{$index+=1}}>
                @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

@endsection
