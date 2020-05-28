<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administradores extends Authenticatable
{ 
    protected $table = "administradores";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function getUser() {
        return $this;
    }
}
