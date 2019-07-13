<?php

namespace App\Providers;

use App\Exceptions\InvalidConfigException;
use App\Helpers\ConfigHelper;
use App\Helpers\DigitalOceanHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ConfigHelper::class, function () {
            return new ConfigHelper();
        });

        $this->app->singleton(DigitalOceanHelper::class, function () {
            /** @var ConfigHelper $config */
            $do_token = app(ConfigHelper::class)->get('digitalOceanToken');

            if (empty($do_token)) {
                throw new InvalidConfigException(
                    "Digital Ocean token seems not to be successfully set. Try to run the token:add command."
                );
            }

            return new DigitalOceanHelper($do_token);
        });
    }
}
