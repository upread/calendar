<x-app-layout>
<div class="wrap_task_form">
    <button id="show_add_task_modal" class="unic_button unic_green_button">Добавить новую задачу</button>
</div>
<br>
<h2>Список задач</h2>
<br>
<div class="wrap_tasks_list">
    @foreach ($tasks as $task)
    <div class="wrap_task">
        <div class="task_name">{{$task->name}}</div>
    </div>
    @endforeach
</div>
</x-app-layout>
