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
            <footer>
                <div id="menu_foot_index">
                    <div class="menu_head_index_item">
                        <a href="#">Правила</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="#">Поддержка</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="#">Политика конфиденциальности</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="#">Пользовательское соглашение</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="#">FAQ</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="#">Правила</a>
                    </div>
                    <div class="menu_head_index_item">
                        <a href="#">О проекте</a>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
</html>
