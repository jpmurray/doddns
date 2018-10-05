<?php

namespace App\Helpers;

use DigitalOceanV2\Adapter\GuzzleHttpAdapter;
use DigitalOceanV2\DigitalOceanV2;

/**
 *
 */
class DigitalOceanHelper
{

    private $adapter;
    private $digitalocean;
    
    public $domain;
    public $domainRecord;

    protected $token;
    
    public function __construct($token)
    {
        $this->token = $token;

        $this->adapter = new GuzzleHttpAdapter($this->token);
        $this->digitalocean = new DigitalOceanV2($this->adapter);
        $this->domain = $this->digitalocean->domain();
        $this->domainRecord = $this->digitalocean->domainRecord();

        return $this;
    }

    public function getDomains()
    {
        return collect($this->domain->getAll())->mapWithKeys(function ($values) {
            return [$values->name => $values->name];
        })->toArray();
    }

    public function getDomainRecords($domain)
    {
        return collect($this->domainRecord->getAll($domain))->filter(function ($record) {
            return $record->type == "CNAME" || $record->type == "A";
        });
    }
}
