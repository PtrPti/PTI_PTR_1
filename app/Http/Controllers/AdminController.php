<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\UserInfo;
use App\AnoLetivo;
use App\Semestre;
use App\Cadeira;
use App\Departamento;
use App\Curso;
use App\CursoCadeira;;
use App\Perfil;
use App\UserCadeira;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            $anosLetivos = AnoLetivo::orderBy('ano')->paginate(10);
            return view('admin.AnoLetivo.anosletivos', compact('anosLetivos'));
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

        public function addAnoLetivoPost(AdminEditAnoLetivo $request) {
            $data_inicio = DateTime::createFromFormat('Y-m-d', $request->data_inicio)->getTimestamp();
            $data_fim = DateTime::createFromFormat('Y-m-d', $request->data_fim)->getTimestamp();
            $anoLetivo = new AnoLetivo;

            $anoLetivo->ano = substr($data_inicio, -2).'/'.substr($data_fim, -2);
            $anoLetivo->dia_inicio = getdate($data_inicio)->mday;
            $anoLetivo->mes_inicio = getdate($data_inicio)->mon;
            $anoLetivo->ano_inicio = getdate($data_inicio)->year;
            $anoLetivo->dia_fim = getdate($data_fim)->mday;
            $anoLetivo->mes_fim = getdate($data_fim)->mon;
            $anoLetivo->ano_fim = getdate($data_fim)->year;
            $anoLetivo->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Ano letivo criado com sucesso', 'redirect' => '/Admin/AnosLetivos' ]);
        }

        public function addAnoLetivoCsv(AddCsvFile $request) {
            if (Input::hasFile('csvfile')) {
                if (($handle = fopen($request->file('csvfile')->getRealPath(), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                        $line = preg_split("/[,]\b/", $data[0]);

                        if (sizeof($line) != 7) {
                            //return erro;
                        }
                        else {
                            $anoLetivo = new AnoLetivo;

                            $ano = mb_convert_encoding($line[0], "UTF-8", "auto");
                            $di = mb_convert_encoding($line[1], "UTF-8", "auto");
                            $mi = mb_convert_encoding($line[2], "UTF-8", "auto");
                            $ai = mb_convert_encoding($line[3], "UTF-8", "auto");
                            $df = mb_convert_encoding($line[4], "UTF-8", "auto");
                            $mf = mb_convert_encoding($line[5], "UTF-8", "auto");
                            $af = mb_convert_encoding($line[6], "UTF-8", "auto");

                            $anoLetivo->ano = $ano;
                            $anoLetivo->dia_inicio = $di;
                            $anoLetivo->mes_inicio = $mi;
                            $anoLetivo->ano_inicio = $ai;
                            $anoLetivo->dia_fim = $df;
                            $anoLetivo->mes_fim = $mf;
                            $anoLetivo->ano_fim = $af;
                            $anoLetivo->save();
                        }
                    }
                    fclose($handle);
                }
            }
            //fazer return com o sucesso
            return redirect()->action('AdminController@getAnosLetivos');
        }

        public function searchAnosLetivos(Request $request) {            
            $result = AnoLetivo::all();

            $campos = $request->campos;
            $ano_letivo = "";
            if($campos != null || $campos != "") {              
                foreach($campos as $campo => $id) {
                    if($id != "") {
                        $result = AnoLetivo::where($campo.'_id', $id);
                    }
                    $ano_letivo = $id;
                }
            }

            $result = $result->paginate(10);

            $data = array('anosLetivos' => $result, 'ano_letivo' => $ano_letivo);

            $returnHTML = view('admin.AnoLetivo.table')->with($data)->render();
            return response()->json(array('html'=>$returnHTML));
        }
    #Ano letivo

    #Semestre
        public function getSemestres(Request $request) {
            $semestres = Semestre::join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->select('semestre.*', 'ano_letivo.ano', 'ano_letivo.id as ano_letivo_id')->
            orderBy('ano_letivo.ano')->orderBy('semestre.semestre')->paginate(10);
            $anosLetivos = AnoLetivo::select('ano', 'id')->orderBy('ano', 'asc')->get();
            return view('admin.Semestre.semestres', compact('semestres', 'anosLetivos'));
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

        public function addSemestrePost(AdminEditSemestre $request) {
            $data_inicio = DateTime::createFromFormat('Y-m-d', $request->data_inicio)->getTimestamp();
            $data_fim = DateTime::createFromFormat('Y-m-d', $request->data_fim)->getTimestamp();
            $semestre = new Semestre;

            $semestre->semestre = $request->semestre;
            $semestre->dia_inicio = getdate($data_inicio)->mday;
            $semestre->mes_inicio = getdate($data_inicio)->mon;
            $semestre->ano_inicio = getdate($data_inicio)->year;
            $semestre->dia_fim = getdate($data_fim)->mday;
            $semestre->mes_fim = getdate($data_fim)->mon;
            $semestre->ano_fim = getdate($data_fim)->year;
            $semestre->ano_letivo_id = $request->ano_letivo;
            $semestre->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Semestre criado com sucesso', 'redirect' => '/Admin/Semestres' ]);
        }

        public function addSemestreCsv(AddCsvFile $request) {
            if (Input::hasFile('csvfile')) {
                if (($handle = fopen($request->file('csvfile')->getRealPath(), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                        $line = preg_split("/[,]\b/", $data[0]);

                        if (sizeof($line) != 8) {
                            //return erro;
                        }
                        else {
                            $semestre = new Semestre;

                            $sem = mb_convert_encoding($line[0], "UTF-8", "auto");
                            $di = mb_convert_encoding($line[1], "UTF-8", "auto");
                            $mi = mb_convert_encoding($line[2], "UTF-8", "auto");
                            $ai = mb_convert_encoding($line[3], "UTF-8", "auto");
                            $df = mb_convert_encoding($line[4], "UTF-8", "auto");
                            $mf = mb_convert_encoding($line[5], "UTF-8", "auto");
                            $af = mb_convert_encoding($line[6], "UTF-8", "auto");
                            $ano_letivo = mb_convert_encoding($line[7], "UTF-8", "auto");
                            $ano_letivo_id = 0;

                            if (is_numeric($ano_letivo)) {
                                $curso_id = intval($ano_letivo);
                            }
                            else {
                                $a = AnoLetivo::select('id')->where('ano', 'like', '%'.$ano_letivo.'%')->first();
                                $ano_letivo_id = $a->id;
                            }

                            $semestre->semestre = $sem;
                            $semestre->dia_inicio = $di;
                            $semestre->mes_inicio = $mi;
                            $semestre->ano_inicio = $ai;
                            $semestre->dia_fim = $df;
                            $semestre->mes_fim = $mf;
                            $semestre->ano_fim = $af;
                            $semestre->ano_letivo_id = $ano_letivo_id;
                            $semestre->save();
                        }
                    }
                    fclose($handle);
                }
            }
            //fazer return com o sucesso
            return redirect()->action('AdminController@getSemestres');
        }

        public function searchSemestres(Request $request) {            
            $result = Semestre::join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->select('semestre.*', 'ano_letivo.ano', 'ano_letivo.id as ano_letivo_id');

            $campos = $request->campos;
            $ano_letivo = "";
            $semestre = "";
            if($campos != null || $campos != "") {              
                foreach($campos as $campo => $id) {
                    if($id != "") {
                        $result = $result->where($campo.'_id', $id);
                    }
                    $ano_letivo = $id;
                }
            }

            $result = $result->paginate(10);

            $data = array('semestres' => $result, 'ano_letivo' => $ano_letivo, 'semestre' => $semestre);

            $returnHTML = view('admin.Semestre.table')->with($data)->render();
            return response()->json(array('html'=>$returnHTML));
        }
    #Semestre
    
    #Departamento
        public function getDepartamentos(Request $request) {
            $departamentos = Departamento::orderBy('nome', 'asc')->paginate(10);
            return view('admin.Departamento.departamentos', compact('departamentos'));
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

        public function addDepartamentoPost(AdminEditDepartamento $request) {
            $departamento = new Departamento;

            $departamento->nome = $request->nome;
            $departamento->codigo = $request->codigo;
            $departamento->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Departamento criado com sucesso', 'redirect' => '/Admin/Departamentos' ]);
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

        public function searchDepartamentos(Request $request) {            
            $result = Departamento::orderBy('nome', 'asc');

            $search = $request->search;
            if ($search != null || $search != "" || $request->clear == "false") {
                $result = $result->where('nome', 'like', '%'.$search.'%')->orWhere('codigo', 'like', '%'.$search.'%');
            }

            $result = $result->paginate(10);

            $data = array('departamentos' => $result);

            $returnHTML = view('admin.Departamento.table')->with($data)->render();
            return response()->json(array('html'=>$returnHTML));
        }
    #Departamento

    #Cursos
        public function getCursos(Request $request) {
            $cursos = Curso::join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->select('cursos.*', 'departamentos.nome as departamento', 'departamentos.id as departamento_id')->paginate(10);
            $departamentos = Departamento::select('id', 'nome')->orderBy('nome')->get();
            return view('admin.Curso.cursos', compact('cursos', 'departamentos'));
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

        public function editCursoPost(AdminEditCurso $request) {
            $id = $_POST['curso_id'];
            $curso = Curso::find($id);

            $curso->nome = $request->nome;
            $curso->codigo = $request->codigo;
            $curso->departamento_id = $request->departamento;
            $curso->active = $request->ativo == null ? false : ($request->ativo == "on" ? true : false);
            $curso->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Curso alterado com sucesso', 'redirect' => '/Admin/Cursos']);            
        }

        public function addCursoPost(AdminEditCurso $request) {
            $curso = new Curso;

            $curso->nome = $request->nome;
            $curso->codigo = $request->codigo;
            $curso->departamento_id = $request->departamento;
            $curso->active = $request->ativo == null ? false : ($request->ativo == "on" ? true : false);
            $curso->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Curso criado com sucesso', 'redirect' => '/Admin/Cursos' ]);
        }

        public function addCursosCsv(AddCsvFile $request) {
            if (Input::hasFile('csvfile')) {
                if (($handle = fopen($request->file('csvfile')->getRealPath(), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                        $line = preg_split("/[,]\b/", $data[0]);

                        if (sizeof($line) != 3) {
                            //return erro;
                        }
                        else {
                            $curso = new Curso;

                            $nome = mb_convert_encoding($line[0], "UTF-8", "auto");
                            $codigo = mb_convert_encoding($line[1], "UTF-8", "auto");
                            $departamento = mb_convert_encoding($line[2], "UTF-8", "auto");
                            $departamento_id = 0;

                            if (is_numeric($departamento)) {
                                $departamento_id = intval($departamento);
                            }
                            else {
                                $d = Departamento::select('id')->where('nome', 'like', '%'.$departamento.'%')->first();
                                $departamento_id = $d->id;
                            }

                            $curso->nome = $nome;
                            $curso->codigo = $codigo;
                            $curso->departamento_id = $departamento_id;
                            $curso->save();
                        }
                    }
                    fclose($handle);
                }
            }
            //fazer return com o sucesso
            return redirect()->action('AdminController@getCursos');
        }

        public function searchCursos(Request $request) {
            $result = Curso::join('departamentos', 'cursos.departamento_id', '=', 'departamentos.id')->select('cursos.*', 'departamentos.nome as departamento', 'departamentos.id as departamento_id');

            $search = $request->search;
            if ($search != null || $search != "" || $request->clear == "false") {
                $result = $result->where('cursos.nome', 'like', '%'.$search.'%')->orWhere('cursos.codigo', 'like', '%'.$search.'%')->orWhere('departamentos.nome', 'like', '%'.$search.'%');
            }

            $campos = $request->campos;
            $departamento = "";
            if($campos != null || $campos != "") {              
                foreach($campos as $campo => $id) {
                    if($id != "") {
                        $result = $result->where($campo.'_id', $id);
                    }
                    $departamento = $id;
                }
            }

            $result = $result->paginate(10);

            $data = array('cursos' => $result, 'departamento' => $departamento);

            $returnHTML = view('admin.Curso.table')->with($data)->render();
            return response()->json(array('html'=>$returnHTML));
        }
    #Cursos

    #Disciplinas
        public function getCadeiras(Request $request) {
            $cadeiras = Cadeira::join('cursos_cadeiras', 'cadeiras.id', '=', 'cursos_cadeiras.cadeira_id')->
                                join('semestre', 'cursos_cadeiras.semestre_id', '=', 'semestre.id')->
                                join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->
                                join('cursos', 'cursos_cadeiras.curso_id', '=', 'cursos.id')->
                                select('cadeiras.*', 'cursos_cadeiras.curso_id', 'semestre.semestre', 'semestre.id as semestre_id', 'ano_letivo.ano as ano_letivo', 'ano_letivo.id as anoLetivo_id', 'cursos.nome as curso', 'cursos.id as curso_id')->
                                orderBy('cadeiras.nome', 'asc')->paginate(10);
            $cursos = Curso::select('nome', 'id')->where('active', true)->orderBy('nome', 'asc')->get();
            $anosLetivos = AnoLetivo::select('ano', 'id')->orderBy('ano', 'asc')->get();
            $semestres = Semestre::select('semestre', 'id')->orderBy('semestre', 'asc')->get();

            return view('admin.Disciplina.cadeiras', compact('cadeiras', 'cursos', 'semestres', 'anosLetivos'));
        }

        public function editCadeira(Request $request) {
            $id = $_GET['id'];
            $id2 = $_GET['id2'];
            $cadeira = Cadeira::join('cursos_cadeiras', 'cadeiras.id', '=', 'cursos_cadeiras.cadeira_id')->
                                join('semestre', 'cursos_cadeiras.semestre_id', '=', 'semestre.id')->
                                join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->
                                select('cadeiras.*', 'cursos_cadeiras.semestre_id', 'semestre.ano_letivo_id')->
                                where('cursos_cadeiras.cadeira_id',$id)->where('cursos_cadeiras.curso_id', $id2)->first();
            $cursos = Curso::where('active', true)->orderBy('nome', 'asc')->pluck('nome', 'id');
            $semestres = Semestre::where('ano_letivo_id', $cadeira->ano_letivo_id)->orderBy('semestre', 'asc')->pluck('semestre', 'id');
            $anosLetivos = AnoLetivo::orderBy('ano', 'asc')->pluck('ano', 'id');

            $data = array(
                'cadeira_id' => $id,
                'nome' => $cadeira->nome,
                'codigo' => $cadeira->codigo,
                'ano' => $cadeira->ano,
                'semestre_id' => $cadeira->semestre_id,
                'semestre' => $semestres,
                'ano_letivo_id' => $cadeira->ano_letivo_id,
                'ano_letivo' => $anosLetivos,
                'curso_id' => $id2,
                'curso' => $cursos,
            );

            return response()->json($data);
        }

        public function editCadeiraForm(Request $request, int $id) {
            $cadeira = Cadeira::find($id);
            $cursos = Curso::join('cursos_cadeiras', 'cursos.id', '=', 'cursos_cadeiras.curso_id')->
                            join('semestre', 'cursos_cadeiras.semestre_id', '=', 'semestre.id')->
                            join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->
                            select('cursos.*', 'semestre.semestre', 'ano_letivo.ano')->
                            where('cursos_cadeiras.cadeira_id', $id)->orderBy('nome', 'asc')->get();

            return view('admin.Disciplina.form', compact('cadeira', 'cursos'));
        }

        public function editCadeiraPost(AdminEditCadeira $request) {
            $id = $_POST['cadeira_id'];
            $id2 = $_POST['curso_id'];

            $cadeira = Cadeira::find($id);

            $cadeira->nome = $request->nome;
            $cadeira->codigo = $request->codigo;
            $cadeira->ano = $request->ano;
            $cadeira->active = $request->ativo == null ? false : ($request->ativo == "on" ? true : false);
            $cadeira->save();
            if($id2 != "") {
                $curso_cadeira = CursoCadeira::where('curso_id', $id2)->where('cadeira_id', $id)->first();
                $curso_cadeira->curso_id = $request->curso;
                $curso_cadeira->semestre_id = $request->semestre;
                $curso_cadeira->save();
                return response()->json(['title' => 'Sucesso', 'msg' => 'Disciplina alterado com sucesso', 'redirect' => '/Admin/Disciplinas' ]);
            }
            return redirect()->action('AdminController@editCadeiraForm', ['id' => $id]);
        }

        public function addCadeiraPost(AdminEditCadeira $request) {
            $cadeira = new Cadeira;

            $cadeira->nome = $request->nome;
            $cadeira->codigo = $request->codigo;
            $cadeira->ano = $request->ano;
            $cadeira->active = $request->ativo == null ? false : ($request->ativo == "on" ? true : false);
            $cadeira->save();

            $curso_cadeira = new CursoCadeira;
            $curso_cadeira->curso_id = $request->curso;
            $curso_cadeira->cadeira_id = $cadeira->id;
            $curso_cadeira->semestre_id = $request->semestre;
            $curso_cadeira->save();

            return response()->json(['title' => 'Sucesso', 'msg' => 'Disciplina criada com sucesso', 'redirect' => '/Admin/Disciplinas' ]);
        }

        public function addCadeirasCsv(AddCsvFile $request) {
            if (Input::hasFile('csvfile')) {
                if (($handle = fopen($request->file('csvfile')->getRealPath(), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                        $line = preg_split("/[,]\b/", $data[0]);

                        if (sizeof($line) != 7) {
                            //return erro;
                        }
                        else {
                            $nome = mb_convert_encoding($line[0], "UTF-8", "auto");
                            $codigo = mb_convert_encoding($line[1], "UTF-8", "auto");
                            $ano = mb_convert_encoding($line[2], "UTF-8", "auto");
                            $active = $line[6];

                            $curso = mb_convert_encoding($line[4], "UTF-8", "auto");
                            $curso_id = 0;
                            $semestre = mb_convert_encoding($line[3], "UTF-8", "auto");
                            $semestre_id = 0;
                            $ano_letivo = mb_convert_encoding($line[5], "UTF-8", "auto");
                            $ano_letivo_id = 0;

                            if (is_numeric($curso)) {
                                $curso_id = intval($curso);
                            }
                            else {
                                $c = Curso::select('id')->where('nome', 'like', '%'.$curso.'%')->first();
                                $curso_id = $c->id;
                            }

                            if (is_numeric($ano_letivo)) {
                                $ano_letivo_id = intval($ano_letivo);
                            }
                            else {
                                $a = AnoLetivo::select('id')->where('ano', 'like', '%'.$ano_letivo.'%')->first();
                                $ano_letivo_id = $a->id;
                            }

                            if (is_numeric($semestre)) {
                                $semestre_id = intval($semestre);
                            }
                            else {
                                $s = Semestre::select('id')->where('semestre', 'like', '%'.$semestre.'%')->where('ano_letivo_id', $ano_letivo_id)->first();
                                $semestre_id = $s->id;
                            }

                            $cadeira = new Cadeira;
                            $cadeira->nome = $nome;
                            $cadeira->codigo = $codigo;
                            $cadeira->ano = $ano;
                            $cadeira->active = $active;
                            $cadeira->save();

                            $curso_cadeira = new CursoCadeira;
                            $curso_cadeira->cadeira_id = $cadeira->id;
                            $curso_cadeira->curso_id = $curso_id;
                            $curso_cadeira->semestre_id = $semestre_id;
                            $curso_cadeira->save();
                        }
                    }
                    fclose($handle);
                }
            }
            //fazer return com o sucesso
            return redirect()->action('AdminController@getCadeiras');
        }

        public function searchCadeiras(Request $request) {            
            $result = Cadeira::join('cursos_cadeiras', 'cadeiras.id', '=', 'cursos_cadeiras.cadeira_id')->
                                            join('semestre', 'cursos_cadeiras.semestre_id', '=', 'semestre.id')->
                                            join('ano_letivo', 'semestre.ano_letivo_id', '=', 'ano_letivo.id')->
                                            join('cursos', 'cursos_cadeiras.curso_id', '=', 'cursos.id')->
                                            select('cadeiras.*', 'cursos_cadeiras.curso_id', 'semestre.semestre', 'semestre.id as semestre_id', 'ano_letivo.ano as ano_letivo', 'ano_letivo.id as ano_letivo_id', 'cursos.nome as curso', 'cursos.id as curso_id')->
                                            orderBy('cadeiras.nome', 'asc');

            $search = $request->search;
            if ($search != null || $search != "" || $request->clear == "false") {
                $result = $result->where('cadeiras.nome', 'like', '%'.$search.'%')->orWhere('cadeiras.codigo', 'like', '%'.$search.'%')->orWhere('cursos.nome', 'like', '%'.$search.'%');
            }

            $campos = $request->campos;
            $curso = "";
            $semestre = "";
            $ano_letivo = "";
            if($campos != null || $campos != "") {              
                foreach($campos as $campo => $id) {
                    if($id != "") {
                        $result = $result->where($campo.'_id', $id);
                    }
                    if($campo == "curso") {
                        $curso = $id;
                    }
                    else if ($campo == "semestre") {
                        $semestre = $id;
                    }
                    else if ($campo == "ano_letivo") {
                        $ano_letivo = $id;
                    }
                }
            }

            $result = $result->paginate(10);

            $data = array('cadeiras' => $result, 'curso' => $curso, 'semestre' => $semestre, 'ano_letivo' => $ano_letivo);

            $returnHTML = view('admin.Disciplina.table')->with($data)->render();
            return response()->json(array('html'=>$returnHTML));
        }
    #Disciplinas

    #Utilizadores
        public function getUtilizadores(Request $request) {
            $users = User::join('users_info', 'users.id', '=', 'users_info.user_id')->
                        join('perfis', 'users.perfil_id', '=', 'perfis.id')->
                        join('departamentos', 'users_info.departamento_id', '=', 'departamentos.id')->
                        join('cursos', 'users_info.curso_id', '=', 'cursos.id')->
                        select('users.id as userId', 'users.nome as nome', 'users.email as email','users.active', 'users_info.*', 'perfis.nome as perfil', 'perfis.id as perfil_id', 'departamentos.id as departamento_id',
                             'departamentos.nome as departamento', 'cursos.id as cruso_id', 'cursos.nome as curso')->
                        where('users.perfil_id', '!=', 3)->orderBy('users.nome')->paginate(10);
            $departamentos = Departamento::select('id', 'nome')->orderBy('nome')->get();
            $cursos = Curso::select('id', 'nome')->orderBy('nome')->get();
            $perfis = Perfil::select('id', 'nome')->where('id', '!=', 3)->orderBy('nome')->get();
            return view('admin..Utilizador.users', compact('users', 'departamentos', 'cursos', 'perfis'));
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

        public function editUserForm(Request $request, int $id) {
            $user = User::join('users_info', 'users.id', '=', 'users_info.user_id')->
                        join('perfis', 'users.perfil_id', '=', 'perfis.id')->
                        select('users.id as userId', 'users.nome as nome', 'users.email as email', 'users_info.*', 'perfis.nome as perfil')->
                        where('users.id', $id)->first();
            $cursos = Curso::where('departamento_id', $user->departamento_id)->orderBy('nome', 'asc')->pluck('nome', 'id');
            $departamentos = Departamento::orderBy('nome', 'asc')->pluck('nome', 'id');
            $matriculas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->
                        join('ano_letivo', 'users_cadeiras.ano_letivo_id', '=', 'ano_letivo.id')->get();

            return view('admin.Utilizador.form', compact('user', 'cursos', 'departamentos', 'matriculas'));
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

            if($_POST['form'] == "form") {
                return redirect()->action('AdminController@editUserForm', ['id' => $id]);
            }
            
            return response()->json(['title' => 'Sucesso', 'msg' => 'Utilizador alterado com sucesso', 'redirect' => '/Admin/Utilizadores' ]);
        }

        public function addUserCsv(AddCsvFile $request) {
            $usersIds = [];
            if (($handle = fopen($request->file('csvfile')->getRealPath(), "r")) !== FALSE) { #users
                while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                    $line = preg_split("/[,]\b/", $data[0]);
                    
                    if (sizeof($line) != 18) {
                        //return erro;
                    }
                    else {
                        $nome = mb_convert_encoding($line[1], "UTF-8", "auto");
                        $email = mb_convert_encoding($line[2], "UTF-8", "auto");
                        $password = mb_convert_encoding($line[3], "UTF-8", "auto");
                        $perfil = mb_convert_encoding($line[6], "UTF-8", "auto");
                        $numero = mb_convert_encoding($line[10], "UTF-8", "auto");
                        $departamento = mb_convert_encoding($line[11], "UTF-8", "auto");
                        $curso = mb_convert_encoding($line[12], "UTF-8", "auto");

                        $user = new User;
                        $user->nome = $nome;
                        $user->email = $email;
                        $user->password = bcrypt($password);
                        $user->perfil_id = $perfil;
                        $user->save();
                        
                        $user_info = new UserInfo;
                        $user_info->user_id = $user->id;
                        $user_info->numero = $numero;
                        $user_info->departamento_id = $departamento;
                        $user_info->curso_id = $curso;
                        $user_info->data_nascimento = new DateTime('2000-01-01');
                        $user_info->save();
                        array_push($usersIds, $user->id);
                        array_push($usersIds, $user->id);
                        array_push($usersIds, $user->id);
                        array_push($usersIds, $user->id);
                    }
                }
                fclose($handle);
            }

            if (($handle = fopen($request->file('csvfilecadeira')->getRealPath(), "r")) !== FALSE) { #users
                while (($data = fgetcsv($handle, 1000, "\n")) !== FALSE) {
                    $line = preg_split("/[,]\b/", $data[0]);

                    if (sizeof($line) != 4) {
                        //return erro;
                    }
                    else {
                        set_time_limit(20);
                        $cadeira = mb_convert_encoding($line[2], "UTF-8", "auto");
                        $favorito = mb_convert_encoding($line[3], "UTF-8", "auto");

                        $c = Cadeira::select('id')->where('nome', 'like', '%'.$cadeira.'%')->first();
                        $cadeira_id = $c->id;

                        $uc = new UserCadeira;
                        $uc->user_id = array_shift($usersIds);
                        $uc->cadeira_id = $cadeira_id;
                        $uc->favorito = $favorito;
                        $uc->save();
                    }
                }
                fclose($handle);
            }
            return redirect()->action('AdminController@getUtilizadores');
        }

        public function searchUsers(Request $request) {            
            $result = User::join('users_info', 'users.id', '=', 'users_info.user_id')->
                            join('perfis', 'users.perfil_id', '=', 'perfis.id')->
                            join('departamentos', 'users_info.departamento_id', '=', 'departamentos.id')->
                            join('cursos', 'users_info.curso_id', '=', 'cursos.id')->
                            select('users.id as userId', 'users.nome as nome', 'users.email as email', 'users_info.*', 'perfis.nome as perfil', 'perfis.id as perfil_id', 'departamentos.id as departamento_id',
                             'departamentos.nome as departamento', 'cursos.id as cruso_id', 'cursos.nome as curso')->
                            where('users.perfil_id', '!=', 3);

            $search = $request->search;
            if ($search != null || $search != "" || $request->clear == "false") {
                $result = $result->where('users.nome', 'like', '%'.$search.'%')->orWhere('users_info.numero', 'like', '%'.$search.'%')->orWhere('users.email', 'like', '%'.$search.'%');
            }

            $campos = $request->campos;
            $curso = "";
            $departamento = "";
            $perfil = "";
            if($campos != null || $campos != "") {              
                foreach($campos as $campo => $id) {
                    if($campo == "curso") {
                        $curso = $id;
                        if($id != "") {
                            $result = $result->where('cursos.id', $id);
                        }
                    }
                    else if ($campo == "departamento") {
                        $departamento = $id;
                        if($id != "") {
                            $result = $result->where('departamentos.id', $id);
                        }
                    }
                    else if ($campo == "perfil") {
                        $perfil = $id;
                        if($id != "") {
                            $result = $result->where($campo.'_id', $id);
                        }
                    }
                }
            }

            $result = $result->paginate(10);

            $data = array('users' => $result, 'curso' => $curso, 'departamento' => $departamento, 'perfil' => $perfil);

            $returnHTML = view('admin.Utilizador.table')->with($data)->render();
            return response()->json(array('html'=>$returnHTML));
        }

        public function lockUser(Request $request) {
            $id = $_POST['id'];
            $user = User::find($id);
            $user->active = false;
            $user->save();
            return response()->json(['title' => 'Sucesso', 'msg' => 'Utilizador desativado com sucesso', 'redirect' => '/Admin/Utilizadores' ]);
        }

        public function unlockUser(Request $request) {
            $id = $_POST['id'];
            $user = User::find($id);
            $user->active = true;
            $user->save();
            return response()->json(['title' => 'Sucesso', 'msg' => 'Utilizador ativado com sucesso', 'redirect' => '/Admin/Utilizadores' ]);
        }

        public function exportUsersExcel(Request $request) {            
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
            $spreadsheet = $reader->loadFromString($request->table);
            $title = $request->title;
            
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
            
            ob_start();
            $writer->save('php://output');
            $content = ob_get_contents();
            ob_end_clean();

            Storage::disk('public')->put($title.".xls", $content);
            $file_path = storage_path() . '\app\public\\'.$title.'.xls';
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Length' => filesize($file_path),
                'Content-Disposition' => 'attachment; filename="'.$title.'.xls"',

            ];
            return response()->download($file_path)->deleteFileAfterSend($file_path);            
        }
    #Utilizadores

    public function exportExcel(Request $request) {            
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
        $spreadsheet = $reader->loadFromString($request->table);
        $title = $request->title;
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
        
        ob_start();
        $writer->save('php://output');
        $content = ob_get_contents();
        ob_end_clean();

        Storage::disk('public')->put($title.".xls", $content);
        $file_path = storage_path() . '\app\public\\'.$title.'.xls';
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Length' => filesize($file_path),
            'Content-Disposition' => 'attachment; filename="'.$title.'.xls"',
        ];
        return response()->download($file_path)->deleteFileAfterSend($file_path);            
    }

    public function changeAnoLetivoId(Request $request, int $id) {
        $html = '<option value="">-- Selecionar semestre --</option>';
        
        $semestres = Semestre::where('ano_letivo_id', $id)->orderBy('semestre')->get();
        foreach ($semestres as $s) {
            $html .= '<option value="'.$s->id.'">'.$s->semestre.'</option>';
        }

        return response()->json(['html' => $html]);
    }

    public function changeDepartamentoId(Request $request, int $id) {
        $html = '<option value="">--Selecionar curso--</option>';
        
        $cursos = Curso::where('departamento_id', $id)->orderBy('nome')->get();
        foreach ($cursos as $c) {
            $html .= '<option value="'.$c->id.'">'.$c->nome.'</option>';
        }

        return response()->json(['html' => $html]);
    }

    public function changeCursoId(Request $request, int $id) {
        $html = '<option value="">-- Selecionar disciplina --</option>';
        
        $cadeiras = CadeiraCurso::join('cadeiras', 'cursos_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('cursos_cadeiras.curso_id', $id)->
                                where('cadeiras.active', true)->orderBy('nome')->get();
        foreach ($cadeiras as $c) {
            $html .= '<option value="'.$c->id.'">'.$c->nome.'</option>';
        }

        return response()->json(['html' => $html]);
    }
}