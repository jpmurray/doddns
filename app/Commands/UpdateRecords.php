<?php

namespace App\Commands;

use App\Helpers\DigitalOceanHelper;
use App\Helpers\ConfigHelper;
use Carbon\Carbon;
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
    protected $signature = 'record:update';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Update saved record to current IP address.';

    /**
     * Helper to interact with Digital Ocean API.
     */
    protected $digitalocean;

    protected $config;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DigitalOceanHelper $digitalocean, ConfigHelper $config)
    {
        $this->digitalocean = $digitalocean;
        $this->config = $config;

        $current_ip = Ip::get();
        $has_ip_changed = $config->get("last_ip", true) != $current_ip;
        
        if (!$has_ip_changed) {
            $this->info("IP address has not changed. Doing nothing.");
            exit(1);
        }

        $this->updateIPAddress($current_ip);
    }

    private function updateIPAddress($current_ip)
    {
        $this->config->set("last_ip", $current_ip);

        $record = $this->config->get('record');

        $this->digitalocean->domainRecord->update($record['domain'], $record['record_id'], $record['record_name'], $current_ip);

        $this->config->set("last_ip_datestamp", Carbon::now()->toDatetimeString());

        $this->info("Updated ({$record['record_type']}) {$record['record_name']} of {$record['domain']} to : {$current_ip}");
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
