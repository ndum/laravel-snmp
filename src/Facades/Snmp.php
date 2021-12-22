<?php

namespace Ndum\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Snmp extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'snmp';
    }
}
