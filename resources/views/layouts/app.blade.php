<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <base href="{{env('APP_URL')}}" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href='/css/sweetalert2.min.css'>
        <link rel="stylesheet" href="/css/style.css?ver=3">
        <script src="/js/jquery-3.6.0.min.js"></script>
        <script src="/js/sweetalert2.all.min.js"></script>
        <script src="/js/main.js?ver=3"></script>
    </head>
    <body>
        <div class="wrapper">
            @include('components.header')
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
