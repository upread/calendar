<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class BanlanceController extends Controller
{


    public function show(Request $request, String $pageNotFound1 = "")
    {
        if ($pageNotFound1){
            $html = DB::table('html')
            ->where("chpu", $pageNotFound1)
            ->first();   
            
            if ($html){
                echo $html->name;
                return true;
            }
        }
        abort(404);
    }
}