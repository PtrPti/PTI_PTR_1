<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\Cadeira;
use App\Grupo;
use App\Tarefa;
use App\GrupoFicheiros;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Auth;
use DateTime;

class ProjetoController extends Controller
{
    public function index($tab = "tab1"){
        $user = Auth::user()->getUser();  
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = DB::select('select * from projetos p
                                where p.cadeira_id in (select ca.id from users_cadeiras uc
                                inner join cadeiras ca
                                 on uc.cadeira_id = ca.id
                                 where uc.user_id = ?)', [$user->id]);        
        $active_tab = $tab;

        return view('docente.docenteHome', compact('disciplinas', 'projetos', 'active_tab'));
    }

    public function pagProjeto(int $grupo_id){
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                        ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                        ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                        ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                            ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id')->get();
        
        /* Cabecalho da pagina Projetos */
        $nomesUsers = User::join('users_grupos','users_grupos.user_id', '=','users.id')
                        ->where('users_grupos.grupo_id','=',$grupo_id)->select('users.nome')->get();     
        $grupo = Grupo::where('id', $grupo_id)->first();
        $projeto = Projeto::where('id', $grupo_id)->first();
        $id_disciplina = $projeto->cadeira_id;
        $disciplina = Cadeira::where('id', $id_disciplina)->first();

        /* Tarefas Grupo */
        $tarefas = Tarefa::where('grupo_id',$grupo_id)->get();

        /* Ficheiros Grupo */
        $ficheiros = GrupoFicheiros::where('grupo_id',$grupo_id)->get();

        $IdGrupo = $grupo_id;

        return view('aluno.projetosAluno', compact('cadeiras','projetos','nomesUsers','grupo','disciplina','projeto','tarefas','ficheiros','IdGrupo'));
    }

    public function editTarefa(Request $request) {
        $id = $_GET['id'];
        $val = $_GET['val'];

        $tarefa = Tarefa::find($id);
        $tarefa->estado = $val == "false"?FALSE:TRUE;
        $tarefa->save();

        return response()->json('Guardado com sucesso');
    }

    public function editAllTarefa(Request $request) {
        $id = $_GET['id'];
        $val = $_GET['val'];
        $val = $val == "false"?FALSE:TRUE;

        $subtarefas = Tarefa::where('tarefa_id', $id)->update(['estado'=>$val]);

        $tarefa = Tarefa::find($id);
        $tarefa->estado = $val;
        $tarefa->save();

        return response()->json('Guardado com sucesso');
    }

    public function addPasta(Request $request) {
        $nome = $_GET['nome'];
        $grupoId = $_GET['grupoId'];

        $pasta = new GrupoFicheiros;
        $pasta->nome = $nome;
        $pasta->is_folder = TRUE;
        $pasta->grupo_id = $grupoId;
        $pasta->save();

        return response()->json('Adicionado com sucesso');
    }

    public function addLink(Request $request) {
        $pastaId = $_GET['Pasta'];
        $nome = $_GET['nome'];
        $link = $_GET['url'];
        
        $grupoId = $_GET['grupoId'];

        $site = new GrupoFicheiros;
        
        if ($pastaId === ''){
            $site->pasta_id = NULL;
        } else {
            $site->pasta_id = $pastaId;
        }
        $site->nome = $nome;
        $site->is_folder = FALSE;
        $site->grupo_id = $grupoId;
        $site->link = $link;
        $site->save();

        return response()->json('Adicionado com sucesso');
    }

    public function uploadFicheiro(Request $request) {
        $pastaId = $_POST['Pasta'];
        $grupoId = $_POST['grupoId'];


        $file = new GrupoFicheiros;
        if ($pastaId === ''){
            $file->pasta_id = NULL;
        } else {
            $file->pasta_id = $pastaId;
        }
        $file->is_folder = FALSE;
        $file->grupo_id = $grupoId;
        $file->nome = $request->ficheiro->getClientOriginalName();

        $file->save();

        $filename = $file->id. '.' .$request->ficheiro->getClientOriginalExtension();
        $request->file('ficheiro')->storeAs('public/ficheiros_grupos', $filename);

        return response()->json('Adicionado com sucesso');
    }

    public function id_projetos(int $id){
        $projeto = Projeto::where('id', $id)->first();
        $user = Auth::user()->getUser();
        $id_disciplina = $projeto->cadeira_id;
        $cadeira = Cadeira::where('id', $id_disciplina)->first();
        $grupos = Grupo::where('projeto_id', $id)->get();
        $gruposcount = $grupos->count(); 

        error_log($cadeira->nome);

        return view ('projeto.paginaProjetos', compact('projeto', 'cadeira', 'gruposcount', 'grupos')); 
    }

    public function eraseProject($id){
        DB::delete('delete from projetos where id=?', [$id]);
        echo "Record deleted successfully.<br/>";
        return redirect()->action('HomeController@indexDocente', ['tab' => 'tab2']);
    }    
}