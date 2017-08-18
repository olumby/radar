<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>RadarVLC</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,400,600,700" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>

        <div id="app" v-cloak>

            <radar-map></radar-map>

            @foreach ($tweets as $tweet)
                <div style="margin-bottom: 30px; -webkit-column-break-inside: avoid;">
                    <p class="fill-darker p-05">Radar on {{ $tweet->date->format('l, jS F Y') }}</p>
                    @foreach ($tweet->streets as $street)
                        <p class="fill-dark p-05">{{ $street->name }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>


        <script type="text/javascript" src="{{ asset('js/app.js' )}}"></script>
    </body>
</html>
