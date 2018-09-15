<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class UpdateToken extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'token {token : Your DigitalOcean Personnal Access Token}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Updates your Digital Ocean\'s Personnal Access Token';

    private $settings;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->settings = DB::table('settings')->get();

        if ($this->settings->isEmpty()) {
            $this->insertToken();
        } else {
            $this->updateToken();
        }
    }

    private function updateToken()
    {
        if ($this->confirm('Do you wish to overwrite existing saved token?')) {
            DB::table('settings')->update(
                ['token' => $this->argument('token')]
            );
        }

        $this->info("Token updated!");
    }

    private function insertToken()
    {
        DB::table('settings')->insert(
            ['token' => $this->argument('token')]
        );

        $this->info("Token added!");
    }
}
