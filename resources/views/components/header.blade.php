<div id="header">
    <div id="wrap_head_mnu">
        <div class="sin_head_mnu"><a href="/dashboard">Задачи</a></div>
        <div class="sin_head_mnu"><a href="/profile">Профиль</a></div>
        <div class="sin_head_mnu">
            <a href="/"></a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Выход</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
            </form>
        </div>
    </div>
    <div id="wrap_logo">
        <a href="/">
            <img class="logo" src="/img/logo.png" alt="" />
        </a>
    </div>
</div>
