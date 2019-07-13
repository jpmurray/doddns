<?php

namespace App\Commands;

use App\Helpers\ConfigHelper;
use LaravelZero\Framework\Commands\Command;

class AddToken extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'token:add {token}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Add you Digital Ocean API token to the configuration file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ConfigHelper $config)
    {
        $token = $this->argument('token');

        if ($this->confirm('This will overwrite any previously saved token. Do you wish to continue?')) {
            $new = $config->set("digitalOceanToken", $token);
        }
        
        $this->info("Token saved! You're ready to go!");
    }
}
