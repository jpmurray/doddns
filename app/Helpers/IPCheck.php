<?php

namespace App\Helpers;

use GuzzleHttp\Client;

/**
 *
 */
class IPCheck
{

    protected $base_uri = "https://ipcheck.doddns.com/";
    private $client;
    
    public function __construct()
    {
        $this->client = new Client(['base_uri' => $this->base_uri]);
    }

    public function get($output = "json")
    {
        $response = $this->client->request('GET', '/', [
            'query' => [
                'output' => $output
            ]
        ]);

        return json_decode($response->getBody()->getContents())->address;
    }
}
