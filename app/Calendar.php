<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Calendar extends Model
{ 
    protected $table = "calendario";
    public $timestamps = false;
}