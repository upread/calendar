<x-app-layout>
<div class="wrap_task_form">
    <button id="show_add_task_modal" class="unic_button unic_green_button">Добавить новую задачу</button>
</div>
<br>
<h2>Список задач</h2>
<br>
<div class="wrap_tasks_list">
    <div class="thead">
        <div class="td">Название</div>
        <div class="td">Тип</div>
        <div class="td">Действие</div>
    </div>
    @foreach ($tasks as $task)
    <div class="wrap_task" id="wrap_task{{$task->id}}">
        <div class="task_name td">{{$task->name}}</div>
        <div class="td">{{$task->type}}</div>
        <div class="td">
            <button class="button del_task" data-id="{{$task->id}}">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    @endforeach
</div>
</x-app-layout>
