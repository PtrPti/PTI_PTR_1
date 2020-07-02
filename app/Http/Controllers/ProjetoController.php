<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Projeto;
use App\UserCadeira;
use App\Cadeira;
use App\Grupo;
use App\Tarefa;
use App\Feedback;
use App\GrupoFicheiros;
use App\UsersGrupos;
use App\FeedbackFicheiros;
use App\TarefasFicheiros;
use App\AvaliacaoMembros;
use App\Http\Controllers\ChatController;
use App\Http\Requests\TarefaPost;
use App\Http\Requests\TarefaPastaPost;
use App\Http\Requests\TarefaLinkPost;
use App\Http\Requests\TarefaFilePost;
use App\Http\Requests\TarefaNotaPost;
use App\Http\Requests\CreateFeedback;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use DateTime;
use Session;

class ProjetoController extends Controller
{
    public function index(Request $request, int $id, int $tab = 1) { #id = grupo_id
        //Navbar
            $user = Auth::user()->getUser();
            $disciplinas = UserCadeira::join('cadeiras', 'users_cadeiras.cadeira_id', '=', 'cadeiras.id')->where('users_cadeiras.user_id', $user->id)->get();

            if($user->perfil_id == 1) { //se for aluno
                $query = "select p.id as id, p.nome as nome, c.nome as cadeira, g.id as grupo_id, g.numero as numero, ug.favorito as favorito, ug.id as usersGrupos_id
                        from projetos p
                        inner join cadeiras c
                            on p.cadeira_id = c.id
                        inner join users_cadeiras uc
                            on c.id = uc.cadeira_id and uc.user_id = ?
                        inner join grupos g
                            on p.id = g.projeto_id
                        inner join users_grupos ug
                            on g.id = ug.grupo_id and ug.user_id = ?";
                $projetos = DB::select($query, [$user->id, $user->id]);
            }
            else {
                $query = "select p.id as id, p.nome as nome, c.nome as cadeira, c.id as cadeira_id
                        from projetos p
                        inner join cadeiras c
                            on p.cadeira_id = c.id
                        inner join users_cadeiras uc
                            on c.id = uc.cadeira_id and uc.user_id = ?";
                $projetos = DB::select($query, [$user->id]);
            }

            $utilizadores = User::get();
        //Navbar

        #grupo (id)
        $grupo = Grupo::where('id', $id)->first();
        #projeto (nome)
        $projeto = Projeto::join('grupos', 'projetos.id', '=', 'grupos.projeto_id')->select('projetos.*')->where('grupos.id', $id)->first();
        #disciplina (nome)
        $disciplina = Cadeira::where('id', $projeto->cadeira_id)->first();
        #ficheiros grupo
        $ficheiros = GrupoFicheiros::where('grupo_id',$id)->where('pasta_id', null)->orderBy('is_folder','desc')->orderBy('notas', 'asc')->orderBy('link', 'asc')->orderBy('nome', 'asc')->get();
        $subFicheiros = GrupoFicheiros::where('grupo_id',$id)->where('pasta_id', '!=', null)->orderBy('is_folder','desc')->orderBy('nome', 'asc')->get();

        $pastasSelect = GrupoFicheiros::where('grupo_id', $id)->where('is_folder', 1)->where('pasta_id', null)->orderBy('nome', 'asc')->get();

        #tarefas nao feitas 
        $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$id, false, null]);
        #tarefas feitas
        $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$id, true, null]);
        #ficheiros tarefas
        $tarefasIds = Tarefa::select('id')->where('grupo_id', $id)->get();
        $ids = [];
        foreach ($tarefasIds as $tarefa) {
            array_push($ids, $tarefa->id);
        }
        $ficheirosTarefas = TarefasFicheiros::whereIn('tarefa_id', $ids )->get();
        
        #feedback
        $feedbacks = Feedback::where('grupo_id', $id)->orderBy('created_at', 'desc')->get();
        #membros
        $membros = UsersGrupos::join('users', 'users_grupos.user_id', '=', 'users.id')->
                    join('users_info', 'users.id', '=', 'users_info.user_id')
                    ->select('users.id', 'users.nome', 'users_info.numero')->where('users_grupos.grupo_id', $id)->get();
        #progresso
        $progresso = $this->barraProgresso($id);
        #ficheiros p/ feedback
        $first = GrupoFicheiros::where('link', null)->where('notas', null)->where('is_folder', false)->where('grupo_id', $id)->select('id', 'nome', DB::raw("'grupo' as tipo"));
        $feedFicheiros = TarefasFicheiros::where('link', null)->where('notas', null)->whereIn('tarefa_id', $tarefasIds)->select('id', 'nome', DB::raw("'ficheiro' as tipo"))->union($first)->get();
        #avaliacoes dos membros
        $avaliacoes = AvaliacaoMembros::join('users', 'avaliacao_membros.membro_avaliado', '=', 'users.id')->where('grupo_id',$id)->select('users.id', 'users.nome','avaliacao_membros.avaliado_por', 'avaliacao_membros.grupo_id', 'avaliacao_membros.nota')->get();

        $active_tab = $tab;
        
        Session::has('search') ? Session::forget('search') : null;

        return view('grupo.indexGrupo', compact('disciplinas','projetos','utilizadores','grupo','disciplina','projeto',
                                                'tarefasNaoFeitas', 'tarefasFeitas','ficheirosTarefas', 'feedbacks', 'active_tab', 'ficheiros', 
                                                'subFicheiros', 'progresso', 'membros', 'pastasSelect', 'feedFicheiros', 'avaliacoes'));
    }

    public function verFeedback(Request $request) {
        $id = $_GET['id'];

        $feedback = Feedback::leftJoin('users', 'feedback.docente_id', '=', 'users.id')->where('feedback.id', $id)->first();
        $feedbackFicheiros = FeedbackFicheiros::leftJoin('tarefas_ficheiros', 'feedback_ficheiros.tarefa_ficheiro_id', '=', 'tarefas_ficheiros.id')
                                                ->leftJoin('grupos_ficheiros', 'feedback_ficheiros.grupo_ficheiro_id', '=', 'grupos_ficheiros.id')
                                                ->select('tarefas_ficheiros.id as tf_id', 'tarefas_ficheiros.nome as tf_nome', 'grupos_ficheiros.id as gf_id', 'grupos_ficheiros.nome as gf_nome')
                                                ->where('feedback_ficheiros.feedback_id', $id)->get();
        $data = array(
            'feedback'  => $feedback,
            'feedbackFicheiros'  => $feedbackFicheiros,
        );

        $returnHTML = view('grupo.feedbackMensagens')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }

    public function barraProgresso(Int $id) {
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
        $totalTarefas = count($tarefas) - count($ids);
        $percentagem =  $totalTarefas == 0 ? 0 : round($tarefasDone*100/$totalTarefas);
        return $percentagem;
    }

    public function createTarefa(TarefaPost $request) {
        $nome = $_POST['nomeTarefa'];
        $membro = $_POST['membro'];
        $tarefaAssociada = $_POST['tarefaAssociada'];
        $prazo = $_POST['prazo'];
        $grupoId = $_POST['grupo_id'];
        $projetoId = $_POST['projeto_id'];

        $novaTarefa = new Tarefa;
        $novaTarefa->nome = $nome;
        $novaTarefa->user_id = $membro == "" ? null : $membro;
        $novaTarefa->grupo_id = $grupoId;
        $novaTarefa->projeto_id = $projetoId;
        $novaTarefa->prazo = $prazo == "" ? null : $membro;
        $novaTarefa->tarefa_id = $tarefaAssociada == "" ? null : $tarefaAssociada;
        $novaTarefa->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Tarefa criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function editTarefa(Request $request) {
        $id = $_GET['tarefa_id'];
        $tarefa = Tarefa::find($id);
        return response()->json(array('nome'=>$tarefa->nome, 'membro'=>$tarefa->user_id, 'prazo'=>$tarefa->prazo, 'tarefaAssoc'=>$tarefa->tarefa_id));
    }

    public function editTarefaPost(TarefaPost $request) {
        $id = $_POST['tarefa_id'];
        $nome = $_POST['nomeTarefa'];
        $membro = $_POST['membro'];
        $tarefaAssociada = $_POST['tarefaAssociada'];
        $prazo = $_POST['prazo'];
        $grupoId = $_POST['grupo_id'];

        $tarefa = Tarefa::find($id);
        $tarefa->nome = $nome;
        $tarefa->user_id = $membro == "" ? null : $membro;
        $tarefa->prazo = $prazo == "" ? null : $membro;
        $tarefa->tarefa_id = $tarefaAssociada == "" ? null : $tarefaAssociada;
        $tarefa->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Tarefa alterada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function checkTarefa(Request $request) {
        $id = $_POST['id'];
        $val = $_POST['val'] == "false" ? FALSE : TRUE;
        $finished_time = $val == TRUE ? date('Y-m-d H:i:s') : null; 

        if ($_POST['changePai'] == "true") {
            $pai = Tarefa::select('tarefa_id')->where('id',$id)->first();
            Tarefa::where('id', $pai->tarefa_id)->update(['estado'=>$val,'finished_at'=>$finished_time]);
        }
        //Atualiza as tarefas filhos para o estado do pai
        Tarefa::where('tarefa_id', $id)->update(['estado'=>$val,'finished_at'=>$finished_time]);

        $tarefa = Tarefa::find($id);
        $tarefa->estado = $val;
        $tarefa->finished_at = $finished_time;
        $tarefa->save();

        // Id do grupo
        $grupo = Tarefa::select('grupo_id')->where('id',$id)->first();    
        $progresso = $this->barraProgresso($grupo->grupo_id);        
        
        if ($_POST['update'] == "true") {
            $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$grupo->grupo_id, false, null]);
            $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$grupo->grupo_id, true, null]);
            #membros
            $membros = UsersGrupos::join('users', 'users_grupos.user_id', '=', 'users.id')->select('users.id', 'users.nome')->where('users_grupos.grupo_id', $grupo->grupo_id)->get();

            $data = array('progresso' => $progresso, 'tarefasNaoFeitas' => $tarefasNaoFeitas, 'tarefasFeitas' => $tarefasFeitas, 'grupo_id' => $grupo->grupo_id, 'membros'=>$membros);
            $returnHTML = view('grupo.tarefas')->with($data)->render();
            return response()->json(array('html' => $returnHTML, 'title' => 'Sucesso', 'msg' => 'Tarefa alterada com sucesso'));
        }
        else {
            return response()->json(array('progresso'=>$progresso, 'title' => 'Sucesso', 'msg' => 'Tarefa alterada com sucesso'));
        }
    }

    public function createPasta(TarefaPastaPost $request) {
        $nome = $_POST['nomePasta'];
        $grupoId = $_POST['grupo_id'];

        $pasta = new GrupoFicheiros;
        $pasta->grupo_id = $grupoId;
        $pasta->nome = $nome;
        $pasta->is_folder = TRUE;
        $pasta->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Pasta criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addNotaGrupo(TarefaNotaPost $request) {
        $pastaId = $_POST['notaPasta'];
        $nome = $_POST['nomeNota'];
        $texto = $_POST['notaTexto'];
        $grupoId = $_POST['grupo_id'];

        $nota = new GrupoFicheiros;
        $nota->is_folder = FALSE;
        $nota->pasta_id = $pastaId == "" ? null : $pastaId;
        $nota->grupo_id = $grupoId;
        $nota->nome = $nome;
        $nota->notas = $texto;
        $nota->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Nota criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addNotaTarefa(TarefaNotaPost $request) {
        $nome = $_POST['nomeNota'];
        $texto = $_POST['notaTexto'];
        $grupoId = $_POST['grupo_id'];
        $tarefaId = $_POST['tarefa_id'];

        $nota = new TarefasFicheiros;
        $nota->tarefa_id = $tarefaId;
        $nota->nome = $nome;
        $nota->notas = $texto;
        $nota->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Nota criada com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addLinkGrupo(TarefaLinkPost $request) {
        $pastaId = $_POST['linkPasta'];
        $nome = $_POST['nomeLink'];
        $link = $_POST['url'];
        $grupoId = $_POST['grupo_id'];
        
        $site = new GrupoFicheiros;

        $site->grupo_id = $grupoId;
        $site->pasta_id = $pastaId == "" ? null : $pastaId;
        $site->nome = $nome;
        $site->link = $link;
        $site->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Link adicionado com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addLinkTarefa(TarefaLinkPost $request) {
        $nome = $_POST['nomeLink'];
        $link = $_POST['url'];
        $tarefaId = $_POST['tarefa_id'];
        $grupoId = $_POST['grupo_id'];

        $site = new TarefasFicheiros;
        $site->nome = $nome;
        $site->tarefa_id = $tarefaId;
        $site->link = $link;
        $site->save();

        return response()->json(['title' => 'Sucesso', 'msg' => 'Link adicionado com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/1' ]);
    }

    public function addFileGrupo(TarefaFilePost $request) {
        $grupoId = $_POST['grupo_id'];
        $pastaId = $_POST['filePasta'];

        if (Input::hasFile('grupoFile')) {
            $filename = $grupoId . '_' . $request->file('grupoFile')->getClientOriginalName();
            $request->file('grupoFile')->storeAs('public/grupo', $filename);

            $ficheiro = new GrupoFicheiros();
            $ficheiro->nome = $filename;
            $ficheiro->grupo_id = $grupoId;
            $ficheiro->is_folder = FALSE;
            $ficheiro->pasta_id = $pastaId == "" ? null : $pastaId;
            $ficheiro->save();
        }

        return redirect()->action('ProjetoController@index',['grupo_id'=>$grupoId]);
    }

    public function addFileTarefa(TarefaFilePost $request) {
        $tarefaId = $_POST['tarefa_id'];
        $grupoId = $_POST['grupo_id'];

        if (Input::hasFile('grupoFile')) {
            $filename = $tarefaId . '_' . $request->file('grupoFile')->getClientOriginalName();
            $request->file('grupoFile')->storeAs('public/tarefa', $filename);

            $file = new TarefasFicheiros;
            $file->tarefa_id = $tarefaId;
            $file->nome = $filename;
            $file->save();
        }

        return redirect()->action('ProjetoController@index',['grupo_id'=>$grupoId]);
    }

    public function pesquisarTarefas(Request $request) {
        $search = $_GET['search'];
        $grupoId = $_GET['grupo_id'];
        $clear = $_GET['clear'];

        $search == "" ? (Session::has('search') ? Session::forget('search') : null) : Session::flash('search', $search);

        $progresso = $this->barraProgresso($grupoId);
        $membros = $membros = UsersGrupos::join('users', 'users_grupos.user_id', '=', 'users.id')->select('users.id', 'users.nome')->where('users_grupos.grupo_id', $grupoId)->get();
        
        if ($clear == "true") {
            $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, false, null]);
            $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, true, null]);            
        }
        else{
            $tarefasNaoFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, false, $search]);
            $tarefasFeitas = DB::select('call GetTarefas(?,?,?)', [$grupoId, true, $search]);
        }

        $data = array('progresso' => $progresso, 'tarefasNaoFeitas' => $tarefasNaoFeitas, 'tarefasFeitas' => $tarefasFeitas, 'grupo_id' => $grupoId, 'membros' => $membros);

        $returnHTML = view('grupo.tarefas')->with($data)->render();
        return response()->json(array('html' => $returnHTML));
    }

    public function createFeedback(CreateFeedback $request) {
        $mensagem = $_POST['message'];
        $grupoId = $_POST['grupo_id'];
        $ids = explode(',' , $_POST['files_ids']);

        $feedback = new Feedback;
        $feedback->mensagem_grupo = $mensagem;
        // $feedback->mensagem_docente = null;
        $feedback->grupo_id = $grupoId;
        $feedback->save();
        $feedbackId = $feedback->id;

        for($i = 0; $i < sizeof($ids) - 1; $i++) {
            $feedbackFicheiro = new FeedbackFicheiros;
            $feedbackFicheiro->feedback_id = $feedbackId;

            if (explode('_' , $ids[$i])[1] == "grupo") {
                $feedbackFicheiro->grupo_ficheiro_id = explode('_' , $ids[$i])[0];
            }
            else {
                $feedbackFicheiro->tarefa_ficheiro_id = explode('_' , $ids[$i])[0];                
            }
            $feedbackFicheiro->save();
        }

        return response()->json(['title' => 'Sucesso', 'msg' => 'Feedback criado com sucesso', 'redirect' => '/Home/Projeto/Grupo/'. $grupoId . '/2' ]);
    }

    public function addAvaliacao (Request $request) {     
        $lista_membros = UsersGrupos::where('grupo_id', $request->grupo_id)->get();
        
        for($i = 0; $i < sizeof($lista_membros) - 1; $i++) {
            print_r($lista_membros[$i]->user_id);
            $aval = new AvaliacaoMembros;
            $aval->avaliado_por = Auth::user()->getUser()->id;
            $aval->membro_avaliado = $lista_membros[$i]->user_id;
            $aval->grupo_id = $request->grupo_id;
            $nota_membro = "nota_".$lista_membros[$i]->user_id;
            $aval->nota = $request->$nota_membro;
            $aval->save();
        }
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
        $returnHTML = view('grupo.nota')->with($data)->render();
        return response()->json(array('html'=>$returnHTML));
    }
}
