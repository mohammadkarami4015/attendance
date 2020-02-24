@extends('layouts.master')
@section('title')
    ویرایش عنوان شیفت کاری
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form method="post"
                      action="{{route('roles.update',$role)}}">
                    {{csrf_field()}}
                    {{method_field('patch')}}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title"><span class="text-danger">عنوان</span></label>
                            <input name="title" type="text" class="form-control" id="title" value="{{$role->title}}">
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="form-group">
                            <label> انتخاب سطوح دسترسی </label>
                            <select required name="permissions[]" class="form-control select2 select2-hidden-accessible"
                                    multiple
                                    data-placeholder="سطوح دسترسی" style="width: 100%;" tabindex=""
                                    aria-hidden="true">
                                @foreach($permissions as $permission)
                                    <option {{in_array($permission->id,$role->permissions->pluck('id')->toArray()) ? 'selected' : ''}} value="{{$permission->id}}">{{$permission->label}} </option>
                                @endforeach
                            </select>
                            <a onclick="selectAll()" class="selectAll btn-sm btn-primary ">انتخاب همه</a>
                            <a onclick="Clear()" class="clear btn-sm btn-primary">حذف همه</a>
                        </div>

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{route('roles.index')}}" class="btn btn-danger">بازگشت</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
<script >
    function selectAll() {
        $exampleMulti = $(".select2").select2();
        $exampleMulti.val([{{$permission_index}}]).trigger("change");

    }

    function Clear() {
        $exampleMulti = $(".select2").select2();
        $exampleMulti.val(null).trigger("change");
    }

</script>

