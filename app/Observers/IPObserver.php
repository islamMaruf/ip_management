<?php

namespace App\Observers;

use ActivityTracker;
use App\Models\IP;

class IPObserver
{
    /**
     * Handle the IP "created" event.
     */
    public function created(IP $ip): void
    {
        ActivityTracker::track('IP created successfully - ' . $ip->id, $ip);
    }

    /**
     * Handle the IP "updated" event.
     */
    public function updated(IP $ip): void
    {
        ActivityTracker::track('IP updated successfully - ' . $ip->id, $ip);
    }

    /**
     * Handle the IP "deleted" event.
     */
    public function deleted(IP $ip): void
    {
        ActivityTracker::track('IP deleted successfully - ' . $ip->id, $ip);
    }
}
