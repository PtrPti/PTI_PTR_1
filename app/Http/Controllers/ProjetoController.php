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
use App\TarefasFicheiros;
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

    public function viewTarefasAluno(int $grupoId){
        $tarefas = Tarefa::where('grupo_id', $grupoId)->orderBy('ordem','ASC')->get();
        $percentagem = $this->barraProgresso($grupoId);
        
        $ids = [];
        foreach ($tarefas as $tarefa) {
            array_push($ids, $tarefa->id);
        }
        $ficheirosTarefas = TarefasFicheiros::whereIn('tarefa_id', $ids )->get();
        $nomesUsers = User::join('users_grupos','users_grupos.user_id', '=','users.id')
                        ->where('users_grupos.grupo_id','=', $grupoId)->select('users.nome','users.id')->get();       
        $data = array('tarefas' => $tarefas, 'nomesUsers' => $nomesUsers,'ficheirosTarefas' => $ficheirosTarefas, 'IdGrupo' => $grupoId, 'percentagem' => $percentagem);
        return $data;
    }

    public function pagProjeto(int $grupo_id, int $tarefa_id=0){

        $data = $this->viewTarefasAluno($grupo_id);
        
        $user = Auth::user()->getUser();
        $cadeiras = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')
                                  ->where('users_cadeiras.user_id', $user->id)->get();
        $projetos = User::join('users_grupos', 'users.id', '=', 'users_grupos.user_id')
                        ->join('grupos', 'users_grupos.grupo_id', '=', 'grupos.id')
                        ->join('projetos', 'grupos.projeto_id', '=', 'projetos.id')
                        ->join('cadeiras', 'projetos.cadeira_id', '=', 'cadeiras.id')
                            ->where('users.id', $user->id)->select('cadeiras.nome as cadeiras', 'projetos.nome as projeto', 'grupos.numero','grupos.id')->get();
        $grupo = Grupo::where('id', $grupo_id)->first();
        $projeto = Projeto::where('id', $grupo_id)->first();
        $id_disciplina = $projeto->cadeira_id;
        $disciplina = Cadeira::where('id', $id_disciplina)->first();
        $ficheiros = GrupoFicheiros::where('grupo_id',$grupo_id)->get();
        
        $tarefas = $data['tarefas'];
        $nomesUsers = $data['nomesUsers'];
        $ficheirosTarefas = $data['ficheirosTarefas'];
        $IdGrupo = $data['IdGrupo'];
        $percentagem = $data['percentagem'];

        $tarefaId = $tarefa_id;

        return view('aluno.projetosAluno', compact('tarefaId','cadeiras','projetos','grupo','disciplina','projeto','ficheiros','tarefas','nomesUsers','IdGrupo','ficheirosTarefas','percentagem'));
    }

    public function barraProgresso(Int $id){
        $tarefas = Tarefa::where('grupo_id', $id)->get();
        $ids = [];
        $tarefasDone = 0;
        foreach ($tarefas as $tarefa){
            foreach ($tarefas as $subtarefa){
                if ($tarefa->tarefa_id === NULL and $tarefa->id == $subtarefa->tarefa_id){
                    if ( !in_array($tarefa->id , $ids)){
                        array_push($ids, $tarefa->id);
                    }
                    if($subtarefa->estado){
                        $tarefasDone ++;
                    }
                }
            }
            if ( !in_array($tarefa->id, $ids) and $tarefa->tarefa_id === NULL){
                if($tarefa->estado){
                    $tarefasDone ++;
                }
            }
        }
        $totalTarefas = count($tarefas) -count($ids);
        $percentagem = round($tarefasDone*100/$totalTarefas);
        return $percentagem;
    }


    public function editTarefa(Request $request) {
        $id = $_GET['id'];
        $val = $_GET['val'];

        $tarefa = Tarefa::find($id);
        $tarefa->estado = $val == "false"?FALSE:TRUE;
        $tarefa->save();    

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $IdGrupo = $grupo[0]->grupo_id;

        $data = $this->viewTarefasAluno($IdGrupo);
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

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $IdGrupo = $grupo[0]->grupo_id;
    
        $data = $this->viewTarefasAluno($IdGrupo);
        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
        
    }

    public function infoTarefa(Request $request) {
        $id = $_GET['id'];  
        
        $tarefa = Tarefa::where('id', $id )->get();
        $fichTarefa = TarefasFicheiros::where('tarefa_id', $id )->get();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $IdGrupo = $grupo[0]->grupo_id;
        $nomesUsers = User::join('users_grupos','users_grupos.user_id', '=','users.id')
                        ->where('users_grupos.grupo_id','=',$IdGrupo)->select('users.nome','users.id')->get();

        $data = array('tarefaEdit' => $tarefa, 'fichTarefa' => $fichTarefa, 'nomesUsers' => $nomesUsers);
        $returnHTML = view('aluno.editarTarefa')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function alterarTarefa(Request $request) {
        $id = $_GET['tarefaId'];  
        $nome = $_GET['nome'];  
        $prazo  = date('Y-m-d H:i:s', strtotime($_GET['prazo']));  
        $alunoId = $_GET['alunoId'];  
        if ($alunoId==0){ $alunoId = NULL;}

        $tarefa = Tarefa::find($id);
        $tarefa->nome = $nome;
        $tarefa->prazo = $prazo;
        $tarefa->user_id = $alunoId;
        $tarefa->save();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $IdGrupo = $grupo[0]->grupo_id;

        $data = $this->viewTarefasAluno($IdGrupo);
        
        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));       
    }

    public function infoNota(Request $request) {
        $tipo = $_GET['tipo']; 
        $id = $_GET['id'];  

        if($tipo == 'grupo'){
            $nota = GrupoFicheiros::where('id',$id)->get();
        } else {
            $nota = TarefasFicheiros::where('id',$id)->get();
        }

        $data = array('nota' => $nota);
        $returnHTML = view('aluno.notaAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function saveNota(Request $request) {
        $tipo = $_GET['tipo']; 
        $id = $_GET['id']; 
        $nota =  $_GET['nota']; 

        if($tipo == 'grupo'){
            $notaSave = GrupoFicheiros::find($id);
        } else {
            $notaSave = TarefasFicheiros::find($id);
        }
        $notaSave->notas = $nota;
        $notaSave->save(); 
    }

    public function eliminarFicheiro(Request $request) {
        $id = $_GET['idT'];  
        $idF = $_GET['idF'];  
        
        if ($idF == 0){
            $tarefa = Tarefa::find($id);
            $tarefa->notas = "";
            $tarefa->save();
        } else {
            TarefasFicheiros::destroy($idF);
        }

        $tarefa = Tarefa::where('id', $id )->get();
        $fichTarefa = TarefasFicheiros::where('tarefa_id', $id )->get();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->get();
        $IdGrupo = $grupo[0]->grupo_id;

        $dataV = $this->viewTarefasAluno($IdGrupo);
        $tarefas = $dataV['tarefas'];
        $nomesUsers = $dataV['nomesUsers'];
        $ficheirosTarefas = $dataV['ficheirosTarefas'];
        $IdGrupo = $dataV['IdGrupo'];
        $percentagem = $dataV['percentagem'];

        $data = array('tarefaEdit' => $tarefa, 'fichTarefa' => $fichTarefa, 'tarefas' => $tarefas,
                    'nomesUsers' => $nomesUsers,'ficheirosTarefas' => $ficheirosTarefas,'IdGrupo' => $IdGrupo , 'percentagem'=>$percentagem);
        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML,'abrir'=>1));
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

    public function addSubmissao(Request $request) {
        $array = $request->all();
        $grupoId = $_GET['grupoId'];

        $ficheiros = GrupoFicheiros::where('grupo_id',$grupoId)->get();

        foreach($ficheiros as $ficheiro)
            if (array_key_exists($ficheiro->id , $array) ){
                $ficheiro->submetido = TRUE;
                $ficheiro->save();
            } else {
                $ficheiro->submetido = FALSE;
                $ficheiro->save();
            }
    }

    public function addNota(Request $request) {

        // adicionar nota grupo
        if ($_GET['tipo'] == 'grupo'){
            $pastaId = $_GET['Pasta'];
            $nome = $_GET['nome'];
            $grupoId = $_GET['grupoId'];
            $nota = new GrupoFicheiros;
            if ($pastaId === ''){
                $nota->pasta_id = NULL;
            } else {
                $nota->pasta_id = $pastaId;
            }
            $nota->is_folder = FALSE;
            $nota->grupo_id = $grupoId;

        // adicionar nota a uma tarefa
        } else {
            $tarefaId = $_GET['tarefaId'];
            $nome = $_GET['nome'];
            $nota = new TarefasFicheiros;
            $nota->tarefa_id = $tarefaId;
        }
        $nota->nome = $nome;
        $nota->notas = '';
        $nota->save();
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

    public function addLinkTarefa(Request $request) {
        $nome = $_GET['nome'];
        $link = $_GET['url'];
        $tarefaId = $_GET['tarefaId'];
        error_log($nome);

        $site = new TarefasFicheiros;
        $site->nome = $nome;
        $site->tarefa_id = $tarefaId;
        $site->link = $link;
        $site->save();

        $tarefa = Tarefa::where('id', $tarefaId )->get();
        $fichTarefa = TarefasFicheiros::where('tarefa_id', $tarefaId )->get();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$tarefaId)->get();
        $IdGrupo = $grupo[0]->grupo_id;

        $dataV = $this->viewTarefasAluno($IdGrupo);
        $tarefas = $dataV['tarefas'];
        $nomesUsers = $dataV['nomesUsers'];
        $ficheirosTarefas = $dataV['ficheirosTarefas'];
        $IdGrupo = $dataV['IdGrupo'];
        $percentagem = $dataV['percentagem'];

        $data = array('tarefaEdit' => $tarefa, 'fichTarefa' => $fichTarefa, 'tarefas' => $tarefas,
                    'nomesUsers' => $nomesUsers,'ficheirosTarefas' => $ficheirosTarefas,'IdGrupo' => $IdGrupo, 'percentagem'=>$percentagem);
        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML,'abrir'=>1));
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

    public function uploadFicheiroTarefa(Request $request) {
        $tarefaId = $_POST['tarefaId'];

        $file = new TarefasFicheiros;
        $file->tarefa_id = $tarefaId;
        $file->nome = $request->ficheiro->getClientOriginalName();
        $file->save();

        $filename = $file->id. '.' .$request->ficheiro->getClientOriginalExtension();
        $request->file('ficheiro')->storeAs('public/ficheiros_tarefas', $filename);

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$tarefaId)->get();
        $IdGrupo = $grupo[0]->grupo_id;

        return redirect()->action('ProjetoController@pagProjeto',['grupo_id'=>$IdGrupo, 'tarefa_id' => $tarefaId]);

        /* $tarefa = Tarefa::where('id', $tarefaId )->get();
        $fichTarefa = TarefasFicheiros::where('tarefa_id', $tarefaId )->get();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$tarefaId)->get();
        $IdGrupo = $grupo[0]->grupo_id;

        $dataV = $this->viewTarefasAluno($IdGrupo);
        $tarefas = $dataV['tarefas'];
        $nomesUsers = $dataV['nomesUsers'];
        $ficheirosTarefas = $dataV['ficheirosTarefas'];
        $IdGrupo = $dataV['IdGrupo'];

        $data = array('tarefaEdit' => $tarefa, 'fichTarefa' => $fichTarefa, 'tarefas' => $tarefas,
                    'nomesUsers' => $nomesUsers,'ficheirosTarefas' => $ficheirosTarefas,'IdGrupo' => $IdGrupo);
        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML,'abrir'=>1)); */


    }

    public function pesquisar(Request $request){
        $palavra = $_GET['palavra'];
        $grupoId = $_GET['grupoId'];

        $alunoId = User::select('id')->where('nome', 'LIKE', "%{$palavra}%")->get();

        if ($alunoId->isEmpty()){
            $tarefas = Tarefa::where('nome', 'LIKE', "%{$palavra}%")->orderBy('ordem','ASC')->get();
        }else{
            $tarefas = Tarefa::where('nome', 'LIKE', "%{$palavra}%")->orWhere('user_id', $alunoId[0]->id)->orderBy('ordem','ASC')->get();
        }
        $ids = [];
        foreach ($tarefas as $tarefa) {
            array_push($ids, $tarefa->id);
        }
        $ficheirosTarefas = TarefasFicheiros::whereIn('tarefa_id', $ids )->get();

        $nomesUsers = User::join('users_grupos','users_grupos.user_id', '=','users.id')
                        ->where('users_grupos.grupo_id','=',$grupoId)->select('users.nome','users.id')->get();
                
        $data = array('tarefas' => $tarefas, 'nomesUsers' => $nomesUsers, 'ficheirosTarefas' => $ficheirosTarefas,'IdGrupo' => $grupoId);
        $returnHTML = view('aluno.tarefasAluno')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
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