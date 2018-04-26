<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Regist extends Authenticatable
{
    //
    protected $fillable = [
        'username', 'tel', 'password',
    ];
}
