<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Telegram\Telegram;

class BetController extends Controller
{



    public function showAjax(Request $request)
    {
        $uid = Auth::user()->id;

        if ($request->reque == "add_task"){
            $name = $request->name;
            $type = $request->task_type;
            $date_send = date('Y-m-d H:i:s', strtotime($request->date_send));
            $days_send = $request->days_send;
            $time_send = $request->time_send;

            if (!$name){
                $name = date("d-m-Y");
            }

            $task_id = DB::table('tasks')->insertGetId([
                'user_id' => $uid,
                'name' => $name,
                'type' => $type,
                'days_send' => $days_send,
                'date_send' => $date_send,
                'time_send' => $time_send
            ]);

            if ($task_id){
                $resp["success"] = true;
                $resp["task_id"] = $task_id;
                $resp["name"] = $name;
            }
            else{
                $resp["success"] = false;
            }

            return json_encode($resp);
        }

        if ($request->reque == "del_task"){
            $resp["success"] = true;
            DB::table('tasks')
            ->where('id', $request->task_id)
            ->where('user_id', $uid)
            ->delete();
            return json_encode($resp);
        }

        if ($request->reque == "save_user_data"){
            $arrUp = array();
            foreach ($request->data as $field => $val){
                $arrUp[$field] = $val;
            }

            try{
                DB::table('users')
                ->where('id', $uid)
                ->update($arrUp);

                $resp["success"] = true;
                $resp["mess"] = "Сохранено успешно";
            } catch (\Exception $e) {
                $resp["success"] = false;
                $resp["err"] = "Ошибка, обратитесь к системному администратору.";
            }
            return json_encode($resp);
        }

        if ($request->reque == "send_tg_code"){
            $tg_id = $request->tg_id;
            //todo проверяем, не привязан ли tg к другому пользователю

            //проверяем, когда последний раз отправляли код для данного пользователя
            $log = DB::table('logs')
            ->where('uid', $uid)
            ->where('event', 1)
            ->where('dat', '>', DB::raw("CURRENT_TIMESTAMP - interval '1' HOUR"))
            ->first();
            
            //если прошел час, то отправляем снова
            if (!$log){
                //генерируем случайный код
                $kode = rand(1, 99999);

                //логируем действие
                $inf = [
                    'kode' => $kode,
                    'tg' => $tg_id
                ];
                $inf_txt = json_encode($inf);
                DB::table('logs')
                ->insert(
                    [
                        'uid' => $uid,
                        'event' => 1,
                        'inf' => $inf_txt
                    ]
                );

                //отправляем в телеграм
                $tg_id = $request->tg_id;
                $tg = new Telegram();

                //todo обработка ошибки - нет такого тг
                $tg->sendMessage($tg_id, "$kode - ваш код для привязки telegram. Код действителен 1 час.");
            }
            
            //отправляем ответ
            $resp["success"] = true;
            return json_encode($resp);
        }

        if ($request->reque == "check_tg_code"){
            $kode_user = (int)$request->code;

            //проверяем, когда последний раз отправляли код для данного пользователя
            $log = DB::table('logs')
            ->where('uid', $uid)
            ->where('event', 1)
            ->where('dat', '>', DB::raw("CURRENT_TIMESTAMP - interval '1' HOUR"))
            ->first();

            if (!$log){
                $resp["success"] = false;
                $resp["err"] = "Код не был отправлен или срок действия его вышел.";
                return json_encode($resp);
            }

            //логирование
            $inf = [
                'kode' => $kode_user
            ];
            $inf_txt = json_encode($inf);
            DB::table('logs')
            ->insert(
                [
                    'uid' => $uid,
                    'event' => 2,
                    'inf' => $inf_txt
                ]
            );

            //число проверок кода для данного пользователя
            $checks = DB::table('logs')
            ->where('uid', $uid)
            ->where('event', 2)
            ->where('dat', '>', DB::raw("CURRENT_TIMESTAMP - interval '1' HOUR"))
            ->count();

            if ($checks > 3){
                $resp["success"] = false;
                $resp["err"] = "Превышено число попыток. Пожалуйста, подождите, и попробуйте отправить код позже.";
                return json_encode($resp);
            }

            //совпадение кодов
            $kode_true = json_decode($log->inf, true)['kode'];
            if ($kode_true != $kode_user){
                $resp["success"] = false;
                $resp["err"] = "Код не совпадает.";
                return json_encode($resp);
            }

            //обновляем тг ид
            $tg = json_decode($log->inf, true)['tg'];
            DB::table('users')
            ->where('id', $uid)
            ->update(
                [
                    'tg' => $tg
                ]
            );

            $resp["success"] = true;
            return json_encode($resp);
        }

    }
}
