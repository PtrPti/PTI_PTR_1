<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perfil)
    {
        //ver se user pode aceder
        if (Auth::user()->perfil->id != $perfil) {
            return back();
        }

        return $next($request);
    }
}
