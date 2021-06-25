<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can create options.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user){
      return $user->role == 'Admin' || $user->role == 'super_admin';
    }
}
