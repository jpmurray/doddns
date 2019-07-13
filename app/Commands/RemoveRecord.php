<?php

namespace App\Commands;

use App\Helpers\ConfigHelper;
use Illuminate\Support\Facades\DB;
use LaravelZero\Framework\Commands\Command;

class RemoveRecord extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'record:delete';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Delete currently selected record from config file, effectively stopping any future record update.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ConfigHelper $config)
    {

        $config->remove('record');
        $this->info("Record removed from config file. It won't be updated anymore.");
    }
}
