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

        if ($request->reque == "add_task"){

            if ($request->name == "ff"){
                $resp["success"] = true;
            }
            else{
                $resp["success"] = false;
            }

            return json_encode($resp);
        }
    }
}
