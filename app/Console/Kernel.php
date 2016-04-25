<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Event as Event;
use App\Notification as Notification;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\sendConfirmations::class,
        Commands\ElasticSearchCreateIndex::class,
        Commands\ElasticSearchDeleteIndex::class,
    ];

    /**
     * Define the application's command schedule.
     * ADD THIS CRON ENTRY: * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('confirmations:send')->everyMinute();
    }
}
