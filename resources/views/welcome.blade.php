<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>COMIX</title>

        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            <comix-wrapper>
                <comix-navbar></comix-navbar>
                    <router-view></router-view>
                <comix-alert></comix-alert>
            </comix-wrapper>
            <comix-music-player></comix-music-player>
        </div>
        
    </body>
</html>
