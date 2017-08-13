<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <style type="text/css">
            body { 
                margin: 20px;
                column-count: 2;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            }
            p {
                margin: 0 0 10px 0;
                padding: 10px;
            }
        </style>

    </head>
    <body>

        <div>
            @foreach ($tweets as $tweet)
                <div style="margin-bottom: 30px; -webkit-column-break-inside: avoid;">
                    <p style="background: #ff8787">{!! nl2br($tweet['text']) !!}</p>
                    @foreach ($tweet['parsed'] as $result)
                        <p style="background: #ffec99">{{ $result }}</p>
                    @endforeach
                </div>
            @endforeach
        </div>

    </body>
</html>
