<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

interface UserRoles {
    public function isSuperAdmin();
    public function isAdmin();
    public function isMember();
}

class User extends Authenticatable implements MustVerifyEmail, UserRoles
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * configure Created Event.
     *
     * @var array
     */
    protected $dispatchesEvents = [
      'created' => \App\Events\UserCreated::class,
      'deleted' => \App\Events\UserDeleted::class,
    ];

    /**
     * Acceptable USER roles
     * @var Array
     */
    protected static $acceptable_roles = ['super_admin', 'Admin', 'Member'];

    /**
    * Files uploaded by user
    * @return File model collection
     */
    public function files() {
      return $this->hasMany( 'App\Models\Files', 'user_id' );
    }

    /**
     * Check SuperAdmin status
     * @return bool
     */
    public function isSuperAdmin(){
      return $this->role == 'super_admin';
    }

    /**
     * Check Admin status
     * @return bool
     */
    public function isAdmin(){
      return $this->role == 'Admin';
    }

    /**
     * Check Member status
     * @return bool
     */
    public function isMember(){
      return $this->role == 'Member';
    }

    /**
    * Retrieves acceptable user roles
    * @return Array
     */
    public static function getRoles(){
      return self::$acceptable_roles;
    }

}
