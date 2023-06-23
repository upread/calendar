<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <base href="{{env('APP_URL')}}" />
        <title>{{$name}}</title>
        @include('components.head')
    </head>
    <body>
        <div id="preloader">
            <div class="lds-hourglass"></div>
        </div>
        <div id="wrap_index">
            <div id="slogan"><a href="index.php">Умный сервис напоминаний</a></div>
            <div class="body_html">{{$txt}}</div>
            <div id="main_index">
            @include('components.footer')
        </div>
    </body>
</html>
</html>