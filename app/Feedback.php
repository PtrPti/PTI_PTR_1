<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $fillable = [
        'mensagem', 
        'grupo_id',
        'user_id'         
    ];
}
