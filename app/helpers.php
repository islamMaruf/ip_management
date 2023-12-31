<?php

use Illuminate\Support\Facades\Log;

if (! function_exists('infoLog')) {
    function infoLog($function_name, $message, $context)
    {
        $context = is_array($context) ? $context : ["info" => $context];
        return Log::channel('local')->info($function_name . ' - ' . $message, $context);
    }
}

if (! function_exists('errorLog')) {
    function errorLog($function_name, $message, $context)
    {
        $context = is_array($context) ? $context : ["error" => $context];
        Log::channel('local')->error($function_name . ' - ' . $message, $context);
    }
}
