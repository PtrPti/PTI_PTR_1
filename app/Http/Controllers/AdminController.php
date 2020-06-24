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
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\AdminEditUser;
use App\Http\Requests\AdminEditDepartamento;
use App\Http\Requests\AdminEditAnoLetivo;
use App\Http\Requests\AdminEditSemestre;
use App\Http\Requests\AdminEditCadeira;
use App\Http\Requests\AdminEditCurso;
use App\Http\Requests\AddCsvFile;
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
        return view('homeAdmin');
    }

    #Ano letivo
        public function getAnosLetivos(Request $request) {
            $anosLetivos = AnoLetivo::paginate(10);
            return view('admin.anosletivos', compact('anosLetivos'));
        }

        public function editAnoLetivo(Request $request) {
            $id = $_GET['id'];
            $anoLetivo = AnoLetivo::find($id);

            $data = array(
                'ano_letivo_id' => $id,
                'ano' => $anoLetivo->ano,
                'data_inicio' => $anoLetivo->getFullDate($anoLetivo->dia_inicio, $anoLetivo->mes_inicio, $anoLetivo->ano_inicio, 'Y-m-d'),
                'data_fim' => $anoLetivo->getFullDate($anoLetivo->dia_fim, $anoLetivo->mes_fim, $anoLetivo->ano_fim, 'Y-m-d'),
            );

            return response()->json($data);
        }

        public function editAnoLetivoPost(AdminEditAnoLetivo $request) {
            $id = $_POST['ano_letivo_id'];
            $anoLetivo = AnoLetivo::find($id);

            $anoLetivo->ano = $request->ano;
            $anoLetivo->dia_inicio = $anoLetivo->getDay($request->data_inicio);
            $anoLetivo->mes_inicio = $anoLetivo->getMonth($request->data_inicio);
            $anoLetivo->ano_inicio = $anoLetivo->getYear($request->data_inicio);

            $anoLetivo->dia_fim = $anoLetivo->getDay($request->data_fim);
            $anoLetivo->mes_fim = $anoLetivo->getMonth($request->data_fim);
            $anoLetivo->ano_fim = $anoLetivo->getYear($request->data_fim);
            $anoLetivo->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Ano letivo alterado com sucesso', 'redirect' => '/Admin/AnosLetivos']);
        }
    #Ano letivo

    #Semestre
        public function getSemestres(Request $request) {
            $semestres = Semestre::join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->select('semestre.*', 'ano_letivo.ano')->paginate(10);
            return view('admin.semestres', compact('semestres'));
        }

        public function editSemestre(Request $request) {
            $id = $_GET['id'];
            $semestre = Semestre::join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->
                            select('semestre.*', 'ano_letivo.id as ano_letivo_id', 'ano_letivo.ano')->where('semestre.id', $id)->first();
            $anos_letivos = AnoLetivo::orderBy('ano', 'asc')->pluck('ano', 'id');

            $data = array(
                'semestre_id' => $id,
                'semestre' => $semestre->semestre,
                'ano_letivo_id' => $semestre->ano_letivo_id,
                'ano_letivo' => $anos_letivos,
                'data_inicio' => $semestre->getFullDate($semestre->dia_inicio, $semestre->mes_inicio, $semestre->ano_inicio, 'Y-m-d'),
                'data_fim' => $semestre->getFullDate($semestre->dia_fim, $semestre->mes_fim, $semestre->ano_fim, 'Y-m-d'),
            );

            return response()->json($data);
        }

        public function editSemestrePost(AdminEditSemestre $request) {
            $id = $_POST['semestre_id'];
            $semestre = Semestre::find($id);

            $semestre->semestre = $request->semestre;
            $semestre->ano_letivo_id = $request->ano_letivo;
            $semestre->dia_inicio = $semestre->getDay($request->data_inicio);
            $semestre->mes_inicio = $semestre->getMonth($request->data_inicio);
            $semestre->ano_inicio = $semestre->getYear($request->data_inicio);

            $semestre->dia_fim = $semestre->getDay($request->data_fim);
            $semestre->mes_fim = $semestre->getMonth($request->data_fim);
            $semestre->ano_fim = $semestre->getYear($request->data_fim);
            $semestre->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Semestre alterado com sucesso', 'redirect' => '/Admin/Semestres']);
        }
    #Semestre
    
    #Departamento
        public function getDepartamentos(Request $request) {
            $departamentos = Departamento::paginate(10);
            return view('admin.departamentos', compact('departamentos'));
        }

        public function editDepartamento(Request $request) {
            $id = $_GET['id'];
            $departamento = Departamento::find($id);

            $data = array(
                'departamento_id' => $id,
                'nome' => $departamento->nome,
                'codigo' => $departamento->codigo,
            );

            return response()->json($data);
        }

        public function editDepartamentoPost(AdminEditDepartamento $request) {
            $id = $_POST['departamento_id'];

            $departamento = Departamento::find($id);

            $departamento->nome = $request->nome;
            $departamento->codigo = $request->codigo;
            $departamento->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Departamento alterado com sucesso', 'redirect' => '/Admin/Departamentos' ]);
        }

        public function addDepartamentoCsv(AddCsvFile $request) {
            if (Input::hasFile('csvfile')) {
                if (($handle = fopen($request->file('csvfile')->getRealPath(), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                        $line = preg_split("/[,]\b/", $data[0]);

                        if (sizeof($line) != 2) {
                            //return erro;
                        }
                        else {
                            $departamento = new Departamento;

                            $nome = mb_convert_encoding($line[0], "UTF-8", "auto");
                            $codigo = mb_convert_encoding($line[1], "UTF-8", "auto");

                            $departamento->nome = $nome;
                            $departamento->codigo = $codigo;
                            $departamento->save();
                        }
                    }
                    fclose($handle);
                }
            }
            //fazer return com o sucesso
            return redirect()->action('AdminController@getDepartamentos');
        }
    #Departamento

    #Cursos
        public function getCursos(Request $request) {
            $cursos = Curso::join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->select('cursos.*', 'departamentos.nome as departamento')->paginate(10);
            return view('admin.cursos', compact('cursos'));
        }

        public function editCurso(Request $request) {
            $id = $_GET['id'];
            $curso = Curso::join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->select('cursos.*', 'departamentos.nome as departamento')->where('cursos.id', $id)->first();
            $departamentos = Departamento::orderBy('nome')->pluck('nome', 'id');

            $data = array(
                'curso_id' => $id,
                'nome' => $curso->nome,
                'codigo' => $curso->codigo,
                'departamento_id' => $curso->departamento_id,
                'departamento' => $departamentos,
                'checkbox' => 1,
                'ativo' => $curso->active
            );

            return response()->json($data);
        }

        // public function editCursoPost(Request $request) {
        public function editCursoPost(AdminEditCurso $request) {
            $id = $_POST['curso_id'];
            $curso = Curso::find($id);

            $curso->nome = $request->nome;
            $curso->codigo = $request->codigo;
            $curso->departamento_id = $request->departamento;
            $curso->active = $request->ativo;
            $curso->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Curso alterado com sucesso', 'redirect' => '/Admin/Cursos']);
        }
    #Cursos

    #Disciplinas
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

        public function editCadeira(Request $request) {
            $id = $_GET['id'];
            $departamento = Departamento::find($id);

            $data = array(
                'departamento_id' => $id,
                'nome' => $departamento->nome,
                'codigo' => $departamento->codigo,
            );

            return response()->json($data);
        }

        public function editCadeiraPost(AdminEditCadeira $request) {
            $id = $_POST['departamento_id'];

            $departamento = Departamento::find($id);

            $departamento->nome = $request->nome;
            $departamento->codigo = $request->codigo;
            $departamento->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Departamento alterado com sucesso', 'redirect' => '/Admin/Departamentos' ]);
        }
    #Disciplinas

    #Utilizadores
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
            $id = $_GET['id'];
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

        public function addUserCsv(AddCsvFile $request) {
            if (Input::hasFile('csvfile')) {
                $path = $request->file('csvfile')->getRealPath();
                error_log($path);

                $data = array_map('str_getcsv', file($path));
                print_r($data);
            }
        }
    #Utilizadores
    

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