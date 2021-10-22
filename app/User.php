<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'settings','image','thumbnail',  'path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array'
    ];

    protected $dispatchesEvents = [
        'created' => 'App\Events\Users\CreatedUser',
        'deleting' => 'App\Events\Users\DeletingUser',
        'updated' => 'App\Events\Users\UpdatedUser'
   ];

    protected $appends = [
        'user_since'
    ];

    public function getUserSinceAttribute()
    {
        return date('F d, Y', strtotime($this->created_at));
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }




public function getProfileBaseAttribute() {
    return base64_encode(Storage::get($this->image)); //whatever field u saved
}



}
