<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class Version extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'version';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = "Display the current doddns' version";

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $current_version = config('app.version');
        $latest_version = file_get_contents("https://raw.githubusercontent.com/jpmurray/doddns/master/VERSION.md");

        $this->info("Installed version: {$current_version}");
        $this->info("Latest version available: {$latest_version}");

        if ($current_version == $latest_version) {
            $this->line("You are up to date!");
        } else {
            $this->info("A new version is available!");
            $this->line("You should, depending your case, pull the latest from repository, or visit https://github.com/jpmurray/doddns to download the latest build.");
        }
    }
}
