<?php

namespace App\Helpers;

use App\Exceptions\InvalidSettingException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class SettingsHelper
{

    /**
     * @var Collection
     */
    private $settings;

    public function getSettings()
    {
        return $this->settings;
    }

    public function hasToken()
    {
        return $this->hasSetting('token');
    }

    public function getToken()
    {
        return $this->getSetting('token');
    }

    public function hasLastKnownIP()
    {
        return $this->hasSetting('last_known_ip');
    }

    public function getLastKnownIP()
    {
        return $this->getSetting('last_known_ip');
    }

    /**
     * @param $key
     * @return mixed
     */
    private function getSetting($key)
    {
        $this->setupSettings();

        return $this->settings->{$key};
    }

    /**
     * Check to see if the settings exists in the database
     *
     * @param $key
     * @return boolean
     */
    private function hasSetting($key)
    {
        try {
            $this->setupSettings();

            return is_object($this->settings) &&
                property_exists($this->settings, $key);
        } catch (InvalidSettingException $exception) {
            return false;
        }
    }

    /**
     * @throws InvalidSettingException
     */
    private function setupSettings()
    {
        // We bail if the settings are already loaded
        if ($this->settings) {
            return;
        }

        if (!is_file(config('database.connections.sqlite.database'))) {
            throw new InvalidSettingException(
                "The local database does not exist. Please run the setup command."
            );
        }

        $this->settings = DB::table('settings')->first();
    }
}
