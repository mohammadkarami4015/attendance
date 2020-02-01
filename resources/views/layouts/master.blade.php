<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/dist/css/bootstrap-theme.css">
    <link rel="stylesheet" href="/dist/css/persian-datepicker-0.4.5.min.css"/>
    <link rel="stylesheet" href="/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">


    <!-- Bootstrap rtl -->
    <link rel="stylesheet" href="/dist/css/rtl.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="/bower_components/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="/plugins/timepicker/bootstrap-timepicker.min.css">


    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.css">
@yield('style')
<!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <![endif]-->
    <style>
        .flex-checkbox {
            display: inline-flex;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .flex-checkbox .form-group .checkbox {
            width: 200px;
        }
    </style>
    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
        <!-- Logo -->
        <a href="index2.html" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini">پنل</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>سیستم حضور و غیاب</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>


            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">


                    <li class="dropdown notifications-menu">
                        {{--                        <a href="{{route('demand.child')}}" class="dropdown-toggle">--}}
                        {{--                            <i id="test" class="fa fa-envelope"></i>--}}
                        {{--                            <span class="label label-success">{{$newDemand}}</span>--}}
                        {{--                        </a>--}}
                    </li>


                    <!-- Tasks: style can be found in dropdown.less -->

                    <li class="dropdown tasks-menu">
                        {{--                        <a href="{{route('demand.referDemand')}}" class="dropdown-toggle">--}}
                        {{--                            <i class="fa fa-envelope"></i>--}}
                        {{--                            <span class="label label-danger">{{$referDemand}}</span>--}}
                        {{--                        </a>--}}
                    </li>

                    <li class="dropdown tasks-menu">
                    {{--                        <a href="{{route('demand.allFinalConfirm')}}" class="dropdown-toggle">--}}
                    {{--                            <i class="fa fa-envelope"></i>--}}
                    {{--                            <span class="label label-info">@if($finalConfirm > 0)--}}
                    {{--                                    جدید--}}
                    {{--                                @endif</span></a>
                    {{--</li>--}}
                    <!-- User Account: style can be found in dropdown.less -->

                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            @if(auth()->check())
                                {{--                                <span class="hidden-xs">{{\App\Helpers\NameFormat::userfullName(auth()->user())}}</span>--}}
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->

                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">

                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="/" class="btn btn-default btn-flat">پروفایل</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        خروج</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                    <!-- Control Sidebar Toggle Button -->
                    <li>

                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- right side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu" data-widget="tree">

                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span> کاربران</span>
                        <span class="pull-left-container">
                            <i class="fa fa-angle-right pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('users.index')}} ">لیست کاربران</a></li>
                        <li><a href="{{ route('users.create') }}">ثبت کاربر جدید</a></li>
                        <li><a href="">تغییر رمز عبور کاربران </a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('units.index')}}"><i class="fa fa-link"></i> <span>گروه های کاری</span>

                    </a>
                </li>


                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span>بخش مدیریت</span>
                        <span class="pull-left-container">
                            <i class="fa fa-angle-right pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('userVacation.index')}} ">درخواست های مرخصی</a></li>

                        <li><a href="{{ route('vacationType.index') }}"> تعریف انواع مرخصی</a></li>
                        <li><a href="{{ route('specialVacation.index') }}"> مرخصی های خاص</a></li>
                        <li><a href="{{ route('attendanceFiles.index') }}"> حضور و غیاب</a></li>
                        <li><a href="{{ route('roles.index') }}">تعریف نقش ها</a></li>
                        <li><a href="{{ route('userRoles.index') }}">اختصاص نقش به کاربر</a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="#"><i class="fa fa-link"></i> <span> درخواست مرخصی/ ماموریت</span>
                        <span class="pull-left-container">
                            <i class="fa fa-angle-right pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{ route('demandVacation.index')}} ">لیست درخواست های من</a></li>
                        <li><a href="{{ route('demandVacation.create') }}">ثبت درخواست جدید</a></li>
                    </ul>
                </li>


            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <small>
                    @yield('description')
                    @include('partials.error')
                    @include('partials.flash')
                </small>
            </h1>

        </section>

        <!-- Main content -->
        <section class="content container-fluid">

            @yield('content')

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer text-left">
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">

                <!-- /.control-sidebar-menu -->


                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->

            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
    immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->
<script src="{{asset('/js/jquery-1.10.2.js')}}"></script>
<script src="{{asset('/js/jquery-ui-1.10.3.js')}}"></script>
<script src="{{asset('/dist/js/persian-date-0.1.8.min.js')}}"></script>
<script src="{{asset('/dist/js/persian-datepicker-0.4.5.min.js')}}"></script>
<script src="{{asset('/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{asset('/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
@yield('script')
<script>
    $(document).ready(function () {
        $('#insurance_start').pDatepicker({
            autoClose: true,
            initialValue: false,
            format: 'YYYY/MM/DD',
        });
        $('#startWorkDate').persianDatepicker({
            autoClose: true,
            initialValue: false,
            format: 'YYYY/MM/DD',
        });

        $('.tarikh').persianDatepicker({
            autoClose: true,
            initialValue: false,
            format:'HH:mm',
            onlyTimePicker: true,
            timePicker24Hour:true,
            timeFormat:'HH:ii'

    })
        ;

        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2({
                dir:"rtl"
            });
            $('.Select2').val(null).trigger('change');

        });

        //Timepicker
        $('.timepicker').timepicker({
            showInputs: false,
        })
    });

</script>
<script src="{{ asset('/js/app.js') }}"></script>
<script src="{{ asset('/js/all.js') }}"></script>

</body>
</html>
