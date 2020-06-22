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
use App\AnoLetivo;
use Auth;
use Illuminate\Support\Facades\DB;
use DateTime;

class AuthController extends Controller
{
    public function getLogin() {
        return view('auth.login');
    }

    public function getRegistar() {
        $departamentos = Departamento::orderBy('nome')->get();
        $graus_academicos = GrauAcademico::all();

        return view('auth.register', compact('graus_academicos', 'departamentos'));
    }
    
    public function postRegistar(Request $request) {
        if($request->perfil_id == 1) { //aluno
            $this->validate($request, [
                'name' => 'bail|required|string|max:255',
                'email' => 'bail|required|email|string|max:255|unique:users',
                'password' => 'bail|required|string|min:6|confirmed',
                'numero' => 'bail|required|int|',
                'departamento_id' => 'bail|required|int|',
                'curso_id' => 'bail|required|int|',
                'grau_academico_id' => 'bail|required|int|',
                'data_nascimento' => 'bail|required|date|',
                'cadeiras'  => 'bail|required|array|min:1',
            ]); 
    
            $user = new User;
            $user_info = new UserInfo;
    
            $user->nome = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request['password']);
            $user->perfil_id = $request->perfil_id;
            $user->save();
            
            $user_info->user_id = $user->id;
            $user_info->numero = $request->numero;
            $user_info->departamento_id = $request->departamento_id;
            $user_info->curso_id = $request->curso_id;
            $user_info->grau_academico_id = $request->grau_academico_id;
            $user_info->data_nascimento = DateTime::createFromFormat('Y-m-d', $request->data_nascimento);
            $user_info->save();

            foreach ($request->cadeiras as $cadeira) {
                $cadeira_insert = new UserCadeira;

                $cadeira_insert->user_id = $user->id;
                $cadeira_insert->cadeira_id = $cadeira;
                $cadeira_insert->favorito = 0;
                $cadeira_insert->ano_letivo_id = AnoLetivo::getCurrentAcademicYearId(date("Y"), date('m'));

                $cadeira_insert->save();
            }
    
            return redirect()->action('AuthController@getLogin');
        }
        else { //professor
            $this->validate($request, [
                'name' => 'bail|required|string|max:255',
                'email' => 'bail|required|email|string|max:255|unique:users',
                'password' => 'bail|required|string|min:6|confirmed',
                'numero' => 'bail|required|int|',
                'departamento_id' => 'bail|required|int|',
                'data_nascimento' => 'bail|required|date|',
                'cadeiras'  => 'bail|required|array|min:1',
            ]); 
    
            $user = new User;
            $user_info = new UserInfo;
    
            $user->nome = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request['password']);
            $user->perfil_id = $request->perfil_id;
            $user->save();

            $user_info->user_id = $user->id;
            $user_info->numero = $request->numero;
            $user_info->departamento_id = $request->departamento_id;
            $user_info->data_nascimento = DateTime::createFromFormat('d-m-Y', $request->data_nascimento);
            $user_info->save();

            foreach ($request->cadeiras as $cadeira) {
                $cadeira_insert = new UserCadeira;

                $cadeira_insert->user_id = $user->id;
                $cadeira_insert->cadeira_id = $cadeira;
                $cadeira_insert->ano_letivo_id = AnoLetivo::getCurrentAcademicYearId(date("Y"), date('m'));

                $cadeira_insert->save();
            }
    
            return redirect()->action('AuthController@getLogin');
        }   
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
            error_log($cadeiras);
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