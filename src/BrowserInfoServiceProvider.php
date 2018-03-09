<?php

namespace Andaletech\BrowserInfo;

use Illuminate\Support\ServiceProvider;

/**
 * ServiceProvider to bootstrap BrowserInfo.
 * 
 * @author Kolado Sidibe <kolado.sidibe@andaletech.com>
 * @package andaletech\laravel-browser-info
 * @license MIT
 */
class BrowserInfoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // // $this->app->make('');
        $this->app->bind('Andaletech\BrowserInfo', function($app){
            return new BrowserInfo();
        });
    }
}
