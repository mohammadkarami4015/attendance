@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">تعریف نوع مرخصی جدید</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="post" action="{{route('vacationType.store')}}">
            @csrf
            <div class="box-body">
                <div class="col-sm-5">
                    <div class="form-group">
                        <label for="name">عنوان مرخصی</label>
                        <input type="" class="form-control" id="name" placeholder="عنوان مرخصی" name="title">
                    </div>

                </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary">ذخیره</button>
            </div>
        </form>
    </div>

@endsection
