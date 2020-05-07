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
    /* public function index($tab = "tab1"){
        $user = Auth::user()->getUser();  
        $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = DB::select('select * from projetos p
                                where p.cadeira_id in (select ca.id from users_cadeiras uc
                                inner join cadeiras ca
                                 on uc.cadeira_id = ca.id
                                 where uc.user_id = ?)', [$user->id]);        
        $active_tab = $tab;

        return view('docente.docenteHome', compact('disciplinas', 'projetos', 'active_tab'));
    } */

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
                        ->where('users_grupos.grupo_id','=',$grupo_id)->select('users.nome','users.id')->get();     
        $grupo = Grupo::where('id', $grupo_id)->first();
        $projeto = Projeto::where('id', $grupo_id)->first();
        $id_disciplina = $projeto->cadeira_id;
        $disciplina = Cadeira::where('id', $id_disciplina)->first();

        /* Tarefas Grupo */
        $tarefas = Tarefa::where('grupo_id', $grupo_id)->orderBy('ordem','ASC')->get();

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

        /* Tarefas Grupo */
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $tarefas = Tarefa::where('grupo_id', $grupo[0]->grupo_id )->orderBy('ordem','ASC')->get();

        $nomesUsers = User::join('users_grupos','users_grupos.user_id', '=','users.id')
                        ->where('users_grupos.grupo_id','=',$grupo[0]->grupo_id)->select('users.nome','users.id')->get();

        $data = array('tarefas' => $tarefas, 'nomesUsers' => $nomesUsers);

        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function editAllTarefa(Request $request) {
        $id = $_GET['id'];
        $val = $_GET['val'];
        $val = $val == "false"?FALSE:TRUE;

        $subtarefas = Tarefa::where('tarefa_id', $id)->update(['estado'=>$val]);

        $tarefa = Tarefa::find($id);
        $tarefa->estado = $val;
        $tarefa->save();
    
        /* Tarefas Grupo */
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $tarefas = Tarefa::where('grupo_id', $grupo[0]->grupo_id )->orderBy('ordem','ASC')->get();

        $nomesUsers = User::join('users_grupos','users_grupos.user_id', '=','users.id')
                        ->where('users_grupos.grupo_id','=',$grupo[0]->grupo_id)->select('users.nome','users.id')->get();

        $data = array('tarefas' => $tarefas, 'nomesUsers' => $nomesUsers);

        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
        
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

    public function addTarefa(Request $request) {
        $nome = $_GET['nome'];
        $ordemT = $_GET['ordem'];
        $grupoId = $_GET['grupoId'];
        $projetoId = $_GET['projetoId'];
        $prazo = $_GET['prazo'];

        $tarefas = Tarefa::whereNull('tarefa_id')->get();

        foreach ($tarefas as $tarefa) {
            if ($tarefa->ordem > $ordemT ){
                $ord = $tarefa->ordem + 1;
                $tarefa->ordem = $ord;
                $tarefa->save();
            }
        }

        $novaTarefa = new Tarefa;
        $novaTarefa->nome = $nome;
        $novaTarefa->ordem = $ordemT+1;
        $novaTarefa->grupo_id = $grupoId;
        $novaTarefa->projeto_id = $projetoId;
        $novaTarefa->prazo = $prazo;
        $novaTarefa->estado = FALSE;
        $novaTarefa->save();

        return response()->json('Adicionado com sucesso');
    }

    public function addSubTarefa(Request $request) {
        $nome = $_GET['nome'];
        $tarefaId = $_GET['tarefaId'];
        $ordemT = $_GET['ordem'];
        $grupoId = $_GET['grupoId'];
        $projetoId = $_GET['projetoId'];
        $prazo = $_GET['prazo'];

        $subtarefas = Tarefa::where('tarefa_id',$tarefaId)->get();

        foreach ($subtarefas as $sub) {
            if ($sub->ordem > $ordemT ){
                $ord = $sub->ordem + 1;
                $sub->ordem = $ord;
                $sub->save();
            }
        }

        $novaSubTarefa = new Tarefa;
        $novaSubTarefa->nome = $nome;
        $novaSubTarefa->ordem = $ordemT+1;
        $novaSubTarefa->tarefa_id = $tarefaId;
        $novaSubTarefa->grupo_id = $grupoId;
        $novaSubTarefa->projeto_id = $projetoId;
        $novaSubTarefa->prazo = $prazo;
        $novaSubTarefa->estado = FALSE;
        $novaSubTarefa->save();
        
        return response()->json('Adicionado com sucesso');
    }

    public function subTarefas(Request $request) {
        $id = $_GET['tarefaId'];
        $str = '<option value="0" >Inicio</option>';
        $subtarefas = Tarefa::where('tarefa_id',$id)->get();

        foreach ($subtarefas as $sub) {
            $str .= "<option value='".$sub->ordem."'>Depois de: ".$sub->nome."</option>";
        }

        return response()->json($str);
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

    public function pesquisar(Request $request){
        $aluno = $_GET['aluno'];
        $grupoId = $_GET['grupoId'];

        $alunoId = User::select('id')->whereIn('nome',$aluno)->get();

        if ($alunoId->isEmpty()){
            $tarefas = Tarefa::where('grupo_id', $grupoId )->orderBy('ordem','ASC')->get();
        } else{
            
        }
        

        return response()->json();
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