<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCadeira extends Model
{
    protected $table = 'users_cadeiras';
    public $timestamps = false;
    protected $primaryKey = 'user_id';
}
