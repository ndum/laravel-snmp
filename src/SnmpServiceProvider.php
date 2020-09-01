<?php

namespace Ndum\Laravel;

use Illuminate\Support\ServiceProvider;

class SnmpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('snmp', function ($app) {
            return new Snmp();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
