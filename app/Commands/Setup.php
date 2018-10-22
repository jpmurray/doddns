<?php

namespace App\Commands;

use App\Helpers\SettingsHelper;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class Setup extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'setup {--U|upgrade : Run the upgrade command without menu prompt.}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Well... It sets things up.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SettingsHelper $settings)
    {

        if ($this->option('upgrade')) {
            $option = 2;
        } else {
            $option = $this->menu('What do you want to do?', [
                'First time setup', //0
                'Restart from scratch', //1
                'Ugprade to latest version', //2
            ])->open();
        }

        if (is_null($option)) {
            $this->info("Doing nothing.");
            return;
        }

        if ($option == 2) {
            $this->upgrade();
            return;
        }

        $this->makeSetup();
    }

    private function upgrade()
    {
        $this->callSilent('migrate');
        $this->info("Upgraded!");
    }

    private function makeSetup()
    {
        if (!$this->confirm("This will destroy any existing doddns configuration. Is that ok?")) {
            $this->info("Doing nothing.");
            return;
        }

        $this->createDatabase();

        $token = $this->ask("What is your Digital Ocean peronal access token?");

        if ($settings->hasToken()) {
            $this->updateToken($token);
        } else {
            $this->insertToken($token);
        }

        $this->info("All done! We're good to go!");
    }

    private function createDatabase()
    {
        $this->task("Creating local database", function () {
            if (!is_dir($_SERVER['HOME'].'/.doddns/')) {
                mkdir($_SERVER['HOME'].'/.doddns/', 0700);
                $this->info("Created .doddns directory in user's home.");
            }

            file_put_contents(config('database.connections.sqlite.database'), "");
            $this->info("Created or overwrited any actual databse");

            Artisan::call('migrate', ['--force' => true]);

            $this->info("Migrated tables");

            return true;
        });
    }

    private function updateToken($token)
    {
        if ($this->confirm('Do you wish to overwrite existing saved token?')) {
            DB::table('settings')->update(
                ['token' => $token]
            );
        }

        $this->info("Token updated!");
    }

    private function insertToken($token)
    {
        DB::table('settings')->insert(
            ['token' => $token]
        );

        $this->info("Token added!");
    }
}
