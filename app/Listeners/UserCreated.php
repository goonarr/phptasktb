<?php

namespace App\Listeners;

use App\Events\UserCreated as UserCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Models\User;

class UserCreated
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
     * First user on the system gets "super_admin" role
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
      if ( User::all()->count() == 1 ){
        $event->user->role = 'super_admin';
        $event->user->save();
      }
      return true;
    }
}
