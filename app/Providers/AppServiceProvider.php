<?php

namespace App\Providers;

use App\Helpers\DigitalOceanHelper;
use App\Helpers\SettingsHelper;
use App\Helpers\ConfigHelper;
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

        $this->app->singleton(SettingsHelper::class, function () {
            return new SettingsHelper();
        });

        $this->app->singleton(DigitalOceanHelper::class, function () {
            /** @var SettingsHelper $settings */
            $settings = app(SettingsHelper::class);

            return new DigitalOceanHelper($settings->getToken());
        });
    }
}
