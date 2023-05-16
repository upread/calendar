<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Telegram\Telegram;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $sdvig = "";
            if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN') {
                $sdvig = " + interval '3' HOUR";
            }

            //одноразовые задачи
            $tasks_one = DB::table('tasks')
            ->where('type', '1')
            ->where('is_send', '0')
            ->where('date_send', '<', DB::raw("current_timestamp()".$sdvig))
            ->get();


            //повторяемые
            $today = date("N");
            $tim = date("H:i", strtotime('+3 hours')).":00";

          

            $tasks_repeat = DB::table('tasks')
            ->where('type', '2')
            ->where('days_send', 'like', '%'. $today .'%')
            ->where('time_send', $tim)
            ->get();

            $tasks = $tasks_one->merge($tasks_repeat);

            if ($tasks){  
                $tg = new Telegram();
                foreach ($tasks as $task){  
                    $user = DB::table('users')->where('id', $task->user_id)->first();
                    if ($user){                                        
                        $tg_id = $user->tg;
                        if ($tg_id){
                            $tg->sendMessage($tg_id, $task->name);
                            DB::table('tasks')
                            ->where('id', $task->id)
                            ->update([
                                'is_send' => '1'
                            ]);
                        }
                    }
                }

            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
