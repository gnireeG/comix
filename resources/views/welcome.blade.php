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
            <comix-navbar></comix-navbar>
            <transition name="fade">
                <router-view></router-view>
            </transition>
            <comix-alert></comix-alert>
        </div>
        <style>
            .fade-enter-active {
                transition: all .5s ease-out;
                }
            .fade-enter, .fade-leave-to{
                margin-left: -300px;
                opacity: 0;
                /* transform-origin: top left;
                transform: scale(0); */
            }
        </style>
    </body>
</html>
