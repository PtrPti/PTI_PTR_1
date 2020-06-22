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
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getAnosLetivos() {
        $anosLetivos = AnoLetivo::get();
        return view('admin.anosletivos', compact('anosLetivos'));
    }

    public function getSemestres() {
        $semestres = Semestre::get();
        return view('admin.semestres', compact('semestres'));
    }
    
    public function getDepartamentos() {
        $departamentos = Departamento::get();
        return view('admin.departamentos', compact('departamentos'));
    }

    public function getCursos() {
        $cursos = Curso::join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->select('cursos.*', 'departamentos.nome as departamento')->get();
        return view('admin.cursos', compact('cursos'));
    }

    public function getCadeiras() {
        $cadeiras = Cadeira::join('semestre', 'cadeiras.semestre_id', '=', 'semestre.id')->
                            join('cursos_cadeiras', 'cadeiras.id', '=', 'cursos_cadeiras.cadeira_id')->
                            join('ano_letivo', 'cursos_cadeiras.ano_letivo_id', '=', 'ano_letivo.id')->
                            join('cursos', 'cursos_cadeiras.curso_id', '=', 'cursos.id')->
                            select('cadeiras.*', 'semestre.semestre as semestre', 'ano_letivo.ano as ano_letivo', 'cursos.nome as curso')->
                            orderBy('cadeiras.nome', 'asc')->
                            paginate(10);
                            
        return view('admin.cadeiras', compact('cadeiras'));
    }

    public function getUtilizadores() {
        $users = User::join('users_info', 'users.id', '=', 'users_info.user_id')->
                    join('perfis', 'users.perfil_id', '=', 'perfis.id')->
                    join('departamentos', 'users_info.departamento_id', '=', 'departamentos.id')->
                    join('cursos', 'users_info.curso_id', '=', 'cursos.id')->
                    select('users.*', 'users_info.*', 'perfis.nome as perfil', 'departamentos.nome as departamento', 'cursos.nome as curso')->where('users.perfil_id', '!=', 3)->get();
        return view('admin.users', compact('users'));
    }
}