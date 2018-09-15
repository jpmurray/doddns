<?php

namespace App\Commands;

use App\Helpers\DigitalOceanHelper;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
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

    protected $settings;
    protected $token;

    private $digitalocean;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $this->settings = DB::table('settings')->get();

        if ($this->settings->isNotEmpty()) {
            $this->token = $this->settings->first()->token;
        } else {
            $this->error("There is no settings to the database.");
            return;
        }

        $this->digitalocean = new DigitalOceanHelper($this->token);

        $current_ip = Ip::get();
        $records_to_update = DB::table('records')->get();

        $records_to_update->each(function ($record) use ($current_ip) {
            $this->digitalocean->domainRecord->update($record->domain, $record->record_id, $record->record_name, $current_ip);
            ;

            $this->info("Updated ({$record->record_type}) {$record->record_name} of {$record->domain} to : {$current_ip}");
        });

        $this->info("DONE!");
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule)
    {
        $schedule->command(static::class)->hourly();
    }
}
