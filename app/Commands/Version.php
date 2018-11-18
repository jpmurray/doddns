<?php

namespace App\Commands;

use App\Helpers\SettingsHelper;
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
    public function handle(SettingsHelper $settings)
    {
        $current_codebase_version = config('app.version');
        $current_database_version = $settings->getInstalledVersion();
        $latest_version = file_get_contents("https://raw.githubusercontent.com/jpmurray/doddns/master/VERSION.md");

        $this->info("Codebase version: {$current_codebase_version}");
        $this->info("Database version: {$current_database_version}");
        $this->info("Latest codebase version available: {$latest_version}");

        if ($current_codebase_version >= $latest_version) {
            $this->line("You are up to date!");
        } else {
            $this->info("A new version is available!");
            $this->line("You should, depending your case, pull the latest from repository, or visit https://github.com/jpmurray/doddns to download the latest build.");
        }

        if ($current_codebase_version != $current_database_version) {
            $this->error("The database version is different from your codebase version. This is normally because you did not run the upgrade command after an update. Please go run it immediately.");
        }
    }
}
