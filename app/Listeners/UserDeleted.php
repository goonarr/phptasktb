<?php

namespace App\Listeners;

use App\Events\UserDeleted as UserDeletedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserDeleted
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserDeleted  $event
     * @return void
     */
    public function handle(UserDeletedEvent $event)
    {
        //this function does nothing, and here is just for semantic reasons
        return true;
    }
}
