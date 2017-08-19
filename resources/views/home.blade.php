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

            <dev-map inline-template>
                <div>

                    <p v-if="activeStreet != ''" class="fill-darker p-05">@{{ activeStreet }}</p>
                    <div id="map" style="margin:30px auto; width: 80%; height: 600px;"></div>

                    <div style="width: 80%; margin: 0 auto;">
                        @foreach ($streets as $street)
                            <div>
                                <p class="fill-darker p-05">
                                    <span style="width: 350px; display: inline-block">{{ $street->name }}</span>
                                    <span style="width: 230px; display: inline-block">Set Point</span>
                                    <span @click="setPath('{{ $street->slug }}')" style="width: 230px; display: inline-block">Set Path</span>
                                </p>
                            </div>
                        @endforeach

                    </div>
                </div>
            </dev-map>

            {{-- @foreach ($tweets as $tweet)
                <div style="margin-bottom: 30px; -webkit-column-break-inside: avoid;">
                    <p class="fill-darker p-05">Radar on {{ $tweet->date->format('l, jS F Y') }}</p>
                    @foreach ($tweet->streets as $street)
                        <p class="fill-dark p-05">{{ $street->name }}</p>
                    @endforeach
                </div>
            @endforeach --}}
        </div>


        <script type="text/javascript" src="{{ asset('js/app.js' )}}"></script>
    </body>
</html>
