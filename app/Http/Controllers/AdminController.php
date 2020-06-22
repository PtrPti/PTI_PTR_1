<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserInfo;
use App\AnoLetivo;
use App\Semestre;
use App\Cadeira;
use App\Departamento;
use App\Curso;
use App\Perfil;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\AdminEditUser;
use Auth;
use DateTime;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function home(Request $request) {
        $ano = AnoLetivo::getCurrentAcademicYear(date("Y"), date('m'));

        return view('homeAdmin');
    }

    public function getAnosLetivos(Request $request) {
        $anosLetivos = AnoLetivo::paginate(10);
        return view('admin.anosletivos', compact('anosLetivos'));
    }

    public function getSemestres(Request $request) {
        $semestres = Semestre::paginate(10);
        return view('admin.semestres', compact('semestres'));
    }
    
    public function getDepartamentos(Request $request) {
        $departamentos = Departamento::paginate(10);
        return view('admin.departamentos', compact('departamentos'));
    }

    public function getCursos(Request $request) {
        $cursos = Curso::join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->select('cursos.*', 'departamentos.nome as departamento')->paginate(10);
        return view('admin.cursos', compact('cursos'));
    }

    public function getCadeiras(Request $request) {
        $cadeiras = Cadeira::join('semestre', 'cadeiras.semestre_id', '=', 'semestre.id')->
                            join('cursos_cadeiras', 'cadeiras.id', '=', 'cursos_cadeiras.cadeira_id')->
                            join('ano_letivo', 'cursos_cadeiras.ano_letivo_id', '=', 'ano_letivo.id')->
                            join('cursos', 'cursos_cadeiras.curso_id', '=', 'cursos.id')->
                            select('cadeiras.*', 'semestre.semestre as semestre', 'ano_letivo.ano as ano_letivo', 'cursos.nome as curso')->
                            orderBy('cadeiras.nome', 'asc')->
                            paginate(10);

        return view('admin.cadeiras', compact('cadeiras'));
    }

    public function getUtilizadores(Request $request) {
        $users = User::join('users_info', 'users.id', '=', 'users_info.user_id')->
                    join('perfis', 'users.perfil_id', '=', 'perfis.id')->
                    join('departamentos', 'users_info.departamento_id', '=', 'departamentos.id')->
                    join('cursos', 'users_info.curso_id', '=', 'cursos.id')->
                    select('users.id as userId', 'users.nome as nome', 'users.email as email', 'users_info.*', 'perfis.nome as perfil', 'departamentos.nome as departamento', 'cursos.nome as curso')->
                    where('users.perfil_id', '!=', 3)->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function editUser(Request $request) {
        $id = $_GET['user_id'];
        $user = User::join('users_info', 'users.id', '=', 'users_info.user_id')->where('users.id', $id)->first();
        $departamentos = Departamento::orderBy('nome')->pluck('nome', 'id');
        $cursos = Curso::where('active', true)->orderBy('nome')->pluck('nome', 'id');
        $perfil = Perfil::join('users', 'perfis.id', '=', 'users.perfil_id')->where('users.id', $id)->first();

        $data = array(
            'user_id' => $id,
            'nome' => $user->nome,
            'numero' => $user->numero,
            'email' => $user->email,
            'numero' => $user->numero,
            'data_nascimento' => date('Y-m-d', strtotime($user->data_nascimento)),
            'departamento_id' => $user->departamento_id,
            'departamento' => $departamentos,
            'curso_id' => $user->curso_id,
            'curso' => $cursos,
            'perfil' => $perfil->nome,
        );

        return response()->json($data);
    }

    public function editUserPost(AdminEditUser $request) {
        $id = $_POST['user_id'];

        $user = User::find($id);
        $userInfo = UserInfo::where('user_id', $id)->first();

        $user->nome = $request->nome;
        $user->email = $request->email;
        $user->save();

        $userInfo->numero = $request->numero;
        $userInfo->departamento_id = $request->departamento;
        $userInfo->curso_id = $request->curso;
        $userInfo->data_nascimento = $request->data_nascimento;
        $userInfo->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Utilizador alterado com sucesso', 'redirect' => '/Admin/Utilizadores' ]);
    }

    public function addUserFile(Request $request) {

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
}