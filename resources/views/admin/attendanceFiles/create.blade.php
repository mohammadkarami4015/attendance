@extends('layouts.master')
@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">بارگذاری فایل حضور و غیاب کارکنان</h3>
        </div>

        <div class="box-body">
            <form action="{{route('attendanceFiles.store')}}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-3">
                            <label for="file">
                                <input type="file" name="attendanceFile" id="attendanceFile" onchange="previewFile()">
                            </label>
                        </div>
                        <div class="col-sm-3">
                            <input type="date" name="file_date" id="file_date">
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">ثبت</button>

                    </div>
                </div>
            </form>
            <button class="btn btn-primary" onclick="previewFile()">پردازش فایل</button>
        </div>
    </div>


    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">نمایش فایل</h3>
        </div>

        <div class="box-body">
            <div class="form-group">
                <div class="col-auto" id="attendanceFilePreview">
                    @if(!is_null($file_content))
                        {{$file_content}}
                    @endif
                </div>

            </div>

        </div>
    </div>

    <script type="text/javascript">

        function previewFile() {

            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("attendanceFile").files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById("attendanceFilePreview").src = oFREvent.target.result;
            };
            confirm('hello');
        }

    </script>
@endsection
