<?php

namespace App\Commands;

use App\Helpers\DigitalOceanHelper;
use DigitalOceanV2\Adapter\GuzzleHttpAdapter;
use DigitalOceanV2\DigitalOceanV2;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class RecordsToUpdate extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'records-to-update';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Set which records to update.';

    protected $settings;
    protected $token;

    private $adapter;
    private $digitalocean;
    private $domain;
    private $domainRecord;

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

        $this->adapter = new GuzzleHttpAdapter($this->token);
        $this->digitalocean = new DigitalOceanV2($this->adapter);
        $this->domain = $this->digitalocean->domain();
        $this->domainRecord = $this->digitalocean->domainRecord();

        $domains = collect($this->domain->getAll())->mapWithKeys(function ($values) {
            return [$values->name => $values->name];
        })->toArray();

        $selected_domain = $this->menu("Which domain?", $domains)->open();

        $records = collect($this->domainRecord->getAll($selected_domain))->filter(function ($record) {
            return $record->type == "CNAME" || $record->type == "A";
        });

        $records_for_menu = $records->mapWithKeys(function ($values, $key) {
            return [$key => "{$values->name} ({$values->type}): {$values->data}"];
        })->toArray();
        
        $selected_record = $this->menu("Which record?", $records_for_menu)->open();

        DB::table('records')->insert(
            ['domain' => $selected_domain,
            'record_id' => $records[$selected_record]->id,
            'record_name' => $records[$selected_record]->name,
            'record_type' => $records[$selected_record]->type]
        );

        $this->info("Record {$records[$selected_record]->name} for domain {$selected_domain} will be updated on the next cycle.");
    }
}
