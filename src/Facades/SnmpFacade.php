<?php

namespace Ndum\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @author shimomo
 */
class SnmpFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'snmp';
    }
}
