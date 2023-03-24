$(function() {
    $( "#show_add_task_modal" ).click(function() {
        Swal.fire({
            title: 'Добавление новой задачи',
            html:
            'Название: <input type="text" id="task_name" placeholder="Название"><br>' +
            'Тип: <select id="task_type">' +
            '<option value="1" selected>Одноразовая</option>' +
            '<option value="2" selected>Периодическая</option>' +
            '</select><br>'+
            'Время выполнения: <input type="datetime-local">'
            ,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Сохранить',
            cancelButtonText: 'Отмена',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                return fetch(`/ajax`, {
                    method: 'post',
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
                      },
                    body: JSON.stringify({
                        'reque': 'add_task',
                        'name':  $('#task_name').val()
                    }),
                })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                    return response.json();
                  })
                  .then(data=>{
                    if (data["success"] != true){
                        throw new Error("Ошибка")
                    }
                  })
                  .catch(error => {
                    Swal.showValidationMessage(
                      `Request failed: ${error}`
                    )
                  })
              },
              allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
               if (result.isConfirmed) {
                        Swal.fire(
                            'Успешно',
                            'Задача успешно добавлена',
                            'success'
                          )
                    }

                });

    });





});
