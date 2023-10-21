<?php

namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class ActivityTrackerFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
         return 'activity_logger';
    }
}
