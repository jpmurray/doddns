<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Ipify\Ip;
use LaravelZero\Framework\Commands\Command;

class UpdateRecords extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'update-records';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Update saved records to current IP address.';

    private $current_ip;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->current_ip = Ip::get();
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
