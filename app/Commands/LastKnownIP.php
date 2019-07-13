<?php

namespace App\Commands;

use App\Helpers\ConfigHelper;
use LaravelZero\Framework\Commands\Command;

class LastKnownIP extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'ip:last';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Show the last known IP address that has been used.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ConfigHelper $config)
    {
        $this->info($config->get("last_ip"));
    }
}
