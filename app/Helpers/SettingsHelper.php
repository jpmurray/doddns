<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

/**
 *
 */
class SettingsHelper
{

    private $settings;
    private $token;

    public $error = null;
    
    public function __construct()
    {

        $this->settings = DB::table('settings')->get();

        if ($this->settings->isNotEmpty()) {
            $this->token = $this->settings->first()->token;
        } else {
            $this->error = "There is no settings to the database.";
        }

        return $this;
    }

    public function getSettings()
    {
        return $this->settings;
    }

    public function getToken()
    {
        return $this->token;
    }
}
