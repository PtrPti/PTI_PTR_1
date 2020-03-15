<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function getLogin() {
        return view('login');
    }

    public function getRegistar() {
        return view('auth.register');
    }
    
    public function registar(Request $request) {
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|email|string|max:255|unique:users',
            'password' => 'bail|required|string|min:6|confirmed'
        ]); 

        $user = new User;

        $user->nome = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request['password']);

        $user->save();

        return redirect('home');
    }

    public function logout() {
        Auth::logout();
        request()->session()->forget('userNum');

        return redirect('/');
    }
}