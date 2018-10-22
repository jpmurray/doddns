<?php

namespace App\Commands;

use App\Helpers\DigitalOceanHelper;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class AddRecord extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'records:add';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Set which records to update.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DigitalOceanHelper $digitalocean)
    {
        $domains = $digitalocean->getDomains();

        $selected_domain = $this->menu("Which domain?", $domains)->open();

        if ($selected_domain === null) {
            $this->info("Nothing selected. Exiting.");
            return;
        }

        $records = $digitalocean->getDomainRecords($selected_domain);

        $records_for_menu = $records->mapWithKeys(function ($values, $key) {
            return [$key => "{$values->name} ({$values->type}): {$values->data}"];
        })->toArray();
        
        $selected_record = $this->menu("Which record?", $records_for_menu)->open();

        if ($selected_record === null) {
            $this->info("Nothing selected. Exiting.");
            return;
        }

        DB::table('records')->insert(
            ['domain' => $selected_domain,
            'record_id' => $records[$selected_record]->id,
            'record_name' => $records[$selected_record]->name,
            'record_type' => $records[$selected_record]->type]
        );

        $this->info("Record {$records[$selected_record]->name} for domain {$selected_domain} will be updated on the next cycle.");
    }
}
