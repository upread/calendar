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

            $tasks_ring = DB::table('tasks')
            ->where('is_send', '0')
            ->where('date_send', '<', DB::raw("current_timestamp()".$sdvig))
            ->get();

            $tg = new Telegram();

            foreach ($tasks_ring as $task){
                $tg->sendMessage("506570374", $task->name);

                DB::table('tasks')
                ->where('id', $task->id)
                ->update([
                    'is_send' => '1'
                ]);
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
