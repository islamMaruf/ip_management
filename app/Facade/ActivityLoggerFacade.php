<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class ActivityLoggerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
         return 'activity_logger';
    }
}
