<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@yield('title', 'Admin')</title>

        <link rel="shortcut icon" href="{{ asset('resources/assets/image/favicon.png') }}" type="image/x-icon">

        <link rel="icon" href="{{ asset('resources/assets/image/favicon.png') }}" type="image/x-icon">

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/select2/dist/css/select2.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/dist/css/AdminLTE.min.css') }}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/plugins/iCheck/square/blue.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/dist/css/skins/_all-skins.min.css') }}">

        <!-- Morris chart -->
        <!--<link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/morris.js/morris.css') }}">-->
        <!-- jvectormap -->
        <!--<link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/jvectormap/jquery-jvectormap.css') }}">-->

        <!-- Date Picker -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <!-- Custom Style -->
        <link rel="stylesheet" href="{{ asset('resources/assets/backend/dist/css/style-dev.css') }}">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- Header -->
            <header class="main-header">
                @include('includes.header')
            </header>
            <!-- Header -->

            <!-- Sidebar -->
            <aside class="main-sidebar">
                @include('includes.sidebar')
            </aside>
            <!-- Sidebar -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                @yield('content')
                <!-- Main content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Footer -->
            @include('includes.footer')
            <!-- Footer -->

        </div>
        <!-- ./wrapper -->

        <!-- jQuery 3 -->
        <script src="{{ asset('resources/assets/backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="{{ asset('resources/assets/backend/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script>
        $.widget.bridge('uibutton', $.ui.button);
        </script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('resources/assets/backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- iCheck -->
        <script src="{{ asset('resources/assets/backend/plugins/iCheck/icheck.min.js') }}"></script>
        <script>
        $(function () {

            //Initialize Select2 Elements
            $('.select2').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
        </script>

        <!-- Morris.js charts -->
        <!--<script src="{{ asset('resources/assets/backend/bower_components/raphael/raphael.min.js') }}"></script>
        <script src="{{ asset('resources/assets/backend/bower_components/morris.js/morris.min.js') }}"></script>-->

        <!-- Sparkline -->
        <script src="{{ asset('resources/assets/backend/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>

        <!-- jvectormap -->
        <!--<script src="{{ asset('resources/assets/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('resources/assets/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>-->

        <!-- jQuery Knob Chart -->
        <script src="{{ asset('resources/assets/backend/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('resources/assets/backend/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
        <!-- daterangepicker -->
        <script src="{{ asset('resources/assets/backend/bower_components/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('resources/assets/backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
        <!-- datepicker -->
        <script src="{{ asset('resources/assets/backend/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="{{ asset('resources/assets/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset('resources/assets/backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('resources/assets/backend/bower_components/fastclick/lib/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('resources/assets/backend/dist/js/adminlte.min.js') }}"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <!--<script src="{{ asset('resources/assets/backend/dist/js/pages/dashboard.js') }}"></script>-->
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('resources/assets/backend/dist/js/demo.js') }}"></script>
        <!-- Custom Scripts -->
        @yield('custom-scripts')
        <!-- Custom Scripts -->
    </body>
</html>
