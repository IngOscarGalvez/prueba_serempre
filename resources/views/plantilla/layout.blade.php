<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />



    <title>Prueba Serempre</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Charts.js -->
    <link href="{{ asset('plugins/chart.js/Chart.min.css') }}" rel="stylesheet">


    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">


</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">



    <div id="app">


        <navbar-component></navbar-component>

        @role('Admin')

            <app-component></app-component>
            <router-view :key="$route.fullPath"></router-view>

        @endrole

        @role('User')

            <app-component-user></app-component-user>
            <router-view :key="$route.fullPath"></router-view>

        @endrole

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
        {{--        <div class="float-right d-none d-sm-inline">--}}
        {{--            Anything you want--}}
        {{--        </div>--}}
        <!-- Default to the left -->
            <strong>Copyright &copy; 2021 <a href="/">Prueba Serempre</a>.</strong>  © All Rights Reserved.
        </footer>



    </div>




<!-- ./wrapper -->
</div>
<!-- REQUIRED SCRIPTS -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<!-- Charts.js -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>


</body>
</html>
