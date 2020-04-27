<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumDuvidas extends Model
{
    protected $table = 'forum_duvidas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'assunto', 
        'primeiro_user', 
        'ultimo_user',
        'cadeira_id'
    ];
}