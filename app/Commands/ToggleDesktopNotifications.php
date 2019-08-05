<?php

namespace App\Commands;

use App\Helpers\ConfigHelper;
use LaravelZero\Framework\Commands\Command;

class ToggleDesktopNotifications extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'notifications:toggle';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Toggle between having desktop notifications, or not.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ConfigHelper $config)
    {
        $notification_toggle = $config->get('desktop_notifications', true);
        $confirmation_message = $notification_toggle ? "Desktop notifications are curently enabled. Do you wish to disable them?" : "Desktop notifications are curently not enabled. Do you wish to enable them?";

        if ($this->confirm($confirmation_message)) {
            if ($notification_toggle) {
                $config->set('desktop_notifications', false);
                $this->info("Desktop notifications disabled.");
            } else {
                $config->set('desktop_notifications', true);
                $this->info("Desktop notifications enabled.");
            }
            
            return;
        }

        $this->info("Nothing changed.");
    }
}
