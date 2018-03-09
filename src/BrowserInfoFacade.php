<?php

namespace Andaletech\BrowserInfo;

use Illuminate\Support\Facades\Facade;

class BrowserInfoFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Andaletech\BrowserInfo';
    }
}