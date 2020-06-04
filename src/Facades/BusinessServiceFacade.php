<?php

namespace Siravel\Facades;

use Illuminate\Support\Facades\Facade;

class BusinessServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BusinessService';
    }
}
