<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Prueba Serempre</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}" />


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <link rel="stylesheet" href="flogin/css/bundle.css" type="text/css">
    <link rel="stylesheet" href="flogin/css/app.min.css" type="text/css">
    <link rel="stylesheet" href="flogin/css/custom.css" type="text/css">



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}


</head>

<body class="bg-white h-100-vh p-t-0">
    <div id="app">
        <main>
            @yield('content')
        </main>
    </div>
</body>

</html>
