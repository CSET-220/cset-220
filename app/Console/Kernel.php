<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:daily-balance-update')->daily();
        // Have to use microsoft task scheduler
        // Create Basic Task
        // Name + Description
        // Trigger Daily
        // Start time a couple minutes from now
        // Action - Start a Program = C:\xampp\php\php.exe 
        // Add arguments = artisan schedule:run
        // Start in = C:absolute\path\to\cset-220
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
