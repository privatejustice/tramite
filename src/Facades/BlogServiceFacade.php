<?php

namespace Siravel\Facades;

use Illuminate\Support\Facades\Facade;

class BlogServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BlogService';
    }
}
