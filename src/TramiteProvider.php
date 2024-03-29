<?php

namespace Tramite;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class TramiteProvider extends ServiceProvider
{
    /**
     * Alias the services in the boot.
     *
     * @return void
     */
    public function boot(): void
    {
        
    }

    /**
     * Register the services.
     */
    public function register()
    {
        
        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'tramite');

        // // View namespace
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'tramite');
        // $this->publishes(
        //     [
        //     $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'tramite'),
        //     ], 'views'
        // );


    }

}
