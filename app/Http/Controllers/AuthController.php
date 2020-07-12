<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserInfo;
use App\Curso;
use App\CursoCadeira;
use App\GrauAcademico;
use App\Departamento;
use App\UserCadeira;
use App\Http\Requests\RegistarAluno;
use App\Http\Requests\RegistarProfessor;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class AuthController extends Controller
{
    public function getLogin() {
        return view('auth.login');
    }

    public function getRegistar(Request $request) {
        $departamentos = Departamento::orderBy('nome')->get();
        $cursos = Curso::where('departamento_id', $request->old('departamento_id'))->orderBy('nome')->get();
        $cadeiras = CursoCadeira::join('cadeiras', 'cursos_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('curso_id', $request->old('curso_id'))->orderBy('cadeiras.nome')->get();
        $cadeirasProf = CursoCadeira::join('cursos', 'cursos_cadeiras.curso_id', '=', 'cursos.id')->
                    join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->
                    join('cadeiras', 'cursos_cadeiras.cadeira_id', '=', 'cadeiras.id')->
                    where('departamento_id', $request->old('departamento_idProf'))->orderBy('cadeiras.nome')->get();

        $tab_active= $request->old('tab_active') == "" ? "#registoAluno" : $request->old('tab_active');

        return view('auth.register', compact('departamentos', 'cursos', 'cadeiras', 'cadeirasProf', 'tab_active'));
    }

    function registarAluno(RegistarAluno $request) {
        $user = new User;
    
        $user->nome = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request['password']);
        $user->perfil_id = $request->perfil_id;
        $user->save();
        
        $user_info = new UserInfo;
        $user_info->user_id = $user->id;
        $user_info->numero = $request->numero;
        $user_info->departamento_id = $request->departamento_id;
        $user_info->curso_id = $request->curso_id;
        $user_info->data_nascimento = DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
        $user_info->save();

        foreach ($request->cadeiras as $cadeira) {
            $cadeira_insert = new UserCadeira;

            $cadeira_insert->user_id = $user->id;
            $cadeira_insert->cadeira_id = $cadeira;
            $cadeira_insert->favorito = 0;

            $cadeira_insert->save();
        }

        return redirect()->action('AuthController@getLogin');
    }

    function registarProfessor(RegistarProfessor $request) {
        $user = new User;
    
        $user->nome = $request->nameProf;
        $user->email = $request->emailProf;
        $user->password = bcrypt($request['passwordProf']);
        $user->perfil_id = $request->perfil_id;
        $user->save();
        
        $user_info = new UserInfo;
        $user_info->user_id = $user->id;
        $user_info->numero = $request->numeroProf;
        $user_info->departamento_id = $request->departamento_idProf;
        $user_info->data_nascimento = DateTime::createFromFormat('Y-m-d', $request->data_nascimentoProf);
        $user_info->save();

        foreach ($request->cadeirasProf as $cadeira) {
            $cadeira_insert = new UserCadeira;

            $cadeira_insert->user_id = $user->id;
            $cadeira_insert->cadeira_id = $cadeira;
            $cadeira_insert->favorito = 0;

            $cadeira_insert->save();
        }

        return redirect()->action('AuthController@getLogin');
    }

    public function logout() {
        Auth::logout();
        request()->session()->forget('userNum');

        return redirect('/');
    }

    public function changeDepartamentoId(Request $request) {
        if (!$request->departamento_id) {
            $html = '<option value="">-- Selecionar --</option>';
        } 
        else {
            $html = '<option value="">-- Selecionar --</option>';
            $cursos = Curso::where('departamento_id', $request->departamento_id)->orderBy('nome')->get();
            foreach ($cursos as $curso) {
                $html .= '<option value="'.$curso->id.'">'.$curso->nome.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function changeDepartamentoProfId(Request $request) {
        if (!$request->departamento_id) {
            $html = '<option value="">-- Escolha um departamento --</option>';
        } 
        else {
            $html = '';
            $cadeiras = CursoCadeira::join('cursos', 'cursos_cadeiras.curso_id', '=', 'cursos.id')->
                    join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->
                    join('cadeiras', 'cursos_cadeiras.cadeira_id', '=', 'cadeiras.id')->
                    where('departamento_id', $request->departamento_id)->orderBy('cadeiras.nome')->get();
            foreach ($cadeiras as $cadeira) {
                $html .= '<option value="'.$cadeira->cadeira_id.'">'.$cadeira->nome.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }

    public function changeCursoId(Request $request) {
        if (!$request->curso_id) {
            $html = '<option value="">-- Escolha um curso --</option>';
        } 
        else {
            $html = '';
            $cadeiras = CursoCadeira::join('cadeiras', 'cursos_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('curso_id', $request->curso_id)->orderBy('cadeiras.nome')->get();
            foreach ($cadeiras as $cadeira) {
                $html .= '<option value="'.$cadeira->cadeira_id.'">'.$cadeira->nome.'</option>';
            }
        }

        return response()->json(['html' => $html]);
    }
}