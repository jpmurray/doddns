<?php

namespace App\Commands;

use App\Helpers\SettingsHelper;
use LaravelZero\Framework\Commands\Command;

class LastKnownIP extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'last-known-ip';

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
    public function handle(SettingsHelper $settings)
    {
        if (!$settings->hasLastKnownIP()) {
            $this->error("Can't find required field in database. If you have updated lately, you should run doddns migrate.");
            return;
        }
        
        $this->showLastKnownIp($settings);
    }

    private function showLastKnownIp($settings)
    {
        $last_known_ip = $settings->getLastKnownIP();

        if (is_null($last_known_ip)) {
            $this->info("Nothing. Please run the doddns:records update command at last once.");
            return;
        }

        $this->info($last_known_ip);
    }
}
