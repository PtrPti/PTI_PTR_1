<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Perfil;

class User extends Authenticatable
{ 
    protected $table = "users";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome',
        'email',
        'password',
        'numero',
        'data_nascimento',
        'avatar',
        'nome', 
        'email', 
        'password'
    ];

    protected $guarded = ['id', 'perfil_id', 'departamento_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAluno()
    {
        return $this->perfil()->pluck('id')->contains(1);
    }

    public function isProfessor()
    {
        return $this->perfil()->pluck('id')->contains(2);
    }

    public function perfil()
    {
        return $this->belongsTo('App\Perfil');
    }

    public function getUser() {
        return $this;
    }

    public function getUserId() {
        return $this->id;
    }
}
