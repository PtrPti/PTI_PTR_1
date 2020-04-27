<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForumMensagens extends Model
{
    protected $table = 'forum_mensagens';

    protected $fillable = [
        'forum_duvida_id','user_id','mensagem', 
    ];
}