<?php

namespace App\Commands;

use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class RemoveRecord extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'records:remove';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Remove a record from the update cycle.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $records = DB::table('records')->get();
        
        $records_for_menu = collect($records)->mapWithKeys(function ($record) {
            return [$record->id => "({$record->record_type}) {$record->record_name} of {$record->domain}"];
        })->toArray();

        $record_to_remove = $this->menu("Which record to delete?", $records_for_menu)->open();

        if ($record_to_remove === null) {
            $this->info("Nothing selected. Exiting.");
            return;
        }

        DB::table('records')->where('id', '=', $record_to_remove)->delete();

        $this->info("Removed!");
    }
}
