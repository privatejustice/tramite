<?php

namespace Siravel\Facades;

use Illuminate\Support\Facades\Facade;

class SitecServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'SitecService';
    }
}
