<?php

namespace Siravel\Facades;

use Illuminate\Support\Facades\Facade;

class PageServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'PageService';
    }
}
