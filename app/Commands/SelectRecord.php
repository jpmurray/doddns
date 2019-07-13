<?php

namespace App\Commands;

use App\Helpers\ConfigHelper;
use App\Helpers\DigitalOceanHelper;
use LaravelZero\Framework\Commands\Command;

class SelectRecord extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'record:select';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Choose a record to update from a list of available records to update with current Digital Ocean token.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(DigitalOceanHelper $digitalocean, ConfigHelper $config)
    {
        $domains = $digitalocean->getDomains();
        $selected_domain = $this->menu("Which domain do you want to update a record on?", $domains)->open();

        if ($selected_domain === null) {
            $this->info("No domain selected. Nothing will be updated.");
            return;
        }

        $records = $digitalocean->getDomainRecords($selected_domain);

        $records_for_menu = $records->mapWithKeys(function ($values, $key) {
            return [$key => "{$values->name} ({$values->type}): {$values->data}"];
        })->toArray();

        $selected_record = $this->menu("Which record do you want updated?", $records_for_menu)->open();

        if ($selected_record === null) {
            $this->info("No record selected. Nothing will be updated.");
            return;
        }

        $record = ['domain' => $selected_domain,
            'record_id' => $records[$selected_record]->id,
            'record_name' => $records[$selected_record]->name,
            'record_type' => $records[$selected_record]->type];

        $config->set('record', $record);

        $this->info("Record {$records[$selected_record]->name} for domain {$selected_domain} will be updated on the next cycle.");
    }
}
