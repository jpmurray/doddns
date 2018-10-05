<?php

namespace App\Commands;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class ListRecords extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'records:list';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Display a list of records we update each cycles.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $records = DB::table('records')->get();

        $records->each(function ($record, $key) {
            $last_update = is_null($record->record_updated_at) ? "Never" : Carbon::parse($record->record_updated_at)->toDatetimeString();

            $this->line("");
            $this->info("[{$key}] ({$record->record_type}) {$record->record_name} of {$record->domain}. Last updated: {$last_update} (UTC).");
        });
    }
}
