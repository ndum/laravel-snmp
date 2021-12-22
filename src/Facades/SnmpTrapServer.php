<?php

namespace Ndum\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class SnmpTrapServer extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'snmptrapserver';
    }
}
