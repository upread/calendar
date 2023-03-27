<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class BetController extends Controller
{



    public function showAjax(Request $request)
    {
        $uid = Auth::user()->id;

        if ($request->reque == "add_task"){
            $name = $request->name;
            if (!$name){
                $name = date("d-m-Y");
            }

            $task_id = DB::table('tasks')->insertGetId([
                'user_id' => $uid,
                'name' => $name
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
    }
}
