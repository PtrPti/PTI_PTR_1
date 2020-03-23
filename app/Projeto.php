<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    protected $table='projetos';
    protected $fillable=['nome'];
}
