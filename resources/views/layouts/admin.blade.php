<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin | RadarVLC</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>

        <div id="app" v-cloak>
            <div id="admin">
                @yield('content')
            </div>
        </div>

        <script type="text/javascript" src="{{ asset('js/app.js' )}}"></script>
    </body>
</html>