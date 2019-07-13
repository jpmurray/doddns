<?php

namespace App\Helpers;

use App\Exceptions\InvalidConfigException;
use Illuminate\Support\Facades\Storage;

/**
 *
 */
class ConfigHelper
{
    public function __construct()
    {
        $this->prepare();
    }

    /**
     * Will set a config value to the config file and return updated config.
     * @param string $name  Name of the setting
     * @param mixed $value Value of the setting,
     */
    public function set($name, $value)
    {
        $config = $this->get();
        $config[$name] = $value;

        Storage::put('config.json', json_encode($config));
        
        return json_decode(Storage::get('config.json'), true);
    }

    /**
     * Returns an array of the current configuration file
     * @return array Current configuration options.
     */
    public function get($name = null)
    {
        $config = json_decode(Storage::get('config.json'), true);

        if ($name === null) {
            return $config;
        }

        if (!isset($config[$name])) {
            throw new InvalidConfigException(
                "Could not find any value for \"{$name}\" in config file."
            );
        }

        return $config[$name];
    }

    /**
     * Will check for config file and create an empty one if not present
     */
    private function prepare():void
    {
        if (!Storage::has('config.json')) {
            Storage::put('config.json', json_encode([]));
        }
    }
}
