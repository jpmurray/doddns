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
}
