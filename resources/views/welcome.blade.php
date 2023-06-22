<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="">
        <base href="{{env('APP_URL')}}" />
        <title>Умный сервис напоминаний</title>
        @include('components.head')
    </head>
    <body>
        <div id="preloader">
            <div class="lds-hourglass"></div>
        </div>
        <div id="wrap_index">
            <div id="slogan">Умный сервис напоминаний</div>
            <div id="main_index">
                <div id="menu_head_index">
                    @auth
                    <div class="menu_head_index_item">
                        <a href="dashboard">Задачи</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="profile">Профиль</a>
                    </div>
                    @endauth
                    @guest
                    <div class="menu_head_index_item">
                        <a href="login">Вход</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="register">Регистрация</a>
                    </div>
                    @endguest
                </div>
                <div class="wrap_logo_idex">
                    <img src="img/logo.png" />
                </div>
            </div>
            <div id="desc_service">
            {{ __('Just three steps') }}:
                <ol>
                    <li><a href="register">Зарегистрируйтесь</a> или <a href="login">войдите</a></li>
                    <li>Запустите телеграм бот <a href="https://t.me/termRemindBot">@termRemindBot</a></li>
                    <li>Подтвердите телеграм в профиле</li>
                </ol>
                И все! Можно создавать задачи, в ваш телеграм будут приходить оповещения о них.
            </div>
            @include('components.footer')
        </div>
    </body>
</html>
</html>
