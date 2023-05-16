<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    function getNameDay($day){
        $name = "";
        $days = array("0", "Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье");
        $num_day = (int)$day;
        if ($num_day < 8){
            $name = $days[$num_day];
        }

        return $name;
    }

    function dateToStr($date){
        $str = date("H:i d.m.Y", strtotime($date));  
        return $str;
        /*
        $parts1 = explode(" ", $date);

        if (count($parts1) == 2){
            $parts2 = explode("-", $parts1[0]);
            $parts3 = explode(":", $parts1[1]);

            if (count($parts2) == 3 && count($parts2) == 3){
                $str = $parts3[0].":".$parts3[1]." ".$parts2[2].".".$parts2[1].".".$parts2[0];
            }
        }
        */
    }
}
