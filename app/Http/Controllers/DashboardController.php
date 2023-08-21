<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Telegram\Telegram;

class DashboardController extends Controller
{
    function getUserTasks($user_id){
        return DB::table('tasks')
        ->where('user_id', $user_id)
        ->orderBy('id', 'DESC')
        ->get();
    }

    public function showDashboard(Request $request)
    {
        $user_id = Auth::user()->id;

        $tasks = array();
        $tasks_raw = $this->getUserTasks($user_id);

        foreach ($tasks_raw as $task){
            $dat = $this->dateToStr($task->date_send);
            $tim = $task->time_send;
            $days_send = $task->days_send;
            $days_send_name = $this->getNameDay($task->days_send);
         
            $tasks[] = [
                'id' => $task->id,
                'name' => $task->name,
                'type' => $task->type,
                'date_send' => $dat,
                'time_send' => $tim,
                'days_send' => $days_send,
                'days_send_name' => $days_send_name,
            ];
        }

        /*
        $toEmail = "up777up@yandex.ru";
        $message = "Это тестовое сообщение с нового сайта, а не спам!";
		$mm = new SendMail($message);
		Mail::to($toEmail)->send(new SendMail($message));
        */

        return view('dashboard', ["tasks" => $tasks]);
    }
}
