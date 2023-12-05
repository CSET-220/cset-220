<?php

namespace App\Console\Commands;

use App\Models\Patient;
use Illuminate\Console\Command;

class DailyBalanceUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-balance-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increases Patient Balance By 10 Every Day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Patient::query()->increment('balance',10);
    }
}
