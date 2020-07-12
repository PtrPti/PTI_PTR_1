<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        if (Auth::user()->isAluno() || Auth::user()->isProfessor()) {
            return route('home');
        }
        else if (Auth::user()->isAdmin()) {
            return route('homeAdmin');
        }
        else {
            return route('welcome');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        error_log();
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1])) {
            if (Auth::user()->isAluno() || Auth::user()->isProfessor()) {
                return route('home');
            }
            else if (Auth::user()->isAdmin()) {
                return route('homeAdmin');
            }
            else {
                return redirect()->intended('welcome');
            }
        }
    }
}