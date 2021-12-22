<?php

namespace Ndum\Laravel;

use Illuminate\Support\ServiceProvider;

class SnmpServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('snmp', function ($app) {
            return new Snmp();
        });

        $this->app->singleton('snmptrapserver', function ($app) {
            return new SnmpTrapServer();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
