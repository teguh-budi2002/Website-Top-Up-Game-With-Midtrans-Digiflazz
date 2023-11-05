<?php

namespace App\Listeners;

use App\Events\UserLastSeen;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastSeenUser
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserLastSeen $event): void
    {
        $lastSeen = $event->user->update(['last_seen' => Carbon::now()->format('Y-m-d H:i:s'), 'status_online' => 0]);
    }
}
