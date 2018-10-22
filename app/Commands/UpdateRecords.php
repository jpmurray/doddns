<?php

namespace App\Commands;

use App\Helpers\DigitalOceanHelper;
use Carbon\Carbon;
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
    protected $signature = 'records:update';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Update saved records to current IP address.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DigitalOceanHelper $digitalocean)
    {
        $current_ip = Ip::get();

        DB::table('settings')->update(
            ['last_known_ip' => $current_ip]
        );

        $records_to_update = DB::table('records')->get();

        $records_to_update->each(function ($record) use ($current_ip, $digitalocean) {
            $digitalocean->domainRecord->update($record->domain, $record->record_id, $record->record_name, $current_ip);

            DB::update('update records set record_updated_at = ? where id = ?', [Carbon::now()->toDatetimeString(), $record->id]);

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
