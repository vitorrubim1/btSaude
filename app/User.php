<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasPushSubscriptions;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const TYPE_ADMIN = 0;
    const TYPE_DOCTOR = 1;
    const PROFESSION_DOCTOR = 1;
    const PROFESSION_PSY = 2;
    const PROFESSION_NUTRI = 3;




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','last_name','cpf','phone','profession','photo_front','photo_back','opentok_session','opentok_token', 'firebase_token', 'status', 'type'
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
    ];
}
