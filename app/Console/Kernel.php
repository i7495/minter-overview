<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->command('app:update', ['--delay'=> 5])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 10])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 15])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 20])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 25])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 30])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 35])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 40])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 45])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 50])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 55])->everyMinute();
        $schedule->command('app:update', ['--delay'=> 60])->everyMinute();
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
