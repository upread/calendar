<x-app-layout>
<h2>Ваш профиль</h2>
<br>
<div class="wrap_flex">
    <div class="part_in_flex">
        <label>Имя</label>
        <input type="text" class="user_data inp" data-name="name" value="{{$info->name}}" />
    </div>

    <button id="save_profile" class="unic_button unic_blue_button">Сохранить изменения</button>
</div>




<div class="wrap_flex">
    <div class="part_in_flex">
        <div>Наш бот: <a href="https://t.me/termRemindBot">@termRemindBot</a></div>
        <label>Telegram Id</label>
        <input type="number" class="inp" id="tg_id" value="{{$info->tg}}" />
        <button id="save_tg" class="unic_button unic_blue_button">Подтвердить Telegram Id</button>
    </div>


</div>
</x-app-layout>
