<?php

namespace App\Http\Controllers;

use APIResponse;
use App\Models\ActivityLogger;
use Exception;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        try {
            $activity_loggers = ActivityLogger::orderBy('id', 'DESC')->get();
            return APIResponse::okResponse($activity_loggers, 'Activity Logger fetched successfully');
        } catch (Exception $exception) {
            return APIResponse::errorResponse([], 'Activity logger can not be fetched');
        }
    }
}
