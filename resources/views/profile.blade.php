<x-app-layout>
<h2>Ваш профиль</h2>
<br>
<div class="wrap_flex">
<div class="part_in_flex">
        <label>Имя</label>
        <input type="text" class="user_data" data-name="name" value="{{$info->name}}" />
    </div>
    <div class="part_in_flex">
        <label>telegram Id</label>
        <input type="number" class="user_data" data-name="tg" value="{{$info->tg}}" />
    </div>

    <button id="save_profile" class="unic_button unic_blue_button">Сохранить</button>
</div>
</x-app-layout>
