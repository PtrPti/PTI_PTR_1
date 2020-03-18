<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Curso;
use App\GrauAcademico;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class AuthController extends Controller
{
    public function getLogin() {
        return view('login');
    }

    public function getRegistar() {
        $cursos = Curso::orderBy('nome')->get();
        $graus_academicos = GrauAcademico::all();

        return view('auth.register', compact('cursos', 'graus_academicos'));
    }
    
    public function registar(Request $request) {
        $this->validate($request, [
            'name' => 'bail|required|string|max:255',
            'email' => 'bail|required|email|string|max:255|unique:users',
            'password' => 'bail|required|string|min:6|confirmed',
            'n_aluno' => 'bail|required|int|',
            'curso_id' => 'bail|required|int|',
            'grau_academico_id' => 'bail|required|int|',
            'data_nascimento' => 'bail|required|date|',
        ]); 

        $user = new User;

        $user->nome = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request['password']);
        $user->n_aluno = $request->n_aluno;
        $user->curso_id = $request->curso_id;
        $user->grau_academico_id = $request->grau_academico_id;
        $user->data_nascimento = DateTime::createFromFormat('d-m-Y', $request->data_nascimento);

        $user->save();

        return redirect('home');
    }

    public function logout() {
        Auth::logout();
        request()->session()->forget('userNum');

        return redirect('/');
    }
}