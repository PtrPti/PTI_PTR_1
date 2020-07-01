<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cadeira extends Model
{
    protected $table = 'cadeiras';
    public $timestamps = false;

    protected $attributes = [
        'active' => true,
    ];
}
