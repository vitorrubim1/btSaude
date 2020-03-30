<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialtie extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    const TYPE_ADMIN = 0;

    protected $fillable = [
        'name', 'status', 
    ]; //ISSO É FEITO PARA QUANDO SE QUER CRIAR REGISTROS EM MASSA!


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
