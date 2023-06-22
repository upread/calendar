<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <base href="{{env('APP_URL')}}" />
        <title>{{ config('app.name', 'Laravel') }}</title>
        @include('components.head')
    </head>
    <body>
        <div class="wrapper" style="display: flex;flex-direction: column; min-height: calc(100vh - 40px);">
            @include('components.header')
            <main>
                {{ $slot }}
            </main>
            @include('components.footer')
        </div>
        
    </body>
</html>
