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
            //проверяем, когда последний раз отправляли код для данного пользователя

            $log = DB::table('logs')
            ->where('uid', $uid)
            ->where('event', 1)
            ->where('dat', '>', DB::raw("CURRENT_TIMESTAMP - interval '1' HOUR"))
            ->first();
            if ($log){
                $resp["success"] = false;
                $resp["err"] = "Отправлять код можно не чаще одного раза в час!";
                return json_encode($resp);
            }

            //генерируем случайный код
            $kode = rand(1, 99999);

            //логируем действие
            $inf = [
                'kode' => $kode
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
            $tg->sendMessage($tg_id, "$kode - ваш код для привязки telegram. Код действителен 1 час.");

            //отправляем ответ
            $resp["success"] = true;
            return json_encode($resp);
        }

        if ($request->reque == "check_tg_code"){
            $resp["success"] = true;
            return json_encode($resp);
        }

    }
}
