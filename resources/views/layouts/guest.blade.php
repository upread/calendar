<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <base href="{{env('APP_URL')}}" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>
    <body>
        <div class="">
            {{ $slot }}
        </div>
    </body>
</html>
