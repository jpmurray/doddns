<?php

namespace App\Commands;

use App\Helpers\ConfigHelper;
use App\Helpers\IPCheck;
use LaravelZero\Framework\Commands\Command;

class CurrentIP extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'ip:current';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Show your current IP address.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ConfigHelper $config)
    {
        $ipcheck = new IPCheck();
        
        $this->info("Your current IP is {$ipcheck->get()}");
    }
}
