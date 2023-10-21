<?php

namespace App\Traits;

trait ModelObservableTrait
{
    protected static function boot()
    {
        parent::boot();


        static::saving(function ($model) {
        });

        static::deleting(function ($model) {
        });

        static::updating(function ($model) {
        });
    }
}
