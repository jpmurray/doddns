<?php

namespace App\Commands;

use App\Helpers\DigitalOceanHelper;
use App\Helpers\SettingsHelper;
use Illuminate\Console\Scheduling\Schedule;
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
        $this->settings = new SettingsHelper();

        if ($this->settings->error !== null) {
            $this->error($this->settings->error);
            return;
        }

        $this->digitalocean = new DigitalOceanHelper($this->settings->getToken());
        
        $domains = collect($this->digitalocean->domain->getAll())->mapWithKeys(function ($values) {
            return [$values->name => $values->name];
        })->toArray();

        $selected_domain = $this->menu("Which domain?", $domains)->open();

        if ($selected_domain === null) {
            $this->info("Nothing selected. Exiting.");
            return;
        }

        $records = collect($this->digitalocean->domainRecord->getAll($selected_domain))->filter(function ($record) {
            return $record->type == "CNAME" || $record->type == "A";
        });

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
