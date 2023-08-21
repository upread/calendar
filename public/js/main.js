$(function() {

  function conv_date_to_local(source_date){
    let arr = source_date.split(" ");
    let arr1 = arr[0].split(":");
    let arr2 = arr[1].split(".");
    let local_date = arr2[2]+"-"+arr2[1]+"-"+arr2[0]+"T"+arr1[0]+":"+arr1[1];
    return local_date;
  }

  function conv_date_to_time(source_date){
    let arr = source_date.split(":");
    let local_time = arr[0]+":"+arr[1];
    return local_time;
  }

    function add_task(task_id, task_name, task_type){
        let div = `<div class="wrap_task" id="wrap_task${task_id}">`;
        div += `<div class="task_name td">${task_name}</div>`;
        div += `<div class="td">${task_type}</div>`;
        div += `<div class="td"></div>`;
        div += `<div class="td">
        <button title="Изменить" class="button save_task" data-id="${task_id}" data-name="${task_name}">
        <i class="fa fa-edit" aria-hidden="true"></i>
        </button>
        <button title="Удалить" class="button del_task" data-id="${task_id}">
        <i class="fa fa-trash" aria-hidden="true"></i>
        </button></div>`;
        div += `</div>`;
        $(".wrap_tasks_list .thead").after(div);
    }

    function del_task(task_id){
        $("#wrap_task"+task_id).remove();
    }

    /*
    var html_mod = "";
    function get_modal_raw(){
      $.post("/ajax", {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        reque: "get_modal_html"
    }).done(function(data) {
        var obj = JSON.parse(data);
        if (obj["success"]){
          html_mod = obj["mess"];
        }
    });
    }
    */


    $( "#show_add_task_modal" ).click(function() {
        Swal.fire({
            title: "Добавить новую задачу",
            html:
            '<div class="modal_row"><label for="task_name">Название:</label><input type="text" id="task_name" placeholder="Название"></div>' +
            '<div class="modal_row"><label for="task_type">Тип:</label><select id="task_type">' +
            '<option value="1" selected>Разовая</option>' +
            '<option value="2">Повторяемая</option>' +
            '</select></div>'+
            '<div class="modal_row" id="time_one"><label for="task_date_send">Время выполнения:</label><input type="datetime-local" id="task_date_send"></div>'+
            '<div class="modal_row" id="time_repeat"><div><label for="task_days_send">Дни выполнения:</label><select id="task_days_send">'+
            '<option value="1" selected>Понедельник</option>' +
            '<option value="2">Вторник</option>' +
            '<option value="3">Среда</option>' +
            '<option value="4">Четверг</option>' +
            '<option value="5">Пятница</option>' +
            '<option value="6">Суббота</option>' +
            '<option value="7">Воскресенье</option>' +
            '</select>'+
            '</div>'+
            '<div><label for="task_time_send">Время выполнения:</label><input type="time" id="task_time_send"></div></div>'
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
                        'name':  $('#task_name').val(),
                        'date_send':  $('#task_date_send').val(),
                        'task_type':  $('#task_type').val(),
                        'days_send':  $('#task_days_send').val(),
                        'time_send':  $('#task_time_send').val()
                    }),
                })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                    return response.json();
                  })
                  .then(data=>{
                    if (!data["success"]){
                        throw new Error("Ошибка")
                    }
                    else{
                        add_task(data["task_id"], data["name"], $('#task_type option:selected').text());
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
                        );

                    }

                });
    });

    $( ".save_task" ).click(function() {
      let task_name = $(this).data("name");


      Swal.fire({
          title: "Изменить задачу",
          html:
          `<div class="modal_row"><label for="task_name">Название:</label><input type="text" id="task_name" placeholder="Название" value="${task_name}"></div>` +
          '<div class="modal_row"><label for="task_type">Тип:</label>'+
          '<select id="task_type">' +
          '<option value="1" selected>Разовая</option>' +
          '<option value="2">Повторяемая</option>' +
          '</select></div>'+
          '<div class="modal_row" id="time_one"><label for="task_date_send">Время выполнения:</label><input type="datetime-local" id="task_date_send"></div>'+
          '<div class="modal_row" id="time_repeat"><div><label for="task_days_send">Дни выполнения:</label><select id="task_days_send">'+
          '<option value="1" selected>Понедельник</option>' +
          '<option value="2">Вторник</option>' +
          '<option value="3">Среда</option>' +
          '<option value="4">Четверг</option>' +
          '<option value="5">Пятница</option>' +
          '<option value="6">Суббота</option>' +
          '<option value="7">Воскресенье</option>' +
          '</select>'+
          '</div>'+
          '<div><label for="task_time_send">Время выполнения:</label><input type="time" id="task_time_send"></div></div>'
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
                      'reque': 'edit_task',
                      'name':  $('#task_name').val(),
                      'date_send':  $('#task_date_send').val(),
                      'task_type':  $('#task_type').val(),
                      'days_send':  $('#task_days_send').val(),
                      'time_send':  $('#task_time_send').val()
                  }),
              })
                .then(response => {
                  if (!response.ok) {
                    throw new Error(response.statusText)
                  }
                  return response.json();
                })
                .then(data=>{
                  if (!data["success"]){
                      throw new Error("Ошибка")
                  }
                  else{
                      add_task(data["task_id"], data["name"], $('#task_type option:selected').text());
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
                      );

                  }
      });

      let type = $(this).data("type");
      $("#task_type").val(type).change();

      if (type == 1){      
        $("#task_date_send").val(conv_date_to_local($(this).data("date_send")));
      }
      if (type == 2){
        $("#task_days_send").val($(this).data("days_send"));
        $("#task_time_send").val(conv_date_to_time($(this).data("time_send")));
      }

     // alert(type);
  });


    $(".wrap_tasks_list").on('click', '.del_task', function(e){
        let task_id = $(this).data('id');

        Swal.fire({
            title: 'Вы уверены, что хотите удалить задачу?',
            showCancelButton: true,
            confirmButtonText: 'Удалить',
            confirmButtonColor: 'red',
            cancelButtonColor: 'green',
            cancelButtonText: 'Отмена',
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
                        'reque': 'del_task',
                        'task_id':  task_id
                    }),
                })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                    return response.json();
                  })
                  .then(data=>{
                    if (!data["success"]){
                        throw new Error("Ошибка")
                    }
                    else{
                        del_task(task_id);
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
                            'Задача успешно удалена',
                            'success'
                        );

                    }

                });
    });

    $("body").on('change', '#task_type', function(e){
        let task_type = $(this).val();
        if (task_type == 1){
            $("#time_repeat").css("display", "none");
            $("#time_one").css("display", "flex");
        }
        else{
            $("#time_one").css("display", "none");
            $("#time_repeat").css("display", "flex");
        }
    });

    $( "#save_profile" ).click(function() {
      let data = {};

      $(".user_data").each(function(idx, item) {
        data[$(item).data("name")] = $(item).val();
      });


      $.post("/ajax", {
        "_token": $('meta[name="csrf-token"]').attr('content'),
        "reque": "save_user_data",
        "data": data
      }).done(function(data) {
        var obj = JSON.parse(data);
        if (obj["success"]){
            Swal.fire(
                'Успешно',
                obj["mess"],
                'success'
            );
        }
        else{
            Swal.fire(
                'Ошибка',
                obj["err"],
                'error'
            );
        }
      });
    });

    $( "#save_tg" ).click(function() {
        //отправляем код, получаем ответ
        let tg_id = $("#tg_id").val();

        $.post("/ajax", {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "reque": "send_tg_code",
            "tg_id": tg_id
          }).done(function(data) {
            var obj = JSON.parse(data);
            if (obj["success"]){

        Swal.fire({
            title: "Привязка телеграма",
            html: '<div><input type="number" id="code_tg"/><br>'
            +'Вам в telegram отправлен код подтверждения, введите его. Если код не приходит, то убедитесь, что вы запустили бота.'
            + '</div>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Подтвердить',
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
                        'reque': 'check_tg_code',
                        'code':  $('#code_tg').val()
                    }),
                })
                  .then(response => {
                    if (!response.ok) {
                      throw new Error(response.statusText)
                    }
                    return response.json();
                  })
                  .then(data=>{
                    if (!data["success"]){
                        throw new Error(data["err"]);
                    }
                  })
                  .catch(error => {
                    Swal.showValidationMessage(
                      `${error}`
                    )
                  })
              },
              allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
               if (result.isConfirmed) {
                        Swal.fire(
                            'Успешно',
                            'Telegram успешно подтвержден',
                            'success'
                        );

                    }

                });        
          }
          else{
            Swal.fire(
              'Ошибка',
              obj["err"],
              'error'
          );
          }
        });
    });

    setTimeout(() => {
        $("#preloader").css('display', 'none');
    }, 10000);

});

$(window).on('load', function () {
    $("#preloader").css('display', 'none');
});
